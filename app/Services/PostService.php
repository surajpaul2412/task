<?php

namespace App\Services;
use App\Models\Post;

// Repositories
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;

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
        // $tempImage = $input['logo'];
        // unset($input['logo']);

        // try{
        //     $temp = Storage::put('/public/images/posts', $tempImage);
        //     $input['logo'] = '/images/posts/'.basename($temp);
            
        // }catch(\Exception $e)
        // {
        //     \Log::channel('post')->error("post image not uploaded because an exception occured: ");
        //     \Log::channel('post')->error($e->getMessage());

        //     return false;
        // }

        // $post = $this->postRepository->createPost($input);
                
        // return $post;

        $tempImage = $input['logo'];
        unset($input['logo']);

        try{
            $temp = Storage::put('/public/images/posts', $tempImage);
            $input['logo'] = '/images/posts/'.basename($temp);
            
        }catch(\Exception $e)
        {
            \Log::channel('post')->error("post image not uploaded because an exception occured: ");
            \Log::channel('post')->error($e->getMessage());

            return false;
        }

        $inputImages = array();

        if(isset($input['image']))
        { 
            try
            {
                foreach ($input['image'] as $value) {
                    $image = $value;
                    $temp = Storage::put('/public/images/posts', $image);
                    $inputImages[] = basename($temp);
                }
            }catch (\Exception $e)
            {
                \Log::error("New post not created because an exception occured:");
                \Log::error($e->getMessage());

                return false;
            }
        }

        $post = $this->postRepository->createPost($input);

        if ($post)
        {
            if(isset($input['image']))
            { 
                $this->ImageRepostiory = new ImageRepository();

                $inputData = array();
                $i = 0;
                foreach ($inputImages as $key => $value) {
                    $inputData[$i]['url'] = '/images/posts/'. $value;
                    $inputData[$i]['imageable_id'] = $post->id;
                    $inputData[$i]['imageable_type'] = 'App\Models\Post';
                    $inputData[$i]['created_at'] = now();
                    $inputData[$i]['updated_at'] = now();
                    $i++;
                }

                $this->ImageRepostiory->insertImages($inputData);
            }

            return $post;
        }
        else
        {
            foreach ($inputImages as $key => $value) {
                Storage::delete('/public/images/widgets/'.$value);
            }

            return $post;
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