<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Post;

class PostRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
     * Get all enabled Posts.
     *
     * @return \App\Models\Post[]|boolean
     */
    public function getAllEnabledPosts()
	{
		try
		{
			return Post::where('disabled', 0)->get();
		} catch(\Exception $e)
		{
			\Log::channel('post')->error("All enabled post not fetched because an exception occured: ");
			\Log::channel('post')->error($e->getMessage());

			return false;
		}
	}

    /**
     * Get the first Post by the id.
     *
     * @param  int  $id
     * @return \App\Models\Post|boolean
     */
    public function getFirstPostById($id)
    {
        try
        {
            return Post::where('id', $id)->first();
        }catch (\Exception $e)
        {
            \Log::channel('post')->error("First post by id not fetched because an exception occured: ");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the paginated list of Posts.
     *
     * @param  int $perPage
     * @return \App\Models\post[]|boolean
     */
    public function getPaginatedListOfPosts($perPage)
    {
        try
        {
            return Post::orderBy('updated_at', 'desc')->paginate($perPage);
        }catch (\Exception $e)
        {
            \Log::channel('post')->error("Paginated list of posts not fetched because an exception occured: ");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }
    }


    /**
     * Creating a new Post.
     *
     * @param  array $input
     * @return \App\Models\Post|boolean
     */
    public function createPost($input)
    {
        try
        {
            return Post::create($input);
        }catch (\Exception $e)
        {
            \Log::channel('post')->error("New post not created because an exception occured: ");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }
    }


    /**
     * Get all posts plucked by name
     *
     *
     * @return Array posts[]
     */
    public function getAllPostsPluckedByName()
    {
        try
        {
            return Post::all()->pluck('name','id');
        }catch (\Exception $e)
        {
            \Log::channel('post')->error("Plucked list of posts not returned because an exception occured");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get Post by Model.
     *
     * @param  integer $Post
     * @return \App\Models\Post|boolean
     */
    public function getPostByModel($post)
    {
        try{
            return Post::find($post->id);
        }catch(\Exception $e)
        {
            \Log::error("Post not found because an exception occured: ");
            \Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Update a post.
     *
     * @param  int $post
     * @param  array $update
     * @return boolean
     */
    public function updatePostByModel($post, $update)
    {
        try
        {
            $post = Post::find($post->id);
            if($post->update($update))
                return true;
            else
                return false;
        }catch (\Exception $e)
        {
            \Log::error("post not updated because an exception occured:");
            \Log::error($e->getMessage());

            return false;
        }
    }
}