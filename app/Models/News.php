<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    public function tags()
    {
        // Define the many-to-many relationship with Tag model
        return $this->belongsToMany(Tag::class, 'news_tags');
    }
}
