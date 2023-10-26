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
                            <label class="block text-sm font-medium mb-1" for="mandatory">Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="mandatory" class="form-input w-full" type="text" wire:model="name" required/>
                            @error('name')
                            <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>@enderror
                        </div>
                        <!-- End -->
                    </div>


                    <!-- <div class="m-3">
                         <label class="flex items-center">
                             <input type="checkbox" class="form-checkbox" />
                             <span class="text-sm ml-2">Active</span>
                         </label>
                     </div> -->

                </div>

                <div class="mt-4">
                    <h1>Permissions</h1>
                </div>
                {{--                {{dd($this->rolePermission,$this->permission)}}--}}

                                @foreach($this->rolePermission as $val)
                                    <div class="mt-6">
                                        <h2 class="text-slate-800 font-semibold mb-2">{{$val['permission_bar']}}</h2>
                                        <div class="grid gap-5 md:grid-cols-4 mt-6">
                                            @foreach(json_decode($val['actions'], true) as $row)
                                                <div>
                                                    @if(in_array($val['permission_bar'].':'.$row, $this->selectedPermssions))
                                                        checked
                                                    @endif
                                                    <label class="flex items-center">
                                                        <input type="checkbox" wire:model="permission"
                                                               value="<?php echo'{'.$val['permission_bar'].':'.$row.'}'?>"
                                                               class="form-checkbox"/>
                                                        <span class="text-sm ml-2">{{ucfirst($row)}}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

{{--                @foreach($this->rolePermission as $val)--}}
{{--                    <div class="mt-6">--}}
{{--                        <h2 class="text-slate-800 font-semibold mb-2">{{$val['permission_bar']}}</h2>--}}
{{--                        <div class="grid gap-5 md:grid-cols-4 mt-6">--}}
{{--                            @foreach(json_decode($val['actions'], true) as $row)--}}
{{--                                <div>--}}
{{--                                    @if(in_array("{\"{$val['permission_bar']}\":$row}", $this->selectedPermssions))  @endif--}}

{{--                                    <label class="flex items-center">--}}
{{--                                        <input type="checkbox" wire:model="permission"--}}
{{--                                               value="{{ '{"' . $val['permission_bar'] . '":' . $row . '}' }}"--}}
{{--                                               class="form-checkbox"/>--}}
{{--                                        <span class="text-sm ml-2">{{ucfirst($row)}}</span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}


                <div class="grid gap-5 pt-0 float-right md:grid-cols-2">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div class="mb-2">
                        <input type="hidden" wire:model="role_id">
                        <button wire:click.prevent="update()" wire:loading.class="opacity-50 cursor-wait"
                                wire:target="update" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                            </svg>
                            <span class="hidden xs:block ml-2">
                    <span wire:loading wire:target="update" class="spinner-border spinner-border-sm" role="status"
                          aria-hidden="true"></span>
                        <?= $this->updateMode ? 'Update Role' : 'Add Role' ?>
                    </span>
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
