<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Collections</h1>
        </div>
    </div>

    <!-- Message Container -->
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-900 rounded-md">
            {{ session('message') }}
        </div>
    @endif
    <!-- Table -->
    <!-- Table -->
    <div class="flex justify-between mb-2">
        <div class="flex">
            <select class="form-select" wire:model="category_id">
                <option value="0" selected>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>

            <select class="form-select ml-3" wire:model="brand_id">
                <option value="0" selected>Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="flex">
            <input type="text" wire:model.lazy="search"
                   class="rounded-md px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Search">
        </div>
    </div>


    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">All Collections <span
                    class="text-slate-400 font-medium">{{$total_collections}}</span></h2>
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
                            <div class="font-semibold text-left">Title</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Owner</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Date</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Action</div>
                        </th>
                    </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    <?php $perPage = 10; $startingPoint = (($collections->currentPage() - 1) * $perPage) + 1; ?>
                    @foreach($collections as $collection)

                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{$startingPoint++}}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800"><a
                                            href="{{ route("collection.show", $collection->id ) }}">  {{$collection->title}}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                        <img class="rounded-full"
                                             src="https://api.staging.zeedlive.com/image/user_profile/{{$collection->user->accountDetail->profile_image}}"
                                             width="40" height="40" alt="Patricia Semklo">
                                    </div>
                                    <div class="font-medium text-slate-800"><a
                                            href="{{ route("user.show", $collection->user->id) }}">{{$collection->user->name}}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-slate-800">{{$collection->created_at}}</div>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex space-x-1 items-center">
                                    {{-- <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                        wire:click="approve({{ $product->auction->id }})">
                                        <span class="sr-only">Approve</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-check" width="27" height="27"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    </button> --}}

                                    @if($collection->is_delete == "0")
                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">disable</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-ban"
                                                         width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="#2c3e50" fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                                        <path d="M5.7 5.7l12.6 12.6"/>
                                                    </svg>
                                                </button>

                                                <!-- Eye Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="/* Add your logic here */">
                                                    <span class="sr-only">View</span>
                                                    <!-- Your eye icon here -->
                                                </button>
                                            </div>

                                            <!-- Modal overlay -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                            <!-- Delete Category Modal Dialog -->
                                            <div
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog"
                                                aria-modal="true" x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                                x-cloak>
                                                <!-- Modal content -->
                                                <div
                                                    class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Disable Collection
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="px-5 py-4">
                                                        <div class="text-sm">
                                                            <div
                                                                class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                                Are you sure you want to disable this collection?
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-600 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="remove({{ $collection->id }})">
                                                                Disable
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <div
                                            x-data="{ deleteModalOpen2: @entangle('deleteModalOpen2'), collectionsCount: @entangle('collectionsCount') }">
                                            <div class="flex items-center">
                                                <!-- Enable Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                        @click="deleteModalOpen2 = true">
                                                    <span class="sr-only">Enable</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-check" width="27"
                                                         height="27"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                                         fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12l5 5l10 -10"/>
                                                    </svg>
                                                </button>

                                                <!-- Eye Button -->
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full ml-2"
                                                        @click="/* Add your logic here */">
                                                    <span class="sr-only">View</span>
                                                    <!-- Your eye icon here -->
                                                </button>
                                            </div>

                                            <!-- Modal overlay -->
                                            <div
                                                class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
                                                x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                                            <!-- Delete Category Modal Dialog -->
                                            <div
                                                class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6"
                                                role="dialog"
                                                aria-modal="true" x-show="deleteModalOpen2"
                                                x-transition:enter="transition ease-in-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in-out duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true"
                                                x-cloak>
                                                <!-- Modal content -->
                                                <div
                                                    class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full"
                                                    @click.outside="deleteModalOpen2 = false"
                                                    @keydown.escape.window="deleteModalOpen2 = false"
                                                    style="max-width: 640px;">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-between items-center">
                                                            <div
                                                                class="font-semibold text-slate-800 dark:text-slate-100">
                                                                Enable Collection
                                                            </div>
                                                            <button
                                                                class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400"
                                                                @click="deleteModalOpen2 = false">
                                                                <div class="sr-only">Close</div>
                                                                <svg class="w-4 h-4 fill-current">
                                                                    <path
                                                                        d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Modal content -->
                                                    <div class="px-5 py-4">
                                                        <div class="text-sm">
                                                            <div
                                                                class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                                                Are you sure you want to enable this collection?
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div
                                                        class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                                        <div class="flex justify-end">
                                                            <button
                                                                class="btn-sm bg-gray-600 hover:bg-gray-700 text-white mr-2"
                                                                @click="deleteModalOpen2 = false">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                class="btn-sm bg-indigo-600 hover:bg-indigo-700 text-white"
                                                                wire:click="enable({{ $collection->id }})">
                                                                Enable
                                                            </button>
                                                            <template x-if="collectionsCount > 0">
                                                                <button
                                                                    class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                                                    @click="deleteModalOpen2 = false">OK
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                    <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                            wire:click="view({{ $collection->id }})">
                                        <span class="sr-only">View</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                             width="27" height="27" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="#2c3e50" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
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
    </div>

    <!-- Pagination -->
    <div class="px-5 py-3">
        {{ $collections->links() }}
    </div>
</div>
