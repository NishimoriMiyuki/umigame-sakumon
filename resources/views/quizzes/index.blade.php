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
                    <x-slide-over
                        :labels="$labels"
                        :labelId="$labelId" />
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