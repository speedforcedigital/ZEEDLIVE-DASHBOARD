<?php

    namespace App\Http\Controllers;
    use App\Helpers\makeCurlPostRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Session;
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
            if($data['success']==1)
            {
                Session::put('name', $data['user']['name']);
                Session::put('rank', $data['user']['rank']);
                Session::put('profile_image', $data['user']['accountDetail']['profile_image']); 
                return redirect('/dashboard');
            }
            elseif($data['success']=='')
            {
                return redirect('/');
            }
        } 
    }
