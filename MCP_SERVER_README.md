# Itinerary MCP Server

This MCP (Model Context Protocol) server provides tools for creating and managing travel itineraries within the Good Vacations application.

## Features

- **Create Itineraries**: Generate detailed travel itineraries with day-by-day planning
- **Master Templates**: Access and use pre-built itinerary templates
- **Custom Itineraries**: Create personalized itineraries from master templates
- **Comprehensive Planning**: Include activities, accommodations, meals, and transportation

## Installation

1. Install dependencies:
```bash
npm install --package-lock-only --package-lock mcp-package.json
```

2. Make the server executable:
```bash
chmod +x mcp-server.js
```

## Usage

### Start the MCP Server
```bash
node mcp-server.js
```

### Available Tools

#### 1. create_itinerary
Creates a new travel itinerary with detailed planning.

**Parameters:**
- `name` (required): Name of the itinerary
- `tagline` (optional): Short tagline
- `description` (optional): Detailed description
- `duration_days` (required): Number of days
- `country` (required): Country name
- `destinations` (optional): Array of destination names
- `days` (required): Array of day objects with activities
- `inclusions` (optional): What's included in the package
- `exclusions` (optional): What's not included
- `terms_conditions` (optional): Terms and conditions
- `cancellation_policy` (optional): Cancellation policy
- `is_master` (optional): Whether this is a master template

**Example:**
```json
{
  "name": "Thailand Adventure",
  "tagline": "Explore the Land of Smiles",
  "duration_days": 5,
  "country": "Thailand",
  "destinations": ["Bangkok", "Phuket"],
  "days": [
    {
      "day_number": 1,
      "title": "Arrival in Bangkok",
      "description": "Welcome to Thailand",
      "items": [
        {
          "title": "Airport Transfer",
          "description": "Private transfer to hotel",
          "location": "Bangkok Airport",
          "start_time": "09:00",
          "end_time": "10:00",
          "duration_minutes": 60,
          "type": "transport"
        }
      ]
    }
  ],
  "inclusions": ["Hotel accommodation", "Daily breakfast", "Airport transfers"],
  "exclusions": ["International flights", "Personal expenses", "Travel insurance"]
}
```

#### 2. get_itinerary_templates
Retrieves available master itinerary templates.

**Parameters:**
- `country` (optional): Filter by country
- `duration` (optional): Filter by duration in days

#### 3. create_custom_itinerary
Creates a custom itinerary from a master template.

**Parameters:**
- `master_itinerary_id` (required): ID of the master template
- `customizations` (optional): Customizations to apply
- `lead_id` (optional): Lead ID to associate with the itinerary

## Integration with Laravel Backend

The MCP server is designed to work with the Laravel backend API. To integrate:

1. **API Endpoints**: The server should make HTTP requests to your Laravel API endpoints
2. **Authentication**: Include proper authentication headers
3. **Data Validation**: Ensure data matches your Laravel model requirements

### Example API Integration

```javascript
// In the createItinerary method
const response = await fetch('http://your-laravel-app.com/api/itineraries', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer your-api-token'
  },
  body: JSON.stringify(itineraryData)
});

const result = await response.json();
```

## Configuration

### Environment Variables
- `LARAVEL_API_URL`: Your Laravel application URL
- `API_TOKEN`: Authentication token for API requests
- `DEBUG`: Enable debug logging

### Database Connection
The server can be configured to connect directly to your database or use API endpoints.

## Error Handling

The server includes comprehensive error handling:
- Input validation
- API error responses
- Network connectivity issues
- Database errors

## Development

### Running in Development Mode
```bash
npm run dev
```

### Testing
```bash
# Test individual tools
node -e "
const server = require('./mcp-server.js');
// Test your tools here
"
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

MIT License - see LICENSE file for details.

## Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

## Changelog

### v1.0.0
- Initial release
- Basic itinerary creation
- Master template support
- Custom itinerary generation
