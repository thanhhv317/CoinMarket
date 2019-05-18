<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('inspire')
        //     ->everyFiveMinutes()
        //     ->appendOutputTo('C:\inspire.txt');


        // $schedule->call(function(){
        //     print_r('hello world');
        // })->everyFiveMinutes();

        $schedule->call(function(){
            $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
            
            $parameters = [
                'start' => '1',
                'limit' => '5000',
                'convert'=> 'USD',
            ];

            $headers = [
                'Accepts: application/json',
                'X-CMC_PRO_API_KEY: 7e2a787e-2728-4cf9-8809-6004000d91d6'
            ];
            $qs = http_build_query($parameters);
            $request = "{$url}?{$qs}"; // create the request URL


            $curl = curl_init(); // Get cURL resource
            // Set cURL options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_HTTPHEADER => $headers,     // set the headers 
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
            ));

            $response = curl_exec($curl); // Send the request, save the response
            curl_close($curl); // Close request
            $response = json_decode($response);
            $response = $response->data;
                // echo "<pre>";
                // print_r(($response));
                // echo "</pre>";

            foreach($response as $key=>$value){
                $id_Coin = $value->id;
                $cmc_rank = $value->cmc_rank;
                $num_market_pairs = $value->cmc_rank;
                $circulating_supply = $value->circulating_supply;
                $total_supply = $value->total_supply;
                $max_supply = $value->max_supply;
                $last_updated = $value->last_updated;

                for($i=0;$i<(strlen($last_updated));++$i){
                    if($last_updated[$i]=='T'|| $last_updated[$i]=='Z'){
                        $last_updated[$i]=' ';
                    }
                }

                $type = 'USD';
                $price = $value->quote->USD->price;
                $volume_24h = $value->quote->USD->volume_24h;
                $percent_change_1h = $value->quote->USD->percent_change_1h;
                $percent_change_24h = $value->quote->USD->percent_change_24h;
                $percent_change_7d = $value->quote->USD->percent_change_7d;
                $market_cap = $value->quote->USD->market_cap;
                
                $last_updated_q = $value->quote->USD->last_updated;

                for($i=0;$i<(strlen($last_updated_q));++$i){
                    if($last_updated_q[$i]=='T'|| $last_updated_q[$i]=='Z'){
                        $last_updated_q[$i]=' ';
                    }
                }

                DB::insert("insert into detail values('', $id_Coin, $cmc_rank, '$num_market_pairs', '$circulating_supply', '$total_supply', '$max_supply', TO_TIMESTAMP('$last_updated', 'YYYY-MM-DD HH24:MI:SS.FF'))");
                DB::insert("insert into quote values('', $id_Coin, '$type', '$price', '$volume_24h', '$percent_change_1h', '$percent_change_24h', '$percent_change_7d', '$market_cap', TO_TIMESTAMP('$last_updated_q', 'YYYY-MM-DD HH24:MI:SS.FF'))");
            }
        })->everyThirtyMinutes();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
