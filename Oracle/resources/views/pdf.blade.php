<html>
<title>Coins</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
  body {
  	font-family: DejaVu Sans;
  }
  table{
  	font-size: 80%;
  }
</style>
<body>
  <h1><p style="text-align: center;">Top 100 Cryptocurrencies by Coin Market</p></h1>
  <br>
  <hr>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Rank</th>
      <th scope="col">Symbol</th>
      <th scope="col">Price</th>
      <th scope="col">Market Cap</th>
      <th scope="col">Last updated</th>
    </tr>
  </thead>
  <tbody>
    <?php $stt=1; ?>
    @foreach( $result as $value)
    <tr>
      <td>{!! $stt; !!}</td>
      <td>{!! $value->name !!}</td>
      <td>{!! $value->cmc_rank !!}</td>
      <td>{!! $value->symbol !!}</td>
      <td>{!! $value->price !!}</td>
      <td>{!! $value->market_cap !!}</td>
      <td>{!! $value->last_updated !!}</td>
    </tr>
    <?php $stt++ ?>
   @endforeach
  </tbody>
</table>
</body>
</html>