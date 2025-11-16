<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function showForm($campaign = null)
    {

        if ($campaign) {
            // If campaign ID is provided, use that campaign
            $campaignId = $campaign;
            $campaignData = Campaign::where('id', $campaign)->orWhere('slug', $campaign)->first();
            
            if (!$campaignData) {
                abort(404, 'Campaign not found');
            }
            
            return view('frontend.campaign-form', compact('campaignId', 'campaignData'));
        } else {
            // Default campaign for general form
            $campaignId = 'trip-giveaway-' . date('Y');
            $campaignData = null;
            
            return view('frontend.campaign-form', compact('campaignId', 'campaignData'));
        }
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'age' => 'required|integer|min:18|max:100',
            'dream_destination' => 'required|string|max:255',
            'travel_experience' => 'required|string|max:2000',
            'social_media' => 'nullable|string|max:255',
            'terms_accepted' => 'required|accepted',
            'campaign_id' => 'required|string',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'age.required' => 'Please enter your age.',
            'age.min' => 'You must be at least 18 years old to participate.',
            'age.max' => 'Please enter a valid age.',
            'dream_destination.required' => 'Please tell us your dream destination.',
            'travel_experience.required' => 'Please share your travel experience.',
            'terms_accepted.required' => 'You must accept the terms and conditions.',
            'terms_accepted.accepted' => 'You must accept the terms and conditions.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Check if campaign_id is numeric (existing campaign) or string (new campaign)
            $campaignId = $request->input('campaign_id');
            
            if (is_numeric($campaignId)) {
                // Existing campaign by ID
                $campaign = Campaign::find($campaignId);
                if (!$campaign) {
                    return redirect()->back()
                        ->withErrors(['error' => 'Campaign not found.'])
                        ->withInput();
                }
            } else {
                // Create or find campaign by slug
                $campaign = Campaign::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($campaignId)],
                    [
                        'name' => $campaignId,
                        'description' => 'Trip Giveaway Campaign ' . date('Y'),
                        'type' => 'event',
                        'status' => Campaign::STATUS_ACTIVE,
                        'created_by' => auth()->id() ?? 1,
                    ]
                );
            }

            CampaignContact::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'age' => $request->input('age'),
                'dream_destination' => $request->input('dream_destination'),
                'travel_experience' => $request->input('travel_experience'),
                'social_media' => $request->input('social_media'),
                'campaign_id' => $campaign->id,
                'terms_accepted' => $request->boolean('terms_accepted'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'additional_data' => [
                    'submitted_at' => now()->toISOString(),
                    'form_version' => '1.0',
                ],
            ]);

            return redirect()->back()->with('success', 'Your entry has been submitted successfully! Good luck!');
        } catch (\Exception $e) {
            \Log::error('Campaign form submission error', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Something went wrong. Please try again later.'])
                ->withInput();
        }
    }
}
