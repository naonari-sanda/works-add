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
    protected $signature = 'scrape:works';

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
        // バイトルの求人一覧ページURL
        $url = 'https://www.baitoru.com/kanto/jlist/tokyo/23ku/';

        $crawler = \Goutte::request('GET', $url);
        $urls = $crawler->filter('.li01 > h3 > a')->each(function ($node) {
            return [
                'url' => $node->attr('href'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            // $url = substr($href, strpos($href, '/', 20));
        });

        DB::table('jobs_urls')->insert($urls);
        return 0;
    }
}
