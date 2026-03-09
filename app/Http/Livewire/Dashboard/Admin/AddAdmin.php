<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddAdmin extends Component
{
    public $userID;

    public $name;

    public $email;

    public $password;

    public $admin;

    protected $listeners = ['adminAdded' => '$refresh'];

    protected $rules = [
        'name' => 'required|string|max:255|unique:admins,name,deleted_at,id',
        'email' => 'required|string|email|max:255|unique:admins,email,deleted_at,id',
        'password' => 'required',
        'admin' => 'required|integer',
    ];

    protected $messages = [
        'email.required' => 'Required Field',
        'email.email' => 'Email Field',
        'name.required' => 'Required Field',
        'name.string' => 'String Field',
        'name.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        return view('livewire.dashboard.admin.add-admin');
    }

    public function createAdmin()
    {
        if (! in_array('6', Session::get('permissionData'))) {
            return redirect()->back();
        }

        // $this->validate();
        $inputs = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'permission_group' => $this->admin,
            'admin_type' => 1,
            'status' => 1,
            'deleted_at' => null,
        ];
        $exists = Admin::where('name', $this->name)
            ->orwhere('email', $this->email)
            ->withTrashed()
            ->first();
        if ($exists != null) {
            $exists->update($inputs);
            $exists->restore();
        } else {
            Admin::create($inputs);
        }

        session()->flash('message', 'Admin successfully Created.');

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->admin = '';
        $this->emit('adminAdded');

        $this->reset(['name', 'email', 'password', 'admin']);

    }
}
