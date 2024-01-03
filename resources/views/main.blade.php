<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Home</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('style/assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styleassets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/scss/style.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    
    <script src="{{ asset('style/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('style/assets/js/main.js') }}"></script>
 
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="">Basis Data</a>
                <a class="navbar-brand hidden" href=""></a>
            </div>
 
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('home') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
                    <h3 class="menu-title">Master</h3><!-- /.menu-title -->
                
                    <li>
                        <a href="{{ url('role') }}"> <i class="menu-icon fa fa-user"></i>Role</a>
                    </li>
                    <li>
                        <a href="{{ url('user') }}"> <i class="menu-icon fa fa-user-plus"></i>User</a>
                    </li>
                    <li>
                        <a href="{{ url('satuan') }}"> <i class="menu-icon fa fa-file"></i>Satuan</a>
                    </li>
                    <li>
                        <a href="{{ url('barang') }}"> <i class="menu-icon fa fa-archive"></i>Barang</a>
                    </li>
                    <li>
                        <a href="{{ url('vendor') }}"> <i class="menu-icon fa fa-paperclip"></i>Vendor</a>
                    </li>

                </li>
                <h3 class="menu-title">Transaction</h3><!-- /.menu-title -->
                <li>

                    {{-- pangadaan --}}
                    <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Transaksi Pengadaan</a>
                    <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-plus-square"></i><a href="{{ url('pengadaan') }}">Pengadaan</a></li>
                            <li><i class="fa fa-plus-square"></i><a href="{{ url('detpengadaan') }}">Det. Pengadaan</a></li>
                    </ul>

                    {{-- penerimaan --}}
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Transaksi Penerimaan</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('penerimaan') }}">Penerimaan</a></li>
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('detpenerimaan') }}">Det. Penerimaan</a></li>
                    </ul>
                    
                    {{-- Retur --}}
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Transaksi Retur</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('retur') }}">Retur</a></li>
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('detretur') }}">Det. Retur</a></li>
                    </ul>

                    {{-- penjualan --}}
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list-alt"></i>Transaksi Penjualan</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('penjualan') }}">Penjualan</a></li>
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('detpenjualan') }}">Det. Penjualan</a></li>
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('margin') }}">Marg. Penjualan</a></li>
                        <li><i class="fa fa-plus-square"></i><a href="{{ url('kartustok') }}">Kartu Stok</a></li>
                    </ul>

            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
 
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="header-menu">
                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <div class="dropdown for-notification">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger">3</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red">You have 3 Notification</p>
                          </div>
                        </div>
                    </div>
                </div>
 
                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{ asset('style/images/admin.jpg') }}">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf <!-- CSRF protection -->
                                <button type="submit" class="nav-link" style="border: none; background: none; cursor: pointer;">Logout
                                </button>
                            </form>
                        </div>
                    </div>
 
                    <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                            <i class="flag-icon flag-icon-id"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="language" >
                            <div class="dropdown-item">
                                <span class="flag-icon flag-icon-id"></span>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-jp"></i>
                            </div>
                        </div>
                    </div>
 
                </div>
            </div>
 
        </header><!-- /header -->
        
        @yield('breadcrumbs')

        @yield('content')   
 
</body>
</html