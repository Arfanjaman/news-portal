<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\About;

class AboutController extends Controller
{
      public function __construct()
    {
        $this->middleware(['permission:about index,admin'])->only(['index']);
        $this->middleware(['permission:about update,admin'])->only(['update']);
    }



     public function index()
    {
        $languages = Language::all();

        return view('admin.about-page.index', compact('languages'));
    }
      public function update(Request $request)
    {
        $request->validate([
            'content' => ['required']
        ]);

        About::updateOrCreate(
            ['language' => $request->language],
            [
                'content' => $request->content
            ]
        );

        toast(__('Updated Successfully!'), 'success');

        return redirect()->back();
    }

}
