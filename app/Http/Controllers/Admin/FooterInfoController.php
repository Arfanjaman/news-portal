<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\FooterInfo;
use App\Traits\FileUploadTrait;

class FooterInfoController extends Controller
{
    use FileUploadTrait;

     public function __construct()
    {
        $this->middleware(['permission:footer index,admin'])->only(['index']);
        $this->middleware(['permission:footer create,admin'])->only(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $languages = Language::all();
        return view('admin.footer-info.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'max:3000'],
            'description' => ['required', 'max:300'],
            'copyright' => ['required', 'max:255']
        ]);

        $footerInfo = FooterInfo::where('language', $request->language)->first();
        $imagePath = $this->handleFileUpload($request, 'logo', !empty($footerInfo) ?$footerInfo->logo: '');

        FooterInfo::updateOrCreate(
            ['language' => $request->language],
            [
                'logo' => !empty($imagePath) ? $imagePath : $footerInfo->logo,
                'description' => $request->description,
                'copyright' => $request->copyright
            ]
        );

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
