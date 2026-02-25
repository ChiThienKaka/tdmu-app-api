<?php

namespace App\Features\Domain\ChatBox\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Features\Domain\ChatBox\Models\FaqModel;
use App\Features\Domain\ChatBox\Models\FaqExampleModel;
class ChatBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = collect( require app_path(
            'Features/Domain/ChatBox/Database/Data/faq.php'
        ));
        foreach($datas as $item){
            $faq = FaqModel::create([
                'intent' => $item['intent'],
                'domain' => $item['domain'],
                'question' => $item['question'],
                'table' => $item['table']
            ]);
            foreach($item['examples'] as $faq_example){
                FaqExampleModel::create([
                    'faq_id' => $faq->id,
                    'example_question' => $faq_example,
                ]);
            }
        }
    }
}
