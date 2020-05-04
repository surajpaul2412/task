<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =['name','logo'];

    /**
     * Get value of post logo.
     *
     * @param  string $value
     * @return string
     */
    public function getLogoAttribute($value){
        return asset('/storage' . $value);
    }
}
