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
                  <input id="category" class="form-input w-full" type="text" wire:model="categoryName" required/>
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addCategory">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>
                    
                <div x-data="{ editModalOpen: @entangle('editModalOpen') , newCategoryName: '' }">

                  <!-- Modal trigger button -->
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" @click="editModalOpen = true" style="height: 38px;">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                            <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                <line x1="8" y1="2" x2="10" y2="4" fill="none" stroke-linecap="round" stroke-linejoin="round" data-color="color-2"></line>
                                <path d="M4,10l7.08-7.05A1.435,1.435,0,1,0,9.05.92L2,8,.5,11.5Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </button>

                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="editModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                    <!-- Modal dialog -->
                    <div id="feedback-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="editModalOpen" x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true" x-cloak>
                        <!-- Modal content -->
                        <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="editModalOpen = false" @keydown.escape.window="editModalOpen = false" style="max-width: 640px;">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800 dark:text-slate-100">Edit Category Name</div>
                                    <button class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400" @click="editModalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Modal content -->
                            <div class="px-5 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-slate-800 dark:text-slate-100 mb-3">Editing {{ $selectedCategory ? $selectedCategory->name : '' }}</div>
                                </div>
                                <div>
                                    <input id="category-name" class="form-input w-full px-2 py-1" type="text" wire:model="newCategoryName">
                                    @error('newCategoryName')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                <div class="flex flex-wrap justify-end space-x-2">
                                    <button class="btn-sm border-slate-200 dark:border-slate-700" @click="modalOpen = false">Cancel</button>
                                    <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" wire:click="updateCategory">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="resetCategory">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="4 4 16 16">
                      <path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" fill="currentColor"></path>                    </svg>
                  </button>

                  <div x-data="{ deleteModalOpen: @entangle('deleteModalOpen'), collectionsCount: @entangle('collectionsCount') }">

                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" @click="deleteModalOpen = true" style="height: 38px;">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"></path>
                        </svg>
                    </button>

                    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak></div>

                    <!-- Modal dialog -->
                    <div id="delete-category-modal" class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center px-4 sm:px-6" role="dialog" aria-modal="true" x-show="deleteModalOpen" x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" aria-hidden="true" x-cloak>
                        <!-- Modal content -->
                        <div class="bg-white dark:bg-slate-800 rounded shadow-lg overflow-auto max-w-lg w-full max-h-full" @click.outside="deleteModalOpen = false" @keydown.escape.window="deleteModalOpen = false" style="max-width: 640px;">
                            <!-- Modal header -->
                            <div class="px-5 py-3 border-b border-slate-200 dark:border-slate-700">
                                <div class="flex justify-between items-center">
                                    <div class="font-semibold text-slate-800 dark:text-slate-100">Delete Category</div>
                                    <button class="text-slate-400 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400" @click="deleteModalOpen = false">
                                        <div class="sr-only">Close</div>
                                        <svg class="w-4 h-4 fill-current">
                                            <path d="M7.95 6.536L12.192 2.293a1 1 0 111.414 1.414L9.364 7.95l4.243 4.243a1 1 0 11-1.414 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Modal content -->
                            <div class="px-5 py-4">
                                <template x-if="collectionsCount !== ''">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-800 dark:text-slate-100 mb-3">
                                            <template x-if="collectionsCount > 0">
                                                This category has <span x-text="collectionsCount"></span> collection<span x-show="collectionsCount > 1">s</span> connected to it and cannot be deleted.
                                            </template>
                                            <template x-if="collectionsCount === 0">
                                                Are you sure you want to delete this category?
                                            </template>
                                        </div>
                                        <div class="text-slate-800 dark:text-slate-100">
                                            <template x-if="collectionsCount > 0">
                                                Please remove the collections connected to this category before deleting it.
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <!-- Modal footer -->
                            <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
                                <div class="flex justify-end">
                                    <template x-if="collectionsCount === 0">
                                        <button class="btn-sm bg-rose-500 hover:bg-rose-600 text-white mr-2" @click="deleteModalOpen = false">Cancel</button>
                                        <button class="btn-sm bg-red-500 hover:bg-red-600 text-white" wire:click="removeCategory">Delete</button>
                                    </template>
                                    <template x-if="collectionsCount > 0">
                                        <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="deleteModalOpen = false">OK</button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                  <input id="brand" class="form-input w-full" type="text"  wire:model="brandName" required/>
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addBrand">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="resetBrand">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="4 4 16 16">
                      <path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z" fill="currentColor"></path>                    </svg>
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
                
              </div>
              <!-- End -->
            </div>
          </div>

          <!-- Additional Column -->
          <div class="mt-2">
            <div>
              <!-- Start -->
              <div>
                <label class="block text-sm font-medium mb-1" for="model">Model <span class="text-rose-500">*</span></label>
                <div class="flex">
                  <input id="model" class="form-input w-full" type="text"wire:model="modalName" required />
                  <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addModal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                      <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                  </button>
                </div>
                @error('selectedModal')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  wire:model="selectedModal"
                  wire:change="selectModal($event.target.value)"
                  @if (!isset($selectedBrand) || empty($selectedBrand)) disabled @endif>
                  @if (isset($selectedBrand) && $selectedBrand->modals)
                  @foreach ($selectedBrand->modals as $modal)
                  <option value="{{ $modal->id }}">{{ $modal->name }}</option>
                  @endforeach
                  @endif
                </select>
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

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('categoryUpdated', function () {
                // Close the modal
                document.getElementById('feedback-modal').style.display = 'none';
            });

            // Listen for the custom event emitted after category update
            document.addEventListener('category-updated', function () {
                Livewire.emit('categoryUpdated');
            });
        });
    </script>
@endpush