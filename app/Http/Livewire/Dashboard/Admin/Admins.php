<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Admins extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $userID;

    public $name;

    public $email;

    public $password;

    public $admin;

    protected $listeners = ['adminAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:admins,name,deleted_id,id',
        'email' => 'required|string|email|max:255|unique:admins,email,deleted_id,id',
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

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    // public function updatingSearch()
    // {
    //     $this->resetPage('commentsPage');
    // }

    /* خاص بالفلترة */
    public $sortBy = 'id';

    public $field;

    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
    /* خاص بالفلترة */

    public function render()
    {
        $data['CurrentUsers'] = Admin::select('id', 'name', 'email');

        if ($this->sortBy == 'id') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'name') {
            $data['CurrentUsers']->orderBy('name', $this->sortDirection);
        } elseif ($this->sortBy == 'email') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('email', $this->sortDirection);
        } else {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderByDesc('id');
        }
        $data['CurrentUsers'] = $data['CurrentUsers']->paginate(25);

        $data['title'] = __('dashboard.users');
        $data['table'] = 'Admin';
        $data['route'] = 'edit_admins';
        $data['UserType'] = 'admin';
        $data['routeForm'] = 'Admins';
        $data['DeleteRoute'] = 'admin';

        return view('livewire.dashboard.admin.admins', $data);
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
            'active' => 1,
        ];
        $exists = Admin::where('name', $this->name)
            ->orwhere('email', $this->email)
            ->whereNotNull('deleted_at')
            ->exists();
        if ($exists == true) {
            Admin::where('name', $this->name)
                ->orwhere('email', $this->email)->update($inputs);
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
        // $this->dispatchBrowserEvent('close-modal');

    }

    public function editAdmin($userID)
    {
        if (! in_array('7', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $user = Admin::find($userID);
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->admin = $user->admin;
        }
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId != 1) {
            Admin::where('id', $this->deleteId)->delete();
        }
        $this->emit('adminAdded');
    }

    public function deleteConfirm($userID)
    {
        if ($userID != 1) {
            Admin::where('id', $userID)->delete();
        }
        $this->emit('adminAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->admin = '';
    }
}
