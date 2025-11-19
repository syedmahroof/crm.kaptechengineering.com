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
            
            // Extract send_itinerary flag (status update removed per user request)
            $sendItinerary = $data['send_itinerary'] ?? false;
            unset($data['send_itinerary']);
            
            // Extract products
            $products = $data['products'] ?? [];
            unset($data['products']);
            
            $lead = Lead::create(array_merge($data, [
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]));
            
            // If send_itinerary is true, only update timestamp (status update removed)
            if ($sendItinerary) {
                $lead->update(['itinerary_sent_at' => now()]);
            }
            
            // Attach products to lead
            if (!empty($products)) {
                foreach ($products as $productData) {
                    if (!empty($productData['product_id'])) {
                        $quantity = $productData['quantity'] ?? 1;
                        $unitPrice = $productData['unit_price'] ?? null;
                        $totalPrice = $unitPrice ? ($quantity * $unitPrice) : null;
                        
                        $lead->leadProducts()->create([
                            'product_id' => $productData['product_id'],
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                            'notes' => $productData['notes'] ?? null,
                        ]);
                    }
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
