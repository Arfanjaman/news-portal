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


     /** scope for active items */
    public function scopeActiveEntries($query)
    {
        return $query->where([
            'status' => 1,
            'is_approved' => 1
        ]);
    }

    /** scope for check language */
    public function scopeWithLocalize($query)
    {
        return $query->where([
            'language' => getLangauge()
        ]);
    }









    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function auther()
    {
        return $this->belongsTo(Admin::class);
    }



}
