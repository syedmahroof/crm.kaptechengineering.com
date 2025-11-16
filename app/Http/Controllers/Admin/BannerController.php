<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::ordered()->paginate(15);

        // Transform banners to include image URLs
        $banners->getCollection()->transform(function ($banner) {
            // Add URL accessors for frontend display
            $banner->image_url = $banner->image_url;
            $banner->mobile_image_url = $banner->mobile_image_url;
            $banner->desktop_image_url = $banner->desktop_image_url;
            
            // Also add URLs with field names that frontend expects
            $banner->image = $banner->image_url;
            $banner->mobile_image = $banner->mobile_image_url;
            $banner->desktop_image = $banner->desktop_image_url;
            
            return $banner;
        });

        return view('admin.banners.index', [
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_tag' => 'nullable|string|max:255',
            'image_position' => 'nullable|in:top,center,bottom,left,right',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'link' => 'nullable|url',
            'button_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle file uploads
        $data = $validated;
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }
        
        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $request->file('mobile_image')->store('banners', 'public');
        }
        
        if ($request->hasFile('desktop_image')) {
            $data['desktop_image'] = $request->file('desktop_image')->store('banners', 'public');
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', [
            'banner' => $banner,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        // Ensure preview URLs are available to the frontend
        $bannerTransformed = array_merge($banner->toArray(), [
            'image' => $banner->image_url,
            'mobile_image' => $banner->mobile_image_url,
            'desktop_image' => $banner->desktop_image_url,
        ]);

        return view('admin.banners.edit', [
            'banner' => $banner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        // Debug: Log the incoming request data
        \Log::info('Update request data:', [
            'all' => $request->all(),
            'files' => [
                'has_image' => $request->hasFile('image'),
                'has_mobile_image' => $request->hasFile('mobile_image'),
                'has_desktop_image' => $request->hasFile('desktop_image'),
            ],
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'is_ajax' => $request->ajax(),
        ]);

        try {
            // Base validation rules
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'alt_tag' => 'nullable|string|max:255',
                'image_position' => 'nullable|in:top,center,bottom,left,right',
                'overlay_opacity' => 'nullable|integer|min:0|max:100',
                'link' => 'nullable|url',
                'button_text' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ];

            // Add file validation rules if files are present
            if ($request->hasFile('image')) {
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            if ($request->hasFile('mobile_image')) {
                $rules['mobile_image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
            if ($request->hasFile('desktop_image')) {
                $rules['desktop_image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            // Validate the request
            $validated = $request->validate($rules);
            
            // Get the input data
            $input = $request->all();
            
            // Prepare data for update
            $data = [
                'title' => $input['title'] ?? $banner->title,
                'description' => $input['description'] ?? $banner->description,
                'alt_tag' => $input['alt_tag'] ?? $banner->alt_tag,
                'image_position' => $input['image_position'] ?? $banner->image_position ?? 'center',
                'overlay_opacity' => isset($input['overlay_opacity']) ? (int)$input['overlay_opacity'] : $banner->overlay_opacity ?? 40,
                'link' => $input['link'] ?? $banner->link,
                'button_text' => $input['button_text'] ?? $banner->button_text,
                'sort_order' => isset($input['sort_order']) ? (int)$input['sort_order'] : $banner->sort_order ?? 0,
                'is_active' => isset($input['is_active']) ? (bool)$input['is_active'] : $banner->is_active ?? false,
            ];
            
            // Handle file uploads
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($banner->image) {
                    Storage::disk('public')->delete($banner->image);
                }
                $data['image'] = $request->file('image')->store('banners', 'public');
            } elseif (isset($input['existing_image'])) {
                if ($input['existing_image'] === '') {
                    // Handle image removal
                    if ($banner->image) {
                        Storage::disk('public')->delete($banner->image);
                        $data['image'] = null;
                    }
                } elseif ($input['existing_image'] !== $banner->image) {
                    $data['image'] = $input['existing_image'];
                }
            }
            
            if ($request->hasFile('mobile_image')) {
                if ($banner->mobile_image) {
                    Storage::disk('public')->delete($banner->mobile_image);
                }
                $data['mobile_image'] = $request->file('mobile_image')->store('banners', 'public');
            } elseif (isset($input['existing_mobile_image'])) {
                if ($input['existing_mobile_image'] === '') {
                    if ($banner->mobile_image) {
                        Storage::disk('public')->delete($banner->mobile_image);
                        $data['mobile_image'] = null;
                    }
                } elseif ($input['existing_mobile_image'] !== $banner->mobile_image) {
                    $data['mobile_image'] = $input['existing_mobile_image'];
                }
            }
            
            if ($request->hasFile('desktop_image')) {
                if ($banner->desktop_image) {
                    Storage::disk('public')->delete($banner->desktop_image);
                }
                $data['desktop_image'] = $request->file('desktop_image')->store('banners', 'public');
            } elseif (isset($input['existing_desktop_image'])) {
                if ($input['existing_desktop_image'] === '') {
                    if ($banner->desktop_image) {
                        Storage::disk('public')->delete($banner->desktop_image);
                        $data['desktop_image'] = null;
                    }
                } elseif ($input['existing_desktop_image'] !== $banner->desktop_image) {
                    $data['desktop_image'] = $input['existing_desktop_image'];
                }
            }

            // Update the banner
            $banner->update($data);

            // For Inertia requests, always respond with a redirect (no JSON)
            if ($request->header('X-Inertia')) {
                return redirect()->route('admin.banners.index')
                    ->with('success', 'Banner updated successfully.');
            }

            // For pure API consumers requesting JSON (non-Inertia)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner updated successfully.',
                    'redirect' => route('admin.banners.index')
                ]);
            }

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // For Inertia requests, redirect back with errors and old input
            if ($request->header('X-Inertia')) {
                return back()->withErrors($e->errors())->withInput();
            }

            // For pure API consumers requesting JSON (non-Inertia)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validation failed.'
                ], 422);
            }

            // Default: rethrow to let Laravel handle
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error updating banner: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the banner.'
                ], 500);
            }
            
            return back()->with('error', 'An error occurred while updating the banner.');
        }
    }

    /**
     * Handle POST request for banner update (for forms that don't support PUT)
     */
    public function updatePost(Request $request, Banner $banner)
    {
        return $this->update($request, $banner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Delete associated image files
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        if ($banner->mobile_image) {
            Storage::disk('public')->delete($banner->mobile_image);
        }
        if ($banner->desktop_image) {
            Storage::disk('public')->delete($banner->desktop_image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    /**
     * Toggle banner active status
     */
    public function toggleActive(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        return response()->json([
            'message' => 'Banner status updated successfully',
            'is_active' => $banner->is_active,
        ]);
    }
}
