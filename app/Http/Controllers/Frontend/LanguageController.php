<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        session(['language' => $request->language_code]);  //session e user er select kora language ta rakhtesi
        return response(['status' => 'success']);
    }
}
