<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Masuk - Admin</title>

    <style>
        body {
            background-color: #DC4C64;
        }

        .main-container {
            width: 100%;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .title {
            font-size: 24px;
            margin-top: 150px;
            color: #FFFFFF;
            text-align: center;
        }

        .login-card {
            width: 50%;
            height: 50%;
            background-color: #F5F5F5;
            padding: 50px;
            border-radius: 30px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="title">
            <p>Masuk</p>
        </div>
        <div class="login-card">
            @if(session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{session('error')}}
                </div>
            @endif
            <form action="{{ route('do-login') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Masukkan username" name="username">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="password">
                </div>
                <button type="submit" class="btn btn-danger">Masuk</button>
              </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>