<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterInfo extends Model
{
     use HasFactory;

    protected $fillable = [
        'language',
        'logo',
        'description',
        'copyright'
    ];
}
