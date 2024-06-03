<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ラベルの編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    
                    <!-- 作成 -->
                    <div class="mb-4">
                        <form action="{{ route('labels.store') }}" method="POST" class="flex items-center">
                            @csrf
                            <x-text-input 
                                placeholder="新しいラベルを作成(最大100文字)" 
                                class="w-full mr-2" 
                                name="name"
                                maxlength="100"
                                x-on:input="if (event.target.value.length >= 100) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }">
                            </x-text-input>
                            <x-primary-button class="flex-shrink-0">作成</x-primary-button>
                        </form>
                    </div>
                    
                    <!-- 一覧 -->
                    <div class="mb-4">
                        @foreach($labels as $label)
                            <div 
                                class="mb-4" 
                                x-cloak 
                                x-data="{ editing: false }" 
                                x-init="$watch('editing', value => { if(value) { setTimeout(() => { $refs.input.focus(); $refs.input.setSelectionRange($refs.input.value.length, $refs.input.value.length); }, 50) } })">
                                <div class="flex items-center justify-between" x-show="!editing">
                                    <div class="min-h-10 flex items-center">
                                        <div class="h-5 w-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M840-480 666-234q-11 16-28.5 25t-37.5 9H200q-33 0-56.5-23.5T120-280v-400q0-33 23.5-56.5T200-760h400q20 0 37.5 9t28.5 25l174 246Zm-98 0L600-680H200v400h400l142-200Zm-542 0v200-400 200Z"/></svg>
                                        </div>
                                        <span @click="editing = true" class="pl-3 text-gray-700 dark:text-gray-300">{{ $label->name }}</span>
                                    </div>
                                    <button @click="editing = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                    </button>
                                </div>
                                
                                <div class="flex items-center" x-show="editing">
                                    
                                    <!-- 削除フォーム -->
                                    <form action="{{ route('labels.destroy', $label) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <!--<x-primary-button class="flex-shrink-0 mr-4">削除</x-primary-button>-->
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#5f6368" class="size-5">
                                              <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <!-- 更新フォーム -->
                                    <form action="{{ route('labels.update', $label) }}" method="POST" class="flex-grow">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center">
                                            <div class="flex-grow relative">
                                                <input
                                                    @keydown.enter.prevent
                                                    x-ref="input"
                                                    x-on:blur="setTimeout(() => editing = false, 200)" 
                                                    type="text"
                                                    name="name"
                                                    maxlength="100"
                                                    x-on:input="if (event.target.value.length >= 100) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }"
                                                    class="w-full border-none focus:border-none focus:outline-none focus:ring-0 dark:bg-gray-800 dark:text-gray-300"
                                                    value="{{ $label->name }}">
                                                <div class="absolute bottom-0 w-full border-b border-gray-300 dark:border-gray-700"></div>
                                            </div>
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                            </button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>