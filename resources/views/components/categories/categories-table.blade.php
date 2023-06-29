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
</style>

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="border-t border-slate-200">
        <!-- Components -->
        <div class="space-y-8 mt-8">
            <!-- Input Types -->
            <div>
                <div class="grid gap-5 md:grid-cols-2"> <!-- Changed to 2 columns -->
                    <div>
                        <!-- Start -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="category">Category <span class="text-rose-500">*</span></label>
                            <div class="flex">
                                <input id="category" class="form-input w-full" type="text" wire:model="category" required />
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addCategory">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                            </div>
                            @error('category')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <!-- Populate with categories from backend -->
                                <option>Category 1</option>
                                <option>Category 2</option>
                                <option>Category 3</option>
                                <option>Category 4</option>
                                <option>Category 5</option>
                            </select>
                            <button class="btn bg-red-500 hover:bg-red-600 text-white mt-2" wire:click="removeCategory">
                                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 7l4.647-4.646a.5.5 0 00-.708-.708L12 6.293 7.354 1.646a.5.5 0 10-.708.708L11.293 7l-4.647 4.646a.5.5 0 10.708.708L12 7.707l4.646 4.647a.5.5 0 00.708-.708L12.707 7z" clip-rule="evenodd" />
                                </svg>
                                Remove Selected Category
                            </button>
                        </div>
                        <!-- End -->
                    </div>
                    <div>
                        <!-- Start -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="brand">Brand <span class="text-rose-500">*</span></label>
                            <div class="flex">
                                <input id="brand" class="form-input w-full" type="text" wire:model="brand" required />
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addBrand">
                                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                    </svg>
                                </button>
                            </div>
                            @error('brand')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <!-- Populate with brands from backend -->
                                <option>Brand 1</option>
                                <option>Brand 2</option>
                                <option>Brand 3</option>
                                <option>Brand 4</option>
                                <option>Brand 5</option>
                            </select>
                            <button class="btn bg-red-500 hover:bg-red-600 text-white mt-2" wire:click="removeBrand">
                                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 7l4.647-4.646a.5.5 0 00-.708-.708L12 6.293 7.354 1.646a.5.5 0 10-.708.708L11.293 7l-4.647 4.646a.5.5 0 10.708.708L12 7.707l4.646 4.647a.5.5 0 00.708-.708L12.707 7z" clip-rule="evenodd" />
                                </svg>
                                Remove Selected Brand
                            </button>
                        </div>
                        <!-- End -->
                    </div>
                </div>
            </div>
            <!-- Additional Column -->
            <div>
                <div>
                    <!-- Start -->
                    <div>
                        <label class="block text-sm font-medium mb-1" for="model">Model <span class="text-rose-500">*</span></label>
                        <div class="flex">
                            <input id="model" class="form-input w-full" type="text" wire:model="model" required />
                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addModel">
                                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                </svg>
                            </button>
                        </div>
                        @error('model')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                        <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <!-- Populate with models from backend -->
                            <option>Model 1</option>
                            <option>Model 2</option>
                            <option>Model 3</option>
                            <option>Model 4</option>
                            <option>Model 5</option>
                        </select>
                        <button class="btn bg-red-500 hover:bg-red-600 text-white mt-2" wire:click="removeModel">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 7l4.647-4.646a.5.5 0 00-.708-.708L12 6.293 7.354 1.646a.5.5 0 10-.708.708L11.293 7l-4.647 4.646a.5.5 0 10.708.708L12 7.707l4.646 4.647a.5.5 0 00.708-.708L12.707 7z" clip-rule="evenodd" />
                            </svg>
                            Remove Selected Model
                        </button>
                    </div>
                    <!-- End -->
                </div>
            </div>
        </div>
    </div>
</div>
