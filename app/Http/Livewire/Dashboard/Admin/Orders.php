<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Exports\OrdersSheetsExport;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\User\UsersController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderOption;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderID;

    public $pages;

    public $select = [];

    public $multi_status;

    public $search = '';

    protected $listeners = ['orderAdded' => '$refresh'];

    public $deleteId = '';

    public $notes;

    public $user_id;

    public $order_id;

    protected $rules = [
        'notes' => 'nullable|string|max:100000',
        'multi_status' => 'required|string|max:10',
    ];

    protected $messages = [
        'notes.required' => 'Required Field',
        'notes.string' => 'String Field',
        'notes.max' => 'max Field 255',
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
        if (! in_array('57', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['orders'] = Order::query();

        if ($this->pages != 'not_completed') {
            if ($this->search != null || $this->search != '') {
                $data['orders'] = $data['orders']->join('users', 'orders.user_id', 'users.id')
                    ->select('orders.*')
                    ->where('users.name', 'Like', '%'.$this->search.'%')
                    ->orwhere('users.name', $this->search)
                    ->orderBy('users.id', $this->sortDirection);
            }
            if ($this->sortBy == 'id') {
                $data['orders'] = $data['orders']->orderBy('id', $this->sortDirection);
            } elseif ($this->sortBy == 'total') {
                $data['orders'] = $data['orders']->orderBy('total', $this->sortDirection);
            } elseif ($this->sortBy == 'status') {
                $data['orders'] = $data['orders']->orderBy('status', $this->sortDirection);
            } elseif ($this->sortBy == 'payment_status') {
                $data['orders'] = $data['orders']->orderBy('payment_status', $this->sortDirection);
            } elseif ($this->sortBy == 'user_id') {
                $data['orders'] = $data['orders']->join('users', 'orders.user_id', 'users.id')
                    ->select('orders.*')
                    ->orderBy('users.id', $this->sortDirection);
            } elseif ($this->sortBy == 'area') {
                $data['orders'] = $data['orders']->join('area_translations', 'orders.area', 'area_translations.area_id')
                    ->where('area_translations.lang_id', app()->getLocale())
                    ->select('orders.*')
                    ->orderBy('area_translations.area_id', $this->sortDirection);
            } else {
                $data['orders'] = $data['orders']->orderByDesc('id');
            }
        }

        if ($this->pages == 'all') {
            $data['orders'] = $data['orders']->paginate(25);

            return view('livewire.dashboard.admin.orders', $data);
        }
        if ($this->pages == 'return') {
            $data['orders'] = $data['orders']->where('status', 5)->paginate(25);

            return view('livewire.dashboard.admin.orders', $data);
        }
        if ($this->pages == 'not_completed') {
            $data['orders'] = Cart::query();
            if ($this->sortBy == 'user_id') {
                $data['orders'] = $data['orders']->join('users', 'carts.user_id', 'users.id')
                    ->select('carts.*')
                    ->orderBy('users.id', $this->sortDirection);
            } elseif ($this->sortBy == 'email') {
                $data['orders'] = $data['orders']->join('users', 'carts.email', 'users.email')
                    ->select('carts.*')
                    ->orderBy('users.email', $this->sortDirection);
            } elseif ($this->sortBy == 'phone') {
                $data['orders'] = $data['orders']->join('users', 'carts.phone', 'users.phone')
                    ->select('carts.*')
                    ->orderBy('users.phone', $this->sortDirection);
            } elseif ($this->sortBy == 'product_id') {
                $data['orders'] = $data['orders']->join('product_translations', 'carts.product_id', 'product_translations.product_id')
                    ->where('product_translations.lang_id', app()->getLocale())
                    ->select('carts.*')
                    ->orderBy('product_translations.product_id', $this->sortDirection);
            } else {
                $data['orders'] = $data['orders']->orderByDesc('id');
            }
            $data['orders'] = $data['orders']->paginate(25);

            return view('livewire.dashboard.admin.orders-not-completed', $data);
        }
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('60', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Order::where('id', $this->deleteId)->delete();
        OrderDetail::where('order_id', $this->deleteId)->delete();
        OrderOption::where('order_id', $this->deleteId)->delete();
        $this->emit('orderAdded');
    }

    public function deleteConfirm($orderID)
    {
        if (! in_array('60', Session::get('permissionData'))) {
            return redirect()->back();
        }

        Order::where('id', $this->deleteId)->delete();
        OrderDetail::where('order_id', $this->deleteId)->delete();
        OrderOption::where('order_id', $this->deleteId)->delete();
        $this->emit('orderAdded');
    }

    public function multiDelete()
    {
        if (! in_array('60', Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (! empty($this->select)) {
            Order::whereIn('id', $this->select)->delete();
            $details = OrderDetail::whereIn('order_id', $this->select)->pluck('id');
            OrderDetail::whereIn('order_id', $this->select)->delete();
            OrderOption::whereIn('order_details_id', $details)->delete();
        }

        $this->emit('orderAdded');
    }

    public function multiExport()
    {
        if (! in_array('59', Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (! empty($this->select)) {
            Session::put(['orders_id' => $this->select]);

            return Excel::download(new OrdersSheetsExport, 'orders.xlsx');
        }

        $this->emit('orderAdded');
    }

    public function multiStatus()
    {
        // dd($this->multi_status);
        if (! in_array('131', Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (! empty($this->select)) {
            Order::whereIn('id', $this->select)->update([
                'status' => $this->multi_status,
            ]);

            foreach ($this->select as $selected) {
                $this->order_id = $selected;
                $this->user_id = Order::where('id', $selected)->first()->user_id;
                self::createOrderStatus();
            }

        }

        $this->emit('orderAdded');
    }

    public function createOrderStatus()
    {
        if (! in_array('58', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = OrderStatus::where('notes', $this->notes)->where('status', $this->multi_status)
            ->where('user_id', $this->user_id)->where('order_id', $this->order_id)
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            $notPreviousStatus = OrderStatus::where('user_id', $this->user_id)
                ->where('order_id', $this->order_id)->orderByDesc('status')->first();
            if (isset($notPreviousStatus)) {
                if ($this->multi_status > $notPreviousStatus->status) {
                    self::store($this->notes, $this->multi_status, $this->user_id, $this->order_id);
                }
            } else {
                self::store($this->notes, $this->multi_status, $this->user_id, $this->order_id);
            }
        }

        session()->flash('message', 'Status successfully Created.');

        // $this->notes = "";
        // $this->status = "";
        $this->emit('OrderAdded');

        // $this->reset(['notes', 'status']);

    }

    public static function store($notes, $status, $user_id, $order_id)
    {
        if ($status > 0) {
            Order::where('id', $order_id)->where('user_id', $user_id)->update([
                'status' => $status,
            ]);

            OrderStatus::create([
                'status' => $status,
                'notes' => $notes,
                'user_id' => $user_id,
                'order_id' => $order_id,
                'admin_id' => Auth::id(),
            ]);

            $settings = Setting::first();
            if ($settings->send_order_notification == 1 || $settings->send_order_notification == 3) {
                HelperController::sendMailPublic(
                    User::find($user_id),
                    HelperController::orderStatusApi($status)['text'],
                    HelperController::orderStatusApi($status)['slug'],
                    'dashboard.user.order_mail_status',
                    __('dashboard.Order Status'),
                    $order_id
                );
            }

            if ($settings->send_order_notification == 2 || $settings->send_order_notification == 3) {
                $text = __('dashboard.Order Confirmation').'#'.$order_id.' : '.OrdersController::getOrderStatus($status).' '.\LaravelLocalization::localizeUrl('user/complete/'.$order_id);
                UsersController::sendSms(Auth::user()->phone, $text);
            }
        }

    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        // $this->title = '';
    }
}
