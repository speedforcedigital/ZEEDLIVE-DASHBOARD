<?php
    namespace App\Http\Controllers;
    use App\Helpers\makeCurlPostRequest;
    use App\Helpers\baseUrl;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Carbon\Carbon;
    use App\Models\Lot;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;

    class DashboardController extends Controller
    {

        /**
         * Displays the dashboard screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function index()
        {
            $type = 'Pending';
            $pending = Lot::where('is_delete',0)->whereHas('auction', function ($query) use ($type){
                    $query->where('admin_status', $type);
            })->count();
            $type = 'Approved';
            $approved = Lot::where('is_delete',0)->whereHas('auction', function ($query) use ($type){
                    $query->where('admin_status', $type);
                    })->count();
            $type = 'Rejected';
            $rejected = Lot::where('is_delete',0)->whereHas('auction', function ($query) use ($type){
                    $query->where('admin_status', $type);
            })->count();
            $all = Lot::where('is_delete',0)->count();

            $data = [
                'pending' => $pending,
                'approved' => $approved,
                'rejected' => $rejected,
                'all' => $all,
            ];

            // get ranking data from database
            $getRanking = DB::table('rating')
                ->selectRaw('seller_id , name , SUM(rating) as "totalRate", COUNT(seller_id) as "totalCount" ')
                ->join('users', 'users.id', '=', 'rating.seller_id')
                ->groupBy('seller_id')
                ->orderBy('totalRate','DESC')
                ->get();

            $i=0;
            $ranking_data = [];
            if($getRanking){
                foreach($getRanking as $val){
                    $i++;
                    $AuctualRate =  sprintf("%.2f", $val->totalRate/$val->totalCount);
                    $ranking_data[] = array(
                        "seller_id"=>$val->seller_id,
                        "position"=>$i,
                        "name"=>$val->name,
                        "followers"=>$this->getFollowers($val->seller_id),
                        "followings"=>$this->getFollowings($val->seller_id),
                        "totalRateCounts"=>$val->totalCount,
                        "AuctualRate"=>($AuctualRate < 1000 ? $AuctualRate : $this->thousand_format($AuctualRate)),
                        "profileImage"=>$this->profileImage($val->seller_id),
                    );
                }
            }

            return view('pages/dashboard/dashboard', compact('data', 'ranking_data'));
        } 

        public function getFollowers($id)
        {
        $followers = Followers::where('leader_id',$id)->count();
        return $followers;
        }

        public function getFollowings($id)
        {
        $following = Followers::where('follower_id',$id)->count();
        return $following;
        }

        public function profileImage($seller_id)
        {
            $result = DB::table('account_detail')
            ->select('profile_image')
            ->where('user_id',$seller_id)
            ->get();
            $i=0;
            if($result != '' && $result != null){
                foreach ($result as $row){
                    $type [$i]['profile_image'] = $row->profile_image;
                    $i++;
                }
            }
            return isset($type) ? $type : null;
        }
    }
