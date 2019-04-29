<?php

namespace App\Exports;

use App\Coin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class CoinExport implements FromView
{
    /**
    * @return \Illuminate\Support\FromView
    */
    public function view():View
    {
    	$data = DB::select("select t4.id,t4.name, t4.symbol, t4.market_cap, t4.price,  t4.type ,t5.cmc_rank, t4.last_updated from (select coin.id as id,coin.name as name, coin.symbol as symbol ,t3.q_price as price ,t3.q_type as type ,t3.q_market_cap as market_cap, t3.q_last_updated as last_updated  from (coin join (select quote.id_coin as q_id_coin, quote.last_updated as q_last_updated, quote.price as q_price,quote.volume_24h as q_volume_24h,quote.market_cap as q_market_cap,quote.type as q_type ,quote.percent_change_24h as q_percent_change_24h, quote.percent_change_7d as q_percent_change_7d from quote join (SELECT id_coin, MAX(last_updated) as updated FROM quote GROUP BY id_coin) t2 on quote.id_coin = t2.id_coin and quote.last_updated = t2.updated) t3 on coin.id=t3.q_id_coin) ) t4 join (select coin.id as id, coin.name as name, t3.d_cmc_rank as cmc_rank,t3.d_circulating_supply as circulating_supply from coin join (select detail.id_coin as id,detail.last_updated,detail.cmc_rank as d_cmc_rank,detail.circulating_supply as d_circulating_supply from detail join (SELECT id_coin, MAX(last_updated) as updated FROM detail GROUP BY id_coin) t2 on detail.id_coin = t2.id_coin and detail.last_updated = t2.updated ) t3 on t3.id = coin.id ) t5 on t4.id = t5.id order by t5.cmc_rank  OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY");
        $result = ['result' => $data];
        return view('excel',$result);
    }

    
}
