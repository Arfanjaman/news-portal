<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Requests\AdminUpdatePasswordRequest;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Alert;

class ProfileController extends Controller
{

    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProfileUpdateRequest $request, string $id)
    {
        //handle image
        $imagePath = $this->handleFileUpload($request, 'image', $request->old_image);
        // dd($imagePath);
         /** Save updated datas */
        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image; //image is nullable tai ei checking
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

         toast(__('Admin Info Updated Successfully'),'success')->width('400');

        return redirect()->back();


    }

    //update for password
     public function passwordUpdate(AdminUpdatePasswordRequest $request, string $id)
    {

        $admin = Admin::findOrFail($id);
        $admin->password = bcrypt($request->password);
        $admin->save();
        //from sweet alert
          toast(__('Password Updated Successfully'),'success')->width('400');
        return redirect()->back();
    }






}
