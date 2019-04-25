<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $table ='Coin';
    protected $fillable =['id','name','symbol','rank','price_usd','price_btc','market_cap_usd','last_updated'];
  
}
