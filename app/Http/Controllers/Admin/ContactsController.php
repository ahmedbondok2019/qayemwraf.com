<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;

class ContactsController extends BackendController
{
    public function Index(Request $request)
    {
        $data['contacts'] = Contact::where('msg_type', 1)->get();
        $data['type'] = trans_db('dashboard.Review');

        return view('dashboard.admin.support.index', $data);
    }

    public function editcontacts(Request $request)
    {
        $data['contacts'] = Contact::where('id', $request->id)
        // ->where('msg_type', 1)
            ->firstorFail();

        return view('dashboard.admin.support.edit', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($validator->fails()) {
                return redirect('/admin-2023/contacts/editcontacts/'.$request->id)->withErrors($validator)->withInput();
            }
        }

        $data = Contact::where('id', $request->id)->first();
        if (isset($data) && $data != '') {
            $data->update([
                'status' => 1,
                'reply' => $request->reply,
                'reply_user_id' => Auth::user()->id,
            ]);

            $Newdata = ['name' => $data->contact_name, 'email' => $data->contact_email,
                'message_data' => $data->message, 'reply' => $request->reply];

            $replay_trans = trans_db('dashboard.Replay');
            Mail::send('mail', $Newdata, function ($message) use ($Newdata, $replay_trans) {
                $message->from('notification@souqelmlabes.com', $replay_trans.' : '.$Newdata['name']);
                $message->to($Newdata['email']);
                $message->subject($replay_trans.' : '.$Newdata['name']);
            });
        }

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        Contact::where('id', $request->id)->delete();

        return redirect()->back();
    }

    public static function GetID()
    {
        $varD = str_replace(url('admin-2023/'), '', \Illuminate\Support\Facades\Request::url());
        $prefixUrl = explode('/', $varD);

        return $prefixUrl[3];
    }

    public static function GetFileStatus($status)
    {
        switch ($status) {
            case 0:
                $trans = trans_db('dashboard.Waiting');
                $style = 'background:#efc6b9';
                break;
            case 1:
                $trans = trans_db('dashboard.Replied');
                $style = 'background:#afe3af';
                break;
        }

        return ['trans' => $trans, 'style' => $style];
    }
}
