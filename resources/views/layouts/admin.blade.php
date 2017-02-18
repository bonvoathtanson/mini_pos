<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ប្រព័ន្ធគ្រប់គ្រងខ្សាច់</title>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="{{url('/css/plugin/sweet/sweetalert.css')}}" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="{{url('/css/base.css')}}" media="screen" title="no title" charset="utf-8">
  @yield('css')
</head>
<body>
    <div class="box-left">
      <div class="list-group">
        <a href="{{url('/')}}" class="list-group-item font-M1 center">ប្រព័ន្ធគ្រប់គ្រងខ្សាច់</a>
        <a href="{{url('/view/transfer')}}" class="list-group-item bar"><i class="fa fa-cart-plus" aria-hidden="true"></i> ទំនិញត្រូវដឹកចេញ <span class="badge badge2" style="display:none;">0</span></a>
        <a href="{{url('/view/askinfo')}}" class="list-group-item bar"><i class="fa fa-cart-plus" aria-hidden="true"></i> អ្នកសួរព័តមាន <span class="badge badge3" style="display:none;">0</span></a>
        <a href="{{url('/view/sale')}}" class="list-group-item bar"><i class="fa fa-cart-plus" aria-hidden="true"></i> ការលក់ចេញ</a>
        <a href="{{url('/view/import')}}" class="list-group-item bar"><i class="fa fa-download" aria-hidden="true"></i> ការទិញចូល</a>
        <a href="{{url('/view/customer')}}" class="list-group-item bar"><i class="fa fa-user-secret" aria-hidden="true"></i> អតិថិជន</a>
        <a href="{{url('/view/supplier')}}" class="list-group-item bar"><i class="fa fa-user-plus" aria-hidden="true"></i> អ្នកផ្គត់ផ្គង់</a>
        <a href="{{url('/view/income')}}" class="list-group-item bar"><i class="fa fa-money" aria-hidden="true"></i> ចំណូល</a>
        <a href="{{url('/view/expanse')}}" class="list-group-item bar"><i class="fa fa-share-alt-square" aria-hidden="true"></i> ចំណាយ</a>
        <a href="{{url('/view/item')}}" class="list-group-item bar"><i class="fa fa-shopping-bag" aria-hidden="true"></i> មុខទំនិញ</a>
        <a href="{{url('/view/user')}}" class="list-group-item bar"><i class="fa fa-users" aria-hidden="true"></i> គណនីអ្នកប្រើប្រាស់</a>
      </div>
    </div>
    <div class="box-left report">
      <div class="list-group">
        <a href="{{url('/')}}" class="list-group-item font-M1 center">ប្រព័ន្ធគ្រប់គ្រងខ្សាច់</a>
        <a href="{{url('/view/salereport')}}" class="list-group-item bar"><i class="fa fa-cart-plus" aria-hidden="true"></i> ការលក់ចេញ</a>
        <a href="{{url('/view/importreport')}}" class="list-group-item bar"><i class="fa fa-download" aria-hidden="true"></i> ការទិញចូល</a>
        <a href="{{url('/view/incomereport')}}" class="list-group-item bar"><i class="fa fa-money" aria-hidden="true"></i> ចំណូល</a>
        <a href="{{url('/view/expansereport')}}" class="list-group-item bar"><i class="fa fa-share-alt-square" aria-hidden="true"></i> ចំណាយ</a>
      </div>
    </div>
    <div class="box-right">
        <header>
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header"><a class="navbar-brand" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
              <ul class="nav navbar-nav">
                  <li><a href="{{url('/')}}">ប្រតិបតិ្តការ</a></li>
                  <li><a href="{{url('/')}}">កំណត់ត្រាផ្សេងៗ</a></li>
                  <li><a href="{{url('/view/salereport')}}">របាយការណ៍</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('/view/timetransfer')}}"><i class="fa fa-bell-o" aria-hidden="true"></i> ទំនិញជិតអស់ស្តុក<span class="badge badge1">0</span></a></li>
                  <li><a href="{{url('/view/timetransfer')}}"><i class="fa fa-bell-o" aria-hidden="true"></i>អតិថិជនជំពាក់<span class="badge badge1">0</span></a></li>
                  <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> ចាកចេញ</a></li>
              </ul>
            </div>
        </nav>
      </header>
        <div class="box-content">
            @yield('content')
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" charset="utf-8"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="{{url('/script/plugin/sweet/sweetalert.min.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrapValidator.js')}}" charset="utf-8"></script>
<script src="{{url('/script/app.js')}}" charset="utf-8"></script>
@yield('script')
</html>
