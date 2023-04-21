<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            font-family: "Lato", sans-serif;
            background-color: #F5F5F5F5;
        }

        .topnav {
            overflow: hidden;
            background-color: #FFFFFF;
        }

        .topnav img {
            width: 250px;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }

            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }


        .sidebar {
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #FFFFFF;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }
        
        .sidebar a.active {
            background-color: #DC4C64;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #DC4C64;
            color: white;
        }

        .user-logged {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        div.content {
            margin-left: 200px;
            padding: 1px 16px;
            height: 1000px;
        }

        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {float: left;}
                div.content {margin-left: 0;}
            }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <div class="topnav" id="myTopnav">
        <img src="{{ url('images/logo.png') }}" alt="">
    </div>

    {{-- Sidebar --}}
    @yield('sidebar')
        <div class="sidebar">
            <div class="user-logged">
                <marquee behavior="" direction="">Selamat Datang</marquee>
                <p>{{ $user->username }}</p>
            </div>
            <a class="active" href="#home">Dashboard</a>
            <a href="#news">Pengiriman</a>
            <a href="#contact">Riwayat</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a href="" type="submit">Logout</a>
            </form>
        </div>
    
    
    @yield('content')

    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>