<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Vendors extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $userID;

    public $name;

    public $email;

    public $password;

    public $phone;

    public $address;

    public $website;

    public $profit_group;

    public $bank_name;

    public $bank_iban;

    protected $listeners = ['VendorAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:vendors,name,deleted_id,id',
        'email' => 'required|string|email|max:255|unique:vendors,email,deleted_id,id',
        'phone' => 'required|string|unique:vendors,email,deleted_id,id',
        'password' => 'required',
    ];

    // protected $messages = [
    //     'email.required' => "Required Field",
    //     'email.email' => "Email Field",
    //     'name.required' => "Required Field",
    //     'name.string' => "String Field",
    // ];

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
        $data['CurrentUsers'] = Vendor::select('id', 'name', 'email');

        if ($this->sortBy == 'id') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'name') {
            $data['CurrentUsers']->orderBy('name', $this->sortDirection);
        } elseif ($this->sortBy == 'phone') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('phone', $this->sortDirection);
        } else {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderByDesc('id');
        }
        $data['CurrentUsers'] = $data['CurrentUsers']->get();

        $data['title'] = __('dashboard.users');

        return view('livewire.dashboard.admin.vendors', $data);
    }

    public function createVendor()
    {
        if (! in_array('10', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        // dd('test');
        Vendor::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'website' => $this->website,
            'profit_group' => $this->profit_group,
            'bank_name' => $this->bank_name,
            'bank_iban' => $this->bank_iban,
            'password' => Hash::make($this->password),
            'status' => 1,
        ]);

        session()->flash('message', 'Vendor successfully Created.');

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->address = '';
        $this->website = '';
        $this->profit_group = '';
        $this->bank_name = '';
        $this->bank_iban = '';
        $this->emit('VendorAdded');

        $this->reset(['name', 'email', 'password']);
        // $this->dispatchBrowserEvent('close-modal');

    }

    public function editVendor($userID)
    {
        if (! in_array('11', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $user = Vendor::find($userID);
        if ($user) {
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->address = $this->address;
            $user->website = $this->website;
            $user->profit_group = $this->profit_group;
            $user->bank_name = $this->bank_name;
            $user->bank_iban = $this->bank_iban;
            $user->password = Hash::make($this->password);
            $user->status = $this->status;

            session()->flash('message', 'Vendor successfully Created.');
        } else {
            session()->flash('message', 'Vendor Not Found.');
        }
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('12', Session::get('permissionData'))) {
            return redirect()->back();
        }

        if ($this->deleteId != 1) {
            Vendor::where('id', $this->deleteId)->delete();
        }
        $this->emit('VendorAdded');
    }

    public function deleteConfirm($userID)
    {
        if ($userID != 1) {
            Vendor::where('id', $userID)->delete();
        }
        $this->emit('VendorAdded');
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
    }
}
