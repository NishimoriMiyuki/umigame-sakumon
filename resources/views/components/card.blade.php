@props(['quiz', 'view'])

<!-- Card 1 Container -->
<div class="relative">
  <!-- Action -->
  <div class="absolute end-4 top-4">
    <!-- Dropdown Container -->
    <div x-data="{ open: false }" class="relative">
      <button
        id="card-dropdown-1"
        aria-haspopup="true"
        x-bind:aria-expanded="open"
        x-on:click="open = true"
        type="button"
        class="flex h-6 w-6 items-center justify-center text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-400 active:text-slate-400 dark:active:text-slate-600"
      >
        <svg
          class="hi-mini hi-ellipsis-vertical inline-block h-5 w-5"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden="true"
        >
          <path
            d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"
          />
        </svg>
      </button>

      <!-- Dropdown -->
      <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-125"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        x-on:click.outside="open = false"
        role="menu"
        aria-labelledby="card-dropdown-1"
        class="absolute end-0 z-10 mt-2 w-32 rounded-lg shadow-xl ltr:origin-top-right rtl:origin-top-left"
      >
        <div
          class="divide-y divide-slate-100 dark:divide-slate-700 rounded-lg bg-white dark:bg-gray-800 ring-1 ring-black/5 dark:ring-white/10"
        >
          <div class="flex flex-col gap-2 p-2">
            @switch($view)
              @case('index')
                <a
                  href="{{ route('quizzes.edit', $quiz) }}"
                  class="group inline-flex items-center gap-1 rounded-lg bg-slate-50 dark:bg-slate-700 px-2.5 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 hover:text-slate-600 dark:hover:text-slate-200"
                >
                  <svg
                    class="hi-mini hi-pencil inline-block h-4 w-4 opacity-50 group-hover:opacity-100"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z"
                    />
                  </svg>
                  <span>編集</span>
                </a>
                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button
                    type="submit"
                    class="w-full group inline-flex items-center gap-1 rounded-lg bg-slate-50 dark:bg-slate-700 px-2.5 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 hover:text-slate-600 dark:hover:text-slate-200"
                  >
                    <svg
                      class="hi-mini hi-trash inline-block h-4 w-4 opacity-50 group-hover:opacity-100"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <span>削除</span>
                  </button>
                </form>
                @break
              @case('trashed')
                <form action="{{ route('quizzes.force-destroy', ['id' => $quiz->id]) }}" method="POST" x-on:submit.prevent="if (!window.confirm('完全に削除しますか？')) { return false; } $el.submit()">
                  @csrf
                  @method('DELETE')
                  <button
                    type="submit"
                    class="w-full group inline-flex items-center gap-1 rounded-lg bg-slate-50 dark:bg-slate-700 px-2.5 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 hover:text-slate-600 dark:hover:text-slate-200"
                  >
                    <svg
                      class="hi-mini hi-trash inline-block h-4 w-4 opacity-50 group-hover:opacity-100"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 -960 960 960"
                      fill="currentColor">
                      <path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/>
                    </svg>
                    <span>完全に削除</span>
                  </button>
                </form>
                <form action="{{ route('quizzes.restore', ['id' => $quiz->id]) }}" method="POST">
                  @csrf
                  <button
                    type="submit"
                    class="w-full group inline-flex items-center gap-1 rounded-lg bg-slate-50 dark:bg-slate-700 px-2.5 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 hover:text-slate-600 dark:hover:text-slate-200"
                  >
                    <svg
                      class="hi-mini hi-trash inline-block h-4 w-4 opacity-50 group-hover:opacity-100"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 -960 960 960"
                      fill="currentColor">
                      <path d="M440-320h80v-166l64 62 56-56-160-160-160 160 56 56 64-62v166ZM280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/>
                    </svg>
                    <span>復元</span>
                  </button>
                </form>
                @break
              @endswitch
          </div>
        </div>
      </div>
      <!-- END Dropdown -->
    </div>
    <!-- END Dropdown Container -->
  </div>
  <!-- END Action -->

  <!-- Card 1 -->
  <a
    href="#"
    :class="{
      'border border-indigo-400 dark:border-indigo-600 border-4': selectedQuizzes.includes({{ $quiz->id }}),
    }"
    x-cloak
    @click.prevent="
    if (selectedQuizzes.length > 0) 
    { 
      if (selectedQuizzes.includes({{ $quiz->id }})) 
      { 
        selectedQuizzes = selectedQuizzes.filter(id => id !== {{ $quiz->id }}); 
      } 
      else 
      { 
        selectedQuizzes.push({{ $quiz->id }}); 
      } 
    }
    else 
    { 
      @switch($view)
        @case('index')
          window.location.href = '{{ route('quizzes.edit', $quiz) }}'; 
            @break
        @case('trashed')
          window.location.href = '{{ route('quizzes.show', ['quiz' => $quiz->id]) }}'; 
            @break
      @endswitch
    }"
    class="group flex flex-col gap-3 rounded-xl bg-white dark:bg-gray-800 p-4 text-sm transition"
  >
    <div class="-ms-1.5 flex grow flex-wrap gap-1 pe-6">
        @foreach ($quiz->labels as $label)
            <span class="rounded-xl px-1.5 py-px font-medium" 
                  style="color: {{ $label->color }}; background-color: {{ $label->colorToRgba(0.2) }};">
                #{{ $label->name }}
            </span>
        @endforeach
        <!-- スペース開けるためだけに -->
        @if($quiz->labels->isEmpty())
          <div class="h-5"></div>
        @endif
    </div>
    <div class="break-all text-slate-500 dark:text-slate-400">
      <h3 class="mb-1 font-bold">{{ $quiz->title ?? '未入力' }}</h3>
      <p class="line-clamp-3">{{ $quiz->story ?? '未入力' }}</p>
    </div>
    <div class="flex items-center justify-between">
      <div
        class="inline-flex items-center gap-1.5 text-slate-500 dark:text-slate-400"
      >
        <svg
          class="hi-mini hi-calendar-days inline-block h-5 w-5 text-slate-300 dark:text-slate-500"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden="true"
        >
          <path
            d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z"
          />
          <path
            fill-rule="evenodd"
            d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
            clip-rule="evenodd"
          />
        </svg>
        <span>{{ $quiz->created_at->format('Y/m/d') }}</span>
      </div>
      <div
        class="inline-flex items-center gap-1.5 text-slate-500 dark:text-slate-400"
      >
        <svg 
            class="hi-mini hi-clock inline-block h-5 w-5 text-slate-300 dark:text-slate-500"
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 20 20" 
            fill="currentColor" 
            aria-hidden="true">
          <path 
            fill-rule="evenodd" 
            d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 0 0 1.33 0l1.713-3.293a.783.783 0 0 1 .642-.413 41.102 41.102 0 0 0 3.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0 0 10 2ZM6.75 6a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5Z" 
            clip-rule="evenodd" />
        </svg>
        <span>{{ $quiz->questions->count() }}件</span>
      </div>
    </div>
  </a>
  <!-- END Card 1 -->
</div>
<!-- END Card 1 Container -->