<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string  $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            
            if (! isset($socialUser) || $socialUser == false) {
                return redirect()->route('login');
            }

            // Determine the column name based on provider
            $idColumn = match($provider) {
                'google' => 'google_id',
                'facebook' => 'facebook_id',
                'apple' => 'apple_id',
                default => 'google_id'
            };

            // Check if user exists with this social ID
            $userData = User::where($idColumn, $socialUser->getId())->first();

            // If not found by ID, check by email
            if (empty($userData)) {
                $userData = User::where('email', $socialUser->getEmail())->first();
                
                if ($userData) {
                    // User exists with email, link the social ID
                    $userData->update([
                        $idColumn => $socialUser->getId()
                    ]);
                } else {
                    // Create new user
                    $userData = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'phone' => null, // Phone is unknown from social login usually
                        'password' => Hash::make(Str::random(24)), // Random password
                        $idColumn => $socialUser->getId(),
                        'status' => 1,
                        // 'admin' => 3, // Assuming 3 is customer/user role
                        'email_verified_at' => Carbon::now(),
                    ]);
                }
            }

            Auth::login($userData, true);

            $CurrentUrl = Session::pull('CurrentUrl'); // Use pull to remove after use
            $targetUrl = $CurrentUrl ? $CurrentUrl : LaravelLocalization::localizeUrl('user/home');

            return redirect($targetUrl);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Social Login Error: ' . $th->getMessage(), [
                'provider' => $provider,
                'exception' => $th
            ]);
            return redirect('/login')->withErrors(['msg' => __('website.Login Failed')]);
        }
    }
}
