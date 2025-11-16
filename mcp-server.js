#!/usr/bin/env node

const { Server } = require('@modelcontextprotocol/sdk/server/index.js');
const { StdioServerTransport } = require('@modelcontextprotocol/sdk/server/stdio.js');
const {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} = require('@modelcontextprotocol/sdk/types.js');

class ItineraryMCPServer {
  constructor() {
    this.server = new Server(
      {
        name: 'itinerary-creator',
        version: '1.0.0',
      },
      {
        capabilities: {
          tools: {},
        },
      }
    );

    this.setupToolHandlers();
    this.setupErrorHandling();
  }

  setupToolHandlers() {
    this.server.setRequestHandler(ListToolsRequestSchema, async () => {
      return {
        tools: [
          {
            name: 'create_itinerary',
            description: 'Create a new travel itinerary with detailed day-by-day planning',
            inputSchema: {
              type: 'object',
              properties: {
                name: {
                  type: 'string',
                  description: 'Name of the itinerary (e.g., "Thailand 4 Nights / 5 Days Itinerary")',
                },
                tagline: {
                  type: 'string',
                  description: 'Short tagline for the itinerary',
                },
                description: {
                  type: 'string',
                  description: 'Detailed description of the itinerary and destination',
                },
                duration_days: {
                  type: 'number',
                  description: 'Number of days for the itinerary',
                },
                country: {
                  type: 'string',
                  description: 'Country name for the itinerary',
                },
                destinations: {
                  type: 'array',
                  items: { type: 'string' },
                  description: 'Array of destination names',
                },
                days: {
                  type: 'array',
                  description: 'Array of day objects with activities',
                  items: {
                    type: 'object',
                    properties: {
                      day_number: { type: 'number' },
                      title: { type: 'string' },
                      description: { type: 'string' },
                      items: {
                        type: 'array',
                        items: {
                          type: 'object',
                          properties: {
                            title: { type: 'string' },
                            description: { type: 'string' },
                            location: { type: 'string' },
                            start_time: { type: 'string' },
                            end_time: { type: 'string' },
                            duration_minutes: { type: 'number' },
                            type: { type: 'string' },
                          },
                        },
                      },
                    },
                  },
                },
                inclusions: {
                  type: 'array',
                  items: { type: 'string' },
                  description: 'Array of what is included in the package',
                },
                exclusions: {
                  type: 'array',
                  items: { type: 'string' },
                  description: 'Array of what is not included in the package',
                },
                terms_conditions: {
                  type: 'string',
                  description: 'Terms and conditions for the itinerary',
                },
                cancellation_policy: {
                  type: 'string',
                  description: 'Cancellation policy for the itinerary',
                },
                is_master: {
                  type: 'boolean',
                  description: 'Whether this should be a master template',
                  default: false,
                },
              },
              required: ['name', 'duration_days', 'country', 'days'],
            },
          },
          {
            name: 'get_itinerary_templates',
            description: 'Get available master itinerary templates',
            inputSchema: {
              type: 'object',
              properties: {
                country: {
                  type: 'string',
                  description: 'Filter by country (optional)',
                },
                duration: {
                  type: 'number',
                  description: 'Filter by duration in days (optional)',
                },
              },
            },
          },
          {
            name: 'generate_ai_itinerary',
            description: 'Generate an AI-powered itinerary based on customer preferences',
            inputSchema: {
              type: 'object',
              properties: {
                customer_name: {
                  type: 'string',
                  description: 'Customer name',
                },
                destination: {
                  type: 'string',
                  description: 'Travel destination',
                },
                country: {
                  type: 'string',
                  description: 'Country name',
                },
                days: {
                  type: 'number',
                  description: 'Number of days',
                },
                travel_style: {
                  type: 'string',
                  description: 'Travel style (leisure, adventure, luxury, budget, family, romantic)',
                },
                budget_range: {
                  type: 'string',
                  description: 'Budget range (low, medium, high, luxury)',
                },
                interests: {
                  type: 'array',
                  items: { type: 'string' },
                  description: 'Customer interests and activities',
                },
                special_requirements: {
                  type: 'string',
                  description: 'Special requirements or preferences',
                },
                group_size: {
                  type: 'number',
                  description: 'Number of travelers',
                },
              },
              required: ['customer_name', 'destination', 'days', 'travel_style'],
            },
          },
          {
            name: 'create_custom_itinerary',
            description: 'Create a custom itinerary from a master template',
            inputSchema: {
              type: 'object',
              properties: {
                master_itinerary_id: {
                  type: 'number',
                  description: 'ID of the master itinerary to customize',
                },
                customizations: {
                  type: 'object',
                  description: 'Customizations to apply to the master template',
                  properties: {
                    name: { type: 'string' },
                    duration_days: { type: 'number' },
                    days: {
                      type: 'array',
                      description: 'Modified days array',
                    },
                    inclusions: {
                      type: 'array',
                      items: { type: 'string' },
                    },
                    exclusions: {
                      type: 'array',
                      items: { type: 'string' },
                    },
                  },
                },
                lead_id: {
                  type: 'number',
                  description: 'Lead ID to associate with the custom itinerary',
                },
              },
              required: ['master_itinerary_id'],
            },
          },
        ],
      };
    });

    this.server.setRequestHandler(CallToolRequestSchema, async (request) => {
      const { name, arguments: args } = request.params;

      try {
        switch (name) {
          case 'create_itinerary':
            return await this.createItinerary(args);
          case 'generate_ai_itinerary':
            return await this.generateAIItinerary(args);
          case 'get_itinerary_templates':
            return await this.getItineraryTemplates(args);
          case 'create_custom_itinerary':
            return await this.createCustomItinerary(args);
          default:
            throw new Error(`Unknown tool: ${name}`);
        }
      } catch (error) {
        return {
          content: [
            {
              type: 'text',
              text: `Error: ${error.message}`,
            },
          ],
        };
      }
    });
  }

