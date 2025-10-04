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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class LocalizationController extends Controller
{
    public function adminIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.admin-index', compact('languages'));
    }

    public function frontendIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.frontend-index', compact('languages'));
    }
    function extractLocalizationStrings(Request $request)
    {
        $directorys = explode(',', $request->directory);

        $languageCode = $request->language_code;
        $fileName = $request->file_name;

        $localizationStrings = [];


        foreach($directorys as $directory){

            $directory = trim($directory);

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            // Iterate over each file in the directory
            foreach($files as $file){
                if($file->isDir()){
                    continue;
                }

                $contents = file_get_contents($file->getPathname());

                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

                if(!empty($matches[1])){

                    foreach($matches[1] as $match){
                         $match = preg_replace('/^(frontend|admin)\./', '', $match);
                        $localizationStrings[$match] = $match;
                    }
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

        toast(__('admin.Generated Successfully!'), 'success');

        return redirect()->back();
    }


    function updateLangString(Request $request): RedirectResponse
    {

        $languageStrings = trans($request->file_name, [], $request->lang_code);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }





function translateString(Request $request)
{
    try {
        $langCode = $request->language_code;
        $languageStrings = trans($request->file_name, [], $request->language_code);
        $keyStirngs = array_keys($languageStrings);
        $text = implode(' || ', $keyStirngs);

        $response = Http::timeout(60)->withHeaders([
            'X-RapidAPI-Host' => 'google-translate113.p.rapidapi.com',
            'X-RapidAPI-Key' => '44384fbed7msh58e0edca81944e3p184fb0jsned6ca401c909',
            'Content-Type' => 'application/json',
        ])
        ->post("https://google-translate113.p.rapidapi.com/api/v1/translator/text", [
            "from" => "auto",
            "to" => $langCode,
            "text" => $text
        ]);

        // Check if API request was successful
        if (!$response->successful()) {
            return response([
                'status' => 'error',
                'message' => __('admin.Translation API failed with status: ') . $response->status()
            ]);
        }

        $translatedData = json_decode($response->body(), true);

        // Check if JSON parsing was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response([
                'status' => 'error',
                'message' => __('admin.Failed to parse translation response')
            ]);
        }

        // Extract translated text from Google Translate response
        $translatedText = null;
        if (isset($translatedData['trans'])) {
            $translatedText = $translatedData['trans'];
        } elseif (isset($translatedData['translatedText'])) {
            $translatedText = $translatedData['translatedText'];
        } elseif (isset($translatedData['result'])) {
            $translatedText = $translatedData['result'];
        } elseif (isset($translatedData['data']['translatedText'])) {
            $translatedText = $translatedData['data']['translatedText'];
        } else {
            return response([
                'status' => 'error',
                'message' => __('admin.Unknown response structure from translation API')
            ]);
        }

        $translatedValues = explode(' || ', $translatedText);

        // Handle count mismatch
        if (count($keyStirngs) !== count($translatedValues)) {
            $minCount = min(count($keyStirngs), count($translatedValues));
            $keyStirngs = array_slice($keyStirngs, 0, $minCount);
            $translatedValues = array_slice($translatedValues, 0, $minCount);
        }

        $updatedArray = array_combine($keyStirngs, $translatedValues);
        $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";

        // Ensure directory exists
        $langDir = lang_path($langCode);
        if (!File::isDirectory($langDir)) {
            File::makeDirectory($langDir, 0755, true);
        }

        $filePath = lang_path($langCode.'/'.$request->file_name.'.php');
        file_put_contents($filePath, $phpArray);

        return response([
            'status' => 'success',
            'message' => __('admin.Translation is completed')
        ]);

    } catch (\Exception $e) {
        return response([
            'status' => 'error',
            'message' => __('admin.Translation failed: ') . $e->getMessage()
        ]);
    }
}
}
