<?php
    namespace App\Http\Controllers;
    use App\Helpers\makeCurlPostRequest;
    use App\Helpers\baseUrl;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use App\Models\DataFeed;
    use Carbon\Carbon;
    
    class DashboardController extends Controller
    {

        /**
         * Displays the dashboard screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function index()
        {
            $url = baseUrl().'get/all/auction/status';
            $data = makeCurlRequest($url, 'GET');
            $data = $data['data'];
            $ranking_url = baseUrl().'get/ranking';
            $ranking_data = makeCurlRequest($ranking_url, 'GET');
            $ranking_data = $ranking_data['ranking'];
            $dataFeed = new DataFeed();
            return view('pages/dashboard/dashboard', compact('dataFeed','data','ranking_data'));
        } 
    }
