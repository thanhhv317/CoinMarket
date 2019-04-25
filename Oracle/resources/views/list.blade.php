@extends('master')
@section('content')
<section class="content-header">
  <h1>
    Top 100 loại tiền điện tử hàng đầu
    <small>Coin Market</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Layout</a></li>
    <li class="active">Top Coin</li>
  </ol>
  </section>
  <!-- Main content -->
  <section class="content">

  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Top 100</h3>
    </div>
    <div class="box-body">

      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Market Cap</th>
            <th scope="col">Price</th>
            <th scope="col">Volume (24h)</th>
            <th scope="col">Circulating Supply</th>
            <th scope="col">Change (24h)</th>
            <th scope="col">Price Graph(7d)</th>
          </tr>
        </thead>
        <tbody>
          <?php $stt=1; ?>
          @foreach($coin as $value)
          <tr>
            <th scope="row">{!! $stt !!}</th>
            <td><img src="{!! $value->logo !!}" class="logo-sprite" alt="Bitcoin" height="16" width="16">{!! $value->name !!}</td>
            <td>chưa có</td>
            <td>Chưa có</td>
            <td>Chưa có</td>
            <td>Chưa có</td>
            <td>Chưa có</td>
            <td>
              <canvas id="canvas" width="160" height="100"></canvas>
            </td>
          </tr>
          <?php $stt++; ?>
          @endforeach
        </tbody>
      </table>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
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