<?php

namespace App\Actions\Leads;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreLeadAction
{
    public function execute($data)
    {
        try {
            DB::beginTransaction();
            
            // Extract send_itinerary flag
            $sendItinerary = $data['send_itinerary'] ?? false;
            unset($data['send_itinerary']);
            
            $lead = Lead::create(array_merge($data, [
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]));
            
            // If send_itinerary is true, update the lead status to 'itinerary_sent'
            if ($sendItinerary) {
                $itinerarySentStatus = \App\Models\LeadStatus::where('slug', 'itinerary_sent')->first();
                if ($itinerarySentStatus) {
                    $lead->update(['lead_status_id' => $itinerarySentStatus->id]);
                }
            }
            
            DB::commit();
            
            return $lead;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
