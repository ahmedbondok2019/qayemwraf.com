<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\User\UsersController;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddOrderStatus extends Component
{
    public $ID;

    public $status;

    public $notes;

    public $user_id;

    public $order_id;

    protected $listeners = ['OrderAdded' => '$refresh'];

    protected $rules = [
        'notes' => 'nullable|string|max:100000',
        'status' => 'required|string|max:10',
    ];

    protected $messages = [
        'notes.required' => 'Required Field',
        'notes.string' => 'String Field',
        'notes.max' => 'max Field 255',
    ];

    public function render()
    {
        return view('livewire.dashboard.admin.add-order-status');
    }

    public function createOrderStatus()
    {
        if (! in_array('58', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = OrderStatus::where('notes', $this->notes)->where('status', $this->status)
            ->where('user_id', $this->user_id)->where('order_id', $this->order_id)
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            $notPreviousStatus = OrderStatus::where('user_id', $this->user_id)
                ->where('order_id', $this->order_id)->orderByDesc('status')->first();
            if (isset($notPreviousStatus)) {
                if ($this->status > $notPreviousStatus->status) {
                    self::store($this->notes, $this->status, $this->user_id, $this->order_id);
                }
            } else {
                self::store($this->notes, $this->status, $this->user_id, $this->order_id);
            }
        }

        session()->flash('message', 'Status successfully Created.');

        $this->notes = '';
        $this->status = '';
        $this->emit('OrderAdded');

        $this->reset(['notes', 'status']);

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
}
