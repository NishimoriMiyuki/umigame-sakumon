@props(['action', 'method' => 'POST', 'data' => null, 'buttonText' => '送信', 'answerOptions' => [], 'labels' => []])

<form action="{{ $action }}" method="POST">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif
    
    <div class="mb-4" x-data="{ titleCount: '{{ old('title', $data->title ?? '') }}' }">
        <x-input-label for="title" :value="__('タイトル')" />
        <x-text-input
            name="title" 
            id="title" 
            class="w-full" 
            value="{{ old('title', $data->title ?? '') }}" 
            placeholder="タイトルを入力(最大255文字)" 
            maxlength="255"
            x-model="titleCount"
            x-on:input="if (titleCount.length >= 255) { toast('残り0文字', { type: 'warning' }); }" />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div class="mb-4" x-data="{ storyCount: '{{ old('story', $data->story ?? '') }}' }">
        <x-input-label for="story" :value="__('問題文')" />
        <x-textarea 
            name="story" 
            id="story" 
            class="w-full" 
            placeholder="問題文を入力(最大2000文字)" 
            maxlength="2000"
            x-model="storyCount"
            x-on:input="if (storyCount.length >= 2000) { toast('残り0文字', { type: 'warning' }); }">{{ old('story', $data->story ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('story')" />
    </div>
    
    <div class="mb-4" x-data="{ answerCount: '{{ old('answer', $data->answer ?? '') }}' }">
        <x-input-label for="answer" :value="__('答え')" />
        <x-textarea 
            name="answer" 
            id="answer" 
            class="w-full" 
            placeholder="答えを入力(最大2000文字)" 
            maxlength="2000"
            x-model="answerCount"
            x-on:input="if (answerCount.length >= 2000) { toast('残り0文字', { type: 'warning' }); }"
        >{{ old('answer', $data->answer ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('answer')" />
    </div>
    
    <div class="mb-4">
        <x-input-label for="labels" :value="__('ラベル')" />
        <div id="labels" class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1">
            @if($labels->isNotEmpty())
                @foreach($labels as $label)
                    <div class="flex items-center">
                        <x-checkbox-input 
                            name="labels[]" 
                            value="{{ $label->id }}" 
                            id="label-{{ $label->id }}"
                            :checked="in_array($label->id, old('labels', $data ? $data->labels->pluck('id')->toArray() : []))" />
                        <x-checkbox-label for="label-{{ $label->id }}">
                            {{ $label->name }}
                        </x-checkbox-label>
                    </div>
                @endforeach
            @else
                <p>{{ __('ラベルがありません') }}</p>
            @endif
        </div>
        <x-input-error :messages="$errors->get('labels')" />
    </div>
    
    <div class="mb-4" x-data="{ questions: {{ json_encode(old('questions', $data->questions ?? [])) }} }" x-init="console.log(questions)">
        <x-input-label for="questions" :value="__('質問例')" />
        <template x-for="(question, index) in questions" :key="index">
            <div class="mb-2 flex items-center">
                <x-text-input 
                    x-bind:name="'questions[' + index + '][content]'" 
                    x-model="question.content" 
                    class="w-full mr-2" 
                    placeholder="質問を入力(最大255文字)" 
                    maxlength="255"
                    x-on:input="if (question.content.length >= 255) { toast('残り0文字です', { type: 'warning' }); }"/>
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
    
    <div class="mb-4" x-data="{ memoCount: '{{ old('memo', $data->memo ?? '') }}' }">
        <x-input-label for="memo" :value="__('メモ')" />
        <x-textarea 
            id="memo" 
            name="memo" 
            class="w-full" 
            placeholder="メモを入力(最大500文字)" 
            maxlength="500" 
            x-model="memoCount" 
            x-on:input="if (memoCount.length >= 500) { toast('残り0文字です', { type: 'warning' }); }"
        >{{ old('memo', $data->memo ?? '') }}</x-textarea>
        <x-input-error :messages="$errors->get('memo')" />
    </div>
    
    <div class="flex items-center justify-end">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
    </div>
</form>