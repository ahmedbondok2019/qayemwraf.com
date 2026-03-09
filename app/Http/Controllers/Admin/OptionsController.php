<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\options\CreateOptionsRequest;
use App\Http\Requests\options\UpdateOptionsRequest;
use App\Models\Option;
use App\Models\OptionItem;
use App\Models\OptionItemTranslation;
use App\Models\OptionTranslation;
use App\Models\OrderOption;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class OptionsController extends BackendController
{
    public function index()
    {
        if (! in_array('29', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['options'] = Option::whereHas('translations')->paginate(10);

        return view('dashboard.admin.options.index', $data);
    }

    public function create()
    {
        if (! in_array('30', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.options.create');
    }

    public function addTrans(Request $request)
    {
        if (! in_array('30', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = Option::where('id', $request->option_id)->whereHas('translations')->first();
        if ($data['details'] != null) {
            return redirect('/admin-2023/options/edit/'.$request->option_id);
        }
        $data['title'] = trans_db('dashboard.CreateNewOptionsTrans');
        $data['id'] = $request->option_id;

        return view('dashboard.admin.options.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('31', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['details'] = Option::find($request->id);
        if ($data['details'] == null) {
            return redirect('/admin-2023/options/all');
        }

        if ($data['details']->translations()->first() == null) {
            return redirect('/admin-2023/options/addTrans/'.$request->id);
        }
        $data['id'] = $request->id;

        return view('dashboard.admin.options.edit', $data);
    }

    public function store(CreateOptionsRequest $request)
    {
        $data = self::storeOptionsTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/options/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/options/create');
        }
    }

    public function addOptionsTrans(Request $request)
    {
        $test = OptionTranslation::where('option_id', $request->option_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/options/addTrans/'.$request->option_id);
        }

        $data = self::storeOptionsTranslations($request, 'trans');
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/options/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/options/addTrans/'.$request->option_id);
        }
    }

    public function update(UpdateOptionsRequest $request)
    {
        $data = self::updateOptionsTranslations($request);

        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
        }

        return redirect('/admin-2023/options/edit/'.$request->option_id);
    }

    public static function storeOptionsTranslations(Request $request, $type = null)
    {
        // dd($request->all());
        if ($type == null) {
            $testTrans = OptionTranslation::where('title', strip_tags($request->title))->first();
            if ($testTrans != null) {
                return false;
            }

            $CreateOptions = Option::create([
                'lang_id' => app()->getLocale(),
                'type' => $request->type,
            ]);
        }

        if ($type != null) {
            $CreateOptions = Option::findOrFail($request->option_id);
        }

        $CreateTrans = OptionTranslation::create([
            'title' => strip_tags($request->title),
            'option_id' => $CreateOptions->id,
            'lang_id' => app()->getLocale(),
        ]);

        if ($CreateTrans) {
            self::optionItems(
                $request->optionItem,
                $CreateOptions->id,
                false
            );

            return true;
        }

        return false;
    }

    public static function storeOptionItems($optionItems, $optionItemId, $update = false)
    {
        if (! empty($optionItems)) {
            foreach ($optionItems as $item) {
                $OptionItem = OptionItem::create([
                    'option_id' => $optionItemId,
                    'lang_id' => app()->getLocale(),
                ]);

                OptionItemTranslation::create([
                    'option_item_id' => $OptionItem->id,
                    'title' => $item,
                    'lang_id' => app()->getLocale(),
                ]);
            }
        }
    }

    public static function optionItems($optionItems, $optionItemId, $update = false)
    {
        // dd($optionItems);
        if (! empty($optionItems)) {
            if ($update == true) {
                // / delete records from table where deleted from blade.
                foreach ($optionItems['option_item_id'] as $ind => $k) {
                    if ($k != null) {
                        foreach ($k as $i => $value) {
                            $allId_deleted[] = $optionItems['option_item_id'][$ind][$i];
                        }
                    }
                }

                OptionItem::whereNotIn('id', $allId_deleted)->where('option_id', $optionItemId)->delete();

                foreach ($optionItems['id'] as $indexs => $keys) {
                    if ($keys != null) {
                        foreach ($keys as $i => $value) {
                            $allId_deleteds[] = $optionItems['id'][$indexs][$i];
                        }
                    }
                }
                OptionItemTranslation::whereNotIn('id', $allId_deleteds)->where('option_item_id', $optionItemId)->delete();
            }

            if (isset($optionItems['title']) && $optionItems['title'] != '') {
                foreach ($optionItems['title'] as $index => $key) {
                    if ($update == false) {
                        $OptionItem = OptionItem::create([
                            'option_id' => $optionItemId,
                            'lang_id' => app()->getLocale(),
                        ]);
                        $option_item_id = $OptionItem->id;
                    }
                    if ($update == true) {
                        if ($optionItems['option_item_id'][$index][0] == null) {
                            $OptionItem = OptionItem::create([
                                'option_id' => $optionItemId,
                                'lang_id' => app()->getLocale(),
                            ]);
                            $option_item_id = $OptionItem->id;
                        } else {
                            $option_item_id = $optionItems['option_item_id'][$index][0];
                        }
                    }

                    foreach ($key as $i => $value) {
                        if (isset($optionItems['title'][$index][$i]) && $optionItems['title'][$index][$i] != '') {
                            if (isset($optionItems['id'][$index][$i]) && $optionItems['id'][$index][$i] != '' && $optionItems['id'][$index][$i] != null) {
                                $pd = OptionItemTranslation::where('id', $optionItems['id'][$index][$i])
                                    ->where('lang_id', $optionItems['lang_id'][$index][$i])->first();
                                $pd->update([
                                    'title' => $optionItems['title'][$index][$i],
                                    'color' => isset($optionItems['color'][$index][$i]) ? $optionItems['color'][$index][$i] : null,
                                ]);
                            } else {
                                $pd = OptionItemTranslation::where('title', $optionItems['title'][$index][$i])
                                    ->where('color', $optionItems['color'][$index][$i])
                                    ->where('lang_id', $optionItems['lang_id'][$index][$i])->first();
                                if (empty($pd)) {
                                    OptionItemTranslation::create([
                                        'title' => $optionItems['title'][$index][$i],
                                        'color' => isset($optionItems['color'][$index][$i]) ? $optionItems['color'][$index][$i] : null,
                                        'option_item_id' => $option_item_id,
                                        'lang_id' => $optionItems['lang_id'][$index][$i],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function updateOptionsTranslations(Request $request)
    {
        $Options = Option::find($request->option_id);
        $Options->update([
            'lang_id' => app()->getLocale(),
            'type' => $request->type,
        ]);

        $Trans = OptionTranslation::where('option_id', $request->option_id)
            ->where('lang_id', app()->getLocale());
        $Trans->update([
            'title' => strip_tags($request->title),
            'option_id' => $Options->id,
            'lang_id' => app()->getLocale(),
        ]);

        if (! empty($request->optionItem)) {
            self::optionItems(
                $request->optionItem,
                $Options->id,
                true
            );

            return true;
        }

        return true;
    }

    public function delete(Request $request)
    {
        $testProduct = OrderOption::where('option_id', $request->id)->count();
        $usedOptions = ProductOption::where('option_id', $request->id)->count();
        if ($usedOptions > 0 || $testProduct > 0) {
            alert()->error(trans_db('dashboard.Can not Delete Used Option'), trans_db('dashboard.attention'));
        } else {
            Option::where('id', $request->id)->delete();
            OptionTranslation::where('option_id', $request->id)->delete();

            $optionItem = OptionItem::where('option_id', $request->id)->first();
            if ($optionItem) {
                OptionItemTranslation::where('option_item_id', $optionItem->id)->delete();
                $optionItem->delete();
            }

            alert()->success(trans_db('dashboard.Deleted Successfully..'), trans_db('dashboard.congratulation'));
        }

        return redirect('admin-2023/options/all');
    }

    public function deleteOptionItem(Request $request)
    {
        $testProduct = OrderOption::where('option_id', $request->id)->count();
        if ($testProduct > 0) {
            alert()->error(trans_db('dashboard.Can not Delete Used Option'), trans_db('dashboard.attention'));
        } else {

            $optionItem = OptionItem::where('id', $request->id)->first();
            if ($optionItem) {
                OptionItemTranslation::where('option_item_id', $optionItem->id)->delete();
                $optionItem->delete();

                return response()->json(['status' => true]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function itemRowCreate(Request $request)
    {

        $data = '<div class="card news_option_items">';
        $data .= '<div class="card-body">';
        $data .= '<div class="row">';
        $data .= '<div class="col-lg-8">';
        $count = $request->count * 2;
        $count += 1;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $data .= '        <div class="row">';
            $data .= '            <div class="col-lg-9">';
            $data .= '                <div class="form-group">';
            $data .= '                    <input type="hidden" name="optionItem[id]['.$count.'][]">';
            $data .= '                    <input type="hidden" name="optionItem[option_item_id]['.$count.'][]">';
            $data .= '                    <input type="hidden" name="optionItem[lang_id]['.$count.'][]" value="'.$localeCode.'">';
            $data .= '                    <input type="text" class="form-control" name="optionItem[title]['.$count.'][]" value="" required>';
            $data .= '                    <input type="color" class="form-control" name="optionItem[color]['.$count.'][]" value="" required>';
            $data .= '                </div>';
            $data .= '            </div>';
            $data .= '            <div class="col-lg-3">';
            $data .= '                <label> '.$properties['native'].'</label>';
            $data .= '            </div>';
            $data .= '        </div>  ';
        }
        $data .= '</div>';
        $data .= '<div class="col-lg-4">';
        $data .= '    <div class="form-group">';
        $data .= '        <a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeOptionItems(this)"><i data-feather="trash-2"></i></a>';
        $data .= '    </div>';
        $data .= '</div>';
        $data .= '</div>';
        $data .= '</div>';
        $data .= '</div>';

        return response()->json($data);
    }

    public function getOptions(Request $request)
    {
        $term = $request->input('search');
        $options = OptionTranslation::where('title', 'LIKE', '%'.$term.'%')->get();
        $data = [];
        foreach ($options as $option) {
            $data[] = [
                'id' => $option->option_id,
                'text' => $option->title,
            ];
        }

        return response()->json(['results' => $data]);
    }
}
