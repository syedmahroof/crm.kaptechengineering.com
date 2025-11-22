<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all contact types from the static method
        $contactTypesMap = Contact::getContactTypes();
        
        // Get all unique contact_type values from contacts table
        $existingTypes = \DB::table('contacts')
            ->select('contact_type')
            ->whereNotNull('contact_type')
            ->distinct()
            ->pluck('contact_type')
            ->toArray();
        
        // Merge with types from static method
        $allTypes = array_unique(array_merge(array_keys($contactTypesMap), $existingTypes));
        
        $sortOrder = 0;
        foreach ($allTypes as $typeKey) {
            // Check if contact type already exists
            $existing = ContactType::where('name', $contactTypesMap[$typeKey] ?? $typeKey)
                ->orWhere('slug', Str::slug($typeKey))
                ->first();
            
            if (!$existing) {
                ContactType::create([
                    'name' => $contactTypesMap[$typeKey] ?? ucfirst(str_replace('_', ' ', $typeKey)),
                    'slug' => Str::slug($typeKey),
                    'description' => null,
                    'color' => $this->getColorForType($typeKey),
                    'icon' => $this->getIconForType($typeKey),
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }
    
    private function getColorForType(string $type): string
    {
        $colors = [
            'builders_developers' => '#3B82F6',
            'hospitals' => '#EF4444',
            'mep_consultants' => '#10B981',
            'architects' => '#8B5CF6',
            'project' => '#F59E0B',
            'plumbing_contractors' => '#06B6D4',
            'electrical_contractors' => '#F97316',
            'hvac_contractors' => '#14B8A6',
            'petrol_pump_contractors' => '#EC4899',
            'civil_eng_contractors' => '#6366F1',
            'fire_fighting_contractors' => '#DC2626',
            'interior_designers' => '#A855F7',
            'swimming_pool_stp' => '#0EA5E9',
            'biomedicals' => '#84CC16',
            'shop_retail' => '#F43F5E',
        ];
        
        return $colors[$type] ?? '#3B82F6';
    }
    
    private function getIconForType(string $type): string
    {
        $icons = [
            'builders_developers' => 'fa-building',
            'hospitals' => 'fa-hospital',
            'mep_consultants' => 'fa-cogs',
            'architects' => 'fa-drafting-compass',
            'project' => 'fa-project-diagram',
            'plumbing_contractors' => 'fa-wrench',
            'electrical_contractors' => 'fa-bolt',
            'hvac_contractors' => 'fa-wind',
            'petrol_pump_contractors' => 'fa-gas-pump',
            'civil_eng_contractors' => 'fa-hard-hat',
            'fire_fighting_contractors' => 'fa-fire-extinguisher',
            'interior_designers' => 'fa-paint-brush',
            'swimming_pool_stp' => 'fa-swimming-pool',
            'biomedicals' => 'fa-stethoscope',
            'shop_retail' => 'fa-store',
        ];
        
        return $icons[$type] ?? 'fa-address-book';
    }
}
