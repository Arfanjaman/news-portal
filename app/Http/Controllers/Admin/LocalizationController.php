<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Facades\File;

class LocalizationController extends Controller
{
     public function adminIndex() : View {
        $languages = Language::all();
         return view('admin.localization.admin-index', compact('languages'));
    }

    public function frontendIndex() : View {
        $languages = Language::all();
        return view('admin.localization.frontend-index', compact('languages'));
    }
    function extractLocalizationStrings(Request $request)
    {
        $directory = $request->directory;
        $languageCode = $request->language_code;
           $fileName = $request->file_name;

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        $localizationStrings = [];

         // Iterate over each file in the directory
        foreach($files as $file){
            if($file->isDir()){
                continue;
            }

            $contents = file_get_contents($file->getPathname());

            preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches); //regex to match __('string') or __("string")
            if(!empty($matches[1])){
                foreach($matches[1] as $match){
                    $localizationStrings[$match] = $match;
                }
            }

        }
         $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";



           // create language sub folder if it is not exit
        if(!File::isDirectory(lang_path($languageCode))){
            File::makeDirectory(lang_path($languageCode), 0755, true);
        }


         // dd(lang_path($languageCode.'/'.$fileName.'.php'));
        file_put_contents(lang_path($languageCode.'/'.$fileName.'.php'), $phpArray);
    }


}
