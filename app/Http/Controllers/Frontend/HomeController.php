<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    //
    public function index()
    {
        $breakingNews = News::where(['is_breaking_news' => 1,])
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();
      //  dd( $breakingNews);

        return view('frontend.home', compact('breakingNews'));
    }


}
