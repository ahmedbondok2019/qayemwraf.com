<?php

namespace App\Http\Livewire\Dashboard\Vendor;

use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['productAdded' => '$refresh'];

    public $productID;

    public $deleteId;

    public $search = '';

    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage('commentsPage');
    }

    public function render()
    {
        $IDS = ProductTranslation::whereLike('title', $this->search ?? '')->pluck('product_id');
        $products = Product::where('vendor_id', Auth::id())->whereHas('translations')->whereIn('id', $IDS)->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.vendor.products', [
            'products' => $products,
        ]);
    }

    public function deleteConfirm($productID)
    {
        $product = Product::where('vendor_id', Auth::id())->where('id', $productID)->first();
        if (isset($product) && $product != null) {
            $testRelated = OrderDetail::where('product_id', $productID)->first();
            if (empty($testRelated)) {
                Product::where('id', $productID)->delete();
                ProductTranslation::where('product_id', $productID)->delete();
                $ProductImage = ProductImage::where('product_id', (string) $productID)->get();
                if ($ProductImage) {
                    ProductImage::where('product_id', $productID)->delete();
                }

                Cart::where('product_id', $productID)->delete();

                session()->flash('message', __('dashboard.deleted successfully'));
            } else {
                session()->flash('message', __('dashboard.can not delete product , product related to orders'));
            }

            session()->flash('message', __('dashboard.deleted successfully'));
        }
        session()->flash('message', __('dashboard.can not delete product'));
        $this->emit('productAdded');
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $product = Product::where('vendor_id', Auth::id())->where('id', $this->deleteId)->first();
        if (isset($product) && $product != null) {
            $testRelated = OrderDetail::where('product_id', $this->deleteId)->first();
            if (empty($testRelated)) {
                Product::where('id', $this->deleteId)->delete();
                ProductTranslation::where('product_id', $this->deleteId)->delete();
                ProductImage::where('product_id', (string) $this->deleteId)->delete();
                Cart::where('product_id', $this->deleteId)->delete();

                session()->flash('message', __('dashboard.deleted successfully'));
            } else {
                session()->flash('message', __('dashboard.can not delete product , product related to orders'));
            }
        }
        session()->flash('message', __('dashboard.can not delete product'));
        $this->emit('productAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }
}
