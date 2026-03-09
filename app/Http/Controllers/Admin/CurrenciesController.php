<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BackendController;
use App\Models\Currency;
use App\Models\CurrencyTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CurrenciesController extends BackendController
{
    public function index()
    {
        $currencies = Currency::with('translations')->get();
        return view('dashboard.admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('dashboard.admin.currencies.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|string|unique:currencies,code',
            'exchange_rate' => 'required|numeric',
            'status' => 'boolean',
            'is_default' => 'boolean',
        ];

        foreach (config('laravellocalization.supportedLocales') as $locale => $props) {
            $rules["$locale.name"] = 'required|string';
            $rules["$locale.symbol"] = 'required|string';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            if ($request->is_default) {
                Currency::where('is_default', true)->update(['is_default' => false]);
            }

            $currency = Currency::create([
                'code' => $request->code,
                'exchange_rate' => $request->exchange_rate,
                'status' => $request->status ? 1 : 0,
                'is_default' => $request->is_default ? 1 : 0,
            ]);

            foreach (config('laravellocalization.supportedLocales') as $locale => $props) {
                CurrencyTranslation::create([
                    'currency_id' => $currency->id,
                    'locale' => $locale,
                    'name' => $request->input("$locale.name"),
                    'symbol' => $request->input("$locale.symbol"),
                ]);
            }

            DB::commit();
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            return redirect()->route('admin.currencies.index');

        } catch (\Exception $e) {
            DB::rollback();
            alert()->error(trans_db('dashboard.error'), trans_db('dashboard.notsaved'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $currency = Currency::with('translations')->findOrFail($id);
        return view('dashboard.admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);

        $rules = [
            'code' => ['required', 'string', Rule::unique('currencies', 'code')->ignore($id)],
            'exchange_rate' => 'required|numeric',
            'status' => 'boolean',
            'is_default' => 'boolean',
        ];

        foreach (config('laravellocalization.supportedLocales') as $locale => $props) {
            $rules["$locale.name"] = 'required|string';
            $rules["$locale.symbol"] = 'required|string';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            if ($request->is_default) {
                Currency::where('id', '!=', $id)->where('is_default', true)->update(['is_default' => false]);
            }

            $currency->update([
                'code' => $request->code,
                'exchange_rate' => $request->exchange_rate,
                'status' => $request->status ? 1 : 0,
                'is_default' => $request->is_default ? 1 : 0,
            ]);

            foreach (config('laravellocalization.supportedLocales') as $locale => $props) {
                CurrencyTranslation::updateOrCreate(
                    ['currency_id' => $currency->id, 'locale' => $locale],
                    [
                        'name' => $request->input("$locale.name"),
                        'symbol' => $request->input("$locale.symbol"),
                    ]
                );
            }

            DB::commit();
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            return redirect()->route('admin.currencies.index');

        } catch (\Exception $e) {
            DB::rollback();
            alert()->error(trans_db('dashboard.error'), trans_db('dashboard.notsaved'));
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $currency = Currency::findOrFail($id);
            $currency->delete();
            alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
            return redirect()->route('admin.currencies.index');
        } catch (\Exception $e) {
            alert()->error(trans_db('dashboard.error'), trans_db('dashboard.notdeleted'));
            return redirect()->back();
        }
    }
}
