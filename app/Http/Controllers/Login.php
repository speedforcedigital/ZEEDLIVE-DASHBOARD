<?php

    namespace App\Http\Controllers;
    use App\Models\User;
    use App\Helpers\makeCurlPostRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Tymon\JWTAuth\Facades\JWTAuth;

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\ValidationException;

    use Session;
    use Toastr;
    class Login extends Controller
    {
        public $email;
        public $password;

        public function index(Request $request)
        {
            $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];

            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string|max:50'
            ]);

            //Throw validation exception if request is not valid
            if ($validator->fails()) {
                Toastr::error($validator->messages(), 'Error');
                return redirect('/');
            }

            if (!Auth::attempt($credentials)) {
                Toastr::error('Login credentials are invalid.', 'Error');
                return redirect('/');
            }

            // Generate token
            $token = JWTAuth::fromUser(Auth::user());

            // Put the necessary data into session
            session([
                'token' => $token,
                'name' => Auth::user()->name,
                'rank' => Auth::user()->rank,
                'profile_image' => Auth::user()->accountDetail->profile_image,
                'permissions' => json_decode(Auth::user()->accountDetail->permissions, true),
            ]);

            dd(session()->all());

            return redirect()->to('/dashboard');
              
        } 
    }
