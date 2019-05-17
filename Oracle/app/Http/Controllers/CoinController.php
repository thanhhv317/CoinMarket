<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Coin;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CoinExport;

class CoinController extends Controller
{

    public function getData(){
    	$coin = DB::select("select t4.id,t4.name, t4.logo, t4.market_cap, t4.price, t4.volume_24h, t4.percent_change_24h, t4.percent_change_7d, t5.cmc_rank, t5.circulating_supply from (select coin.id as id,coin.name as name, coin.logo as logo,t3.q_price as price,t3.q_volume_24h as volume_24h ,t3.q_market_cap as market_cap,t3.q_percent_change_24h as percent_change_24h,t3.q_percent_change_7d as percent_change_7d from (coin join (select quote.id_coin as q_id_coin, quote.last_updated, quote.price as q_price,quote.volume_24h as q_volume_24h, quote.market_cap as q_market_cap ,quote.percent_change_24h as q_percent_change_24h, quote.percent_change_7d as q_percent_change_7d from quote join (SELECT id_coin, MAX(last_updated) as updated FROM quote GROUP BY id_coin) t2 on quote.id_coin = t2.id_coin and quote.last_updated = t2.updated) t3 on coin.id=t3.q_id_coin) ) t4 join (select coin.id as id, coin.name as name, t3.d_cmc_rank as cmc_rank, t3.d_circulating_supply as circulating_supply from coin join (select detail.id_coin as id, detail.last_updated ,detail.cmc_rank as d_cmc_rank ,detail.circulating_supply as d_circulating_supply from detail join (SELECT id_coin, MAX(last_updated) as updated FROM detail GROUP BY id_coin) t2 on detail.id_coin = t2.id_coin and detail.last_updated = t2.updated ) t3 on t3.id = coin.id ) t5 on t4.id = t5.id order by t5.cmc_rank OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY");

    	$graph = DB::select("select quote.id_coin, quote.percent_change_24h from quote where quote.id_coin in (select coin.id from coin ) order by quote.id_coin, quote.last_updated");
    		
    	$info_Coin = $this->getInfoCoin();

    	return view('list',compact('coin','info_Coin','graph'));
    	//return view('testTable');
    }

