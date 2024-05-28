<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- ここにフィルター機能とか検索機能おきたい -->
                    @if($quizzes->isNotEmpty())
                        <div x-data="{ selectedQuizzes: [] }">
                            @foreach ($quizzes as $quiz)
                                <div class="relative mb-4">
                                    <!-- 選択ボタン -->
                                    <button
                                        class="absolute -translate-y-2 -translate-x-2 z-10"
                                        @click="if (selectedQuizzes.includes({{ $quiz->id }})) { selectedQuizzes = selectedQuizzes.filter(id => id !== {{ $quiz->id }}); } else { selectedQuizzes.push({{ $quiz->id }}); }">
                                        <template x-if="selectedQuizzes.includes({{ $quiz->id }})">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <!-- 背景を白にするためのcircle要素 -->
                                                <circle cx="12" cy="12" r="10" fill="white" />
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                        <template x-if="!selectedQuizzes.includes({{ $quiz->id }})">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="size-6">
                                                <!-- 背景を白にするためのcircle要素 -->
                                                <circle cx="12" cy="12" r="10" fill="white" />
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </button>
                                    <x-card 
                                        title="{{ $quiz->title }}" 
                                        story="{{ $quiz->story }}" 
                                        questionsCount="{{ $quiz->questions->count() }}"
                                        createdAt="{{ $quiz->created_at->format('Y/m/d') }}"
                                        :labels="$quiz->labels"
                                        :quiz="$quiz" />
                                </div>
                            @endforeach
                            
                            <!-- 選択中のみ出るBar -->
                            <div x-data="{
                                    bannerVisibleAfter: 300
                                }" 
                                x-show="selectedQuizzes.length > 0"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="translate-y-full"
                                x-transition:enter-end="translate-y-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="translate-y-0"
                                x-transition:leave-end="translate-y-full"
                                class="fixed bottom-0 left-0 w-full h-12 py-2 duration-300 ease-out bg-black shadow-sm sm:py-0 sm:h-24 z-10" x-cloak>
                                <div class="flex items-center justify-between w-full h-full px-3 mx-auto max-w-7xl ">
                                    <div class="flex flex-col h-full text-xs leading-6 text-white duration-150 ease-out sm:flex-row sm:items-center opacity-80 hover:opacity-100">
                                        <span class="flex items-center">
                                            <strong class="font-semibold text-2xl" x-text="selectedQuizzes.length + '個を選択中'"></strong>
                                        </span>
                                        <span class="block pt-1 pb-2 leading-none sm:inline sm:pt-0 sm:pb-0"></span>
                                    </div>
                                    <div class="flex items-center justify-end space-x-4">
                                        <form id="deleteForm" method="POST" action="{{ route('quizzes.destroy-selected') }}">
                                            @csrf
                                            @method('DELETE')
                                            <!-- JavaScriptの配列をjson形式にエンコード -->
                                            <input type="hidden" name="ids" :value="JSON.stringify(selectedQuizzes)">
                                            <x-primary-button>削除</x-primary-button>
                                        </form>
                                        <!-- 全て解除ボタン -->
                                        <button @click="selectedQuizzes = []" class="flex items-center flex-shrink-0 translate-x-1 ease-out duration-150 justify-center w-6 h-6 p-1.5 text-white rounded-full hover:bg-neutral-800 sm:w-10 sm:h-10 sm:p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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