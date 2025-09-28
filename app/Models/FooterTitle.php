<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterTitle extends Model
{
     protected $fillable = [
        'key', 'value', 'language'
    ];
}
