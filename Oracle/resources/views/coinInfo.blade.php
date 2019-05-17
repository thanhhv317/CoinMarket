@extends('master')
@section('content')
<section class="content-header">
  <h1>
    <small>Coin Market</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{!! url('coinMarket/coin/list') !!}"><i class="fa fa-dashboard"></i> CoinMarket</a></li>
    <li class="active">Coin Infomation</li>
  </ol>
  </section>

<section class="content-header">
<div class="row">
    <div class="col-md-12">
        <div class="box box-green">
            <div class="box-title">
                <h3>&nbsp;<img src="{!! $data[0]->logo !!}" alt=""> {!! $data[0]->name !!} <a style="color: #9E9E9E">( {!! $data[0]->symbol !!} )</a></h3>
                <hr>
            </div>
            <div class="box-content">
                <br/>
                <br/>
                <!-- bắt đầu table -->
                <div class="table-responsive">
                	<div class="col-md-4">
                		<div >
                		<p><h3>$ {!! $data[0]->price !!}&nbsp;<a style="font-size: 50%">{!! $data[0]->type  !!}</a> @if((float)$data[0]->percent_change_24h <=0)
                                  <a style="color: red;">({!! $data[0]->percent_change_24h !!} %)</a>
                                @else
                                  <a style="color: green;">({!! $data[0]->percent_change_24h !!} %)</a>
                                @endif </h3></p>
                		<i class="fa fa-signal">&nbsp;<span class="label label-success"> rank {!! $data[0]->cmc_rank !!}</span></i>
                		</div>
                		
						<?php $website = json_decode($data[0]->website) ?>
						@foreach($website as $value)
						<div>
                		<i class="fa fa-chain (alias)">&nbsp;</i>
                			<a target="_blank" href="{!! $value !!}">website</a>
                		</div>
                		@endforeach
                		<?php $explorer = json_decode($data[0]->explorer); $i=1; ?>

						@foreach($explorer as $value)
						<div>
                		<i class="fa fa-search">&nbsp;</i>
                			<a target="_blank" href="{!! $value !!}">explorer {!! $i !!}</a>
                		</div>
                		<?php $i++; ?>
                		@endforeach
                		<div>
                		<i class="fa fa-tags">&nbsp;<span class="label label-warning">  {!! $data[0]->category !!}</span></i>
                		</div>
                	</div>
               		<div class="col-md-8">
               			<table class="table table-advance">
                        <thead>
                            <tr> 
                              <th >Market cap</th>
                              <th >Volume (24h)</th>
                              <th >Circulating Supply</th>
                              <th >Max Supply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-flag-blue">
								<td id='market_cap'>$ {!! $data[0]->market_cap  !!}&nbsp;{!! $data[0]->type  !!}</td>
								<td id='price'>$ {!! $data[0]->volume_24h  !!}&nbsp;{!! $data[0]->type  !!}</td>           
								<td id='price'>{!! $data[0]->circulating_supply  !!}&nbsp;{!! $data[0]->symbol  !!}</td>      
								<td id='price'>{!! $data[0]->max_supply  !!}&nbsp;{!! $data[0]->symbol  !!}</td>      
                            </tr>
                        </tbody>
                		</table>
                		<hr>
                		<h3>About {!! $data[0]->name !!}</h3>
                		<p>
                        	{!! $data[0]->description  !!}
                        </p>
               		</div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>



