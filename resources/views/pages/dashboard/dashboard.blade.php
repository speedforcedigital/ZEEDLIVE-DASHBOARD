<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Welcome banner -->
        <x-dashboard.welcome-banner />

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

           

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2"> 
            </div>

        </div>
        
        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Line chart (Acme Plus) -->
            <x-dashboard.dashboard-card-01 :data="$data" />
            
            <!-- Table (Top rated) -->
            <div class="col-span-full xl:col-span-8 bg-white shadow-lg rounded-sm border border-slate-200">
    <header class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Top Rated Users</h2>
    </header>
    <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                    <tr>
                        <th class="p-2">
                            <div class="font-semibold text-left">User</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Followers</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Following</div>
                        </th>
                        
                        <th class="p-2">
                            <div class="font-semibold text-center">Rating</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm font-medium divide-y divide-slate-100">
                    <!-- Row -->
                    @if(isset($ranking_data))
                    @foreach($ranking_data as $value)
                    <tr>
                        <td class="p-2">
                            <div class="flex items-center">
                            <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full" src="https://api.staging.zeedlive.com/image/user_profile/{{$value['profileImage'][0]['profile_image']}}" width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                <div class="text-slate-800">{{$value['name']}}</div>
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-center">2.4K</div>
                        </td>
                        <td class="p-2">
                            <div class="text-center text-emerald-500">3.1k</div>
                        </td>
                        
                        <td class="p-2">
                            <div class="text-center text-sky-500">{{$value['AuctualRate']}}</div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                   
                    <!-- Row -->
                    
                    
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- end (Top rated) -->
            

           

        </div>

    </div>
</x-app-layout>
