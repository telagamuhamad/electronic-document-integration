@extends('admin.layouts.sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <style>
    .main-container {
      margin-left: 150px;
      display: flex;
      width: 100%;
      justify-content: center;
    }

    .image {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 500px;
      align-items: center;
    }
  </style>
</head>
<body>
  
</body>
</html>
@section('sidebar')
@section('content')
  <div class="main-container">
    <div class="image">
      <img src="{{ url('images/logo.png') }}" alt="">
    </div>
  </div>
@endsection