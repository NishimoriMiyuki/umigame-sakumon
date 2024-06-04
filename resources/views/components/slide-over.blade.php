@props(['labels' => collect(), 'labelId' => null])

<div x-data="{ 
        slideOverOpen: false 
    }"
    class="relative z-50 w-auto h-auto"
    x-init="$watch('slideOverOpen', value => 
    {
        if(value)
        {
            document.body.classList.add('overflow-y-hidden');
        }
        else
        {
            document.body.classList.remove('overflow-y-hidden');
        }
    })">
    <x-secondary-button 
        @click="slideOverOpen=true">
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            height="18px" 
            viewBox="0 -960 960 960" 
            width="18px" 
            fill="currentColor"
            class="">
            <path d="M440-160q-17 0-28.5-11.5T400-200v-240L168-736q-15-20-4.5-42t36.5-22h560q26 0 36.5 22t-4.5 42L560-440v240q0 17-11.5 28.5T520-160h-80Zm40-308 198-252H282l198 252Zm0 0Z"/>
            @php
                $labelName = $labels->firstWhere('id', $labelId)->name ?? 'フィルター';
            @endphp
            <span class="font-medium">{{ $labelName }}</span>
        </svg>
    </x-secondary-button>
    <template x-teleport="body">
        <div 
            x-show="slideOverOpen"
            @keydown.window.escape="slideOverOpen=false"
            class="relative z-[99]">
            <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen = false" class="fixed inset-0 bg-black bg-opacity-10"></div>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div 
                            x-show="slideOverOpen" 
                            @click.away="slideOverOpen = false"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                            x-transition:enter-start="translate-x-full" 
                            x-transition:enter-end="translate-x-0" 
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                            x-transition:leave-start="translate-x-0" 
                            x-transition:leave-end="translate-x-full" 
                            class="w-screen max-w-md">
                            <div class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l shadow-lg border-neutral-100/70">
                                <div class="px-4 sm:px-5">
                                    <div class="flex items-start justify-between pb-1">
                                        <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">フィルター</h2>
                                        <div class="flex items-center h-auto ml-3">
                                            <button @click="slideOverOpen=false" class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span>閉じる</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                <div class="absolute inset-0 px-4 sm:px-5">
                                    <div class="relative h-full overflow-auto border border-dashed rounded-md border-neutral-300">
                                        <ul>
                                            <a href="/quizzes?clear_filter=1" class="block font-medium border rounded-md border-neutral-200 text-red-500 hover:bg-neutral-100 p-2 cursor-pointer">フィルター解除</a>
                                            @foreach($labels as $label)
                                                <li class="font-medium border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100 p-2 cursor-pointer {{ $label->id == $labelId ? 'bg-neutral-100' : '' }}" x-on:click="window.location.href = '/quizzes?id=' + {{ $label->id }}">
                                                    {{ $label->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>