  async createItinerary(args) {
    // This would typically make an API call to your Laravel backend
    // For now, we'll return a structured response
    const itinerary = {
      id: Math.floor(Math.random() * 10000),
      name: args.name,
      tagline: args.tagline,
      description: args.description,
      duration_days: args.duration_days,
      country: args.country,
      destinations: args.destinations || [],
      days: args.days || [],
      inclusions: args.inclusions || [],
      exclusions: args.exclusions || [],
      terms_conditions: args.terms_conditions,
      cancellation_policy: args.cancellation_policy,
      is_master: args.is_master || false,
      created_at: new Date().toISOString(),
    };

    return {
      content: [
        {
          type: 'text',
          text: `✅ Itinerary created successfully!

**${itinerary.name}**
${itinerary.tagline ? `*${itinerary.tagline}*` : ''}

**Duration:** ${itinerary.duration_days} ${itinerary.duration_days === 1 ? 'day' : 'days'}
**Country:** ${itinerary.country}
**Destinations:** ${itinerary.destinations.join(', ')}

**Itinerary Summary:**
${itinerary.days.map(day => 
  `**Day ${day.day_number}:** ${day.title}
${day.description ? `  ${day.description}` : ''}
${day.items.map(item => 
  `  • ${item.start_time} - ${item.title}${item.location ? ` (${item.location})` : ''}`
).join('\n')}`
).join('\n\n')}

${itinerary.inclusions.length > 0 ? `**Inclusions:**
${itinerary.inclusions.map(inc => `• ${inc}`).join('\n')}` : ''}

${itinerary.exclusions.length > 0 ? `**Exclusions:**
${itinerary.exclusions.map(exc => `• ${exc}`).join('\n')}` : ''}

**Itinerary ID:** ${itinerary.id}
**Created:** ${new Date(itinerary.created_at).toLocaleString()}`,
        },
      ],
    };
  }

  async generateAIItinerary(args) {
    const { customer_name, destination, days, travel_style, budget_range, interests, special_requirements, group_size } = args;
    
    // Generate AI-powered itinerary based on customer preferences
    const itinerary = {
      id: Math.floor(Math.random() * 10000),
      name: `AI-Generated ${travel_style} Trip to ${destination}`,
      tagline: `Personalized ${travel_style} experience in ${destination}`,
      description: `An AI-crafted itinerary designed specifically for ${customer_name} featuring ${travel_style} activities and experiences.`,
      duration_days: days,
      destination: destination,
      travel_style: travel_style,
      budget_range: budget_range,
      customer_name: customer_name,
      group_size: group_size || 1,
      days: this.generateDays(days, destination, travel_style, interests),
      inclusions: this.generateInclusions(travel_style, budget_range),
      exclusions: this.generateExclusions(),
      terms_conditions: 'Standard terms and conditions apply. Please review all details before booking.',
      cancellation_policy: 'Free cancellation up to 24 hours before travel date.',
      created_at: new Date().toISOString(),
    };

    return {
      content: [
        {
          type: 'text',
          text: `🤖 AI-Generated Itinerary for ${customer_name}

**${itinerary.name}**
*${itinerary.tagline}*

**Duration:** ${itinerary.duration_days} ${itinerary.duration_days === 1 ? 'day' : 'days'}
**Destination:** ${itinerary.destination}
**Travel Style:** ${itinerary.travel_style}
**Budget Range:** ${itinerary.budget_range}
**Group Size:** ${itinerary.group_size} ${itinerary.group_size === 1 ? 'person' : 'people'}

**Day-by-Day Itinerary:**
${itinerary.days.map(day => 
  `**Day ${day.day_number}:** ${day.title}
${day.description ? `  ${day.description}` : ''}
${day.items.map(item => 
  `  • ${item.start_time} - ${item.title}${item.location ? ` (${item.location})` : ''}`
).join('\n')}`
).join('\n\n')}

**Inclusions:**
${itinerary.inclusions.map(inc => `• ${inc}`).join('\n')}

**Exclusions:**
${itinerary.exclusions.map(exc => `• ${exc}`).join('\n')}

**Itinerary ID:** ${itinerary.id}
**Generated:** ${new Date(itinerary.created_at).toLocaleString()}

This AI-generated itinerary is tailored to your preferences and can be further customized as needed.`,
        },
      ],
    };
  }

