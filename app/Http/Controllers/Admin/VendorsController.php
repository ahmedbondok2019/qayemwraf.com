<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Http\Requests\vendors\AdminCreateVendorRequest;
use App\Http\Requests\vendors\UpdateVendorRequest;
use App\Models\Category;
use App\Models\ProfitGroup;
use App\Models\Vendor;
use App\Models\VendorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class VendorsController extends BackendController
{
    public function index()
    {
        if (! in_array('9', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['vendors'] = Vendor::orderByDesc('id')->get();

        return view('dashboard.admin.vendors.index', $data);
    }

    public function create()
    {
        if (! in_array('10', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['profit_group'] = ProfitGroup::all();
        $data['categories'] = Category::all();

        return view('dashboard.admin.vendors.create', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('11', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['profit_group'] = ProfitGroup::all();
        $data['Details'] = Vendor::find($request->id);
        if ($data['Details'] == null) {
            return redirect('/admin-2023/vendors/all');
        }
        $data['id'] = $request->id;
        $data['categories'] = Category::all();

        return view('dashboard.admin.vendors.edit', $data);
    }

    public function profile(Request $request)
    {
        if (! in_array('10', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Details'] = Vendor::find($request->id);
        if ($data['Details'] == null) {
            return redirect('/admin-2023/vendors/all');
        }
        $data['id'] = $request->id;

        return view('dashboard.admin.vendors.profile', $data);
    }

    public function store(AdminCreateVendorRequest $request)
    {
        if (! in_array('10', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = self::storeVendor($request);

        if ($data['status'] == true) {
            alert()->success($data['msg'], trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/vendors/all');
        } else {
            alert()->error($data['msg'], trans_db('dashboard.attention'));

            return redirect('/admin-2023/vendors/create');
        }
    }

    public function update(UpdateVendorRequest $request)
    {
        if (! in_array('11', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = self::updateVendor($request);

        if ($data['status'] == true) {
            alert()->success($data['msg'], trans_db('dashboard.congratulation'));
        } else {
            alert()->error($data['msg'], trans_db('dashboard.attention'));
        }

        return redirect('/admin-2023/vendors/all');
    }

    public static function storeVendor(Request $request)
    {
        $testExists = Vendor::where('name', $request->name)
            ->where('email', $request->email)
            ->where('phone', $request->phone)->first();
        if (empty($testExists)) {

            // $image_name = \App\Http\Controllers\Api\helper\helperController::make_slug($request->name) . '.jpg';
            // if ($request->has('image')) {
            //     $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
            //     $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR. $image_name);
            //     HelperController::upload_images($path,$destination,$request->file('image'), null, null);
            // }

            $CreateVendor = Vendor::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'area_id' => $request->area_id,
                'city_id' => $request->city_id,
                'website' => $request->website,
                'profit_group' => $request->profit_group,
                'bank_name' => $request->bank_name,
                'bank_iban' => $request->bank_iban,
                'password' => Hash::make($request->password),
                'status' => 1,
                'commerical_license_status' => isset($request->commerical_license_status) ? $request->commerical_license_status : 0,
                'tax_license_status' => isset($request->tax_license_status) ? $request->tax_license_status : 0,
                'identity_card1_status' => isset($request->identity_card1_status) ? $request->identity_card1_status : 0,
                'identity_card2_status' => isset($request->identity_card2_status) ? $request->identity_card2_status : 0,
                'address_prove_status' => isset($request->address_prove_status) ? $request->address_prove_status : 0,
            ]);

            if ($CreateVendor) {
                // self::images(
                //     $request->image ,
                //     $request->name ,
                //     isset($CreateVendor) ? $CreateVendor->id : $request->vendor_id ,
                // );
                return ['status' => true, 'msg' => trans_db('dashboard.saved')];
            }
        } else {
            return ['status' => false, 'msg' => trans_db('dashboard.Duplicate User')];
        }
    }

    public static function updateVendor(Request $request)
    {
        // $image_name = \App\Http\Controllers\Api\helper\helperController::make_slug($request->name) . '.jpg';
        // if ($request->has('image')) {
        //     $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
        //     $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR. $image_name);
        //     HelperController::upload_images($path,$destination,$request->file('image'), null, null);
        // }

        if (! empty($request->contract)) {
            $pdf_contract_name = HelperController::make_slug($request->name).'-'.time().'.pdf';
            $path = 'website' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'contract';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $request->file('contract')->move($fullStoragePath, $pdf_contract_name);
            $pdf_contract = 'storage/website/uploads/contract/' . $pdf_contract_name;
        }

        $vendor = Vendor::find($request->id);
        $inputs = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'area_id' => $request->area_id,
            'city_id' => $request->city_id,
            'website' => $request->website,
            'profit_group' => $request->profit_group,
            'bank_name' => $request->bank_name,
            'bank_iban' => $request->bank_iban,
            'password' => isset($request->password) ? Hash::make($request->password) : $vendor->password,
            'status' => 1,
            'commerical_license_status' => isset($request->commerical_license_status) ? $request->commerical_license_status : 0,
            'tax_license_status' => isset($request->tax_license_status) ? $request->tax_license_status : 0,
            'identity_card1_status' => isset($request->identity_card1_status) ? $request->identity_card1_status : 0,
            'identity_card2_status' => isset($request->identity_card2_status) ? $request->identity_card2_status : 0,
            'address_prove_status' => isset($request->address_prove_status) ? $request->address_prove_status : 0,
            'contract' => isset($pdf_contract) ? $pdf_contract : $vendor->contract,
        ];
        if ($vendor->update($inputs)) {
            // self::images($request->image , $request->vendor_name , $request->id);
            return ['status' => true, 'msg' => trans_db('dashboard.saved')];
        } else {
            return ['status' => false, 'msg' => trans_db('dashboard.notsaved')];
        }
    }

    public static function images($images, $vendor_name, $vendorId)
    {
        if (! empty($images)) {
            foreach ($images as $image) {
                $imageSlug = HelperController::make_slug($vendor_name.Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.jpg';

                // VendorImage::create([
                //     'image' => $image_name,
                //     'vendor_id' => $vendorId,
                // ]);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $image, '800', '533');
            }
        }
    }

    public function delete(Request $request)
    {
        if (! in_array('12', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $vendor = Vendor::find($request->id);
        if ($vendor) {
            // Delete contract if exists
            if ($vendor->contract) {
                $oldPath = str_replace('storage/', '', $vendor->contract);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($vendor->contract))) {
                    unlink(public_path($vendor->contract));
                } elseif (file_exists(public_path('website/uploads/contract/' . $vendor->contract))) {
                    unlink(public_path('website/uploads/contract/' . $vendor->contract));
                }
            }

            // Delete images
            $images = VendorImage::where('vendor_id', $request->id)->get();
            foreach ($images as $image) {
                if ($image->image) {
                    $oldPath = str_replace('storage/', '', $image->image);
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    } elseif (file_exists(public_path($image->image))) {
                        unlink(public_path($image->image));
                    } elseif (file_exists(public_path('website/images/users/' . $image->image))) {
                        unlink(public_path('website/images/users/' . $image->image));
                    }
                }
            }
            $vendor->delete();
        }

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.deleted'));

        return redirect('admin-2023/vendors/all');
        //            ->with('msg','vendor Deleted Successfully..');
    }

    public function delete_image(Request $request)
    {
        $data = VendorImage::find($request->id);
        if ($data && $data->image) {
            $oldPath = str_replace('storage/', '', $data->image);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            } elseif (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            } elseif (file_exists(public_path('website/images/users/'.$data->image))) {
                unlink(public_path('website/images/users/'.$data->image));
            }
        }
        $data->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.deleted'));

        return redirect()->back();
        //        ->with('msg', trans_db('dashboard.deleted successfully'));
    }

    public function downloadContract(Request $request, Vendor $vendor)
    {
        if (! in_array('11', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $contractPath = $vendor->contract;
        if (strpos($contractPath, 'storage/') === 0) {
            $path = str_replace('storage/', '', $contractPath);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
            }
        }
        
        $file = public_path().'/website/uploads/contract/'.$vendor->contract;
        if (file_exists($file)) {
            $headers = [
                'Content-Type: application/pdf',
            ];
            return Response::download($file, 'contract_'.$vendor->contract, $headers);
        }

        alert()->error(trans_db('dashboard.not found'), trans_db('dashboard.attention'));
        return redirect()->back();
    }

    public function vendorsOrderUp(Request $request)
    {
        $vendor = Vendor::find($request->id);
        $view_index = $vendor->view_index;

        if ($view_index > 0) {
            $vendors = Vendor::where('view_index', $view_index - 1)->get();
            foreach ($vendors as $vendorss) {
                $vendorss->update(['view_index' => $view_index]);
            }
            $vendor->view_index == null ? $new_index = 1 : $new_index = $view_index - 1;
            $vendor->view_index = $new_index;
            $vendor->save();
        }

        return redirect('/admin-2023/vendor/all');
    }

    public function vendorsOrderDown(Request $request)
    {
        $vendor = Vendor::find($request->id);
        $count = Vendor::count();
        $view_index = $vendor->view_index;

        if ($view_index < $count) {
            $vendors = Vendor::where('view_index', $view_index + 1)->get();
            foreach ($vendors as $Cour) {
                $Cour->update(['view_index' => $view_index]);
            }

            $vendor->view_index = $view_index + 1;
            $vendor->save();
        }

        return redirect('/admin-2023/vendor/all');
    }

    public static function imageUpload(Request $request, $oldImage = null)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';

        if ($request->cropped_image != null && file_exists(public_path($request->cropped_image))) {
            self::UploadImagesVendor(public_path($request->cropped_image), $image_name, 'users'.DIRECTORY_SEPARATOR.'small', '181 ', '282');
            $relativePath = self::UploadImagesVendor(public_path($request->cropped_image), $image_name, 'users', '334 ', '222');
            unlink(public_path($request->cropped_image));

            return ['image' => $relativePath, 'body' => trans_db('dashboard.saved'), 'title' => trans_db('dashboard.congratulation'), 'type' => 'success'];
        }
        if (! empty($request->file('image'))) {
            $ex = $request->file('image')->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {

                if (isset($oldImage) && $oldImage != null) {
                    $oldPath = str_replace('storage/', '', $oldImage);
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    } elseif (file_exists(public_path('website/images/users/'.$oldImage))) {
                        unlink(public_path('website/images/users/'.$oldImage));
                    }
                }

                self::UploadImagesVendor($request->file('image'), $image_name, 'users'.DIRECTORY_SEPARATOR.'small', '181 ', '282');
                $relativePath = self::UploadImagesVendor($request->file('image'), $image_name, 'users', '380 ', '290');

                return ['image' => $relativePath, 'body' => trans_db('dashboard.saved'), 'title' => trans_db('dashboard.congratulation'), 'type' => 'success'];
            } else {
                return ['image' => null, 'body' => trans_db('dashboard.notsaved'), 'title' => trans_db('dashboard.attention'), 'type' => 'error'];
            }
        } else {
            return ['image' => null, 'body' => trans_db('dashboard.InValidImage'), 'title' => trans_db('dashboard.attention'), 'type' => 'error'];
        }
    }

    public static function UploadImagesVendor($image, $name, $folder, $width = null, $height = null)
    {
        $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $folder;
        $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
        $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $name;

        HelperController::upload_images($fullStoragePath, $destination, $image, $width, $height);
        
        return 'storage/website/images/' . $folder . '/' . $name;
    }

    public function cropSlider(Request $request)
    {
        $data = $request->image;
        // //data:image/png;base64,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
        $image_array_1 = explode(';', $data);

        // base64,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
        $image_array_2 = explode(',', $image_array_1[1]);

        // iVBORw0KGgoAAAANSUhEUgAAAZAAAAC0CAIAAAA1l+0PAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAABk3SURBVHhe7Z1/iF5VesfnjyJM/3hLWJyhL13WQWGlKETYLVKEsF0WFTrSTZBaRIpdVrZZ2SZl0W4bdV3sgtsqMSC1RurWZNsSXImQqFXYCOLG/CErWUhapdHJTDNm4saEDJhJ0qTfc+/JzZ1zfz3Puee+73tevx++SJz3nvOee997vu9znvvc+05cIoSQSKBhEUKigYZFCIkGGhYhJBpoWISQaKBhEUKigYZFCIkGGhYhJBpoWISQaKBhEUKigYZFCIkGGhYhJBpoWISQaKBhEUKigYZFCIkGGhYhJBpoWISQaKBhETI+nF+Yv7h8xv7POELDImR8WFw/e/KJx+3/jCM0LELGhM8O7P9oYmJuzQTiLPunsYOGRciYsHDzTUdnpuemJo9vvM/+aeygYREyDpze+QLCq6PX9iH8A9GWfWG8oGEREj0XlpaMVc1Mp4aFfyDasq+NFzQsQqLnk8cenVtjw6tUCLIQc9mXxwgaFiFxs3L4ULYYvKKZafxx/EocaFiExM3Hd995tN9zDevaPmKuEw9+3240LtCwCImY5Tf3lYRXlwXPOnvwPbvpWEDDIiRijDFlufai+r3F9bN20yaWF04tvn2kpS6urNjuuoGGRUisnNr+TE14lQobnNn9km1Qzb5v/+z5iQdaatfarba7zqBhERIlF5aW5qYm68KrVMkG9dn3V29/GnazY+KhNkIPpz44YXvsDBoWIVFy4pEtTilDlbDZJ489apsVeH/Xu0Hc6sDDe22PXULDIiQ+Vg4fMm7VGF5dFhaGpTcYXlxZcazHW8sLp2ynXULDIiQ+qkoZKtXvoYltnANhUZDw6tDz79geO4aGRUhkLL+ypzHXXhSaLL+5z3aRgJiovVtBL9+yreuLgxk0LEJiAtYwv/Z6+WLwipIbDPPO8tqG7UHCq8W3j9geu4eGRUhMSEoZqoSGaJ72A5cJ4lZwvbTDwUDDIiQaLi6fMW7lEV6lQsN+78LSErpyrMdPMKzB5NozaFiERINf9iqv9AbDQ8+/EyS8GkwpQx4aFiHRcHrnC8LaqyrNTU3+719896cTP3Tcx08Dy7Vn0LAIiYazB99rFWHNTM+vvf6tu//J8R0PIbx6f9e7dlgDhIZFSEyoK7ByQnR25L6HgoRXL9+yzQ5osNCwCImJ8wvznkFWUtbw6u1PO9bjIYRXgyxlyEPDIiQyfrNtq4dnzU1NHv7uk+3DK7jVvm//zA5l4NCwCImMiysr6S96OZZUp+TBWLvWbnXcx0MwrAGXMuShYRESH/UPGi1qbs1EqFz74EsZ8tCwCImS4xvvM8/DKnhTUWFLGezbDwkaFiFRYh7gJ3nCTFLKECrXPpRShjw0LEJiJf2154+u7tcI4VWoUoa9f/Kv9o2HBw2LkGGw/yeXXt/cXmd/PN2o3Tf8yLEeR//8O3+N6Mn5oyNY3qfb73fe3dWRN+zedQYNi5BhcPy9S89MXHqutf5lqk47rvrvv/rzmvAKL/3N7215rv/1/V/8Zv1mv/rOJvTmvrsj7NHr37E72A00LEKGBOY2JrljMUF1/tkv19jQ36/5u80zD/7gS5tenLrh6LX9+iALXTmdlwue9atn7Q52AA2LkCFx7tNuDWvHVb/csLnUsFKrSrXzd9cZw5qZPnjN10o3xh8Rppnwyum/Stgp7Fo30LAIGR4IRhCSOBM+kJa3frVoQPgL1oCZWz1147devvq6NMI62u/t+cLGYpPdN/xI4VYQDKuzhSENi5ChYR7P8h9/4E74INpx1d6v/K1jPfnAKhWsKlVaAPHBdTc6TeBfS//4pzrDguDCxzv5iXwaFiFD5cgb4YOsHVedfOCufKxUtCooC6+sYSVB1i+m78k3fOO2h9RuBSHIghF3AA2LkGGze13YZNb5Z7+cZdDhPo5PZcrCqyuGlZShZm6FtlhXOp1L1U32nYZFyLBJSxycCe+tHVf9cvbONErKp6scPdf/eolhJUHWr2/YgOaQLWVw+perg+w7DYuQEeD1zaGCrDTXXroGzPSDL23KFoOuYSWe9fPJTfC7tvk1uPD+n9gdDAQNi5ARIFyJA8Krp278Vr3SUoZKw0pKHP7nHx5uFV6lwk4Fzb7TsAgZDUKVOKCTv5y49Md1+q+v9OsMK3nAw2f/+e8BrmDCsIKWONCwCBkZApY4wLbu/C3Hp/KqWxJCM9OL62fNgq593IeRhLvHkIZFyMgQusTh7I+nq2zr0z/q1RlW9jPRQTw0XIkDDYuQEeL/XrorVDLrir73245bpTrw+9fUGBaCrPm11wcLsgKVONCwCBklwpY4ZEKfhcRWPshy3SrR3NTkiUe2mDIxpzcPYQAhShxoWISMGK9v7sSzIHS7eoWYZd8dq8qEheHZvU8GCLJM9n2z3cEW0LAIGTEQiXRkWImcxNaVm59LlWTfwyxUsVOtSxxoWISMHl0+xcHqcmIrXRi6PpVXv2eeNRqiJssYXztoWISMJLvXde5Z6D+xLQRZrknllfxkdLAgq12JAw2LkFElvUKHSV4lvIrAp6WemTj9Z72Pri74VF793skH7ko3bivYVovsOw2LkFi5uLLyb1dva9Svb9gw/9U/rBfCKNekVmtuavLswfeM17RXC2hYhMTKW5tebPy1G+jnk5uMH9Wr4FCu+r2P777TvvHwoGEREiWnPjghcSvopxM/RJAFx3E9SKmPJiaW39xn335I0LAIiRLtjzk77uMjBGL9nn37IUHDIiQ+3t/1rjC8SoUg6xfT97QPsubWTJx84nE7iGFAwyIkMi6urDh+JBE864PrbhSlq2o0M42F4fmFeTuUgUPDIiQyDjy8VxVepYJh7fnCxgBB1tTk4r332KEMHBoWITGxvHDKw61SwbMOXvO1tkHWULPvNCxCYuK1Ddu9DQuyJQ4FD9Kp3zv2jXXmRxUHDg2LkGhYfPtIG7eCEGTt/+I3g5Q4fHZgvx3WAKFhERINu9ZudQzIT/Nrr28ZZ8Gwzux+yQ5rgNCwCImDQ8+/0zK8gtAD+ll+cx8cx/EgldDc3KkzcGhYhETA8sIpx3r8hBgtzT0dm73Vf2HY76F5OrABQ8MiJAKEtw3WCz28v+vdtMNzHx7xDrKGlcACNCxCRh35bYM1Qg+vbdhue0w48ciWuTVqz5qbmlzadL/tYuDQsAgZdV6+ZZvjPh6CYcH4bI8JF5aWjAepsu8z0/A4VroTQsrR3jZYKvRw4OG9tsccp3e+oFoY8l5CQkglfrcNlqq0zhN/PPaNddLsexJe2ZZDgoZFyOjid9ugI/SQ5dqLfHZgvzDIwmbLr+yxzYYEDYuQESXNtbcxrLT5W5tetD1WsHiv4Mkz/d7i+lnbYHjQsAgZURBevXr7069t2O4tWFVNbJVxfmG+McjCBkOpFHWgYRFCLn3y2KM1JQ546cSD37ebDhUaFiHEZN9NfUNpiUPy9wtLS3bToULDIoQYzux+qXRhiPDq1PZn7EbDhoZFCLEs3nGbm32fmZ5fe719eQSgYRFCLMUSB1PKMOyf9spDwyKEXOH4xvvmpiatYY3Gj6fmoWERQq5wYWnJXC5Msu8Ir859eMS+MBrQsAghqzj51JPwLOiTxx61fxoZAhjWb7ZtRdy4eO89jcJmp3e+YJu1AJ3I39HjAoe8/1R+V3xPPvG4009RfuNP+ezAfsleYJvSu8zCcn5hXnVI82o5vJXDhzze2qPsCNPb6aRRbT7f7jAlDknq/eLyGfunkSGAYeGjNYk67GGTsBnM2zZrAaa6/B1PPLLFNhODQQr7N6v9fs/DsM4efE++C34Vxojq0+HVC/3jK8e26YyFm28yC43CuzfKfIKtSxZhDcKjnQnbq5LN9nl4hX5qhE8Hx2SIj2qp4czul0bQSUEYw7qSpasVPp5QhmXO/kL/RWFgHoaFCSzsP13qexgWJnDatln9HjbWRhnmQxHvAmZap2WBisGUCcNr+XsH+byMVMkvWdn2AlblqmXCfgVZcHyuoGGV0LVhVVXoVQkbq46b/P77VDhKmG+2cWiWX9mjGkyJklCxZfYX8YJ2GNhe+HAChMBqR1YaIkmhYZXQqWGZBMHlhnJh8ggXhuhf8YSjy8L+dnFrK46M6V+5syUK8agA9W9bzUwjtrWNa/ELr4b1WPSooWGV0Klh4QhIO89L/IWM/n0imm4qbsxM9tjZMmGnWmZVtIEnhO0bgyybjiy0rRFOyyE+Fj1qaFgldGdYJuJAE6+IA7OiMZXT8qdQwtY0t//xO0foTfXdUEQdCiWflG1cwaLkYVJ5JUnDEbwAFwU0rBK6Myz5yEuUnui12XdESdrF4BWF/rE5c1Z4WXOV0GHLXJv5wsDx0YwKx7zme8IjvKrvkNRDwyqhI8NqE16lwqhqavk8ljyO0DxUYsUjyS0R+myZa1MPLMlkVX1PLK6f1X1DDO8nSMcDGlYJHRkWpoq02yrV/siSolSiSoGmE9Y7ZiQtB1Oq1rk2WI/2QMHgSusP/MKrLi5ufH6gYZXQhWGZi4Mh5jAGhgNuO80RoHogETpZOXzIduqL4gDqhRG2DAPVoWhFkKUNr6o+OyKHhlVCF4alrb2qVBJkFYuSAoRXqfq9xXvvsZ16YcIr9KMajGrjECUO2uw7PjsnyPJwPfyXufaW0LBK6MKw1EVA1cLYnJ0KeT2udtUpQZ0kSoMUzcFB/y2DLHxkZpDyN02eY5e3G214hbdjrr09NKwSghuWR7KjTknld/5NW10cLKjNx6TOECX1ZfBHM35Nq5ZhINAaKzbOgiz1N4S4jI7UQ8MqIbhhLW26X3iIhMpPnpXDh0K6IVSIJuRoU2nYOE2ZeTRsebMOvFV3S0ASe6aZrJJHCdcq203SEhpWCWENq5NLZrm7RuRHQy5MML8i0mOzt8pnMoadr9JQVWA6bf3Q5qHwpojLtPEyWnmchKQUGlYJYQ1LnW5Hn4J5iz7TEEO4BFOFeNjY494RXayXmHj+0GmNABsXr9xpMcGv3O5nphGUwSgVBzP5aJhrDwUNq4SwhqVLMM1ML66flTTBCLEqPC/4zV7IHHlVIJa4iXaa4VDLZzIGUwyRVMcKO94+jY3PzoxZ4PhW2FL+aQYaJMmgYZUQ0LDwkjm/xfMB5zfWKaJbAvs9RAeS1A/2BZ8RBmNSNpqRNN7362BGIuy/ojhDl8wOVOaqvqwp1+j9iEPs0LBKCGhYuvVgLjNl1h31Y0hS4/Cshi/83K22qsGYQ6epctR6TdVMVtV/4BAFeWKn6U38pnLhgDDXHhYaVgkBDUuVSMb5nS0fMA/NGOpnEV5t6twc8yceT/uEbSnsQHCvdR7tnlYl9VU3MGFLbG9btiBw3UkijK39ZQHiQMMqIZRhmeuD8vUgNludNvJ4LFxRmIf5GKQ5cMsJbYX1mWbliybiPcUYbMsCwqycVbh7iXXZ90bhUPR77a8JEAcaVgmhDEt11Rzv6AxVe9G9RIUCS6xQ5NNS/nmpqqjwodRfglSVnmKQLQuyUmCUim+XJuFoaDOARAINq4RQhiUfJ4RT3Aln8P2sSugUVTptFKn3JE1mm9ViwhNxMGhGVVvkpV0Vlj5KwQP0I7fdOoW425GUQsMqIZRhKaoo0+cBFMoIMHi5EbjC2Mp+gkxlB5jAxVE56FJjaZ+1ayVdPVeI23RSMCpd7XuFMHjm2juChlVCEMPC2S+fdVXjbLUqrLgSp1oV4t0bS951GWuZv5gtxWFgqS/7gQMuPzilMif55ascJDg0rBKCGJbKa6p8QeV6jrALVVfQzAYyO0AnjZe6FIcr6VCygpOfVBAOkbOaboP2MQyrVBEpk1DQsEoIYliKlVd1J0B1d15eeHfEPraX1ShSToLHDGjL0yXLJV3JWLig5tyHR8y+yNy8REnDIKVhpBQaVglBDEtRl1R7bV4Vv1wRBjYzXZUqUlzUS3awJmTAS2Z4whmejkoQgGiLG0IluVXmWyqccqFyaqQIDauEIIZljolsGpvDUh0g6CrIM2EO33Gb7aKAyg4wvJqYqIsEFoCpqYobMIb2C7FQVwnRSWPij/hBwyqhvWHhL/JTv/78xjz0mEWNh9rsoMwOzPCqS4q0JQjyE+D4xvvkwQ4G2TKNFbIOK+mk/koo8YOGVUJ7w1Jl3PFe9aWPHtVY9SYI5CtW86lVB4BaW5GHHjhVpJ9CMsiqKwxCcECEp7FEGA/vy+mCKA1LbijGsPS/U9LesBQ54+R5x7ZZBYp02GXh3etz24rIqHYdp4pKMCp5Qlq3FhYvNktRVeoLhQ6DlOCTPFEalmqyefxWcHvDQlgn/boW3A0njygzYbbYxhWo8u5VFwpVK1/0o7rkj9mu2Ova+xPrsYtuZQzbrHCXAkhGlIaliF9qc89VtDcseS2PiQGbFq2nd76gMyyMqt+zjSuAHcgNC/8t7iPQBkGqh0PBR7QF9KWDbCTITealwpCyx2+QIERpWIoMEU736qv7VbQ3LPkVLrxR4zmtyogZCb7bVbl8DLJ0daNyUpwk9fc8F1HVoGF3PPLu6sVgcka5f6xSi5/zIKVEaViK6CA5j7WFfC0NC/+bvdQoDK8xD60rSkqsoTFqg4nLXRXvXuoFqtgEh1SbF1dl9NG/NpzxCOLwFvJdhjAqZt8DEqVhqRzB4zxuaViq5AvmQGPlN/o3HYrnFTaWWIO8SBIdlt5Poy2Vkl8iTFE9vcvYtPICi0k1ivtP9xSttEtIyUdMhERpWEBxw1d1zriKloalqqXElo1LBm0ggMFLPFr3wZVVNpijpDGsqluFqsBeyI8kzgfVB61daGPj1HB1tbKQcmCkhlgNq6MnZ6a0NCxVWgRb2mbVYPmGM15lDTWlnhm6crZC8KK9iod5q12b6zxF/PQugEOq+g7A4PNpQY8gS3LLN2lk0IYFL7DN2qG7PpWcyo6t1NDSsBRVF0lz26wWRUQpNuiWpVgebqJNP2MlpfVE4aesWwwWDqkdmNzv0l+NZva9NQM1LJxPS5vuxwcPu/GQfb8EfEOaDjXfkAs331R6qatIS8NSFGHlfianHlXtKGaXZPGlWHAly2rnYqvu+pp4T/MgIjNHUvwp41OTZIu0azqMoejX5rTXWB421l4kJUUGa1hQv4dzxU/OhNF+SeKtsT1GWz+Z4T6KPSozLMW1LXFtofYZxBJrxncAtnTalqssPlLYOqTPJAK8oznCYsPC7jSGljiLzLUCsftD2M2iD+JDV5kpJBkeqWfghuWromHhjJHOt0zJfTBoBR2bvRXOAiOA8A8YB+Zk+pJid8oMS/GIEnEhfheGpVjTla1oVEMy1ux164wq04TdabzacPKJx6V7nQj7iDPcNl7NSc3djkZJ9t05jYmKiA0LqIOsvDANEHNNTZrBw18gzbelVcGwMEhT7ijrqmYyOGgNS5LeRtQgn7rY0t+Xkz3FLtiWGlSVEzgZau7TBurcU9mOZ+Cz9uhNW4xG8sRtWNolQ3glb73KsDQPcjKGJXuYhOog41hJDEtVj4otnWWR6sIlJrZf/aSq2N0cz9ovAFVvUOOw1Y/QSmLVKgckjcRtWEBXqhNcBcPCv7O/N0o+jUfBsPL5F3wW2tjHL7JQXW3AljULTwxAd6rkfuW/hnTLVQ1rhc/Rb3VMQPSGBRCk6E7EgCozLHM0xIYlLEwbBcPK13apfBlCc0ktaxF1pqziIoZqZ1Nhe0nxlPpuxPRgKov+Sco4GBb+/vHdd2LyO00GoYJhqSYGxiwsTOvIsOQHDVvmZy/amsBHY1iSWtYiihoRqKz8ImXxjttUi0F0hRCy6pRzUFXJGaVXXWWdkzzjYFgp+CqWO0UwFQzrnObG7OEalgkGNYaVX9PZ7HVhsyoZw/KKKVS3NFiXKSzi1JmmZMDykFBxvfWysFOh7vr4XDE+hgVskkL1XddSSW1X3rBURYloG5Fh5YequsIIYWM/w9JWeyFyyX8cQBsMGunv/lNdMzVKsu/CSmaSMVaGBTCRcKqZuaQ6QbW6XM+F6YFv7/zAFNWYsRlWvmJAWyyOjf0MC19CKsOCnH1f1D+s3WO0WgeHMCpm37WMm2GlLL+yB0sDcwJpv1prlEwGTJ70vMQKtLRqWZWCjcmwVldgaBdB2Lj0cDWiNSyMM7/vPheRlU9GzdDeEQ1hbH6pvc8tAQwrTR4NQHLDSsGpkJ5DaGtOeg/zwvbJoi/t4djsrZi0+O51Fh150nSJXPWFjhnYEadhvSSGhW2cVvXKhwOpL6vkbVhOP43K1lnaHczkVJwJwVnh9CMRzqvGygmSEcCw8OniXByA7PspwWkEi4Ev4Gszu/kmO1fyyr+UCp4Fp8CcwbujH4ljYpLkx9woYRZDe5AlQ8U2Tqt65e/BxNFwXm2U37TUHk8oeyOPtqnS5h7gEDldSVTz/UccAhhWXGCWwiNgYVgsQAiIoPTfiBqM3tyHcwjnujagI4R0zefOsAgh8ULDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREAw2LEBINNCxCSDTQsAgh0UDDIoREwqVL/w8KSyqJVFfZUwAAAABJRU5ErkJggg==
        $data = base64_decode($image_array_2[1]);
        //        return $data;
        $image_name = HelperController::make_slug(Carbon::now());

        $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'temporary');
        $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'temporary'.DIRECTORY_SEPARATOR.$image_name.'.jpg');
        HelperController::upload_images($path, $destination, $data, '380', '290');

        return '/website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'temporary'.DIRECTORY_SEPARATOR.$image_name.'.jpg';
    }

    public function change_status(Request $request)
    {
        $user = Vendor::find($request->vendor_id);
        $user->update([
            'status' => $request->status,
        ]);

        return response()->json(['data' => 'success']);

    }
}
