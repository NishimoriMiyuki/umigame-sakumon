<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = auth()->user()->getLatestQuizzes(5);
        return view('quizzes.index', compact('quizzes'));
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
        // 仮で置く
        $colors = [
            '#dc2626', // 赤
            '#ca8a04', // 黄色
            '#16a34a', // 緑
            '#2563eb', // 青
            '#4f46e5', // 藍色
            '#9333ea', // 紫
            '#db2777', // ピンク
            '#4b5563', // 灰色
            '#059669', // エメラルド
            '#0d9488', // ティール
            '#0891b2', // シアン
            '#d97706', // 琥珀色
            '#65a30d', // ライム
            '#ea580c', // オレンジ
            '#7c3aed', // バイオレット
            '#c026d3', // フクシア
            '#0284c7', // 空色
            '#525252', // ニュートラル
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