    // chỉ nên chạy 1 lần khi bắt đầu để khởi tạo giá trị coin
    public function getApi(){
    	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info';
    	
    	$stt = '1';
    	for ($i=2; $i <= 1000; $i++) { 
    		if($i != 251) 
    			$stt.=','.$i;
    	}

		$parameters = [
		    'id'=>$stt,
		];

		$headers = [
		    'Accepts: application/json',
		    'X-CMC_PRO_API_KEY: 4185a840-95a0-48f3-8e8b-14f33f27814c'
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
			echo "<pre>";
	    	//print_r(($response));
	    	echo "</pre>";
	    foreach ($response as $key => $value) {
	    	//insert into table coin in oracle:

	    	$id = $value->id;
	    	$name = $value->name;
	    	$symbol = $value->symbol;
	    	$category = $value->category;
	    	$logo = $value->logo;
			$description = $value->description;
			$websites = $value->urls->website;
			$website = json_encode($websites);

			$explorers = $value->urls->explorer;
			$explorer = json_encode($explorers);
			

			// nếu trong phần description có dấu ' thì sẽ ko insert đc
	    	$description = str_replace("'",'',$description);
	    	$date_added = $value->date_added;

	    	// vì timestamp trong API là 2013-04-28T00:00:00.000Z
	    	// mà trong oracle ghi có chữ T và Z là ko được
	    	// nên phải loại bỏ bằng hàm dưới

	    	for($i=0;$i<(strlen($date_added));++$i){
	    		if($date_added[$i]=='T'|| $date_added[$i]=='Z'){
	    			$date_added[$i]=' ';
	    		}
	    	}

	    	DB::insert("insert into Coin values($id, '$name', '$symbol', '$category', '$logo','$website','$explorer' , '$description', TO_TIMESTAMP('$date_added', 'YYYY-MM-DD HH24:MI:SS.FF'))");
	    }
    }
    public function getInfoCoin(){
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
		return $response;

    }

    public function getInfo($id){
    	$data = DB::select("select coin.*,d.cmc_rank,d.num_market_pairs,d.circulating_supply, d.total_supply, d.max_supply,d.last_updated, q.type, q.price, q.volume_24h, q.percent_change_1h, q.percent_change_24h, q.percent_change_7d, q.market_cap, q.last_updated from coin join detail d on coin.id = d.id_coin join quote q on coin.id =q.id_coin and d.id_coin =q.id_coin where coin.id= $id order by q.last_updated desc");
    	$coin = DB::select("select t4.id,t4.name, t4.logo, t4.symbol, t4.category, t4.market_cap, t4.price, t4.volume_24h, t4.type , t4.percent_change_24h, t4.percent_change_7d,t5.cmc_rank,t5.circulating_supply,t4.last_updated from (select coin.id as id,coin.name as name, coin.logo as logo, coin.symbol as symbol, coin.category as category ,t3.q_price as price,t3.q_volume_24h as volume_24h ,t3.q_type as type ,t3.q_market_cap as market_cap, t3.q_last_updated as last_updated ,t3.q_percent_change_24h as percent_change_24h,t3.q_percent_change_7d as percent_change_7d from (coin join (select quote.id_coin as q_id_coin, quote.last_updated as q_last_updated, quote.price as q_price,quote.volume_24h as q_volume_24h,quote.market_cap as q_market_cap,quote.type as q_type ,quote.percent_change_24h as q_percent_change_24h, quote.percent_change_7d as q_percent_change_7d from quote join (SELECT id_coin, MAX(last_updated) as updated FROM quote GROUP BY id_coin) t2 on quote.id_coin = t2.id_coin and quote.last_updated = t2.updated) t3 on coin.id=t3.q_id_coin) ) t4 join (select coin.id as id, coin.name as name, t3.d_cmc_rank as cmc_rank,t3.d_circulating_supply as circulating_supply from coin join (select detail.id_coin as id,detail.last_updated,detail.cmc_rank as d_cmc_rank,detail.circulating_supply as d_circulating_supply from detail join (SELECT id_coin, MAX(last_updated) as updated FROM detail GROUP BY id_coin) t2 on detail.id_coin = t2.id_coin and detail.last_updated = t2.updated ) t3 on t3.id = coin.id ) t5 on t4.id = t5.id order by t5.cmc_rank OFFSET 0 ROWS FETCH NEXT 15 ROWS ONLY");
    	$history = DB::select("select * from quote where id_coin = $id order by last_updated DESC");
    	return view('coininfo',compact('data','coin','history'));
    }

    public function generatePDF(){
        $coin = DB::select("select t4.id,t4.name, t4.symbol, t4.market_cap, t4.price,  t4.type ,t5.cmc_rank, t4.last_updated from (select coin.id as id,coin.name as name, coin.symbol as symbol ,t3.q_price as price ,t3.q_type as type ,t3.q_market_cap as market_cap, t3.q_last_updated as last_updated  from (coin join (select quote.id_coin as q_id_coin, quote.last_updated as q_last_updated, quote.price as q_price,quote.volume_24h as q_volume_24h,quote.market_cap as q_market_cap,quote.type as q_type ,quote.percent_change_24h as q_percent_change_24h, quote.percent_change_7d as q_percent_change_7d from quote join (SELECT id_coin, MAX(last_updated) as updated FROM quote GROUP BY id_coin) t2 on quote.id_coin = t2.id_coin and quote.last_updated = t2.updated) t3 on coin.id=t3.q_id_coin) ) t4 join (select coin.id as id, coin.name as name, t3.d_cmc_rank as cmc_rank,t3.d_circulating_supply as circulating_supply from coin join (select detail.id_coin as id,detail.last_updated,detail.cmc_rank as d_cmc_rank,detail.circulating_supply as d_circulating_supply from detail join (SELECT id_coin, MAX(last_updated) as updated FROM detail GROUP BY id_coin) t2 on detail.id_coin = t2.id_coin and detail.last_updated = t2.updated ) t3 on t3.id = coin.id ) t5 on t4.id = t5.id order by t5.cmc_rank  OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY");
        $result = ['result' => $coin];
        $pdf = PDF::loadView('pdf', $result);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $name= 'Report'.date("d-m-Y").date('-h-i-sa');
        return $pdf->download($name.'.pdf');
    }

    public function exportExcel(){
    	$name= 'Report'.date("d-m-Y").date('-h-i-sa');
    	return Excel::download(new CoinExport(), $name.'.xlsx');
    }

    
}