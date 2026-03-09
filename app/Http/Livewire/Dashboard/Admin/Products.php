<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\Vendor;
use App\Observers\ProductObserver;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['productAdded' => '$refresh'];

    public $productID;

    public $deleteId;

    public $price;

    public $show_in_landing;

    public $sale_price;

    public $select = [];

    public $multi_status;

    public $category_id;

    public $search = '';

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

    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($category_id)
    {
        $this->category_id = $category_id;
    }

    public function render()
    {
        $IDS = ProductTranslation::whereLike('title', $this->search ?? '');
        if ($this->category_id != null) {
            $ProCat = HelperController::GetTree($this->category_id);
            $ProductCategories = collect($ProCat)->unique()->toArray();

            $ProductCategory = ProductCategory::whereIn('category_id', $ProductCategories)
                ->pluck('product_id');
            $IDS = $IDS->whereIn('product_id', $ProductCategory);
        }
        $IDS = $IDS->orwhere('product_id', $this->search ?? '')
            // ->orderBy($this->sortBy , $this->sortDirection)
            ->pluck('product_id');

        $products = Product::whereHas('translations');
        if ($this->sortBy == 'id') {
            $products = $products->whereIn('id', $IDS)->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $products = $products->join('product_translations', 'products.id', 'product_translations.product_id')
                ->select('products.*')
                ->whereIn('products.id', $IDS)
                ->orderBy('product_translations.title', $this->sortDirection);
        } elseif ($this->sortBy == 'price') {
            $products = $products->whereIn('id', $IDS)->orderBy('price', $this->sortDirection);
        } elseif ($this->sortBy == 'status') {
            $products = $products->whereIn('id', $IDS)->orderBy('status', $this->sortDirection);
        } else {
            $products = $products->orderByDesc('id');
        }
        $products = $products->paginate(10);

        $vendors = Vendor::all();

        return view('livewire.dashboard.admin.products', [
            'products' => $products,
            'vendors' => $vendors,
            'category' => $this->category_id,
        ]);
    }

    public function deleteConfirm($productID)
    {
        if (! in_array('44', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }
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
        $this->emit('productAdded');
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function updatePrice($productID, $value, $index)
    {
        if (! in_array('130', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }
        if ($index == 1) {
            Product::where('id', $productID)->update([
                'price' => $value,
            ]);
        } else {
            Product::where('id', $productID)->update([
                'sale_price' => $value,
            ]);
        }

        Product::observe(ProductObserver::class);
        session()->flash('message', __('dashboard.updated'));
        $this->emit('productAdded');
    }

    public function updateShowInLanding($productID, $show_in_landing)
    {
        Product::where('id', $productID)->update([
            'show_in_landing' => $show_in_landing == null ? 0 : 1,
        ]);

        Product::observe(ProductObserver::class);
        session()->flash('message', __('dashboard.updated'));
        $this->emit('productAdded');
    }

    public function updateVendor($productID, $vendor_id)
    {
        if (! in_array('131', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }

        Product::where('id', $productID)->update([
            'vendor_id' => $vendor_id,
        ]);

        session()->flash('message', __('dashboard.updated'));
        $this->emit('productAdded');
    }

    public function delete()
    {
        if (! in_array('44', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }
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

        $this->emit('productAdded');
    }

    public function multiStatus()
    {
        // dd($this->multi_status);
        if (! in_array('131', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (! empty($this->select)) {
            Product::whereIn('id', $this->select)->update([
                'status' => $this->multi_status,
            ]);
        }

        $this->emit('productAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }
}
