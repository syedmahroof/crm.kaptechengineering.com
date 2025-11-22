<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all project types from the static method
        $projectTypesMap = Project::getProjectTypes();
        
        // Get all unique project_type values from projects table
        $existingTypes = \DB::table('projects')
            ->select('project_type')
            ->whereNotNull('project_type')
            ->distinct()
            ->pluck('project_type')
            ->toArray();
        
        // Merge with types from static method
        $allTypes = array_unique(array_merge(array_values($projectTypesMap), $existingTypes));
        
        $sortOrder = 0;
        foreach ($allTypes as $typeName) {
            // Check if project type already exists
            $existing = ProjectType::where('name', $typeName)
                ->orWhere('slug', Str::slug($typeName))
                ->first();
            
            if (!$existing) {
                // Find the key for this type name to get the slug
                $typeKey = array_search($typeName, $projectTypesMap);
                $slug = $typeKey ? Str::slug($typeKey) : Str::slug($typeName);
                
                ProjectType::create([
                    'name' => $typeName,
                    'slug' => $slug,
                    'description' => null,
                    'color' => $this->getColorForType($typeName),
                    'icon' => $this->getIconForType($typeName),
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }
    
    private function getColorForType(string $type): string
    {
        $colors = [
            'Residential' => '#3B82F6',
            'Commercial' => '#10B981',
            'Industrial' => '#F59E0B',
            'Infrastructure' => '#8B5CF6',
            'Hospital' => '#EF4444',
            'Hotel' => '#EC4899',
            'Educational' => '#06B6D4',
            'Retail' => '#F97316',
            'Office' => '#6366F1',
            'Mixed Use' => '#14B8A6',
            'Other' => '#6B7280',
        ];
        
        return $colors[$type] ?? '#3B82F6';
    }
    
    private function getIconForType(string $type): string
    {
        $icons = [
            'Residential' => 'fa-home',
            'Commercial' => 'fa-building',
            'Industrial' => 'fa-industry',
            'Infrastructure' => 'fa-road',
            'Hospital' => 'fa-hospital',
            'Hotel' => 'fa-hotel',
            'Educational' => 'fa-graduation-cap',
            'Retail' => 'fa-store',
            'Office' => 'fa-briefcase',
            'Mixed Use' => 'fa-city',
            'Other' => 'fa-project-diagram',
        ];
        
        return $icons[$type] ?? 'fa-project-diagram';
    }
}
