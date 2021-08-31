<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JobsUrl;
use App\Models\Job;

class ScrapingWorks extends Command
{
    const HOST = 'https://www.baitoru.com/kanto/jlist/tokyo/23ku';

    // データ挿入時デフォルトのstatue_id
    const STATUE_ID = 1;
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
        // $this->truncateTables();
        // $this->saveUrls();
        $this->saveJobs();
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
        DB::table('jobs')->truncate();
    }

    /**
     * 求人一覧ページのURLを取得しDBに保存
     *
     * @return void
     */
    private function saveUrls()
    {
        $this->info('スクレイピングを始めます');

        $page = 3;

        // 求人一覧ページを遷移する
        for ($i = 2; $page > $i; $i++) {

            // バイトルの求人一覧ページURL
            $url = $this::HOST . '/page' . $i . '/';

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

    /**
     * 求人詳細をスクレイピング
     */
    private function saveJobs()
    {
        $this->info('求人詳細をスクレイピング開始');


        
    
        foreach (JobsUrl::all() as $jobs_url) {
            $url =  $this::HOST . $jobs_url->url;
            $this->info($url);
            
            $crawler = \Goutte::request('GET', $url);

            $tell = $this->getContact($crawler);

            $this->info($tell);

            Job::create([
            'url' => $url,
            'title' => $this->getTitle($crawler),
            'company_name' => $this->getCompanyName($crawler),
            'place' => $this->getWorkPlace($crawler),
            'tell' => $this->getContact($crawler),
            'salary' => $this->getSalary($crawler),
            'salary_detail' => $this->getSalaryDetail($crawler),
            'hours' => $this->getHours($crawler),
            'hours_detail' => $this->getHoursDetail($crawler), // 求人によってはな,
            'features' => $this->getFeatures($crawler), // 求人によってはな,
            'detail' => $this->getDetail($crawler),
            'treatment' => $this->getTreatment($crawler),
            'qualification' => $this->getQualification($crawler),
            'file' => $this->getFile($crawler),
            'location' => $this->getLocation($crawler),
            'status_id' => self::STATUE_ID
            ]);

            sleep(1);
        }
    }

    /**
     * タイトル取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getTitle($crawler): string
    {
        return $crawler->filter('.pt02 > h2')->text();
    }

    /**
     * 会社名取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getCompanyName($crawler): string
    {
        return $crawler->filter('.detail-entryInfo .dl01 > dd > p')->text();
    }

    /**
     * 電話番号を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getContact($crawler): string
    {
        return $crawler->filter('#tel_modal_obotel_text')->text();
    }

    /**
     * 交通情報を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getWorkPlace($crawler): string
    {
        return $crawler->filter('.js-detailAccordion dd dl:first-of-type dd')->text();
    }

    /**
     * 貸与を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getSalary($crawler): string
    {
        return $crawler->filter('.js-detailAccordion dd ul:last-of-type em')->text();
    }

    /**
     * 貸与詳細を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getSalaryDetail($crawler): string
    {
        return $crawler->filter('.js-detailAccordion dd .js-da-target')->text();
    }

    /**
     * 勤務時間を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getHours($crawler): string
    {
        return $crawler->filter('.dl03 dd .ul02 em')->text();
    }

    /**
     * 勤務時間詳細を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getHoursDetail($crawler): string
    {
        $check = $crawler->filter('.dl03 dd .ul03 .js-da-target');
        
        // 取得先があるかチェック
        if (!$check->count()) {
            return '上記時間内';
        }
        return $check->text();
    }

    /**
     * 求人特徴を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getFeatures($crawler): string
    {
        $check = $crawler->filter('.detail-recruitInfo .pt01 .dl09 dd > p');

        // 取得先があるかチェック
        if (!$check->count()) {
            return '大募集中！！';
        }
        return $check->text();
    }

    /**
     * 求人詳細を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getDetail($crawler): string
    {
        return $crawler->filter('.detail-recruitInfo .pt01 .dl01 dd > p')->text();
    }

    /**
     * 応募資格を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getTreatment($crawler): string
    {
        return $crawler->filter('.detail-recruitInfo .pt01 .dl05 dd > p')->text();
    }

    /**
     * 待遇を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getQualification($crawler): string
    {
        return $crawler->filter('.detail-recruitInfo .pt01 .dl06 dd > p')->text();
    }

    /**
     * 画像を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getFile($crawler): string
    {
        $check = $crawler->filter('.detail-basicInfo .pt01b .ul01 .js-ic-bigImage img');

        // 取得先があるかチェック
        if (!$check->count()) {
            return '';
        }
        return 'https:' . $check->attr('data-replaceimage');
    }

    /**
     * 所在地を取得
     *
     * @param  object $crawler
     * @return string
     */
    private function getLocation($crawler): string
    {
        return $crawler->filter('.detail-companyInfo .bg01 .pt03 dl:first-of-type dd > p')->text();
    }
}
