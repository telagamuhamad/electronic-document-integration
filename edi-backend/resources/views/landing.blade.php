<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <title>TGExpress Portal</title>

    <style>

        body {

            background-color: #F5F5F5;
        }

        .main-container {
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .header-container {
            background-color: #FFFFFF;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0px 20px;
        }

        .header-container img {
            width: 250px;
        }

        .content-container {
            height: 100%;
        }

        .content {
            padding: 20px;
        }

        .running-welcome-text {
            text-align: center;
            font-size: 24px;
        }

        .carousel-inner img {
            width: 1196px;
            height: 359px;
            padding: 20px;
            margin-left: 120px;
        }

        .card {
            border-radius: 20px;
        }

        .card-body {
            text-align: center;
            border-radius: 50px;
        }

        .footer {
            background-color: #DC4C64;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 10px;
        }

        .footer p {
            text-align: center;
            color: #FFFFFF;
            font-size: 14px;
            margin: 0;
        }

        .our-services {
            margin-bottom: 30px;
        }

        .contact-section {
            padding-bottom: 30px;
        }

        .social-media {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            padding-top: 10px;
            border-radius: 20px;
            background-color: #FFFFFF;
        }
    
        .social-media img {
            width: 30px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header-container" id="header">
            <div class="company-logo">
                <img src="{{ url('images/logo.png') }}" alt="">
            </div>
            <div class="login-button">
                <a href="{{ route('login') }}" class="btn btn-danger">Masuk</a>
            </div>
        </div>
        <div class="content-container">
            <div class="running-welcome-text" style="background-color: #DC4C64; color: #FFFFFF;">
                <marquee behavior="" direction="">Selamat datang di TGExpress Portal</marquee>
            </div>
            <div id="carousel" class="carousel slide" data-bs-ride="carousel" style="background-color: #DC4C64; padding-bottom: 20px;">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ url('images/delivery1.png') }}">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ url('images/delivery2.jpeg') }}">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ url('images/delivery3.jpeg') }}">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="content">
                <div class="search-resi-section">
                    <form action="{{ route('landing') }}" method="GET" id="search-form" enctype="multipart/form-data" style="padding: 20px">
                        <div class="mb-3">
                            <section>
                                <div class="input-group mb-3" style="padding: 20px">
                                    <input type="text" class="form-control" placeholder="Masukkan nomor resi Anda" name="resi" id="resi">
                                    <button class="btn btn-danger" type="submit" id="button-addon2">Cari</button>
                                  </div>
                            </section>
                      </form>
                </div>
                <div class="delivery-order-section">
                    @if(!empty($delivery_order))
                        <h3>Data Delivery Order</h3>
                        <div class="card">
                            <div class="card-body" style="text-align: left">
                                <p><strong>Sender Name:</strong> {{ $delivery_order->sender_name }}</p>
                                <p><strong>Receiver Name:</strong> {{ $delivery_order->receiver_name }}</p>
                                <p><strong>Status:</strong> {{ $delivery_order->status }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="our-services">
                    <h3 style="text-align: center">Layanan Kami</h3>
                    <div class="row">
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Pengiriman Barang</h5>
                              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Pengembalian Barang</h5>
                              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="contact-section">
                    <h3 style="text-align: center">Kontak Kami</h3>
                    <div class="social-media">
                        <div class="phone" style="display: flex; flex-direction: column; align-items: center">
                            <img src="{{ url('icons/phone-call.png') }}" alt="">
                            <p>0812-1234-5678</p>
                        </div>
                        <div class="email" style="display: flex; flex-direction: column; align-items: center">
                            <img src="{{ url('icons/mail.png') }}" alt="">
                            <p>KXNpH@example.com</p>
                        </div>
                        <div class="whatsapp" style="display: flex; flex-direction: column; align-items: center">
                            <img src="{{ url('icons/whatsapp.png') }}" alt="">
                            <p>0812-1234-5678</p>
                        </div>
                        <div class="telegram" style="display: flex; flex-direction: column; align-items: center">
                            <img src="{{ url('icons/telegram.png') }}" alt="">
                            <p>0812-1234-5678</p>
                        </div>
                        <div class="instagram" style="display: flex; flex-direction: column; align-items: center">
                            <img src="{{ url('icons/instagram.png') }}" alt="">
                            <p>TGExpress</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>Tebu Giling Express© 2023</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>