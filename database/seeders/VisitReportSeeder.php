<?php

namespace Database\Seeders;

use App\Models\VisitReport;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisitReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        if ($projects->isEmpty()) {
            $this->command->warn('No projects found. Please run ProjectSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $objectives = [
            'Site inspection and progress review',
            'Meeting with project manager to discuss timeline',
            'Quality check and material verification',
            'Client meeting for approval',
            'Follow-up on previous visit concerns',
            'Safety audit and compliance check',
            'Coordination meeting with contractors',
            'Final inspection before handover',
            'Technical discussion with engineers',
            'Budget review and cost analysis',
            'Material delivery verification',
            'Work progress assessment',
            'Client feedback collection',
            'Issue resolution meeting',
            'Documentation and reporting',
        ];

        $reports = [
            'Site visit completed successfully. All work is progressing as per schedule. Materials are available and quality is satisfactory.',
            'Met with project team. Discussed upcoming milestones and resource requirements. All stakeholders are aligned.',
            'Conducted quality inspection. Found minor issues which were addressed on-site. Overall quality is good.',
            'Client meeting went well. Received positive feedback on progress. Some design modifications requested.',
            'Followed up on previous concerns. All issues have been resolved. Site is ready for next phase.',
            'Safety audit completed. All safety measures are in place. No violations found.',
            'Coordination meeting held with all contractors. Timeline and responsibilities clarified.',
            'Final inspection completed. All work meets quality standards. Ready for handover.',
            'Technical discussion with engineering team. Resolved technical queries and approved design changes.',
            'Budget review completed. Project is within budget. Some cost optimizations identified.',
            'Material delivery verified. All materials received are as per specifications.',
            'Work progress assessed. Project is 75% complete. On track for deadline.',
            'Collected client feedback. Overall satisfaction is high. Minor suggestions noted.',
            'Issue resolution meeting held. All pending issues discussed and action plan created.',
            'Documentation updated. All reports and records are current and accurate.',
        ];

        $visitReports = [];

        // Create visit reports for the last 6 months
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        // Create approximately 50-60 visit reports
        for ($i = 0; $i < 55; $i++) {
            $project = $projects->random();
            $user = $users->random();
            
            // Random date within the last 6 months
            $visitDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            )->startOfDay();

            $objective = $objectives[array_rand($objectives)];
            $report = $reports[array_rand($reports)];

            // 70% chance of having next meeting date
            $nextMeetingDate = null;
            if (rand(1, 100) <= 70) {
                $nextMeetingDate = $visitDate->copy()->addDays(rand(7, 30));
            }

            // 60% chance of having next call date
            $nextCallDate = null;
            if (rand(1, 100) <= 60) {
                $nextCallDate = $visitDate->copy()->addDays(rand(3, 14));
            }

            $visitReports[] = [
                'project_id' => $project->id,
                'user_id' => $user->id,
                'visit_date' => $visitDate,
                'objective' => $objective,
                'report' => $report,
                'next_meeting_date' => $nextMeetingDate,
                'next_call_date' => $nextCallDate,
                'created_at' => $visitDate,
                'updated_at' => $visitDate,
            ];
        }

        // Sort by visit date
        usort($visitReports, function($a, $b) {
            return $a['visit_date'] <=> $b['visit_date'];
        });

        foreach ($visitReports as $visitReportData) {
            VisitReport::create($visitReportData);
        }

        $this->command->info('Created ' . count($visitReports) . ' visit reports.');
    }
}
