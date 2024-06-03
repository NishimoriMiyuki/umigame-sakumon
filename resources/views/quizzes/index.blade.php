<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden sm:rounded-lg">
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