<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to assign tasks to
        $users = User::limit(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $projects = [
            'Website Redesign',
            'Mobile App Development',
            'Marketing Campaign',
            'Customer Support',
            'Product Launch',
            'Bug Fixes',
            'Feature Development',
            'Documentation',
        ];

        $categories = [
            'Development',
            'Design',
            'Marketing',
            'Support',
            'Testing',
            'Documentation',
            'Research',
            'Planning',
        ];

        $tags = [
            'frontend', 'backend', 'ui', 'ux', 'api', 'database', 'testing', 'deployment',
            'marketing', 'seo', 'content', 'social', 'email', 'analytics', 'reporting',
            'bug', 'feature', 'enhancement', 'urgent', 'low-priority', 'research',
        ];

        $taskTemplates = [
            [
                'title' => 'Design new homepage layout',
                'description' => 'Create a modern, responsive homepage design that improves user engagement and conversion rates.',
                'project' => 'Website Redesign',
                'category' => 'Design',
                'priority' => Task::PRIORITY_HIGH,
                'status' => Task::STATUS_IN_PROGRESS,
                'tags' => ['frontend', 'ui', 'ux'],
                'story_points' => 8,
                'estimated_hours' => '16h',
                'completion_percentage' => 60,
            ],
            [
                'title' => 'Implement user authentication',
                'description' => 'Add secure user registration, login, and password reset functionality.',
                'project' => 'Mobile App Development',
                'category' => 'Development',
                'priority' => Task::PRIORITY_URGENT,
                'status' => Task::STATUS_TODO,
                'tags' => ['backend', 'api', 'security'],
                'story_points' => 13,
                'estimated_hours' => '24h',
                'completion_percentage' => 0,
            ],
            [
                'title' => 'Create social media campaign',
                'description' => 'Develop and launch a comprehensive social media marketing campaign for the new product.',
                'project' => 'Marketing Campaign',
                'category' => 'Marketing',
                'priority' => Task::PRIORITY_MEDIUM,
                'status' => Task::STATUS_REVIEW,
                'tags' => ['marketing', 'social', 'content'],
                'story_points' => 5,
                'estimated_hours' => '12h',
                'completion_percentage' => 90,
            ],
            [
                'title' => 'Fix payment processing bug',
                'description' => 'Resolve issue where payments are not being processed correctly for international customers.',
                'project' => 'Bug Fixes',
                'category' => 'Development',
                'priority' => Task::PRIORITY_URGENT,
                'status' => Task::STATUS_IN_PROGRESS,
                'tags' => ['bug', 'backend', 'payment'],
                'story_points' => 8,
                'estimated_hours' => '8h',
                'completion_percentage' => 40,
            ],
            [
                'title' => 'Write API documentation',
                'description' => 'Create comprehensive documentation for the REST API endpoints.',
                'project' => 'Documentation',
                'category' => 'Documentation',
                'priority' => Task::PRIORITY_LOW,
                'status' => Task::STATUS_TODO,
                'tags' => ['documentation', 'api'],
                'story_points' => 3,
                'estimated_hours' => '6h',
                'completion_percentage' => 0,
            ],
            [
                'title' => 'Conduct user research',
                'description' => 'Interview 20 users to understand pain points and gather feedback on current features.',
                'project' => 'Product Launch',
                'category' => 'Research',
                'priority' => Task::PRIORITY_HIGH,
                'status' => Task::STATUS_HOLD,
                'tags' => ['research', 'user-feedback'],
                'story_points' => 5,
                'estimated_hours' => '20h',
                'completion_percentage' => 20,
            ],
            [
                'title' => 'Set up automated testing',
                'description' => 'Implement CI/CD pipeline with automated testing for all new features.',
                'project' => 'Feature Development',
                'category' => 'Testing',
                'priority' => Task::PRIORITY_MEDIUM,
                'status' => Task::STATUS_DONE,
                'tags' => ['testing', 'deployment', 'ci-cd'],
                'story_points' => 13,
                'estimated_hours' => '32h',
                'completion_percentage' => 100,
            ],
            [
                'title' => 'Optimize database queries',
                'description' => 'Review and optimize slow database queries to improve application performance.',
                'project' => 'Bug Fixes',
                'category' => 'Development',
                'priority' => Task::PRIORITY_MEDIUM,
                'status' => Task::STATUS_IN_PROGRESS,
                'tags' => ['backend', 'database', 'performance'],
                'story_points' => 8,
                'estimated_hours' => '16h',
                'completion_percentage' => 30,
            ],
            [
                'title' => 'Create email templates',
                'description' => 'Design responsive email templates for marketing campaigns and notifications.',
                'project' => 'Marketing Campaign',
                'category' => 'Design',
                'priority' => Task::PRIORITY_LOW,
                'status' => Task::STATUS_TODO,
                'tags' => ['design', 'email', 'marketing'],
                'story_points' => 3,
                'estimated_hours' => '8h',
                'completion_percentage' => 0,
            ],
            [
                'title' => 'Implement search functionality',
                'description' => 'Add advanced search capabilities with filters and sorting options.',
                'project' => 'Feature Development',
                'category' => 'Development',
                'priority' => Task::PRIORITY_HIGH,
                'status' => Task::STATUS_REVIEW,
                'tags' => ['frontend', 'backend', 'search'],
                'story_points' => 13,
                'estimated_hours' => '24h',
                'completion_percentage' => 85,
            ],
            [
                'title' => 'Update customer support docs',
                'description' => 'Revise and update all customer support documentation with latest information.',
                'project' => 'Customer Support',
                'category' => 'Documentation',
                'priority' => Task::PRIORITY_MEDIUM,
                'status' => Task::STATUS_TODO,
                'tags' => ['documentation', 'support'],
                'story_points' => 5,
                'estimated_hours' => '10h',
                'completion_percentage' => 0,
            ],
            [
                'title' => 'Plan product launch event',
                'description' => 'Organize and coordinate the launch event for the new product release.',
                'project' => 'Product Launch',
                'category' => 'Planning',
                'priority' => Task::PRIORITY_HIGH,
                'status' => Task::STATUS_IN_PROGRESS,
                'tags' => ['planning', 'event', 'launch'],
                'story_points' => 8,
                'estimated_hours' => '20h',
                'completion_percentage' => 50,
            ],
            [
                'title' => 'Fix responsive design issues',
                'description' => 'Resolve mobile responsiveness problems on the checkout page.',
                'project' => 'Website Redesign',
                'category' => 'Development',
                'priority' => Task::PRIORITY_URGENT,
                'status' => Task::STATUS_HOLD,
                'tags' => ['frontend', 'responsive', 'bug'],
                'story_points' => 5,
                'estimated_hours' => '6h',
                'completion_percentage' => 10,
            ],
            [
                'title' => 'Create analytics dashboard',
                'description' => 'Build a comprehensive analytics dashboard for tracking key metrics.',
                'project' => 'Feature Development',
                'category' => 'Development',
                'priority' => Task::PRIORITY_MEDIUM,
                'status' => Task::STATUS_DONE,
                'tags' => ['frontend', 'analytics', 'dashboard'],
                'story_points' => 13,
                'estimated_hours' => '28h',
                'completion_percentage' => 100,
            ],
            [
                'title' => 'Conduct security audit',
                'description' => 'Perform comprehensive security audit of the application and fix vulnerabilities.',
                'project' => 'Bug Fixes',
                'category' => 'Testing',
                'priority' => Task::PRIORITY_URGENT,
                'status' => Task::STATUS_TODO,
                'tags' => ['security', 'testing', 'audit'],
                'story_points' => 8,
                'estimated_hours' => '16h',
                'completion_percentage' => 0,
            ],
        ];

        $position = 1;
        foreach ($taskTemplates as $template) {
            $user = $users->random();
            $creator = $users->random();
            
            // Set due dates (some in past, some in future)
            $dueDate = null;
            if (rand(1, 3) === 1) {
                $dueDate = now()->addDays(rand(-5, 30));
            }

            // Set timestamps based on status
            $startedAt = null;
            $completedAt = null;
            $reviewedAt = null;

            switch ($template['status']) {
                case Task::STATUS_IN_PROGRESS:
                    $startedAt = now()->subDays(rand(1, 10));
                    break;
                case Task::STATUS_REVIEW:
                    $startedAt = now()->subDays(rand(5, 15));
                    $reviewedAt = now()->subDays(rand(1, 3));
                    break;
                case Task::STATUS_DONE:
                    $startedAt = now()->subDays(rand(10, 30));
                    $reviewedAt = now()->subDays(rand(5, 15));
                    $completedAt = now()->subDays(rand(1, 5));
                    break;
                case Task::STATUS_HOLD:
                    $startedAt = now()->subDays(rand(3, 10));
                    break;
            }

            Task::create([
                'title' => $template['title'],
                'description' => $template['description'],
                'project' => $template['project'],
                'category' => $template['category'],
                'assigned_to' => $user->id,
                'created_by' => $creator->id,
                'priority' => $template['priority'],
                'status' => $template['status'],
                'tags' => $template['tags'],
                'story_points' => $template['story_points'],
                'estimated_hours' => $template['estimated_hours'],
                'due_date' => $dueDate,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'reviewed_at' => $reviewedAt,
                'completion_percentage' => $template['completion_percentage'],
                'position' => $position++,
                'is_public' => true,
                'deadline_type' => Task::DEADLINE_DUE_DATE,
            ]);
        }

        $this->command->info('Created ' . count($taskTemplates) . ' sample tasks.');
    }
}