<section class="content-header">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3>&nbsp;<i class="fa fa-bullseye"></i> {!! $data[0]->name !!}</h3>
                <div class="box-tool">
                  
                </div>
            </div>
            <div class="box-content">

                <div class="row">
                    <div class="col-md-12">

                        <div class="tabbable">
                            <ul id="myTab1" class="nav nav-tabs">
                                <li class="active"><a href="#home1" data-toggle="tab"><i class="fa fa-bar-chart-o"></i> Charts</a>
                                </li>
                                <li><a href="#profile1" data-toggle="tab"><i class="fa fa-exchange"></i> Markets</a>
                                </li>
                            </ul>
                            <div class="table-responsive">
                            <div id="myTabContent1" class="tab-content">
                                <div class="tab-pane fade in active" id="home1">
                                    <div id="chartContainer" style="height: 300px; width: 100%;">
                                </div>
                                
                                <div class="tab-pane fade" id="profile1">
                                    <table class="table table-advance">
                                    <thead>
                                        <tr> 
                                          <th >#</th>
                                          <th >Source</th>
                                          <th >Pair</th>
                                          <th >Volume (24h)</th>
                                          <th >Price</th>
                                          <th >Change 24h (%)</th>
                                          <th >Category</th>
                                          <th >Fee Type</th>
                                          <th >Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; ?>
                                        @foreach ($coin as $value)
                                        <tr class="table-flag-blue">
                                            <th>{!! $i !!}</th> 
                                            <td><i><img src="{!! $value->logo !!}" class="logo-sprite"  height="16" width="16"></i><a style="color: black" href="{!! URL('coinMarket/coin/info/'.$value->id) !!}">{!! $value->name !!}</a></td> 
                                            <td><a>{!! $value->symbol !!}/{!! $value->type !!}</a></td> 
                                            <td>$ {!! $value->volume_24h !!}</td> 
                                            <td>$ {!! $value->price !!}</td> 
                                            @if((float)$value->percent_change_24h >=0)
                                            <td><p style="color: green">{!! $value->percent_change_24h !!}%</p></td>
                                            @else
                                            <td><p style="color: red">{!! $value->percent_change_24h !!}%</p></td>
                                            @endif 
                                            <td>{!! $value->category !!}</td> 
                                            <td>{!! $value->type !!}</td> 
                                            <td>
                                                {!! 
                                                  \Carbon\Carbon::createFromTimeStamp(strtotime($value->last_updated))->diffForHumans();
                                                !!}
                                            </td> 
                                        </tr>
                                        <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                    </table>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6"><a href="{!! Route('coinMarket.coin.list') !!}">Xem thêm</a></div>   
                                    
                                </div>
                            </div>
                                
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
</section>

<section class="content-header">
<div class="row">
    <div class="col-md-12">
        <div class="box box-green">
            <div class="box-title">
                <h3>&nbsp;HISTORY</h3>
                <hr>
            </div>
            <div class="box-content">
                <br/>
                <br/>
                <!-- bắt đầu table -->
                <div class="table-responsive">
                    <table class="table table-advance">
                    <thead>
                        <tr> 
                          <th >#</th>
                          <th >Volume (24h)</th>
                          <th >Price</th>
                          <th >Market cap</th>
                          <th >Change 1h (%)</th>
                          <th >Change 24h (%)</th>
                          <th >Change 7d (%)</th>
                          <th >Last updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($history as $value)
                        @if($i<=30)
                        <tr class="table-flag-blue">
                            <th>{!! $i !!}</th>
                            <td>$ {!! $value->volume_24h !!}</td> 
                            <td>$ {!! $value->price !!}</td> 
                            <td>{!! $value->market_cap !!}</td> 
                            @if((float) $value->percent_change_1h >=0)
                            <td><p style="color: green">{!! $value->percent_change_1h !!}%</p></td>
                            @else
                            <td><p style="color: red">{!! $value->percent_change_1h !!}%</p></td>
                            @endif
                            @if((float)$value->percent_change_24h >=0)
                            <td><p style="color: green">{!! $value->percent_change_24h !!}%</p></td>
                            @else
                            <td><p style="color: red">{!! $value->percent_change_24h !!}%</p></td>
                            @endif 
                            @if((float)$value->percent_change_7d >=0)
                            <td><p style="color: green">{!! $value->percent_change_7d !!}%</p></td>
                            @else
                            <td><p style="color: red">{!! $value->percent_change_7d !!}%</p></td>
                            @endif 
                            <td>{!! $value->last_updated !!}</td> 
                        </tr>
                        @endif
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        zoomEnabled: true,
        title:{
            text: "Market cap chart" 
        },
        axisY :{
            includeZero:false
        },
        data: data  // random generator below
    });
    chart.render();

    }

    var data = [];
    var dataSeries = { type: "line" };
    var dataPoints = [];
    @foreach($history as $value)
    <?php 
        $date = explode ( '-' , $value->last_updated);
        $day = explode ( ' ' , $date[2]);
        $time = explode ( ':' , $day[1]);
        
    ?>
        dataPoints.push({
            x: new Date({!! $date[0] .','. $date[1] .','.$day[0].','.$time[0].','.$time[1].','.$time[2] !!}),           
            y: {!! $value->market_cap !!}
        });
    @endforeach
    dataSeries.dataPoints = dataPoints;
    data.push(dataSeries);               

</script>
@endsection()