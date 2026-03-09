<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Product;
use App\Models\Promocode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddPromoCode extends Component
{
    public $promo_name;

    public $promo_code;

    public $promoValue;

    public $promoType;

    public $promo_oneUse;

    public $promoMaxAmount;

    public $promo_valid_from;

    public $promo_valid_to;

    public $promo_usage_count;

    public $product_id;

    public $payment_method;

    protected $listeners = ['PromoCodeAdded' => '$refresh'];

    protected $rules = [
        'promo_name' => 'required|string|max:255',
        'promo_code' => 'required|string|max:255',
        'promoValue' => 'required|string',
        'promoType' => 'required|string',
        'promo_oneUse' => 'required|string',
        'promoMaxAmount' => 'required|string',
        'promo_valid_from' => 'required|string',
        'promo_valid_to' => 'required|string',
        'promo_usage_count' => 'required|string',
        'product_id' => 'required|string',
        'payment_method' => 'required|string',
    ];

    protected $messages = [
        'promo_name.required' => 'Required Field',
        'promo_usage_count.required' => 'Required Field',
        'promo_name.string' => 'String Field',
        'promo_usage_count.string' => 'String Field',
        'promoValue.required' => 'Required Field',
        'promoValue.string' => 'String Field',
        'promoType.required' => 'Required Field',
        'promoType.string' => 'String Field',
        'promo_oneUse.required' => 'Required Field',
        'promo_oneUse.string' => 'String Field',
        'promoMaxAmount.required' => 'Required Field',
        'promoMaxAmount.string' => 'String Field',
        'promo_code.required' => 'Required Field',
        'promo_code.string' => 'String Field',
        'promo_name.unique' => 'لا يجب تكرار الاسم',
    ];

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function selectedProductItem($item)
    {
        if ($item) {
            $this->emit('product_id', $this->product_id);
        } else {
            $this->product_id = null;
        }
    }

    public function selectedPaymentItem($item)
    {
        if ($item) {
            $this->emit('payment_method', $this->payment_method);
        } else {
            $this->payment_method = null;
        }
    }

    public function render()
    {
        if (! in_array('65', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['products'] = Product::all();

        return view('livewire.dashboard.admin.add-promo-code', $data);
    }

    public function createPromoCodes()
    {
        if (! in_array('66', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();

        $withoutTrashed = Promocode::where('promo_name', $this->promo_name)
            ->withoutTrashed()->exists();
        // dd($this->promo_valid_to . $this->promo_valid_from);
        if (! $withoutTrashed) {
            Promocode::create([
                'promo_name' => $this->promo_name,
                'promo_code' => $this->promo_code,
                'promoType' => $this->promoType,
                'promoValue' => $this->promoValue,
                'promo_usage_count' => $this->promo_usage_count,
                'promoMaxAmount' => $this->promoMaxAmount,
                'promo_valid_from' => Carbon::createFromFormat('Y-m-d', $this->promo_valid_from),
                'promo_valid_to' => Carbon::createFromFormat('Y-m-d', $this->promo_valid_to),
                'promo_oneUse' => $this->promo_oneUse == null ? 0 : $this->promo_oneUse,
                'product_id' => str_replace(',', '', $this->product_id),
                'payment_method' => str_replace(',', '', $this->payment_method),
            ]);
        }

        session()->flash('message', 'PromoCode successfully Created.');

        $this->promo_name = '';
        $this->promo_code = '';
        $this->promoValue = '';
        $this->promoType = '';
        $this->promo_usage_count = '';
        $this->promo_oneUse = '';
        $this->promoMaxAmount = '';

        $this->emit('PromoCodeAdded');
        $this->reset([
            'promo_name', 'promoValue', 'promo_code',
            'promoType', 'promo_oneUse', 'promoMaxAmount', 'promo_usage_count',
        ]);

    }
}
