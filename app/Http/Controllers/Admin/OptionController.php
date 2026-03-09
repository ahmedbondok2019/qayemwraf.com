<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionTranslation;
use App\Models\OptionValue;
use App\Models\OptionValueTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Option::with(['translation', 'values.translation'])->select('options.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('type', function ($row) {
                    return $row->type == 'single' ? trans_db('dashboard.Single Selection') : trans_db('dashboard.Multiple Selection');
                })
                ->addColumn('values', function ($row) {
                    return $row->values->map(function ($value) {
                        return '<span class="badge badge-light-primary mb-1 mr-1">' . $value->value . '</span>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="' . route('admin.options.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteItem(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['values', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.options.index');
    }

    public function create()
    {
        return view('dashboard.admin.options.create');
    }

    public function store(Request $request)
    {
        // Validation logic - simplified for now
        $request->validate([
            'type' => 'required|in:single,multiple',
        ]);
        
        // Custom validaton for localized names
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }


        DB::beginTransaction();
        try {
            $option = Option::create([
                'type' => $request->type,
            ]);

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                OptionTranslation::create([
                    'option_id' => $option->id,
                    'locale' => $localeCode,
                    'name' => $request->input("name_$localeCode"),
                ]);
            }

            // Handle Option Values
            if ($request->has('values')) {
                foreach ($request->values as $key => $valueData) {
                    // Check if at least one language value is present to valid entry
                    // Assuming valueData contains arrays like [ar => val, en => val, color => #...]
                    
                    $val = OptionValue::create([
                        'option_id' => $option->id,
                        'color_code' => $valueData['color'] ?? null,
                    ]);

                    foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                        OptionValueTranslation::create([
                            'option_value_id' => $val->id,
                            'locale' => $localeCode,
                            'value' => $valueData[$localeCode] ?? '', 
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.options.index')->with('success', trans_db('dashboard.created_successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $option = Option::with(['translations', 'values.translations'])->findOrFail($id);
        return view('dashboard.admin.options.edit', compact('option'));
    }

    public function update(Request $request, $id)
    {
        $option = Option::findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:single,multiple',
        ]);
         
         foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }


        DB::beginTransaction();
        try {
            $option->update([
                'type' => $request->type,
            ]);

            // Update Translations
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                 OptionTranslation::updateOrCreate(
                    ['option_id' => $option->id, 'locale' => $localeCode],
                    ['name' => $request->input("name_$localeCode")]
                );
            }

            // Handle Option Values Sync
            // Strategy: 
            // 1. Get IDs of values sent in request.
            // 2. Delete values not in request IDs.
            // 3. Update existing values.
            // 4. Create new values (those without ID).
            
            $existingValueIds = [];
            
            if ($request->has('values')) {
                foreach ($request->values as $key => $valueData) {
                    
                    if (isset($valueData['id']) && $valueData['id']) {
                        // Update
                        $val = OptionValue::find($valueData['id']);
                        if($val) {
                            $val->update(['color_code' => $valueData['color'] ?? null]);
                            $existingValueIds[] = $val->id;

                            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                                OptionValueTranslation::updateOrCreate(
                                    ['option_value_id' => $val->id, 'locale' => $localeCode],
                                    ['value' => $valueData[$localeCode] ?? '']
                                );
                            }
                        }
                    } else {
                        // Create
                         $val = OptionValue::create([
                            'option_id' => $option->id,
                            'color_code' => $valueData['color'] ?? null,
                        ]);
                        $existingValueIds[] = $val->id;

                        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                            OptionValueTranslation::create([
                                'option_value_id' => $val->id,
                                'locale' => $localeCode,
                                'value' => $valueData[$localeCode] ?? '', 
                            ]);
                        }
                    }
                }
            }
            
            // Delete values not present in the update
            $option->values()->whereNotIn('id', $existingValueIds)->delete();

            DB::commit();
            return redirect()->route('admin.options.index')->with('success', trans_db('dashboard.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return response()->json(['success' => trans_db('dashboard.deleted_successfully')]);
    }
}
