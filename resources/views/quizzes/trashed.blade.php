<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ゴミ箱') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="px-6">
                @if($quizzes->isNotEmpty())
                    <div class="flex items-center justify-end">
                        <form method="POST" action="{{ route('quizzes.all-force-destroy') }}" x-on:submit.prevent="if (!window.confirm('ゴミ箱を空にしますか？ゴミ箱内の問題はすべて完全に削除されます。')) { return false; } $el.submit()">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">ゴミ箱を空にする</x-danger-button>
                        </form>
                    </div>
                @endif
            </div>
            
            <div class="bg-gray-100 dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6 bg-gray-100 dark:bg-gray-900">
                    <x-quiz-list 
                        :quizzes="$quizzes"
                        massage="ゴミ箱は空です"
                        view="trashed" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>