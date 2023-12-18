<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->


        <div class="border-t border-slate-200">

            <!-- Components -->
            <div class="space-y-8 mt-8">

                <!-- Input Types -->
                <div>

                    <div class="grid gap-5 md:grid-cols-3">

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Name <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="name" required />
                                @error('name')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Email <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="email" wire:model="email" required />
                                @error('email')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Mobile <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="mobile" required />
                                @error('mobile')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>



                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Password <span class="text-rose-500">*</span></label>
                                <input id="mandatory" class="form-input w-full" type="text" wire:model="password" required />
                                @error('password')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>


                         <div>
                            <!-- Start -->
                        <label class="block text-sm font-medium mb-1" for="country">Gender <span class="text-rose-500">*</span></label>
                        <select id="country" class="form-input w-full" wire:model="gender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('gender')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            <!-- End -->
                        </div>

{{--                        <div>--}}
{{--                    <!-- Start -->--}}
{{--                        <label class="block text-sm font-medium mb-1" for="country">Type</label>--}}
{{--                        <select id="country" class="form-input w-full" wire:model="type">--}}
{{--                            <option value="">Select</option>--}}
{{--                            <option value="Public">Public</option>--}}
{{--                            <option value="Private">Private</option>--}}
{{--                        </select>--}}
{{--                    <!-- End -->--}}
{{--                        </div>--}}

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Role <span class="text-rose-500">*</span></label>
                                <select id="roles" name="role_id" class="form-input w-full" wire:model="role_id">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')<div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                            </div>
                            <!-- End -->
                        </div>

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="mandatory">Profile </label>
                                <input class="form-input w-full" type="file" wire:model="image" required />
                            </div>
                            <!-- End -->
                        </div>

{{--                       <div>--}}
{{--                        <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3 mt-6">--}}
{{--                            <img class="rounded-full" id="imgInp" src="{{$this->imageURL}}" alt="">--}}
{{--                       </div>--}}
{{--                       </div>--}}



                       <!-- <div class="m-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" />
                                <span class="text-sm ml-2">Active</span>
                            </label>
                        </div> -->

                   </div>

{{--                @foreach($this->rolePermission as $val)--}}
{{--            <div class="mt-6">--}}
{{--                    <h2 class="text-slate-800 font-semibold mb-2">{{$val['permission_bar']}}</h2>--}}
{{--                <div class="grid gap-5 md:grid-cols-4 mt-6">--}}
{{--                @foreach(json_decode($val['actions'], true) as $row)--}}
{{--                    <div>--}}
{{-- @if(in_array($val['permission_bar'].':'.$row, $this->selectedPermssions)) checked @endif  --}}
{{--                            <label class="flex items-center">--}}
{{--                                <input type="checkbox" wire:model="permission" value="<?php echo'{'.$val['permission_bar'].':'.$row.'}'?>" class="form-checkbox" />--}}
{{--                                <span class="text-sm ml-2">{{ucfirst($row)}}</span>--}}
{{--                            </label>--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
{{--               </div>--}}
{{--            </div>--}}
{{--                    @endforeach--}}

                <div class="grid gap-5 pt-0 float-right md:grid-cols-2">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div>
                   <input type="hidden" wire:model="user_id">
                   <button wire:click.prevent="update()" wire:loading.class="opacity-50 cursor-wait" wire:target="update" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">
                    <span wire:loading wire:target="update" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <?= $this->updateMode ? 'Update User' : 'Add User' ?>
                    </span>
                </button>
               </div>

                </div>

                </div>

            </div>

        </div>

    </div>

{{--    @push('scripts')--}}
{{--  <script>--}}
{{--imgInp.onchange = evt => {--}}
{{--  const [file] = imgInp.files--}}
{{--  if (file) {--}}
{{--    blah.src = URL.createObjectURL(file)--}}
{{--  }--}}
{{--}--}}
{{--  </script>--}}
{{--@endpush--}}
