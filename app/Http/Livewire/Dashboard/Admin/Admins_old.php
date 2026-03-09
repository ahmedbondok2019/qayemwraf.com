<?php

// namespace App\Http\Livewire\Dashboard\Admin;

// use App\Http\Controllers\helper\HelperController;
// use App\Models\Admin;
// use Illuminate\Support\Facades\Hash;
// use Livewire\Component;
// use Livewire\WithPagination;

// class Admins_old extends Component
// {
//     use WithPagination;
//     protected $paginationTheme = 'bootstrap';
// protected $listeners = ['adminAdded' => '$refresh'];
// public $search = '';
// public $userID, $name , $email, $password, $admin;

// protected $rules = [
//     'name' => 'required|string|max:255|unique:admins',
//     'email' => 'required|string|email|max:255|unique:admins',
//     'password' => 'required|string',
//     'admin' => 'required|integer',
// ];

// protected $messages = [
//     'email.required' => "Required Field",
//     'email.email' => "Email Field",
//     'name.required' => "Required Field",
//     'name.string' => "String Field",
// ];

// protected $validationAttributes = [
//     'email' => 'email address'
// ];

// public function updated($propertyName)
// {
//     $this->validateOnly($propertyName);
// }

// public function updatingSearch()
// {
//     $this->resetPage('commentsPage');
// }

// public function render()
// {
//     $data['CurrentUsers'] = Admin::select('id', 'name', 'email')->orderByDesc('id')->paginate(25);
//     $data['title'] = __('dashboard.users');
//     $data['table'] = 'Admin';
//     $data['route'] = 'edit_admins';
//     $data['UserType'] = 'admin';
//     $data['routeForm'] = 'Admins';
//     $data['DeleteRoute'] = 'admin';

//     return view('livewire.dashboard.admin.admins', $data);
// }

// public function addAdmin()
// {
//     if (!in_array('10', Session::get("permissionData"))){
//         return redirect()->back();
//     }
//     return view('livewire.dashboard.admin.add-admin');
// }

// public function createAdmin()
// {
// if (!in_array('10', Session::get("permissionData"))){
//     return redirect()->back();
// }

// $this->validate();

//     Admin::create([
//         'name' => $this->name,
//         'email' => $this->email,
//         'password' => Hash::make($this->password),
//         'permission_group'=> $this->admin,
//         'admin_type'=> 1,
//         'active'=> 1,
//     ]);

//     session()->flash('message', 'Admin successfully Created.');

//     $this->name = "";
//     $this->email = "";
//     $this->password = "";
//     $this->admin = "";
//     $this->emit('adminAdded');

//     $this->reset(['name', 'email', 'password', 'admin']);
//     $this->dispatchBrowserEvent('close-modal');

// }

// public function editAdmin(int $userID)
// {
//     if (!in_array('13', Session::get("permissionData"))){
//         return redirect()->back();
//     }

//     $user = Admin::find($userID);
//     if($user){
//         $this->name = $user->name;
//         $this->email = $user->email;
//         $this->admin = $user->admin;
//     }else{
//         return redirect('/admin-2023/users/admin');
//     }
// }

//     public function closeModal()
//     {
//         $this->resetInput();
//     }

//     public function resetInput()
//     {
//         $this->name = '';
//         $this->email = '';
//         $this->password = '';
//         $this->admin = '';
//     }
// }
