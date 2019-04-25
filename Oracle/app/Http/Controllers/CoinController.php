<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Coin;

class CoinController extends Controller
{

    public function getData(){
    	$coin = DB::select("select * from Coin ORDER BY ID OFFSET 10 ROWS FETCH NEXT 10 ROWS ONLY");
    		// echo "<pre>";
    		// var_dump($coin);
    		// echo "</pre>";
    	return view('list',compact('coin'));
    }

    // chỉ nên chạy 1 lần khi bắt đầu để khởi tạo giá trị coin
    public function getApi(){
    	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info';
    	
    	$stt = '1';
    	for ($i=2; $i <= 100; $i++) { 
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
	    	print_r(($response));
	    	echo "</pre>";
	    foreach ($response as $key => $value) {
	    	//insert into table coin in oracle:

	    	$id = $value->id;
	    	$name = $value->name;
	    	$symbol = $value->symbol;
	    	$category = $value->category;
	    	$logo = $value->logo;
			$description = $value->description;
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
	    	DB::insert("insert into Coin values($id, '$name', '$symbol', '$category', '$logo', '$description', TO_TIMESTAMP('$date_added', 'YYYY-MM-DD HH24:MI:SS.FF'))");
	    }
    }

    
}