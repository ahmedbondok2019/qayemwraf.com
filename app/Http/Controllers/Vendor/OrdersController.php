<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\helper\bostaController;
use App\Models\Area;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Vendor;
use Bosta\Bosta;
use Bosta\Utils\ContactPerson;
use Bosta\Utils\DropOffAddress;
use Bosta\Utils\Receiver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrdersController extends VendorBackendController
{
    public function index()
    {
        $data['pages'] = 'all';

        return view('dashboard.vendor.orders.index', $data);
    }

    public function order_returns()
    {
        $data['pages'] = 'return';

        return view('dashboard.vendor.orders.index', $data);
    }

    public function orders_notcompleted()
    {
        $data['pages'] = 'not_completed';

        return view('dashboard.vendor.orders.index', $data);
    }

    public function edit(Request $request)
    {
        $data['details'] = Order::where('id', $request->id)->first();

        // $bosta = new Bosta(getenv("API_KEY"), getenv("BASE_URL"));
        // try {
        //     $list = $bosta->pickup->list(0);
        //     dd($list);
        // } catch (Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }

        return view('dashboard.vendor.orders.edit', $data);
    }

    public function update(Request $request)
    {
        if (is_numeric($request->order_id)) {
            $Order = Order::find($request->order_id);
            if ($Order) {
                $Order->update([
                    'status' => $request->status,
                ]);

                OrderStatus::create([
                    'order_id' => $Order->id,
                    'user_id' => $Order->user_id,
                    'admin_id' => Auth::id(),
                    'status' => $request->status,
                    'notes' => $request->notes,
                ]);
                $status = true;
            } else {
                $status = false;
            }

            if ($status == true) {
                alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));
            } else {
                alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));
            }

            return redirect('/vendor/orders/edit/'.$request->order_id);

        } else {
            alert()->error(__('dashboard.User Id Wrong'), __('dashboard.attention'));

            return redirect()->back();
        }
    }

    public function updateOrder(Request $request)
    {
        if (is_numeric($request->order_id)) {
            $msg = __('dashboard.saved');
            $Order = OrderDetail::find($request->order_id);
            if ($Order) {
                $Order->update([
                    'shipping_method_id' => $request->shipping_method_id,
                ]);

                $bosta = new Bosta(getenv('API_KEY'), getenv('BASE_URL'));
                if ($request->shipping_method_id == 2) {
                    if ($Order->delivery_ref == null) {
                        $msg = self::BostaCreate($Order);
                    }
                } else {
                    if ($Order->delivery_ref != null) {
                        try {
                            $bosta->pickup->delete($Order->pickup_ref);
                            $bosta->delivery->delete($Order->delivery_ref);
                        } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    }
                }

                return response()->json(['msg' => $msg]);
            } else {
                return response()->json(['msg' => $msg]);
            }
        } else {
            return response()->json(['msg' => __('dashboard.User Id Wrong')]);
        }
    }

    public static function BostaCreate($Order)
    {
        $vendor = Vendor::find($Order->vendor_id);
        $login = bostaController::Login();
        $businessId = $login->data->user->businessAdminInfo->businessId;
        $createBussinesAddress = bostaController::createBussinesAddress($login->data->token, $vendor, $businessId);
        $businessLocationId = json_decode($createBussinesAddress)->data->pickupId;
        // souqelmlabes key
        // d4ee5277d5be31e3a44a817e857496410cd0b9f77a51b27114bf69d537fe1ba4

        $bosta = new Bosta(getenv('API_KEY'), getenv('BASE_URL'));

        if ($vendor) {
            $mainOrder = Order::find($Order->order_id);

            $contactPerson = new ContactPerson($vendor->name, $vendor->phone, $vendor->email);
            try {
                $create = $bosta->pickup->create(Carbon::tomorrow()->format('Y-m-d'), '10:00 to 13:00', $contactPerson, $businessLocationId, '', 0);

                if ($Order->name == null) {

                    $user = User::find($mainOrder->user_id);
                    $name = $user->name;
                    $phone = $user->phone;
                } else {
                    $name = $Order->name;
                    $phone = $Order->phone;
                }

                $receiver = new Receiver($name, $name, $phone);
                $area = Area::find($mainOrder->area);
                $dropOffAddress = new DropOffAddress(1, $mainOrder->address, $area->code, $area->translations()->first()->title);
                $create = $bosta->delivery->create(10, $dropOffAddress, $receiver, '', 0);

                return ['msg' => __('dashboard.saved'), 'status' => true];
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";

                return ['msg' => __('dashboard.notsaved'), 'status' => false];
            }

            return $create;
        } else {
            return ['msg' => __('website.account not found'), 'status' => false];
        }
    }

    public function delete(Request $request)
    {
        Order::where('id', $request->id)->delete();

        alert()->success(__('dashboard.deleted'), __('dashboard.congratulation'));

        return redirect('vendor/orders/all');
    }

    public function invoice_pdf(Request $request)
    {
        $data['id'] = $request->id;
        // Session::put(['invoiceID' => $request->id]);
        // return Excel::download(
        //     new InvoicesExport ,
        //     'invoice_' . $request->id . '.pdf',
        //     \Maatwebsite\Excel\Excel::MPDF,
        // );

        $data['PdfData'] = Order::where('id', $request->id)->whereHas('order_details')->first();
        $pdf = PDF::loadView('dashboard.vendor.orders.pdf', $data);

        return $pdf->download('invoice_'.$data['PdfData']->id.'.pdf');
    }

    public function print(Request $request)
    {
        $data['details'] = Order::where('id', $request->id)->whereHas('order_details')->first();
        $data['id'] = $request->id;
        $data['print'] = 'print';

        return view('dashboard.vendor.orders.preview', $data);
    }

    public static function getPaymentStatus($status)
    {
        switch ($status) {
            case '1':
                return __('dashboard.paid');
                break;
            case '2':
                return __('dashboard.not paid');
                break;
            default:
                return __('dashboard.not paid');
                break;
        }
    }

    public static function getOrderStatus($status)
    {
        switch ($status) {
            case '1':
                return __('dashboard.NewOrder');
                break;
            case '2':
                return __('dashboard.Ready');
                break;
            case '3':
                return __('dashboard.OnTheWay');
                break;
            case '4':
                return __('dashboard.Receive');
                break;
            case '5':
                return __('dashboard.Returned');
                break;
        }
    }
}
