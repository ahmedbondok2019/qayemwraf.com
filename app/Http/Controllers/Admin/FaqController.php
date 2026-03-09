<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\faqs\CreateFaqRequest;
use App\Http\Requests\faqs\CreateFaqTransRequest;
use App\Http\Requests\faqs\UpdateFaqRequest;
use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqController extends BackendController
{
    public function index()
    {
        if (! in_array('103', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['faqs'] = Faq::whereHas('FaqTranslation')->get();

        return view('dashboard.admin.faqs.index', $data);
    }

    public function create()
    {
        if (! in_array('104', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.faqs.create');
    }

    public function addTrans(Request $request)
    {
        if (! in_array('104', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Details'] = Faq::where('id', $request->faq_id)->first();
        if ($data['Details'] == null) {
            return redirect('/admin-2023/faqs/all');
        }
        $data['title'] = trans_db('dashboard.CreateNewFaqTrans');
        $data['id'] = $request->faq_id;

        return view('dashboard.admin.faqs.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('105', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['Details'] = Faq::where('id', $request->id)->first();
        if ($data['Details'] == null) {
            return redirect('/admin-2023/faqs/all');
        }
        if ($data['Details']->FaqTranslation == null) {
            return redirect('/admin-2023/faqs/addTrans/'.$request->id);
        }
        $data['id'] = $request->id;

        return view('dashboard.admin.faqs.edit', $data);
    }

    public function store(CreateFaqRequest $request)
    {
        if (! in_array('104', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = self::storeFaqTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/faqs/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/faqs/create');
        }
    }

    public function addFaqTrans(CreateFaqTransRequest $request)
    {
        if (! in_array('104', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $test = FaqTranslation::where('faq_id', $request->faq_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/faqs/addTrans/'.$request->faq_id);
        }

        $data = self::storeFaqTranslations($request, 'trans');
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/faqs/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/faqs/addTrans/'.$request->faq_id);
        }
    }

    public function update(UpdateFaqRequest $request)
    {
        if (! in_array('105', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::updateFaqTranslations($request);

        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
        }

        return redirect('/admin-2023/faqs/edit/'.$request->faq_id);
    }

    public static function storeFaqTranslations(Request $request, $type = null)
    {
        if ($type == null) {
            $CreateFaq = Faq::create([
                'lang_id' => app()->getLocale(),
                'view_index' => $request->view_index == null || $request->view_index == '' ? 0 : $request->view_index,
            ]);
        }

        if ($type != null) {
            $CreateFaq = Faq::findOrFail($request->faq_id);
        }
        FaqTranslation::create([
            'title' => strip_tags($request->title),
            'description' => str_replace('script', '', $request->description),
            'faq_id' => $CreateFaq->id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public static function updateFaqTranslations(Request $request)
    {
        $Faq = Faq::find($request->faq_id);
        $Faq->update([
            'lang_id' => app()->getLocale(),
            'view_index' => $request->view_index == null || $request->view_index == '' ? 0 : $request->view_index,
        ]);

        $Trans = FaqTranslation::where('faq_id', $request->faq_id)
            ->where('lang_id', app()->getLocale());
        $Trans->update([
            'title' => strip_tags($request->title),
            'description' => str_replace('script', '', $request->description),
            'faq_id' => $Faq->id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = FaqTranslation::where('faq_id', $request->id)->first();
        $parentCheck = FaqTranslation::where('faq_id', $request->id)->count();
        if ($parentCheck < 2) {
            Faq::where('id', $request->id)->delete();
        }
        $data->delete();

        alert()->success(trans_db('dashboard.Deleted Successfully..'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/faqs/all');
    }
}
