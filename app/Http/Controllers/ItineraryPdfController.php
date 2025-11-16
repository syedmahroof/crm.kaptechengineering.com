<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItineraryPdfController extends Controller
{
    public function generate(Itinerary $itinerary)
    {
        try {
            // Ensure itinerary exists and has required data
            if (!$itinerary) {
                throw new \Exception('Itinerary not found');
            }

            // For public frontend access, ensure itinerary is published
            // Admin routes will have auth middleware, so this check only applies to public routes
            if (!auth()->check() && $itinerary->status !== 'published') {
                abort(404, 'Itinerary not found');
            }

            $itinerary->load([
                'country', 
                'destinations.country', 
                'days.items', 
                'user',
                'lead'
            ]);

            // Use professional template
            if (!view()->exists('pdf.itinerary-professional')) {
                throw new \Exception('PDF template not found');
            }

            $pdf = Pdf::loadView('pdf.itinerary-professional', [
                'itinerary' => $itinerary,
            ]);

            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('enable-local-file-access', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);
            
            // Sanitize filename to remove invalid characters
            $filename = $this->sanitizeFilename($itinerary->name);
            
            return $pdf->download($filename . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'itinerary_id' => $itinerary->id ?? 'unknown',
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'error' => 'Failed to generate PDF. Please try again.',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while generating the PDF.'
            ], 500);
        }
    }

    public function view(Itinerary $itinerary)
    {
        try {
            $itinerary->load([
                'country', 
                'destinations.country', 
                'days.items', 
                'user',
                'lead'
            ]);

            return view('pdf.itinerary-professional', [
                'itinerary' => $itinerary,
            ]);
            
        } catch (\Exception $e) {
            Log::error('PDF View Error: ' . $e->getMessage(), [
                'itinerary_id' => $itinerary->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to load PDF view. Please try again.',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while loading the PDF view.'
            ], 500);
        }
    }


    /**
     * Sanitize filename by removing or replacing invalid characters
     */
    private function sanitizeFilename(string $filename): string
    {
        // Remove or replace invalid filename characters using a safer approach
        $invalidChars = ['<', '>', ':', '"', '/', '\\', '|', '?', '*'];
        $filename = str_replace($invalidChars, '_', $filename);
        
        // Remove multiple consecutive underscores and trim
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = trim($filename, '_');
        
        // Ensure filename is not empty and has a reasonable length
        if (empty($filename)) {
            $filename = 'itinerary';
        }
        
        // Limit filename length to avoid filesystem issues
        if (strlen($filename) > 100) {
            $filename = substr($filename, 0, 100);
        }
        
        return $filename;
    }
}
