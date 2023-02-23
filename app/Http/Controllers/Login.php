<?php

    namespace App\Http\Controllers;
    use App\Helpers\makeCurlPostRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Session;
    use Toastr;
    class Login extends Controller
    {

        public function index(Request $request)
        {
            $postData = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            $postData = json_encode($postData);
            $url = "https://api.staging.zeedlive.com/api/v1/login";
            $data = makeCurlPostRequest($url, 'POST',$postData);
            if($data['success']=='')
            {
                Toastr::error($data['message'], 'Error');
                return redirect('/');
            }
            else
            {
                    $permissions = $data['user']['accountDetail']['permissions'];
                    $permissions = json_decode($permissions);
                    $permissions = json_decode($permissions, true);
                    Session::put('token', $data['token']);
                    Session::put('name', $data['user']['name']);
                    Session::put('rank', $data['user']['rank']);
                    Session::put('profile_image', $data['user']['accountDetail']['profile_image']);
                    Session::put('permissions', $permissions);
                    return redirect('/dashboard');
            }
              
        } 
    }
