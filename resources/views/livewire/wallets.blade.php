<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Wallet</h1>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md">
            {{ session('message') }}
        </div>
    @endif
    <!-- Table -->

    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2 mb-2 ">
        <input type="text" wire:model.lazy="search"
               class="mt-2 w-full  rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
               placeholder="Search">
    </div>
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Wallets <span
                    class="text-slate-400 font-medium">{{$totalWallets}}</span></h2>
        </header>

        <div x-data="handleSelect">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Sr No</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">User</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Balance</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>
                    </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    <?php $perPage = 10; $startingPoint = (($wallets->currentPage() - 1) * $perPage) + 1; ?>
                    @foreach($wallets as $wallet)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">
                                        <a href="{{ route("user.show", $wallet->user->id ?? '' ) }}"> {{$wallet->user->name ?? 'No Name'}} </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">SAR {{$wallet->balance}}</div>
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="space-x-1">
                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                            wire:click="balanceModal({{ $wallet->id }})">
                                        <span class="sr-only">Add Balance</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-circle-plus" width="27" height="27"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                                            <path d="M9 12h6"/>
                                            <path d="M12 9v6"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($showModal)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
                    </div>

                    <!-- Modal content -->
                    <div
                        class="bg-white rounded-xl max-w-xl w-full overflow-hidden shadow-2xl transform transition-all">
                        <!-- Header -->
                        <div class="bg-gray-100 p-5 border-b border-gray-200 rounded-t-xl">
                            <h3 class="text-xl leading-6 font-semibold text-gray-900">
                                Add Balance
                            </h3>
                        </div>

                        <!-- Body -->
                        <div class="p-5">
                            <div class="my-4">
                                <label for="wallet_balance" class="font-semibold mb-2 block">Wallet Balance:</label>
                                <input type="number" id="wallet_balance" name="wallet_balance"
                                       wire:model="wallet_balance"
                                       class="p-2 border rounded w-full" min="0" placeholder="Enter amount to add"/>
                            </div>


                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end bg-gray-100 p-5 rounded-b-xl border-t border-gray-200">
                            <button wire:click="addBalance"
                                    class="px-5 py-2 text-gray-100 bg-green-600 hover:bg-green-700 transition duration-150 rounded">
                                Add Balance
                            </button>
                            <button wire:click="$set('showModal', false)"
                                    class="ml-2 px-5 py-2 text-gray-100 bg-red-600 hover:bg-red-700 transition duration-150 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>

    <!-- Pagination -->
    <div class="px-5 py-3">
        {{ $wallets->links() }}
    </div>
</div>




