<div>
    <div class="flex-col space-y-4">
        <div class="flex flex-col space-y-2" x-data="{ selected: null }">
            @forelse ($permissions as $group => $collection)
                <div class="overflow-hidden w-full dark:text-gray-200 text-gray-700">
                    <button type="button" class="w-full p-2 rounded-lg dark:bg-gray-900 bg-gray-200" x-on:click="selected !==  {{$loop->iteration}} ? selected = {{$loop->iteration}} : selected = null">
                        <div class="flex items-center justify-between">
                            <span class="text-base md:text-lg font-semibold">{{__(Str::title($group))}}</span>
                            <div :class="selected == {{$loop->iteration}} ? 'transform rotate-180' : 'transform rotate-0'">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </button>
                    <div class="grid grid-cols-2 gap-4 p-2" x-show="selected == {{$loop->iteration}}" x-collapse.duration.1000ms>
                        @foreach ($collection as $id => $permission)
                        <div class="col-span-1 flex flex-col hover:bg-gray-200 dark:hover:bg-gray-600 p-2 rounded-md">
                            <span class="text-base md:text-lg">{{$permission->display_name}}</span>
                            <span class="mt-1 text-xs">{{$permission->description}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
