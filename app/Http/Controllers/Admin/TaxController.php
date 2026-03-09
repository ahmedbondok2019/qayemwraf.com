<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\tax\CreateTaxRequest;
use App\Http\Requests\tax\UpdateTaxRequest;
use App\Models\Category;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaxController extends BackendController
{
    public function index()
    {
        if (! in_array('107', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['taxes'] = Tax::all();

        return view('dashboard.admin.taxes.index', $data);
    }

    public function create()
    {
        if (! in_array('108', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $parents = Category::select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotIn('id', $parents)->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();

        return view('dashboard.admin.taxes.create', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('109', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $parents = Category::select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotIn('id', $parents)->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();

        $data['details'] = Tax::where('id', $request->id)->firstOrFail();

        return view('dashboard.admin.taxes.edit', $data);
    }

    public function store(CreateTaxRequest $request)
    {
        if (! in_array('108', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storeTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/tax/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/tax/create');
        }
    }

    public static function storeTranslations(Request $request)
    {
        $methods = array_filter(explode(',', $request->payment_methods), fn ($value) => ! is_null($value) && $value !== '');
        $payment_methods = array_unique($methods);

        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        Tax::create([
            'title' => $request->title,
            'value' => $request->value,
            'status' => $request->status,
            'payment_method' => collect($payment_methods)->implode(','),
            'product_categories' => collect($categories)->implode(','),
        ]);

        return true;
    }

    public function update(UpdateTaxRequest $request)
    {
        if (! in_array('109', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->id)) {
            $data = self::updateTranslations($request);

            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/tax/edit/'.$request->id);

        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public static function updateTranslations(Request $request)
    {
        $methods = array_filter(explode(',', $request->payment_methods), fn ($value) => ! is_null($value) && $value !== '');
        $payment_methods = array_unique($methods);

        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $test = Tax::where('id', $request->id)->first();

        if ($test) {
            $test->update([
                'title' => $request->title,
                'value' => $request->value,
                'status' => $request->status,
                'payment_method' => collect($payment_methods)->implode(','),
                'product_categories' => collect($categories)->implode(','),
            ]);

            return true;
        }

        return false;

    }

    public function delete(Request $request)
    {
        if (! in_array('110', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Tax::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/tax/all');
    }
}
