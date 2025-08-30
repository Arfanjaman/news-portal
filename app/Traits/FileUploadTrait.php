<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileUploadTrait
{
    //old path hoilo ager image delete korar jonne. jodi thake nullable ar ?String becausse user can just change mail and not change image so it can return null

    public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads'): ?String
    {
        /** Check request has file */
        if(!$request->hasFile($fieldName)){
            return null;
        }

        /** Delete the existing image if have */
        if($oldPath && File::exists(public_path($oldPath))){
            File::delete(public_path($oldPath)); //ager image delete
        }

        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();
        $updatedFileName = Str::random(30).'.'.$extension; //notun file path for the uploaded image

        $file->move(public_path($dir), $updatedFileName);  //database e pathano

        $filePath = $dir.'/'.$updatedFileName;  //notun image path ta pathabo

        return $filePath;

    }

    /** Handle file delete */
    public function deleteFile(string $path) : void
    {
        if($path && File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}
