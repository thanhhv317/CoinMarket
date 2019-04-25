<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DetailController extends Controller
{
    public function getApi(){
    	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    	
		$parameters = [
		    'start' => '1',
		    'limit' => '5000',
		    'convert'=> 'USD',
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

	    	DB::insert("insert into detail values('', $id_Coin, $cmc_rank, '$num_market_pairs', '$circulating_supply', '$total_supply', '$max_supply', TO_TIMESTAMP('$last_updated', 'YYYY-MM-DD HH24:MI:SS.FF'))");
	    }
	    
	   
	}
}
