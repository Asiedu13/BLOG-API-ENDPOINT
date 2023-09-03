<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $blogs = Blog::latest()->paginate(10);
        return [
            "status"=>1,
            "data" =>$blogs,
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title'=>'required|email',
        //     'body'=> 'required'
        // ]);

        $validatedData = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
            'status' => false,
            'errors' => $validatedData->errors()
            ], 401);
        }

        $blog = Blog::create($request->all());
        return response()->json([
            'status' => false,
            'data' => $blog
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return [
            'status'=>1,
            'data'=> $blog
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $blog->title = $request->input('title');
        $blog->body = $request->input('body');
        $blog->update();

        return [
            'status'=>1,
            'data'=>$blog,
            'msg'=> 'Blog updated',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        return [
            'status'=>1,
            'data'=>$blog,
        ];

        // Search first
        $foundBlog = Blog::find($blog);
        echo $foundBlog;

        if (is_null($foundBlog)) {
            return response()->json([
            'status' => false,
            'message' => 'blog article not found'
            ], 404);
        }
        // Delete
        $blog->delete();
        return [
            'status'=>1,
            'data'=>$blog,
            'msg'=>'blog deleted successfully'
        ];
    }
}
