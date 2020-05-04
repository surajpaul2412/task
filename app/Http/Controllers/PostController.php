<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model
use App\Models\Post;
// Services
use App\Services\PostService;
//request
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
// Support Facades
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = new $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->getPaginatedListOfPosts(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreatePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->validated();

        $result = $this->postService->createPost($input);

        if($result)
            Session::flash('success', 'The Post has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the Post.');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit', compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EditPostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, $id)
    {
        $update = $request->validated();
        $result = $this->postService->updatePostByModel($update, $post);

        if($result)
            Session::flash('success', 'The post has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the post.');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
