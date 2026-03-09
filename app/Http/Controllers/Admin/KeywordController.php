<?php

namespace App\Http\Controllers\Admin;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends BackendController
{
    public function index()
    {
        $data['keywords'] = Keyword::orderby('id', 'desc')->paginate(25);

        return view('dashboard.admin.keywords.index', $data);
    }

    public function deleteKeyword(Request $request)
    {
        Keyword::where('id', $request->id)->delete();

        return redirect('admin-2023/keywords/all')
            ->with('msg', trans_db('dashboard.deleted successfully'));
    }
}