  generateDays(days, destination, travel_style, interests) {
    const dayTemplates = {
      leisure: [
        { title: 'Beach relaxation', description: 'Enjoy the beautiful beaches', duration: 4 },
        { title: 'Spa treatment', description: 'Relaxing spa experience', duration: 2 },
        { title: 'City walking tour', description: 'Explore the city on foot', duration: 3 },
        { title: 'Local market visit', description: 'Shop for local products', duration: 2 }
      ],
      adventure: [
        { title: 'Hiking trail', description: 'Scenic hiking adventure', duration: 6 },
        { title: 'Water sports', description: 'Exciting water activities', duration: 4 },
        { title: 'Mountain climbing', description: 'Challenging mountain trek', duration: 8 },
        { title: 'Wildlife safari', description: 'Wildlife spotting adventure', duration: 5 }
      ],
      luxury: [
        { title: 'Fine dining', description: 'Exquisite culinary experience', duration: 3 },
        { title: 'Luxury shopping', description: 'High-end shopping experience', duration: 4 },
        { title: 'Private tour', description: 'Exclusive guided tour', duration: 6 },
        { title: 'Wine tasting', description: 'Premium wine experience', duration: 2 }
      ],
      budget: [
        { title: 'Free walking tour', description: 'Budget-friendly city exploration', duration: 3 },
        { title: 'Local street food', description: 'Authentic local cuisine', duration: 2 },
        { title: 'Public transport', description: 'Explore using public transport', duration: 4 },
        { title: 'Budget attractions', description: 'Affordable local attractions', duration: 3 }
      ],
      family: [
        { title: 'Family-friendly museum', description: 'Educational family experience', duration: 3 },
        { title: 'Amusement park', description: 'Fun for the whole family', duration: 6 },
        { title: 'Zoo visit', description: 'Wildlife experience for kids', duration: 4 },
        { title: 'Interactive activities', description: 'Hands-on learning experience', duration: 3 }
      ],
      romantic: [
        { title: 'Sunset dinner', description: 'Romantic dining experience', duration: 3 },
        { title: 'Couple spa', description: 'Relaxing couples treatment', duration: 2 },
        { title: 'Romantic walk', description: 'Scenic couple stroll', duration: 2 },
        { title: 'Private boat tour', description: 'Intimate water experience', duration: 4 }
      ]
    };

    const activities = dayTemplates[travel_style] || dayTemplates.leisure;
    const generatedDays = [];

    for (let i = 1; i <= days; i++) {
      const dayActivities = activities.slice(0, Math.min(3, activities.length));
      const items = [];
      let startTime = 9;

      dayActivities.forEach((activity, index) => {
        items.push({
          title: activity.title,
          description: activity.description,
          location: destination,
          start_time: `${startTime.toString().padStart(2, '0')}:00`,
          end_time: `${(startTime + activity.duration).toString().padStart(2, '0')}:00`,
          duration_minutes: activity.duration * 60,
          type: 'activity',
          order: index
        });
        startTime += activity.duration + 1;
      });

      generatedDays.push({
        day_number: i,
        title: `Day ${i}: Exploring ${destination}`,
        description: `A full day of ${travel_style} activities in ${destination}`,
        items: items
      });
    }

    return generatedDays;
  }

