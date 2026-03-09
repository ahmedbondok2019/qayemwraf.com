<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\User;
use Livewire\Component;

class Customers extends Component
{
    protected $listeners = ['customerAdded' => '$refresh'];

    public function render()
    {
        $data['CurrentCustomers'] = User::orderbyDesc('id')->get();
        $data['title'] = __('dashboard.Customers');
        $data['table'] = 'customers';
        $data['route'] = 'edit_customers';
        $data['CustomerType'] = 'customer';
        $data['routeForm'] = 'Customers';
        $data['DeleteRoute'] = 'customer';
        $data['Profile'] = 'profile';

        return view('livewire.dashboard.admin.customers', $data);
    }
}
