<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(\Illuminate\Http\Request $request)
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

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $tempUserId = $request->cookie('temp_user_id');

        if ($tempUserId) {
            // Migrate Cart
            $guestCartItems = \App\Models\Cart::where('temp_user_id', $tempUserId)->get();
            foreach ($guestCartItems as $item) {
                \App\Models\Cart::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $item->product_id,
                    ],
                    [
                        'quantity' => \Illuminate\Support\Facades\DB::raw('quantity + ' . $item->quantity)
                    ]
                );
                $item->forceDelete(); // Remove guest item after migrating
            }

            // Migrate Wishlist
            $guestWishlistItems = \App\Models\Wishlist::where('temp_user_id', $tempUserId)->get();
            foreach ($guestWishlistItems as $item) {
                // Check if already in user's wishlist
                $exists = \App\Models\Wishlist::where('user_id', $user->id)
                    ->where('product_id', $item->product_id)
                    ->exists();
                
                if (!$exists) {
                    \App\Models\Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $item->product_id
                    ]);
                }
                $item->forceDelete();
            }
            
            // Clear the cookie
            // We can't easily clear non-http-only cookies from server if set that way, but we can expire it
            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('temp_user_id'));
        }
    }

    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect(LaravelLocalization::localizeURL('/'));
    }
}
