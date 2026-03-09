<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends WebController
{
    public function index(Request $request)
    {
        $data['page'] = Page::where('id', $request->id)->with('PageTranslation')
            ->where('status', 1)->first();
        if (empty($data['page']->PageTranslation)) {
            abort('404');
        }
        $data['title'] = $data['page']->PageTranslation->title;

        //        dd($data['title']);
        return view('page', $data);
    }
}
