<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 sm:rounded-lg">
                
                <div class="pl-6 pr-6 sm:flex sm:justify-between items-center">
                    <div class="sm:mr-24 flex-grow">
                        <form action="{{ route('quizzes.index') }}" method="GET" class="flex items-center">
                            <x-text-input name="search" class="w-full flex-grow" placeholder="検索..." value="{{ request('search') }}" />
                            <x-primary-button class="flex-shrink-0 ml-1">検索</x-primary-button>
                        </form>
                    </div>
                    
                    <div class="flex">
                        <x-slide-over
                            :labels="$labels"
                            :labelId="$labelId" />
                            
                        <div class="ml-1">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <x-secondary-button>
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            height="18px" 
                                            viewBox="0 -960 960 960"
                                            width="18px" 
                                            fill="currentColor"><path d="M144-264v-72h240v72H144Zm0-180v-72h432v72H144Zm0-180v-72h672v72H144Z"/></svg>
                                        <span class="font-medium">
                                            @php
                                                $sortOrderMap = [
                                                    'created_atasc' => '作成日 昇順',
                                                    'created_atdesc' => '作成日 降順',
                                                    'updated_atasc' => '更新日 昇順',
                                                    'updated_atdesc' => '更新日 降順',
                                                ];
                                                $sortOrderKey = session('sort') . session('order');
                                            @endphp
                                            {{ $sortOrderMap[$sortOrderKey] ?? '並び替え' }}
                                        </span>
                                    </x-secondary-button>
                                </x-slot>
            
                                <x-slot name="content">
                                    <x-dropdown-link href="/quizzes?clear_sort=1" class="text-red-500">
                                        並び替え解除
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('quizzes.index', ['sort' => 'created_at', 'order' => 'asc'])">
                                        作成日 昇順
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('quizzes.index', ['sort' => 'created_at', 'order' => 'desc'])">
                                        作成日 降順
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('quizzes.index', ['sort' => 'updated_at', 'order' => 'asc'])">
                                        更新日 昇順
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('quizzes.index', ['sort' => 'updated_at', 'order' => 'desc'])">
                                        更新日 降順
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        
                    </div>
                </div>
                
                <div class="p-6 bg-gray-100 dark:bg-gray-900">
                    <x-quiz-list 
                        :quizzes="$quizzes"
                        massage="問題がありません"
                        view="index" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>