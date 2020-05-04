<?php

namespace App\Services;
use App\Models\Post;

// Repositories
use App\Repositories\PostRepository;

// Facades
use Illuminate\Support\Facades\Storage;

class PostService extends BaseService
{
    protected $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository;
    }

    /**
     * Get all enabled Posts.
     *
     * @return \App\Models\Post[]|boolean
     */
    public function getAllEnabledPosts()
    {
        return $this->postRepository->getAllEnabledPosts();
    }

    /**
     * Get the first post based on the id.
     *
     * @param  int  $id
     * @return \App\Models\post|boolean
     */
    public function getFirstPostById($id)
    {
        return $this->postRepository->getFirstPostById($id);
    }

    /**
     * Get the paginated list of Posts.
     *
     * @param  int $perPage
     * @return \App\Models\post[]|boolean
     */
    public function getPaginatedListOfPosts($perPage)
    {
        return $this->postRepository->getPaginatedListOfPosts($perPage);
    }

     /**
     * Creating a new Post.
     *
     * @param  array $input
     * @return \App\Models\Post|boolean
     */
    public function createPost($input)
    {
        /* Save image in temporary variable and remove from the input array. */
        $tempImage = $input['image'];
        unset($input['image']);

        try{
            /* Save image at the desired location. */
            $temp = Storage::put('/public/images/posts', $tempImage);
            $input['logo'] = '/images/posts/'.basename($temp);
            
        }catch(\Exception $e)
        {
            \Log::channel('post')->error("post image not uploaded because an exception occured: ");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }

        $post = $this->postRepository->createPost($input);

                
        return $post;
    }

    /**
     * Get all posts plucked by name
     *
     *
     * @return Array posts[]
     */
    public function getAllPostsPluckedByName()
    {
        return $this->postRepository->getAllPostsPluckedByName();
    }

    /**
     * Update an post based on the model object.
     *
     * @param  array $update
     * @param  \App\Models\post $post
     * @return boolean
     */
    public function updatePostByModel($update, Post $post)
    {
        $tempImage = isset($update['image']) ? $update['image'] : null;
        unset($update['image']);

        $previous['image'] = $post->getOriginal('logo');
        try
        {
            $temp = Storage::put('public/images/posts', $tempImage);
            $update['logo'] = '/images/posts/'.basename($temp);
        }catch (\Exception $e)
        {
            \Log::error("post not updated because an exception occured:");
            \Log::error($e->getMessage());
            return false;
        }
        $result = $this->postRepository->updatePostByModel($post, $update);

        if ($result)
        {
            if(isset($update['image']))
                Storage::delete('/images/posts'.$previous['image']);
            return $result;
        }
        else
        {
            Storage::delete('/images/posts'.$previous['image']);
            return $result;
        }
    }
}