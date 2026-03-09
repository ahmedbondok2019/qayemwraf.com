<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    protected $listeners = ['userAdded' => '$refresh'];

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
        $data['CurrentUsers'] = User::query();

        if ($this->sortBy == 'id') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'name') {
            $data['CurrentUsers']->orderBy('name', $this->sortDirection);
        } elseif ($this->sortBy == 'email') {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderBy('email', $this->sortDirection);
        } else {
            $data['CurrentUsers'] = $data['CurrentUsers']->orderByDesc('id');
        }
        $data['CurrentUsers'] = $data['CurrentUsers']->get();

        $data['title'] = __('dashboard.Customers');
        $data['table'] = 'users';
        $data['route'] = 'edit_users';
        $data['UserType'] = 'user';
        $data['routeForm'] = 'Users';
        $data['DeleteRoute'] = 'user';
        $data['Profile'] = 'profile';

        return view('livewire.dashboard.admin.users', $data);
    }
}
