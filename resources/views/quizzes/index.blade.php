<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('問題一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- ここにフィルター機能とか検索機能おきたい -->
                    @if($quizzes->isNotEmpty())
                        <ul>
                            @foreach ($quizzes as $quiz)
                                <x-card 
                                    title="{{ $quiz->title }}" 
                                    story="{{ $quiz->story }}" 
                                    questionsCount="{{ $quiz->questions->count() }}"
                                    createdAt="{{ $quiz->created_at->format('Y/m/d') }}"
                                    :labels="$quiz->labels"
                                    :quiz="$quiz"
                                />
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            {{ $quizzes->links() }}
                        </div>
                    @else
                        <p>{{ __('問題がありません') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>