<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\helper\helperController;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\UserApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SocialController extends ApiController
{
    use ApiResponseTrait;

    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, 'Email Required', 'false', '401');
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(80);
            $userToken = new UserApiToken;
            $userToken->user_id = $user->id;
            $userToken->api_token = $token;
            $userToken->user_type = 1;
            $userToken->save();

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => 'user',
                'phone' => $user->phone == null ? '' : $user->phone,
                'status' => $user->status,
                'image' => $user->image == null ? '' : $user->image,
                'token' => $token == null ? '' : $token,
            ];

            return $this->NewApiResponse($userData, '', 'true', '200');
        } else {
            $userData = self::CreateUser($request);

            return $this->NewApiResponse($userData, '', 'true', '200');
        }
    }

    public static function CreateUser(Request $request)
    {
        $image_name = helperController::make_slug($request->name).'.jpg';

        $user = new User;
        $user->name = $request->name == null ? (explode('@', $request->email))[0] : $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('123456789');
        $user->phone = $request->phone == null ? '' : $request->phone;
        if ($request->has('image')) {
            $user->image = $image_name;
        }
        $user->status = 1;
        $user->save();

        $token = Str::random(80);

        $userToken = new UserApiToken;
        $userToken->user_id = $user->id;
        $userToken->api_token = $token;
        $userToken->user_type = 1;
        $userToken->save();

        // $data = file_get_contents($image_name , false, $request->image);
        // Storage::put(public_path('website/images/users/' . $image_name) , $data);

        // $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
        // $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR. $image_name);

        // helperController::upload_images($path,$destination,$request->file('image'), '150', '150');

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => 'user',
            'phone' => $user->phone == null ? '' : $user->phone,
            'active' => $user->status,
            'image' => $user->image == null ? '' : $user->image,
            'token' => $token == null ? '' : $token,
        ];

        return $userData;
    }
}
