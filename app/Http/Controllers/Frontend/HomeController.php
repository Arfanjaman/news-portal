<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

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

    public function ShowNews(string $slug)
    {
        $news = News::with(['auther' ,'tags'])->where('slug', $slug)
            ->activeEntries()->withLocalize()
            ->first();


         $mostCommonTags = $this->mostCommonTags();



            $this->countView($news);

        $recentNews = News::with(['category', 'auther'])->where('slug','!=', $news->slug) //current news er sathe recent news same hobe na
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();



       return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags'));
    }


    public function countView($news)
    {                                                              //bar bar refresh korle bar bar view count hobe na
        if(session()->has('viewed_posts')){
            $postIds = session('viewed_posts');

            if(!in_array($news->id, $postIds)){
                $postIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $postIds]);

        }else {
            session(['viewed_posts' => [$news->id]]);

            $news->increment('views');

        }
    }

    public function mostCommonTags()
    {
        return Tag::select('name', DB::raw('COUNT(*) as count'))
            ->where('language', getLangauge())
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(15)
            ->get();
    }



}

