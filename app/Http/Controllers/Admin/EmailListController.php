<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsLetterExport;
use App\Exports\UsersExport;
use App\Models\Newsletter;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class EmailListController extends BackendController
{
    public function index()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['Currentnewsletter'] = Newsletter::whereNotNull('email')
        // whereDay('send_date', '>', Carbon::today()->format('d'))
            ->whereNull('send_date')->orderby('id', 'desc')->paginate(8);

        $data['totalSent'] = Newsletter::whereNotNull('send_date')->count();
        $data['totalToday'] = Newsletter::whereDay('send_date', Carbon::today()->format('d'))
            ->whereMonth('send_date', Carbon::today()->format('m'))
            ->whereYear('send_date', Carbon::today()->format('Y'))
            ->count();
        $data['Setting'] = Setting::where('lang_id', app()->getLocale())->first();

        return view('dashboard.admin.email_list.index', $data);
    }

    public function phones()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Currentnewsletter'] = Newsletter::whereNotNull('number')
        // whereDay('send_date', '>', Carbon::today()->format('d'))
            ->whereNull('send_date')->orderby('id', 'asc')->paginate(8);

        $data['totalSent'] = Newsletter::whereNotNull('send_date')->count();
        $data['totalToday'] = Newsletter::whereDay('send_date', Carbon::today()->format('d'))->whereNotNull('send_date')->count();

        return view('dashboard.admin.email_list.index', $data);
    }

    public function createContact(Request $request)
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        // dd($request->all());
        if ($request->has('contacts')) {
            $path = $request->file('contacts')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            $dataRow = [];
            foreach ($data as $newUrls) {
                $number = null;
                if (trim($newUrls[0]) != null) {
                    $checkDuplicte = Newsletter::where('email', trim($newUrls[0]))->first();
                    if (! $checkDuplicte) {
                        if (trim($newUrls[0]) == null || trim($newUrls[0]) == 'email') {
                            $emailValue = null;
                        } else {
                            $emailValue = trim($newUrls[0]);
                        }
                        $dataRow[] = [
                            'email' => $emailValue,
                            'number' => null,
                            'deleted_at' => null,
                            'send_date' => null,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                } else {
                    $checkDuplicte = Newsletter::where('number', trim($newUrls[1]))->first();
                    if (! $checkDuplicte) {
                        $number = '0'.trim($newUrls[1]);
                        if (Str::startsWith(trim($newUrls[1]), '01')) {
                            $number = trim($newUrls[1]);
                        }

                        if (trim($newUrls[0]) == null || trim($newUrls[0]) == 'email') {
                            $emailValue = null;
                        } else {
                            $emailValue = trim($newUrls[0]);
                        }

                        $dataRow[] = [
                            'email' => $emailValue,
                            'number' => $number,
                            'deleted_at' => null,
                            'send_date' => null,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }

            Newsletter::insert($dataRow);

            return redirect()->back()->with('msg', 'uploaded successfully');
        } else {
            if ($request->contacts_txt != null) {
                $datas = explode(';', $request->contacts_txt);
                if (is_array($datas)) {
                    $data = [];
                    foreach ($datas as $value) {
                        $sub = explode(',', $value);
                        foreach ($sub as $new_sub) {
                            array_push($data, $new_sub);
                        }
                    }
                } else {
                    $data = explode(',', $request->contacts_txt);
                }

                $dataRow = [];
                foreach ($data as $newUrls) {
                    $emailRow = Newsletter::where('email', trim($newUrls))->first();
                    if (! $emailRow) {
                        $dataRow[] = [
                            'email' => trim($newUrls),
                            'deleted_at' => null,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }

                    // array_push($dataRow, trim($newUrls));
                }
                Newsletter::insert($dataRow);

                return redirect()->back()->with('msg', 'done.');
            } else {
                return redirect()->back()->with('msg', 'upload file to proceed.');
            }
        }
    }

    public function createContactBlackList(Request $request)
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }
        // dd($request->all());
        if ($request->has('block_contacts')) {
            $path = $request->file('block_contacts')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            $dataRow = [];
            foreach ($data as $newUrls) {
                $checkDuplicte = Newsletter::where('email', trim($newUrls[0]))->first();
                if ($checkDuplicte) {
                    $checkDuplicte->update([
                        'deleted_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                array_push($dataRow, [trim($newUrls[0])]);
            }

            return redirect()->back()->with('msg', 'uploaded successfully');
        } else {
            if ($request->contacts_txt != null) {
                $datas = explode(';', $request->contacts_txt);
                if (is_array($datas)) {
                    $data = [];
                    foreach ($datas as $value) {
                        $sub = explode(',', $value);
                        foreach ($sub as $new_sub) {
                            array_push($data, $new_sub);
                        }
                    }
                } else {
                    $data = explode(',', $request->contacts_txt);
                }

                $dataRow = [];
                foreach ($data as $newUrls) {
                    $emailRow = Newsletter::where('email', trim($newUrls))->first();
                    if ($emailRow) {
                        $emailRow->delete();
                    }

                    array_push($dataRow, trim($newUrls));
                }

                // dd($dataRow);
            }

            return redirect()->back()->with('msg', 'done.');
        }
    }

    public function hasWhatsapp()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        // $all_phones = phone::all();
        // foreach ($all_phones as $phone) {
        //     $result = \App\Http\Controllers\admin\phoneController::hasWhatsappV2($phone->number);
        //     if ($result == "null") {
        //         $phone->update(['status' => 'null']);
        //         // return false;
        //     } else {
        //         $phone->update(['status' => 'valid']);
        //         // return true;
        //     }

        // }
        return redirect()->back()->with('msg', 'checked successfully');
    }

    public function hasWhatsappV2($number)
    {
        $country = substr($number, 0, 2);
        $number = substr($number, 2);

        $status_url = 'https://sro.whatsapp.com/client/iphone/iq.php?cd=1&cc=002&me=12345&u[]='.$number;
        $status_content = file_get_contents($status_url);
        $status_xml = simplexml_load_string($status_content);

        if (! $status_xml->array->dict) {
            return false;
        }

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = Newsletter::where('id', '=', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/newsletter/all');
    }

    public function send(Request $request)
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $setting = Setting::where('lang_id', app()->getLocale())->first();
        $newsletter = Newsletter::find($request->id);
        if ($newsletter) {
            $newsletter->update(['send_date' => Carbon::now()]);
            $data = [
                'email' => $newsletter->email,
                'newsletter_title' => $setting->newsletter_title,
                'newsletter_description' => $setting->newsletter_description,
                'newsletter_image_to_send' => $setting->newsletter_image_to_send,
            ];

            Mail::send('dashboard.user.newsletter', $data, function ($message) use ($newsletter, $setting) {
                // $message->from('notification@souqelmlabes.com', 'بيع منتجك واربح معنا');
                $message->from('notification@souqelmlabes.com', $setting->newsletter_title);
                $message->to($newsletter['email']);
                // $message->subject('موقع '. env('APP_NAME') .' - بيع منتجك');
                $message->subject(env('APP_NAME').'موقع - '.$setting->newsletter_description);
            });

            alert()->success('تم ارسال رسالتك بنجاح ', trans_db('dashboard.congratulation'));
        } else {
            alert()->error('لم يتم ارسال رسالتك', trans_db('dashboard.attention'));
        }

        return redirect('admin-2023/newsletter/all');
    }

    public function Usersexport()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return Excel::download(new UsersExport, 'UsersReports.xlsx');
    }

    public function Newsletterexport()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return Excel::download(new NewsLetterExport, 'NewsLetterReports.xlsx');
    }
}
