<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Image;

// Exception
use Exception;

// Log
use Log;

class ImageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Inserting  images.
     *
     * @param array $input
     * @return boolean
     */
    public function insertImages($input)
    {
        try
        {
            return Image::insert($input);
        }catch (\Exception $e)
        {
            \Log::error(" Images not inserted because an exception occured:");
            \Log::error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the  image based on the id.
     *
     * @param int $id
     * @return App\Models\Image
     */
    public function getImageById($id)
    {
        try
        {
            return Image::find($id);
        }catch (\Exception $e)
        {
            \Log::error(" Image not found by Id because an exception occured:");
            \Log::error($e->getMessage());

            return false;
        }
    }

    /**
     * Delete a  image based on the id.
     *
     * @param int $id
     * @return boolean
     */
    public function deleteImageById($id)
    {
        try
        {
            return Image::find($id)->delete();
        }catch (\Exception $e)
        {
            \Log::error(" Image not deleted by Id because an exception occured:");
            \Log::error($e->getMessage());

            return false;
        }
    }
}