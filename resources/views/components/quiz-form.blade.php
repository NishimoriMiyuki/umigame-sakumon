@props(['action' => '#', 'method' => 'POST', 'data' => null, 'buttonText' => '送信', 'answerOptions' => [], 'labels' => []])

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    
    <div class="mb-4">
        <x-input-label for="title" :value="__('タイトル')" />
        <x-text-input
            name="title" 
            id="title" 
            class="w-full" 
            value="{{ old('title', $data->title ?? '') }}" 
            placeholder="(最大255文字)" 
            maxlength="255"
            x-on:input="if (event.target.value.length >= 255) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }" />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div class="mb-4">
        <x-input-label for="story" :value="__('問題')" />
        <x-textarea 
            name="story" 
            id="story" 
            class="w-full" 
            placeholder="(最大2000文字)" 
            maxlength="2000"
            x-on:input="if (event.target.value.length >= 2000) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }">{{ old('story', $data->story ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('story')" />
    </div>
    
    <div class="mb-4">
        <x-input-label for="answer" :value="__('真相')" />
        <x-textarea 
            name="answer" 
            id="answer" 
            class="w-full" 
            placeholder="(最大2000文字)" 
            maxlength="2000"
            x-on:input="if (event.target.value.length >= 2000) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }"
        >{{ old('answer', $data->answer ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('answer')" />
    </div>

<!-- 処理書き直したい・・・ --> 
@php
    $oldLabels = old('labels');
    if ($oldLabels !== null) {
        // バリデーションエラーが発生した場合、old('labels')からオブジェクトの配列を再構築する
        $oldLabels = $labels->whereIn('id', $oldLabels)->values();
    }
@endphp
    
    <div 
        class="mb-4" 
        x-data="{ 
            labels: {{ ($oldLabels ?? $data->labels ?? collect([]))->toJson() }}, 
            colorToRgba: function(color, opacity = 0.2) {
                let [r, g, b] = color.match(/\w\w/g).map((c) => parseInt(c, 16));
                return `rgba(${r}, ${g}, ${b}, ${opacity})`;
            },
            // ラベルの選択状態が変わったときにlabels配列を更新
            updateLabels: function(label, checked) {
                // チェックボックスがチェックされている場合、ラベルをlabels配列に追加する。
                if (checked) {
                    this.labels.push(label);
                } else {
                    // チェックボックスがチェックされていない場合、そのラベルをlabels配列から削除する。
                    this.labels = this.labels.filter(l => l.id !== label.id);
                }
            },
            userLabels: {{ ($labels ?? collect([]))->toJson() }},
            search: '',
        }">
        
        <x-input-label for="labels" :value="__('ラベル')" />
        
        <div class="flex grow flex-wrap gap-1 pe-6">
            <template x-for="(label, index) in labels" :key="index">
                <span class="rounded-xl px-1.5 py-px font-medium" 
                      x-bind:style="'color: ' + label.color + '; background-color: ' + colorToRgba(label.color, 0.2)"
                      x-text="label.name">
                </span>
            </template>
        </div>
        
        <x-secondary-button class="mt-2" x-on:click="$dispatch('open-modal', 'label-modal');">
            ラベルを追加
        </x-secondary-button>
        
        <!-- labelmodal -->
        <x-modal name="label-modal" :show="false" maxWidth="2xl">
            <div class="m-4">
                <p class="block font-medium text-sm text-gray-700 dark:text-gray-300">ラベル</p>
                <div class="relative">
                    <x-text-input x-model="search" class="w-full pr-8" />
                    <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 h-5 w-5 text-indigo-400 dark:text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col m-4 max-h-64 overflow-auto">
                <template x-for="(userLabel, index) in userLabels" :key="index">
                    <label :for="'userLabel-' + userLabel.id" x-show="userLabel.name.includes(search)" class="block font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 p-2">
                        <input
                            type="checkbox"
                            name="labels[]"
                            :value="userLabel.id"
                            :id="'userLabel-' + userLabel.id"
                            :checked="labels.some(label => label.id === userLabel.id)"
                            @keydown.enter.prevent
                            x-on:click="updateLabels(userLabel, $event.target.checked)">
                        <span x-text="userLabel.name"></span>
                    </label>
                </template>
            </div>
            <div class="m-4 flex items-center justify-end">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'label-modal'); setTimeout(() => { search = ''; }, 500);">
                    閉じる
                </x-secondary-button>
            </div>
        </x-modal>
    </div>
    
    <div class="mb-4" x-data="{ questions: {{ json_encode(old('questions', $data->questions ?? [])) }} }">
        <x-input-label for="questions" :value="__('質問例')" />
        <template x-for="(question, index) in questions" :key="index">
            <div class="mb-2 flex items-center">
                <x-text-input 
                    x-bind:name="'questions[' + index + '][content]'" 
                    x-model="question.content" 
                    class="w-full mr-2" 
                    placeholder="(最大255文字)" 
                    maxlength="255"
                    x-on:input="if (question.content.length >= 255) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }"/>
                <x-select
                    x-bind:name="'questions[' + index + '][answer]'" 
                    x-model="question.answer"
                    :options="$answerOptions"
                    class="w-full mr-2" />
                <x-secondary-button @click="questions.splice(index, 1)" class="flex-shrink-0">削除</x-secondary-button>
            </div>
        </template>
        <x-secondary-button @click="questions.push({ content: '', answer: '' });">質問例を追加</x-secondary-button>
    </div>
    
    <div class="mb-4">
        <x-input-label for="memo" :value="__('メモ')" />
        <x-textarea 
            id="memo" 
            name="memo" 
            class="w-full" 
            placeholder="(最大500文字)"
            maxlength="500"
            x-on:input="if (event.target.value.length >= 500) { toast('残り0文字です', { type: 'warning', position: 'bottom-center' }); }"
        >{{ old('memo', $data->memo ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('memo')" />
    </div>
    
    @if($action !== '#')
        <div class="flex items-center justify-end">
            <x-primary-button>{{ $buttonText }}</x-primary-button>
        </div>
    @endif
</form>