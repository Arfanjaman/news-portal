<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Requests\AdminNewsUpdateRequest;
use App\Models\Language;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Response;

class NewsController extends Controller
{


    use FileUploadTrait;
    public function __construct()
    {
        $this->middleware(['permission:news index,admin'])->only(['index', 'copyNews']);
        $this->middleware(['permission:news create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:news update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:news delete,admin'])->only(['destroy']);
        $this->middleware(['permission:news all-access,admin'])->only(['toggleNewsStatus']);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }

    public function pendingNews(): View
    {
        $languages = Language::all();
        return view('admin.pending-news.index', compact('languages'));
    }



    /**
     * Fetch categoiry by newses
     */

    public function fetchCategory(Request $request)
    {
        $categories = Category::where('language', $request->lang)->get();
        return $categories;
    }


     function approveNews(Request $request) : Response
    {
        $news = News::findOrFail($request->id);
        $news->is_approved = $request->is_approve;
        $news->save();

        return response(['status' => 'success', 'message' => __('Updated Successfully')]);
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.news.create', compact('languages'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminNewsCreateRequest $request)
    {
        /** Handle image using the previously defined trait */
        $imagePath = $this->handleFileUpload($request, 'image'); //directory by default upload
        /** Store news */
        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->auther_id = Auth::guard('admin')->user()->id;
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
          $news->is_approved = getRole() == 'Super Admin' || checkPermission('news all-access') ? 1 : 0;
        $news->save();


        $tags = explode(',', $request->tags); //array tey convert
        $tagIds = [];

        foreach ($tags as $tag) {
            $item = new Tag();
            $item->name = $tag;   //storing the tags
            $item->language = $news->language;
            $item->save();

            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);





        toast(__('admin.Created Successfully!'), 'success')->width('330');

        return redirect()->route('admin.news.index');


        //
    }

    /**
     * Display the specified resource.
     */
    public function toggleNewsStatus(Request $request)
    {
         try {
            $news = News::findOrFail($request->id); //database e update
            $news->{$request->name} = $request->status;
            $news->save();

            return response(['status' => 'success', 'message' => __('Updated successfully!')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $news = News::findOrFail($id);
        if(!canAccess(['news all-access'])){
            if($news->auther_id != auth()->guard('admin')->user()->id){
                return abort(404);
            }
        } //superadmin and author chara ar keu edit korte parbe na

        $categories = Category::where('language', $news->language)->get(); //fetch category by language

        return view('admin.news.edit', compact('languages', 'news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminNewsUpdateRequest $request, string $id)
    {
        $news = News::findOrFail($id); //fetch news by id

        if(!canAccess(['news all-access'])){
            if($news->auther_id != auth()->guard('admin')->user()->id){
                return abort(404);
            }
        }//superadmin and author chara ar keu update korte parbe na

        /** Handle image */
        $imagePath = $this->handleFileUpload($request, 'image'); //directory by default upload

        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ? $imagePath : $news->image; //if image is updated then new otherwise old
        $news->title = $request->title;
        //author id cannot be changed
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        /** Delete previos tags */
        $news->tags()->delete();

        /** detach tags form pivot table */
        $news->tags()->detach($news->tags);

        foreach($tags as $tag){
            $item = new Tag();
            $item->name = $tag;
             $item->language = $news->language;
            $item->save();

            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);


        toast(__('Update Successfully!'), 'success')->width('330');

        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $this->deleteFile($news->image);
        $news->tags()->delete(); //delete tags ,the news_tags has cascade delete
        $news->delete();

        return response(['status' => 'success', 'message' => __('Deleted Successfully!')]);
    }

    /**
     * Copy news
     */
    public function copyNews(string $id)
    {
        $news = News::findOrFail($id);
        $copyNews = $news->replicate();
        $copyNews->save();

        toast(__('Copied Successfully!'), 'success');

        return redirect()->back();
    }


}
