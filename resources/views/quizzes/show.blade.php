<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('詳細') }}
        </h2>
    </x-slot>

    <div class="py-12" x-init="toast('ゴミ箱では編集できません', { type: 'info', position: 'bottom-center' })">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    
                    <fieldset disabled>
                        <x-quiz-form
                            :data="$quiz"
                            :answerOptions="$answerOptions"
                            :labels="$labels" />
                    </fieldset>
                    
                    <div class="flex items-center justify-end space-x-4">
                        <form action="{{ route('quizzes.restore', ['id' => $quiz->id]) }}" method="POST">
                            @csrf
                            <x-primary-button>復元</x-primary-button>
                        </form>
                        <form action="{{ route('quizzes.force-destroy', ['id' => $quiz->id]) }}" method="POST" x-on:submit.prevent="if (!window.confirm('完全に削除しますか？')) { return false; } $el.submit()">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>完全に削除</x-danger-button>
                        </form>
                    </div>
                    
                    <div class="text-slate-300 dark:text-slate-500 text-sm space-x-4">    
                        <span>作成日:{{ $quiz->created_at->format('Y/m/d') }}</span>
                        <span>編集日:{{ $quiz->updated_at->format('Y/m/d') }}</span>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>