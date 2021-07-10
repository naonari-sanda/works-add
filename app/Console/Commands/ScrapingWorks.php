<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScrapingWorks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'スクレイピングでタウンワークから求人情報を取得';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->truncateTables();
        $this->saveUrls();
    }

    /**
     * 求人一覧ページのURLを取得しDBに保存
     *
     * @return void
     */
    private function truncateTables()
    {
        $this->info('Truncate実行');
        DB::table('jobs_urls')->truncate();
    }

    /**
     * 求人一覧ページのURLを取得しDBに保存
     *
     * @return void
     */
    private function saveUrls()
    {
        $this->info('スクレイピングを始めます');

        $page = 4;

        // 求人一覧ページを遷移する
        for ($i = 2; $page > $i; $i++) {

            // バイトルの求人一覧ページURL
            $url = 'https://www.baitoru.com/kanto/jlist/tokyo/23ku/' . 'page' . $i . '/';

            $this->info($url);
            $crawler = \Goutte::request('GET', $url);
            $urls = $crawler->filter('.li01 > h3 > a')->each(function ($node) {

                // 求人詳細URL
                $href = $node->attr('href');
                return [
                    'url' => substr($href, strpos($href, '/', 20)),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            });
            DB::table('jobs_urls')->insert($urls);
            
            // sleep(30);
        }
        $this->info('スクレイピング終了');
    }
}
