<style>
.custom-select {
  /* Existing styles */
}
</style>

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
  <!-- Page header -->
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
              </div>
              @error('name')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
              <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    wire:model="selectedCategory"
                    wire:change="selectCategory($event.target.value)">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
              <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500">
                <span class="mr-1">Remove Selected Category</span>
                <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 16 16">
                    <!-- Remove selected category logic -->
                </svg>
            </button>
            </div>
            <!-- End -->
          </div>

          <div>
            <!-- Start -->
            <div>
              <label class="block text-sm font-medium mb-1" for="brand">Brand <span class="text-rose-500">*</span></label>
              <div class="flex">
                <input id="brand" class="form-input w-full" type="text" wire:model="selectedBrand" required />
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-2" wire:click="addBrand">
                  <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                  </svg>
                </button>
              </div>
              @error('selectedBrand')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
              <select size="5" class="custom-select mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    wire:model="selectedBrand"
                    wire:change="selectBrand($event.target.value)"
                    @if (!$selectedCategory) disabled @endif>
                    <option value="">Select a brand</option>
                    <!-- Fetch brands from Brand model based on the selected category -->
                    @if ($selectedCategory)
                        @foreach ($selectedCategory->brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    @endif
                </select>
                <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500"
                    @if (!$selectedBrand) disabled @endif>
                    <span class="mr-1">Remove Selected Brand</span>
                    <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 16 16">
                        <!-- Remove selected brand logic -->
                    </svg>
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
                @if (!$selectedBrand) disabled @endif>
                <option value="">Select a model</option>
                @if ($selectedBrand)
                    @foreach ($selectedBrand->models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                @endif
            </select>

            <button class="mt-2 btn bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-rose-500"
                @if (!$selectedModel) disabled @endif>
                <span class="mr-1">Remove Selected Model</span>
                <svg class="w-4 h-4 fill-current opacity-75" viewBox="0 0 16 16">
                    <!-- Remove selected model logic -->
                </svg>
            </button>
          </div>
          <!-- End -->
        </div>
      </div>
    </div>
  </div>
</div>