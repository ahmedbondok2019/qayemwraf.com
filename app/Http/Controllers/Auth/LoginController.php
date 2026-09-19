<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        return LaravelLocalization::localizeURL(RouteServiceProvider::HOME);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Validate the user login request.
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $loginValue = $request->input($this->username());
        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $field => $loginValue,
            'password' => $request->input('password'),
        ];
    }

    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $tempUserId = $request->cookie('temp_user_id');

        if ($tempUserId) {
            // Migrate Cart
            $guestCartItems = Cart::where('temp_user_id', $tempUserId)->get();
            foreach ($guestCartItems as $item) {
                Cart::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $item->product_id,
                    ],
                    [
                        'quantity' => DB::raw('quantity + '.$item->quantity),
                    ]
                );
                $item->forceDelete(); // Remove guest item after migrating
            }

            // Migrate Wishlist
            $guestWishlistItems = Wishlist::where('temp_user_id', $tempUserId)->get();
            foreach ($guestWishlistItems as $item) {
                // Check if already in user's wishlist
                $exists = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $item->product_id)
                    ->exists();

                if (! $exists) {
                    Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $item->product_id,
                    ]);
                }
                $item->forceDelete();
            }

            // Clear the cookie
            // We can't easily clear non-http-only cookies from server if set that way, but we can expire it
            Cookie::queue(Cookie::forget('temp_user_id'));
        }
    }

    protected function loggedOut(Request $request)
    {
        return redirect(LaravelLocalization::localizeURL('/'));
    }
}
