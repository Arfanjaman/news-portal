<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
        public function news()
    {
        // Define the many-to-many relationship with News model
        return $this->belongsToMany(News::class, 'news_tags');
    }
}
