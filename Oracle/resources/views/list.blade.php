@extends('master')
@section('content')
<section class="content-header">
	<h1>
		Top 100 Các loại tiền điện tử theo vốn hóa thị trường
		<small>Coin Market</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{!! url('coinMarket/coin/list') !!}"><i class="fa fa-dashboard"></i> Coin Market</a></li>
		<li class="active">Top Coin</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header">
                  <h3>&nbsp;<i class="fa fa-usd"></i> TOP 100 TIỀN ĐIỆN TỬ</h3>
                </div><!-- /.box-header -->
                <hr>
                <div class="table-responsive">
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th >#</th>
            						<th >Name</th>
            						<th >Market Cap</th>
            						<th >Price</th>
            						<th class="text-center" >Volume (24h)</th>
            						<th >Circulating Supply</th>
            						<th >Change (24h)</th>
            						<!-- <th >Price Graph(7d)</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      	<?php 
                      	$stt=1;
                        ?>
                        @foreach($coin as $value)
                        <tr class="table-flag-blue">
                          <th scope="row">{!! $stt !!}</th>
                          <td><img src="{!! $value->logo !!}" class="logo-sprite" alt="Bitcoin" height="16" width="16">&nbsp;<a style="color: black;" href="{!! URL('coinMarket/coin/info/'.$value->id) !!}" >{!! $value->name !!}</a></td>
                          <td id='market_cap'>${!! $value->market_cap !!}</td>
                          <td id='price'>
                          <a>
                            {!! isset($value->price) ? $value->price : '<a>đang cập nhật...</a>' !!}
                          </a>
                          </td>
                          <td id='volume_24h'>
                            <a>
                            {!! isset($value->volume_24h) ? $value->volume_24h : 'đang cập nhật...' !!}
                            </a>
                          </td>
                          <td id='circulating_supply'>{!! $value->circulating_supply !!}</td>
                          <td id='change_24h'>
                            @if((float)$value->percent_change_24h <=0)
                              <p style="color: red;">{!! $value->percent_change_24h !!} %</p>
                            @else
                              <p style="color: green;">{!! $value->percent_change_24h !!} %</p>
                            @endif
                            
                          </td>
                          <!-- <td id='price_graph_7d'>
                            <canvas id="canvas" width="160" height="80"></canvas>
                          </td> -->
                          
                           <?php $stt++; ?>               
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div>
              </div><!-- /.box -->
    	</div><!-- /.col -->
  	</div><!-- /.row -->
</section><!-- /.content -->
<script>
var canvas = document.getElementById('canvas'),
  context = canvas.getContext('2d'),
  width = canvas.width = 160,
  height = canvas.height = 80;

  //var stats = [40,50,70,80,5,80,7,10];
  var stats = [0,-6,3,6,10,2,-6,4];

  context.translate(0, height);
  context.scale(1, -1);

  context.fillStyle = '#f6f6f6';
  context.fillRect(0, 0, width, height);

  var left = 0,
      prev_stat = stats[0],
      move_left_by = 20;

  for(stat in stats) {
    the_stat = stats[stat];

    context.beginPath();
    context.moveTo(left, prev_stat);
    context.lineTo(left+move_left_by, the_stat);
    context.lineWidth = 1;
    context.lineCap = 'round';

    context.stroke();

    prev_stat = the_stat;
    left += move_left_by;

  }
</script>

@endsection()