  generateInclusions(travel_style, budget_range) {
    const baseInclusions = [
      'Hotel accommodation',
      'Daily breakfast',
      'Airport transfers',
      'Local transportation'
    ];

    const styleInclusions = {
      leisure: ['Spa access', 'Beach equipment'],
      adventure: ['Equipment rental', 'Guide services'],
      luxury: ['Premium dining', 'Concierge service'],
      budget: ['Public transport pass', 'Free attractions'],
      family: ['Family activities', 'Child-friendly meals'],
      romantic: ['Couple activities', 'Romantic dining']
    };

    const budgetInclusions = {
      low: ['Basic accommodation', 'Simple meals'],
      medium: ['Mid-range hotel', 'Standard meals'],
      high: ['Luxury hotel', 'Fine dining'],
      luxury: ['5-star accommodation', 'Premium experiences']
    };

    return [
      ...baseInclusions,
      ...(styleInclusions[travel_style] || []),
      ...(budgetInclusions[budget_range] || [])
    ];
  }

  generateExclusions() {
    return [
      'International flights',
      'Personal expenses',
      'Travel insurance',
      'Visa fees',
      'Meals not specified',
      'Optional activities',
      'Tips and gratuities'
    ];
  }

  async getItineraryTemplates(args) {
    // This would typically fetch from your database
    // For now, we'll return some example templates
    const templates = [
      {
        id: 1,
        name: 'Thailand 4 Nights / 5 Days Itinerary',
        tagline: 'Explore the vibrant culture and stunning beaches of Thailand',
        duration_days: 5,
        country: 'Thailand',
        destinations: ['Phuket', 'Bangkok'],
        is_master: true,
      },
      {
        id: 2,
        name: 'Paris 3 Days Romantic Getaway',
        tagline: 'Experience the City of Light with your loved one',
        duration_days: 3,
        country: 'France',
        destinations: ['Paris'],
        is_master: true,
      },
      {
        id: 3,
        name: 'Japan 7 Days Cultural Journey',
        tagline: 'Discover ancient traditions and modern marvels',
        duration_days: 7,
        country: 'Japan',
        destinations: ['Tokyo', 'Kyoto', 'Osaka'],
        is_master: true,
      },
    ];

    let filteredTemplates = templates;

    if (args.country) {
      filteredTemplates = filteredTemplates.filter(t => 
        t.country.toLowerCase().includes(args.country.toLowerCase())
      );
    }

    if (args.duration) {
      filteredTemplates = filteredTemplates.filter(t => t.duration_days === args.duration);
    }

    return {
      content: [
        {
          type: 'text',
          text: `📋 Available Master Itinerary Templates:

${filteredTemplates.map(template => 
  `**${template.name}**
  *${template.tagline}*
  🌍 ${template.country} | ⏱️ ${template.duration_days} days
  📍 Destinations: ${template.destinations.join(', ')}
  🆔 Template ID: ${template.id}
  ---`
).join('\n\n')}

Total templates found: ${filteredTemplates.length}`,
        },
      ],
    };
  }

  async createCustomItinerary(args) {
    const { master_itinerary_id, customizations, lead_id } = args;

    // This would typically fetch the master template and create a custom version
    const customItinerary = {
      id: Math.floor(Math.random() * 10000),
      master_itinerary_id,
      name: customizations?.name || `Custom Itinerary from Template ${master_itinerary_id}`,
      duration_days: customizations?.duration_days || 5,
      days: customizations?.days || [],
      inclusions: customizations?.inclusions || [],
      exclusions: customizations?.exclusions || [],
      lead_id: lead_id || null,
      is_custom: true,
      created_at: new Date().toISOString(),
    };

    return {
      content: [
        {
          type: 'text',
          text: `✅ Custom itinerary created successfully!

**${customItinerary.name}**
*Based on master template #${master_itinerary_id}*

**Duration:** ${customItinerary.duration_days} ${customItinerary.duration_days === 1 ? 'day' : 'days'}
${customItinerary.lead_id ? `**Associated Lead:** #${customItinerary.lead_id}` : ''}

**Custom Itinerary ID:** ${customItinerary.id}
**Created:** ${new Date(customItinerary.created_at).toLocaleString()}

You can now further customize this itinerary or use it as a starting point for your travel planning.`,
        },
      ],
    };
  }

  setupErrorHandling() {
    this.server.onerror = (error) => {
      console.error('[MCP Error]', error);
    };

    process.on('SIGINT', async () => {
      await this.server.close();
      process.exit(0);
    });
  }

  async run() {
    const transport = new StdioServerTransport();
    await this.server.connect(transport);
    console.error('Itinerary MCP server running on stdio');
  }
}

const server = new ItineraryMCPServer();
server.run().catch(console.error);
