<!DOCTYPE html>
<html>
  <head>
    @include('pages.header')
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="{!! url('coinMarket/coin/list') !!}" class="navbar-brand"><b>Coin</b>Market</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tool <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{!! url('coinMarket/coin/generate-pdf') !!}">Generate PDF file</a></li>
                    <li class="divider"></li>
                    <li><a href="{!! url('coinMarket/coin/export-excel') !!}">Export Excel file</a></li>
                  </ul>
                </li>
              </ul>
              
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          @yield('content')
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    @include('pages.footer')
  </body>
</html>
