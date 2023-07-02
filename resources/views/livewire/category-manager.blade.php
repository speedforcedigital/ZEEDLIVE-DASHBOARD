<?php
$array = Session::get('permissions');
//add
$add_capability_exists = false;
$permissionsArray = json_decode($array, true);
foreach ($permissionsArray as $item) {
  if (isset($item['Category']) && in_array('add', $item['Category'])) {
    $add_capability_exists = true;
    break;
  }
} 
//list
$list_capability_exists = false;
foreach ($permissionsArray as $item) {
  if (isset($item['Category']) && in_array('list', $item['Category'])) {
    $list_capability_exists = true;
    break;
  }
}
?>
<div>
  <style>
    .custom-select {
      display: inline-block;
      width: 100%;
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 1.75rem 0.375rem 0.75rem;
      font-size: 0.875rem;
      font-weight: 400;
      line-height: 1.5;
      color: #3c4e71;
      vertical-align: middle;
      background: #FFFFFF url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%233c4e71' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e) right 0.75rem center/8px 10px no-repeat;
      border: 1px solid #c9d2e3;
      border-radius: 6px;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      height: auto;
      padding-right: 0.75rem;
      background-image: none;
    }

    .selected {
      background-color: yellow;
      font-weight: bold;
    }

    .no-scroll {
      overflow: hidden;
    }
  </style>

  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
      <!-- Left: Title -->
      <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
          Manage Categories ✨
        </h1>
      </div>
    </div>

    <div class="border-t border-slate-200">
      <!-- Components -->
      <div class="space-y-8 mt-8">
        <!-- Input Types -->
        <div>
          <div class="grid gap-5 md:grid-cols-2">
            <!-- Changed to 2 columns -->
            <div>
              <!-- Start -->
              <div>
                <label class="block text-sm font-medium mb-1" for="category">Category <span class="text-rose-500">*</span></label>
                <div class="flex">
                  <input id="category" class="form-input w-full" type="text" wire:model="name" required />
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addCategory">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>

                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" x-data="{ modalOpen: false }" @click="modalOpen = true" x-show="selectedCategory">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                    <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                    <line x1="8" y1="2" x2="10" y2="4" fill="none" stroke-linecap="round" stroke-linejoin="round" data-color="color-2"></line>
                    <path d="M4,10l7.08-7.05A1.435,1.435,0,1,0,9.05.92L2,8,.5,11.5Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                    </svg>
                </button>


                  <!-- Modal backdrop -->
                  <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                  <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="modalOpen" x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true" x-cloak>
                    <!-- Modal content -->
                    <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false" style="max-width: 640px;">
                        <!-- Modal header -->
                        <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex justify-between items-center">
                            <div class="font-semibold text-slate-800 dark:text-slate-100">Edit Category Name</div>
                            <button class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400" @click="modalOpen = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                            </button>
                        </div>
                        </div>
                        <!-- Modal content -->
                        <div class="px-5 py-4">
                        <div class="text-sm">
                            <div class="font-medium text-slate-800 dark:text-slate-100 mb-3">Category Name</div>
                            <div class="text-slate-800 dark:text-slate-100 mb-3">Editing {{ $selectedCategory ? $selectedCategory->name : '' }}</div>
                        </div>
                        <div>
                            <input id="category-name" class="form-input w-full px-2 py-1" type="text" wire:model="newCategoryName" required>
                            @error('newCategoryName')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                        </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex flex-wrap justify-end space-x-2">
                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" x-data="{ modalOpen: false }" @click="modalOpen = false">Cancel</button>
                            <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" wire:click="updateCategory">Update</button>
                        </div>
                        </div>
                    </div>
                    </div>


                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="resetSelection">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="4 4 16 16">
                      <path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" fill="currentColor"></path>                    </svg>
                  </button>
                </div>
                @error('name')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{ $selectedCategory ? 'no-scroll' : '' }}"
                  wire:model="selectedCategory"
                  wire:change="selectCategory($event.target.value)"
                  @if ($selectedCategory) disabled @endif>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $selectedCategory && $selectedCategory->id == $category->id ? 'selected' : '' }} class="{{ $selectedCategory && $selectedCategory->id == $category->id ? 'selected' : '' }}">
                    {{ $category->name }}
                  </option>
                  @endforeach
                </select>
                <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500">
                  <span class="mr-1">Remove Selected Category</span>
                  <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 24 24">
                    <path
                      d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </button>
              </div>
              <!-- End -->
            </div>

            <div>
              <!-- Start -->
              <div>
                <label class="block text-sm font-medium mb-1" for="brand">
                  Brand <span class="text-rose-500">*</span>
                </label>
                <div class="flex">
                  <input id="brand" class="form-input w-full" type="text" required />
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addBrand">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="resetSelection">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M6.1 0H3.3C1.5 0 0 1.5 0 3.3v2.8C0 7.5 1.5 9 3.3 9h2.8C9 9 10.5 7.5 10.5 5.7V3.3C10.5 1.5 9 0 6.1 0zm0 7H3.3C2.1 7 1 5.9 1 4.7V3.3C1 2.1 2.1 1 3.3 1h2.8C7.9 1 9 2.1 9 3.3v1.4C9 5.9 7.9 7 6.7 7z" />
                      <path d="M13.1 2H9V.9C9 .4 8.6 0 8.1 0H6.8C6.3 0 5.9.4 5.9.9V2H1.8C1.3 2 0 3.3 0 4.8v5.6C0 11.7 1.3 13 2.8 13h5.6c1.5 0 2.8-1.3 2.8-2.8V4.8C16 3.3 14.7 2 13.1 2zm1.5 8.4c0 .8-.7 1.5-1.5 1.5H2.8c-.8 0-1.5-.7-1.5-1.5V4.8c0-.8.7-1.5 1.5-1.5H6v1.2c0 .5.4.9.9.9H8v1.2c0 .5.4.9.9.9H13v1.2z" />
                    </svg>
                  </button>
                </div>
                @error('selectedBrand')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                <select size="5"
                  class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{ $selectedBrand ? 'no-scroll' : '' }}"
                  wire:model="selectedBrandId" wire:change="selectBrand($event.target.value)"
                  @if (!isset($selectedCategory) || empty($selectedCategory) || $selectedBrand) disabled @endif>
                  <!-- Fetch brands from Brand model based on the selected category -->
                  @if (isset($selectedCategory) && $selectedCategory->brands)
                  @foreach ($selectedCategory->brands as $brand)
                  <option value="{{ $brand->id }}" {{ $selectedBrand && $selectedBrand->id == $brand->id ? 'selected' : '' }}
                    class="{{ $selectedBrand && $selectedBrand->id == $brand->id ? 'selected' : '' }}">
                    {{ $brand->name }}
                  </option>
                  @endforeach
                  @endif
                </select>
                <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500"
                  @if (!isset($selectedBrand) || empty($selectedBrand)) disabled @endif>
                  <span class="mr-1">Remove Selected Brand</span>
                  <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 24 24">
                    <path
                      d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </button>
              </div>
              <!-- End -->
            </div>
          </div>

          <!-- Additional Column -->
          <div>
            <div>
              <!-- Start -->
              <div>
                <label class="block text-sm font-medium mb-1" for="model">Model <span class="text-rose-500">*</span></label>
                <div class="flex">
                  <input id="model" class="form-input w-full" type="text" wire:model="selectedModel" required />
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addModel">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>
                </div>
                @error('selectedModel')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  wire:model="selectedModel"
                  wire:change="selectModel($event.target.value)"
                  @if (!isset($selectedBrand) || empty($selectedBrand)) disabled @endif>
                  @if (isset($selectedBrand) && $selectedBrand->modals)
                  @foreach ($selectedBrand->modals as $modal)
                  <option value="{{ $modal->id }}">{{ $modal->name }}</option>
                  @endforeach
                  @endif
                </select>

                <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500"
                  @if (!isset($selectedModel) || empty($selectedModel)) disabled @endif>
                  <span class="mr-1">Remove Selected Model</span>
                  <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 24 24">
                    <path
                      d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </button>
              </div>
              <!-- End -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>