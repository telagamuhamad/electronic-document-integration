<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TGExpress - EDI</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        .callout-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .callout-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="{{ url('images/logo.png') }}" alt="" style="width: 150px; background-color: white"></a>
            </div>
            <div style="color: white;
                padding: 15px 50px 5px 50px;
                float: right;
                font-size: 16px;"> 
                {{ auth()->user()->name }} &nbsp; <a href="{{ route('logout') }}" class="btn btn-danger square-btn-adjust">Logout</a> 
            </div>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="active-menu" href="{{ route('home') }}"><i class="fa fa-square-o fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fast-forward fa-3x"></i> Pengiriman<span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ route('admin.edi.delivery-order.index') }}">Permintaan Pengiriman</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.edi.good-return-note.index') }}">Tanda Terima</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.edi.invoice.index') }}">Invoice</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.edi.car.index') }}"><i class="fa fa-truck fa-3x"></i> Mobil</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.edi.travel-document.index') }}"><i class="fa fa-file-text fa-3x"></i> Surat Jalan</a>
                    </li>
                    @if (auth()->user()->role == 'Super Admin')
                        <li>
                            <a href="{{ route('admin.edi.user-access-management.index') }}"><i class="fa fa-desktop fa-3x"></i> Manajemen User</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
                <hr/>
            </div>
        </div>
    </div>

    <!-- JQUERY SCRIPTS -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @yield('scripts')


</body>

</html>
