<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\ShippingRule;
use App\Models\ShippingRuleGovernorate;
use App\Models\ShippingRuleTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class ShippingRuleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ShippingRule::with(['translation', 'country.translation'])->select('shipping_rules.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('country', function ($row) {
                    return $row->country->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                     return $row->is_active 
                        ? '<span class="badge badge-success">' . trans_db('dashboard.active') . '</span>' 
                        : '<span class="badge badge-danger">' . trans_db('dashboard.inactive') . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="' . route('admin.shipping_rules.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteItem(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.shipping_rules.index');
    }

    public function create()
    {
        $countries = Country::with('translation')->get();
        return view('dashboard.admin.shipping_rules.create', compact('countries'));
    }

    public function getGovernorates(Request $request) {
        $country_id = $request->country_id;
        $governorates = Governorate::where('country_id', $country_id)->active()->with('translation')->get();
        
        $html = '';
        foreach($governorates as $gov) {
            $html .= '<tr>';
            $html .= '<td>' . $gov->id . '</td>';
            $html .= '<td>' . $gov->name . '</td>';
            $html .= '<td><input type="number" step="0.01" name="rates[' . $gov->id . ']" class="form-control" placeholder="'.trans_db('dashboard.Value').'" value="0"></td>';
            $html .= '</tr>';
        }
        
        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
        ]);
        
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }


        DB::beginTransaction();
        try {
            $rule = ShippingRule::create([
                'country_id' => $request->country_id,
                'is_active' => $request->has('is_active'),
            ]);

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                ShippingRuleTranslation::create([
                    'shipping_rule_id' => $rule->id,
                    'locale' => $localeCode,
                    'name' => $request->input("name_$localeCode"),
                ]);
            }

            if ($request->has('rates')) {
                foreach ($request->rates as $govId => $rate) {
                    if ($rate !== null && $rate !== '') {
                        ShippingRuleGovernorate::create([
                            'shipping_rule_id' => $rule->id,
                            'governorate_id' => $govId,
                            'rate' => $rate,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.shipping_rules.index')->with('success', trans_db('dashboard.created_successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $rule = ShippingRule::with(['translations', 'governorateRates'])->findOrFail($id);
        $countries = Country::with('translation')->get();
        
        // Fetch governorates for the selected country to populate the table (even those without rates yet)
        $governorates = Governorate::where('country_id', $rule->country_id)->active()->with('translation')->get();
        
        // Map existing rates for easy lookup
        $rates = $rule->governorateRates->pluck('rate', 'governorate_id')->toArray();

        return view('dashboard.admin.shipping_rules.edit', compact('rule', 'countries', 'governorates', 'rates'));
    }

    public function update(Request $request, $id)
    {
        $rule = ShippingRule::findOrFail($id);
        
        $request->validate([
            'country_id' => 'required|exists:countries,id',
        ]);
         
         foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }


        DB::beginTransaction();
        try {
            $rule->update([
                'country_id' => $request->country_id,
                 'is_active' => $request->has('is_active'),
            ]);

            // Update Translations
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                 ShippingRuleTranslation::updateOrCreate(
                    ['shipping_rule_id' => $rule->id, 'locale' => $localeCode],
                    ['name' => $request->input("name_$localeCode")]
                );
            }

            // Sync Rates
            // First delete existing rates for this rule to handle removals/updates cleanly or just updateOrCreate
            // Simpler: iterate input, updateOrCreate.
            
            if ($request->has('rates')) {
                foreach ($request->rates as $govId => $rate) {
                     ShippingRuleGovernorate::updateOrCreate(
                        ['shipping_rule_id' => $rule->id, 'governorate_id' => $govId],
                        ['rate' => $rate ?? 0]
                    );
                }
            }
            
            DB::commit();
            return redirect()->route('admin.shipping_rules.index')->with('success', trans_db('dashboard.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $rule = ShippingRule::findOrFail($id);
        $rule->delete();
        return response()->json(['success' => trans_db('dashboard.deleted_successfully')]);
    }
}
