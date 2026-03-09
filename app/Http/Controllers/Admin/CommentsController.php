<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends BackendController
{
    public function index()
    {
        $data['type'] = trans_db('dashboard.ratings');
        $data['Comments'] = Rating::orderby('status', 'desc')->paginate(20);

        return view('dashboard.admin.Comments.index', $data);
    }

    public function activateComments(Request $request)
    {
        $commentSingle = Rating::where('id', $request->id)->first();
        if ($commentSingle) {
            $commentSingle->update([
                'status' => $commentSingle->status == 1 ? 0 : 1,
            ]);
        }

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/ratings/all');
    }

    public function delete(Request $request)
    {
        Rating::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/ratings/all');
    }

    public static function getRate($rowid, $order_id, $business_id)
    {
        $output = '';
        $rating = self::count_rating($rowid, $order_id, $business_id);
        $color = '';
        $output .= '<ul class="list-inline" style="display: inline-flex;" data-rating="'.$rating.'" title="Average Rating - '.$rating.'">';
        for ($count = 1; $count <= 5; $count++) {
            if ($count <= $rating) {
                $color = 'color:#ffcc00;';
            } else {
                $color = 'color:#ccc;';
            }
            $output .= '<li title="'.$count.'" id="'.$business_id.'-'.$count.'" data-rowid="'.$rowid.'" data-order_id="'.$order_id.'" data-index="'.$count.'"  data-business_id="'.$business_id.'" data-rating="'.$rating.'" class="rating" style="cursor:pointer;padding: 0.1rem; '.$color.' font-size:30px;">&#9733;</li>';
        }
        $output .= '</ul>';
        echo $output;
    }

    public static function count_rating($rowid, $order_id, $business_id)
    {
        $output = 0;
        $result = Rating::select('rating')
            ->where('order_id', $order_id)
            ->where('product_id', $business_id)
            ->first();
        // $result = Rating::select(DB::raw('AVG(rating) as rating'))->where('product_id', $product_id)->get();
        if (isset($result)) {
            $total_row = $result->rating;
            if ($total_row > 0) {
                // foreach($result as $row)
                // {
                $output = round($result->rating);
                // }
            }
        }

        return $output;
    }
}
