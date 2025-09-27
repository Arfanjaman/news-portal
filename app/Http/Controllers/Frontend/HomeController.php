<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HomeSectionSetting;
use App\Models\SocialCount;
use App\Models\Ad;

class HomeController extends Controller
{
    //
    public function index()
    {
        $breakingNews = News::where(['is_breaking_news' => 1,])
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();
      //  dd( $breakingNews);
          $heroSlider = News::with(['category', 'auther'])
            ->where('show_at_slider', 1)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')->take(7)
            ->get();



         $recentNews = News::with(['category', 'auther'])->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')->take(6)->get();

         $popularNews = News::with(['category'])->where('show_at_popular', 1)
            ->activeEntries()->withLocalize()
            ->orderBy('updated_at', 'DESC')->take(4)->get();

         $HomeSectionSetting = HomeSectionSetting::where('language', getLangauge())->first();


         $categorySectionOne = News::where('category_id', $HomeSectionSetting->category_section_one)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
         $categorySectionTwo = News::where('category_id', $HomeSectionSetting->category_section_two)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $categorySectionThree = News::where('category_id', $HomeSectionSetting->category_section_three)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get();

        $categorySectionFour = News::where('category_id', $HomeSectionSetting->category_section_four)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();


         $mostViewedPosts = News::activeEntries()->withLocalize()
            ->orderBy('views', 'DESC')
            ->take(3)
            ->get();


          $socialCounts = SocialCount::where(['status' => 1, 'language' => getLangauge()])->get();

            $mostCommonTags = $this->mostCommonTags();

         $ad = Ad::first();

        return view('frontend.home', compact(
            'breakingNews',
            'heroSlider',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'categorySectionFour',
            'mostViewedPosts',
             'socialCounts',
             'mostCommonTags',
                'ad'
        ));
    }

    public function ShowNews(string $slug)
    {
        $news = News::with(['auther' ,'tags' ,'comments'])->where('slug', $slug)
            ->activeEntries()->withLocalize()
            ->first();


         $mostCommonTags = $this->mostCommonTags();



            $this->countView($news);

        $recentNews = News::with(['category', 'auther'])->where('slug','!=', $news->slug) //current news er sathe recent news same hobe na
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();


         $nextPost = News::where('id', '>', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'asc')->first();

        $previousPost = News::where('id', '<', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')->first();

        $relatedPosts = News::where('slug', '!=', $news->slug)
            ->where('category_id', $news->category_id)
            ->activeEntries()
            ->withLocalize()
            ->take(5)
            ->get();

        $socialCounts = SocialCount::where(['status' => 1, 'language' => getLangauge()])->get();

       $ad = Ad::first();

       return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags', 'nextPost', 'previousPost', 'relatedPosts', 'socialCounts', 'ad'));
    }

   public function news(Request $request) //this one is for the search result page
    {

        $news = News::query(); //query er jonne alada variable

        $news->when($request->has('tag'), function($query) use ($request){ //fetching with tag
            $query->whereHas('tags', function($query) use ($request){
                $query->where('name', $request->tag);
            });
        });


         $news->when($request->has('category') && !empty($request->category), function($query) use ($request) {  //fetching with category as well, request has category , category ache ki na

            $query->whereHas('category', function($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });




        $news->when($request->has('search'), function($query) use ($request) {
            $query->where(function($query) use ($request){
                $query->where('title', 'like','%'.$request->search.'%')
                    ->orWhere('content', 'like','%'.$request->search.'%');
            })->orWhereHas('category', function($query) use ($request){
                $query->where('name', 'like','%'.$request->search.'%');   //jusst queries
            });
        });



        $news = $news->activeEntries()->withLocalize()->paginate(20); //actual fetching using the query

        $recentNews = News::with(['category', 'auther'])
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();
        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where(['status' => 1, 'language' => getLangauge()])->get();

          $ad = Ad::first();

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ad'));
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

    public function handleComment(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();
         toast(__('Comment added successfully!'), 'success');
        return redirect()->back();


    }

    public function handleReplay(Request $request)
    {

        $request->validate([
            'replay' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->replay;
        $comment->save();
         toast(__('Comment added successfully!'), 'success');
        return redirect()->back();
    }

      public function commentDestory(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if(Auth::user()->id === $comment->user_id){
            $comment->delete();
            return response(['status' => 'success', 'message' => __('Deleted Successfully!')]);
        }

        return response(['status' => 'error', 'message' => __('Something went wrong!')]);
    }







}

