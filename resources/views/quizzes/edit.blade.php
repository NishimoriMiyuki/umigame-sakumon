<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <x-quiz-form 
                        :action="route('quizzes.update', $quiz->id)"
                        method="PUT" 
                        :data="$quiz" 
                        :answerOptions="$answerOptions"
                        :labels="$labels"
                        buttonText="更新" />
                    
                    <div class="text-slate-300 dark:text-slate-500 text-sm space-x-4">    
                        <span>作成日:{{ $quiz->created_at->format('Y/m/d') }}</span>
                        <span>編集日:{{ $quiz->updated_at->format('Y/m/d') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>