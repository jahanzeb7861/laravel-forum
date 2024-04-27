<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BannersController extends Controller
{
    /**
     * Create a new BannersController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Channel      $channel
     * @param ThreadFilters $filters
     * @param \App\Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        try {
            $banners = Banner::all();
            return view('banners.index', compact('banners'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit(Banner $banner)
    {
        // Load the view for editing the banner
        return view('banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        // Validate the incoming request data
        $request->validate([
            'image' => 'nullable|string',
            'type' => 'nullable|string',
            'link' => 'nullable|string',
            'title' => 'nullable|string',
            'alt' => 'nullable|string',
            'sort' => 'nullable|string',
            'status' => 'nullable|integer',
        ]);

        // Update the banner with the new data
        $banner->update($request->all());

        // Redirect back to the banners index page or wherever appropriate
        return redirect('/banners')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        // Delete the banner
        $banner->delete();

        // Redirect back to the banners index page or wherever appropriate
        return redirect('/banners')->with('success', 'Banner deleted successfully.');
    }

    public function create()
    {
        // Load the view for creating a new banner
        return view('banners.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Rules\Recaptcha $recaptcha
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'size' => 'required',
            'position' => 'required',
            // 'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($request->all());


        // Check if user is an admin
        $user = auth()->user();
        if ($user->type !== 'admin') {
            return redirect()->back()->with('status', 'Only Admin can create New Banner!');
        }

        // Handle image upload
        // $imagePath = $request->file('image')->store('banners', 'public');

        $slug = Str::slug('banner', '-');

        // dd(!empty($request->file('file')));


        if (!empty($request->file('file'))) {
            // Save Image
            $files = $request->file('file');
            foreach ($files as $key => $file) {
                $imageName = $slug . '-' . now()->format('YmdHis') . $key . '.webp';
                $file->move(public_path('uploads/content/'), $imageName);


                $banner = Banner::create([
                    'title' => $request->input('title'),
                    'link' => $request->input('link'),
                    'store_link' => $request->input('store_link'),
                    'image' => $imageName,
                    'size' => $request->input('size'),
                    'position' => $request->input('position'),
                    'type' => 'slider',
                    'alt' => $request->input('title'),
                    'sort' => 1,
                    'status' => 1,
                ]);
            }
        } else {

            $banner = Banner::create([
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'store_link' => $request->input('store_link'),
            'size' => $request->input('size'),
            'position' => $request->input('position'),
            'type' => 'slider',
            'alt' => $request->input('title'),
            'sort' => 1,
            'status' => 1,
        ]);

        }



        // Create thread
        // $banner = Banner::create([
        //     'title' => $request->input('title'),
        //     'link' => $request->input('link'),
        //     'image' => $imageName,
        //     'type' => 'slider',
        //     'alt' => $request->input('title'),
        //     'sort' => 1,
        //     'status' => 1,
        // ]);

        if ($request->wantsJson()) {
            return response($banner, 201);
        }

        return redirect('/banners')->with('flash', 'Your banner has been created!');
    }

    public function updateBanner(Request $request)
    {
        try {


            // dd($request->all());

            // Create Slug name
            $slug = Str::slug('banner', '-');


            if (!empty($request->input('removeMedia'))) {
                // Remove Media

                foreach ($request->input('removeMedia') as $id) {
                     try {
                    $removedFile = Banner::findOrFail($id);
                    $oldImagePath = public_path('uploads/content/'. $removedFile->file_name) ;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $removedFile->delete();
                     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                        // Handle the case where the record is not found (log, return response, etc.)
                        return response()->json(['status' => 'danger', 'message' => 'Media record not found', 'error' => $e->getMessage()]);
                }
                }
            }

            $banner = Banner::where('id', '=',$request->id)->first();

            if (!empty($request->file('file'))) {
                // Save Image
                $files = $request->file('file');
                foreach ($files as $key => $file) {
                    $imageName = $slug . '-' . now()->format('YmdHis') . $key . '.webp';
                    $file->move(public_path('uploads/content/'), $imageName);
                    $banner->update([
                        'title' => $request->input('title'),
                        'link' => $request->input('link'),
                        'store_link' => $request->input('store_link'),
                        'image' => $imageName,
                        'size' => $request->input('size'),
                        'position' => $request->input('position'),
                        'type' => 'slider',
                        'alt' => $request->input('title'),
                        'sort' => 1,
                        'status' => 1,
                    ]);
                }
            }

            $banner->update([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'store_link' => $request->input('store_link'),
                'size' => $request->input('size'),
                'position' => $request->input('position'),
                'type' => 'slider',
                'alt' => $request->input('title'),
                'sort' => 1,
                'status' => 1,
            ]);

            return redirect('/banners')->with('flash', 'Your banner has been updated!');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong in the DB', 'error' => $th->getMessage()]);
        }
    }
}
