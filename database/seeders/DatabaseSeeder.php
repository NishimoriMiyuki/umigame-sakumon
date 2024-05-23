<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        // 名前が「みる」のユーザーを取得
        $user = User::where('name', 'みる')->first();

        // ユーザーが存在する場合のみクイズを作成
        if ($user) {
            Quiz::factory()->count(10)->create([
                'user_id' => $user->id,
            ]);
        } else {
            // ユーザーが存在しない場合の処理
            $this->command->info('ユーザー「みる」が見つかりませんでした。');
        }
    }
}
