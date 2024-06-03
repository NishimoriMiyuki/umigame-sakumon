<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = auth()->user()->labels;
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:labels|max:100',
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
                ->with('type', 'warning')
                ->with('description', $errorMessages);
        }
    
        $validated = $validator->validated();
        auth()->user()->labels()->create($validated + ['color' => Label::getRandomColor()]);
    
        return redirect()->route('labels.index')
            ->with('type', 'success')
            ->with('description', '作成されました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        if ($response = $this->authorize('update', $label))
        {
            return $response;
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:labels|max:100',
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
                ->with('type', 'warning')
                ->with('description', $errorMessages);
        }
        
        $validated = $validator->validated();
        $label->update($validated);
        
        return redirect()->route('labels.index')
            ->with('type', 'success')
            ->with('description', '更新されました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if ($response = $this->authorize('delete', $label))
        {
            return $response;
        }
        
        $label->delete();
        
        return redirect()->route('labels.index')
            ->with('type', 'success')
            ->with('description', '削除されました');
    }
    
    // 更新権限を確認
    private function authorize(string $action, Label $label)
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
        if (auth()->user()->cannot($action, $label)) 
        {
            return redirect()->route('labels.index')
                ->with('type', 'warning')
                ->with('description', $status);
        }
    }
}
