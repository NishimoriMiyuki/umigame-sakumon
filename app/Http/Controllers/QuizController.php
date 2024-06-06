<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request->has('clear_filter')) 
        // {
        //     // clear_filterパラメータが存在する場合、セッションからラベルIDを削除
        //     $request->session()->forget('labelId');
        // }
        
        // if ($request->has('clear_sort')) 
        // {
        //     $request->session()->forget(['sort', 'order']);
        // }
    
        // $labelId = $request->id;
        
        // if ($labelId) 
        // {
        //     // ラベルIDが指定されている場合、それをセッションに保存
        //     $request->session()->put('labelId', $labelId);
        // }
        // else
        // {
        //     // ラベルIDが指定されていない場合、セッションから取得
        //     $labelId = $request->session()->get('labelId');
        // }
    
        // $quizzes = collect();
        // $labels = auth()->user()->labels;
        // $search = $request->search;
        // $sort = $request->sort;
        // $order = $request->order;
    
        // if ($labelId)
        // {
        //     // ユーザーが所持してるラベルに同じidのラベルがあるか
        //     $label = $labels->firstWhere('id', $labelId);
    
        //     if ($label) 
        //     {
        //         // あったらラベルと紐付いてるquizを取ってくる
        //         $quizzes = $label->quizzes();
        //     }
        // }
        // else 
        // {
        //     $quizzes = auth()->user()->quizzes();
        // }
        
        // if ($sort && $order) 
        // {
        //     // セッションにsortとorderを保存
        //     $request->session()->put('sort', $sort);
        //     $request->session()->put('order', $order);
        // }
        // else
        // {
        //     // セッションからsortとorderを取得
        //     $sort = $request->session()->get('sort');
        //     $order = $request->session()->get('order');
        // }
        
        // if ($sort && $order) 
        // {
        //     if ($order === 'asc') 
        //     {
        //         $quizzes = $quizzes->orderBy($sort);
        //     }
        //     elseif ($order === 'desc') 
        //     {
        //         $quizzes = $quizzes->orderByDesc($sort);
        //     }
        // }
        
        // if($search)
        // {
        //     $quizzes = $quizzes->search($search);
        // }
        
        // $quizzes = $quizzes->paginate(10);
        
        $quizzes = collect();
        $labels = collect();
        $labelId = 1;
    
        return view('quizzes.index', compact('quizzes', 'labels', 'labelId'));
    }
    
    public function trashed()
    {
        $quizzes = auth()->user()->getLatestDeletedQuizzes(10);
        return view('quizzes.trashed', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labels = auth()->user()->labels;
        $answerOptions = Question::getAnswerOptions();
        return view('quizzes.create', compact('labels', 'answerOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'story' => 'nullable|string|max:2000',
            'memo' => 'nullable|string|max:500',
            'answer' => 'nullable|string|max:2000',
            'labels' => 'array',
            'labels.*' => 'exists:labels,id',
            'questions' => 'array|max:20',
            'questions.*.content' => 'nullable|string|max:255',
            'questions.*.answer' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
        
            // エラーメッセージを取得
            $errorMessages = '';
            foreach ($errors->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages .= "$message";
                }
            }
        
            return redirect()->back()
                ->withInput()
                ->with('type', 'warning')
                ->with('description', $errorMessages);
        }
        
        $validated = $validator->validated();
        
        // 配列の要素にコールバック登録して新しい配列を作る
        $nonEmptyValidated = array_filter($validated, function($value) {
            // 要素が空じゃなかったらtrueで新しい配列に入る
            return !empty($value);
        });
    
        // 中身がすべて空かどうかを確認して空だったら作らない
        if (empty($nonEmptyValidated)) {
            return redirect()->route('quizzes.index')
                ->with('type', 'warning')
                ->with('description', '入力が全て空です');
        }
        
        try 
        {
            DB::transaction(function () use ($validated) {
                // quizの作成
                $quiz = auth()->user()->quizzes()->create([
                    'title' => $validated['title'],
                    'story' => $validated['story'],
                    'memo' => $validated['memo'],
                    'answer' => $validated['answer'],
                ]);
    
                // ラベルの関連付け
                if (!empty($validated['labels'])) 
                {
                    $quiz->labels()->attach($validated['labels']);
                }
    
                // 質問の保存
                if (!empty($validated['questions'])) 
                {
                    foreach ($validated['questions'] as $questionData) 
                    {
                        // contentとanswerのどちらも空でない場合にのみ保存
                        if (!empty($questionData['content']) || !empty($questionData['answer'])) {
                            $quiz->questions()->create([
                                'content' => $questionData['content'],
                                'answer' => $questionData['answer'],
                            ]);
                        }
                    }
                }
            });
            
            // トランザクション成功
            return redirect()->route('quizzes.index')
                ->with('type', 'success')
                ->with('description', '作成されました');
        }
        catch (QueryException $e) 
        {
            // トランザクションが失敗した場合
            return redirect()->route('quizzes.index')
                ->with('type', 'danger')
                ->with('description', '作成に失敗しました');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = auth()->user()->quizzes()->where('id', $id)->onlyTrashed()->first();
        
        if ($response = $this->authorize('view', $quiz))
        {
            return $response;
        }
        
        $labels = auth()->user()->labels;
        $answerOptions = Question::getAnswerOptions();
        return view('quizzes.show', compact('quiz', 'labels', 'answerOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        // ポリシー確認
        if ($response = $this->authorize('update', $quiz))
        {
            return $response;
        }
        
        $labels = auth()->user()->labels;
        $answerOptions = Question::getAnswerOptions();
        return view('quizzes.edit', compact('quiz', 'labels', 'answerOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // ポリシー確認
        if ($response = $this->authorize('update', $quiz)) 
        {
            return $response;
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'story' => 'nullable|string|max:2000',
            'memo' => 'nullable|string|max:500',
            'answer' => 'nullable|string|max:2000',
            'labels' => 'array',
            'labels.*' => 'exists:labels,id',
            'questions' => 'array',
            'questions.*.content' => 'nullable|string|max:255',
            'questions.*.answer' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
        
            // エラーメッセージを取得
            $errorMessages = '';
            foreach ($errors->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages .= "$message";
                }
            }
        
            return redirect()->back()
                ->withInput()
                ->with('type', 'warning')
                ->with('description', $errorMessages);
        }
        
        $validated = $validator->validated();
    
        try 
        {
            DB::transaction(function () use ($quiz, $validated) {
                // クイズの更新
                $quiz->update([
                    'title' => $validated['title'],
                    'story' => $validated['story'],
                    'memo' => $validated['memo'],
                    'answer' => $validated['answer'],
                ]);
                
                // updated_atを明示的に更新
                $quiz->touch();
    
                // ラベルの関連付けの更新
                if (!empty($validated['labels'])) 
                {
                    // 既存の関連付け解除してから、新しいlabelsを関連付け
                    $quiz->labels()->sync($validated['labels']);
                }
                else 
                {
                    // もしlabelsが空だったら関連付けを外す
                    $quiz->labels()->detach();
                }
    
                // 質問の更新
                // 一旦全部削除
                $quiz->questions()->delete();
                // 空じゃなかったら全ての新しい質問データを作る
                if (!empty($validated['questions'])) 
                {
                    foreach ($validated['questions'] as $questionData) 
                    {
                        // contentとanswerのどちらも空でない場合にのみ保存
                        if (!empty($questionData['content']) || !empty($questionData['answer'])) {
                            $quiz->questions()->create([
                                'content' => $questionData['content'],
                                'answer' => $questionData['answer'],
                            ]);
                        }
                    }
                }
            });
            
            // トランザクション成功
            return redirect()->route('quizzes.index')
                ->with('type', 'success')
                ->with('description', '更新されました');
        } 
        catch (QueryException $e) 
        {
            // トランザクションが失敗した場合
            return redirect()->route('quizzes.index')
                ->with('type', 'danger')
                ->with('description', '更新に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        // ポリシー確認
        if ($response = $this->authorize('delete', $quiz))
        {
            return $response;
        }
        
        $quiz->delete();
        
        return redirect()->route('quizzes.index')
            ->with('type', 'success')
            ->with('description', '削除されました');
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->input('ids', '[]');
        $ids = json_decode($ids, true);
        
        $quizzes = auth()->user()->quizzes()->whereIn('id', $ids)->get();
        
        $count = 0;
        
        foreach ($quizzes as $quiz) 
        {
            if ($response = $this->authorize('delete', $quiz))
            {
                return $response;
            }
            
            $quiz->delete();
            $count++;
        }
        
        return redirect()->route('quizzes.index')
            ->with('type', 'success')
            ->with('description', "{$count}個削除されました");
    }
    
    public function forceDestroy($id)
    {
        $quiz = auth()->user()->quizzes()->where('id', $id)->onlyTrashed()->first();
        
        if ($response = $this->authorize('forceDelete', $quiz))
        {
            return $response;
        }
        
        $quiz->forceDelete();
        
        return redirect()->route('quizzes.trashed')
            ->with('type', 'success')
            ->with('description', "完全に削除されました");
    }
    
    public function forceDestroySelected(Request $request)
    {
        $ids = $request->input('ids', '[]');
        $ids = json_decode($ids, true);
        
        $quizzes = auth()->user()->quizzes()->onlyTrashed()->whereIn('id', $ids)->get();
        
        $count = 0;
        
        foreach ($quizzes as $quiz) 
        {
            if ($response = $this->authorize('forceDelete', $quiz))
            {
                return $response;
            }
            
            $quiz->forceDelete();
            $count++;
        }
        
        return redirect()->route('quizzes.trashed')
            ->with('type', 'success')
            ->with('description', "{$count}個完全に削除されました");
    }
    
    public function AllForceDestroy()
    {
        $quizzes = auth()->user()->quizzes()->onlyTrashed()->get();
        
        foreach ($quizzes as $quiz) 
        {
            if ($response = $this->authorize('forceDelete', $quiz))
            {
                return $response;
            }
            
            $quiz->forceDelete();
        }
        
        return redirect()->route('quizzes.trashed')
            ->with('type', 'success')
            ->with('description', "完全に削除されました");
    }
    
    public function restore($id)
    {
        $quiz = auth()->user()->quizzes()->where('id', $id)->onlyTrashed()->first();
        
        if ($response = $this->authorize('restore', $quiz))
        {
            return $response;
        }
        
        $quiz->restore();
        
        return redirect()->route('quizzes.trashed')
            ->with('type', 'success')
            ->with('description', "復元されました");
    }
    
    public function restoreSelected(Request $request)
    {
        $ids = $request->input('ids', '[]');
        $ids = json_decode($ids, true);
        
        $quizzes = auth()->user()->quizzes()->onlyTrashed()->whereIn('id', $ids)->get();
        
        $count = 0;
        
        foreach ($quizzes as $quiz) 
        {
            if ($response = $this->authorize('restore', $quiz))
            {
                return $response;
            }
            
            $quiz->restore();
            $count++;
        }
        
        return redirect()->route('quizzes.trashed')
            ->with('type', 'success')
            ->with('description', "{$count}個復元されました");
    }

    // 更新権限を確認
    private function authorize(string $action, Quiz $quiz)
    {
        switch ($action)
        {
            case 'update':
                $status = '編集権限がありません';
                break;
            case 'delete':
                $status = '削除権限がありません';
                break;
            default:
                $status = '権限がありません';
        }
        
        // ポリシーを確認 権限がなかったらtrueが返ってくる
        if (auth()->user()->cannot($action, $quiz)) 
        {
            return redirect()->route('quizzes.index')
                ->with('type', 'warning')
                ->with('description', $status);
        }
    }
}
