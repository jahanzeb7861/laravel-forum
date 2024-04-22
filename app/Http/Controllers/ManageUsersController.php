<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\User;
use App\Trending;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ManageUsersController extends Controller
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
     * @param  User      $user
     * @param ThreadFilters $filters
     * @param \App\Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, ThreadFilters $filters, Trending $trending)
    {
        try {
            $users = User::all();
            return view('users.index', compact('users'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->first();

        // Load the view for editing the user
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the incoming request data
        $request->validate([
            // 'image' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $user = User::where('id',$request->id)->first();

        // Update the user with the new data
        $user->update($request->all());

        // Redirect back to the users index page or wherever appropriate
        return redirect('/users')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect back to the users index page or wherever appropriate
        return redirect('/users')->with('success', 'User deleted successfully.');
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
            'title' => 'required|spamfree',
            'link' => 'required|spamfree',
            'size' => 'required|spamfree',
            'position' => 'required|spamfree',
            // 'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($request->all());


        // Check if user is an admin
        $user = auth()->user();
        if ($user->type !== 'admin') {
            return redirect()->back()->with('status', 'Only Admin can create New Banner!');
        }

        // Handle image upload
        // $imagePath = $request->file('image')->store('users', 'public');

        $slug = Str::slug('user', '-');

        // dd(!empty($request->file('file')));


        if (!empty($request->file('file'))) {
            // Save Image
            $files = $request->file('file');
            foreach ($files as $key => $file) {
                $imageName = $slug . '-' . now()->format('YmdHis') . $key . '.webp';
                $file->move(public_path('uploads/content/'), $imageName);


                $user = User::create([
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

            $user = User::create([
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
            return response($user, 201);
        }

        return redirect('/users')->with('flash', 'Your user has been created!');
    }

    public function updateUser(Request $request)
    {
        try {


            // dd($request->all());

            // Create Slug name
            $slug = Str::slug('user', '-');


            if (!empty($request->input('removeMedia'))) {
                // Remove Media

                foreach ($request->input('removeMedia') as $id) {
                     try {
                    $removedFile = User::findOrFail($id);
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

            $user = User::where('id', '=',$request->id)->first();

            if (!empty($request->file('file'))) {
                // Save Image
                $files = $request->file('file');
                foreach ($files as $key => $file) {
                    $imageName = $slug . '-' . now()->format('YmdHis') . $key . '.webp';
                    $file->move(public_path('uploads/content/'), $imageName);
                    $user->update([
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

            $user->update([
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

            return redirect('/banners')->with('flash', 'User has been updated!');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong in the DB', 'error' => $th->getMessage()]);
        }
    }
}
