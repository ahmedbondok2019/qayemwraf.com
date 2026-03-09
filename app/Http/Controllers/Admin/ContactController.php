<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends BackendController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_read) {
                        return '<span class="badge badge-light-success">' . trans_db('dashboard.Read') . '</span>';
                    }
                    return '<span class="badge badge-light-danger">' . trans_db('dashboard.Unread') . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                                <a href="' . route('admin.contacts.show', $row->id) . '" class="btn btn-sm btn-info">
                                    <i data-feather="eye"></i>
                                </a>
                                <form action="' . route('admin.contacts.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                        <i data-feather="trash"></i>
                                    </button>
                                </form>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.admin.contacts.index');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['is_read' => 1]);
        return view('dashboard.admin.contacts.show', compact('contact'));
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
        return redirect()->route('admin.contacts.index');
    }
}
