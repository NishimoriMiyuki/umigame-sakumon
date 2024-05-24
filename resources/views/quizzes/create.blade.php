<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <x-quiz-form 
                        :action="route('quizzes.store')" 
                        method="POST" 
                        :data="null" 
                        :answerOptions="$answerOptions"
                        :labels="$labels"
                        buttonText="作成" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>