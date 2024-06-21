<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/move-top.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easing.js')}}"></script>
    @stack('head.style')
</head>
<body>
<!-- header -->
<div class="agileits_header">
    <div class="container">
        <div class="w3l_offers">
            <p>DAPATKAN PENAWARAN MENARIK KHUSUS HARI INI, <a href="">GUNAKAN JASA KAMI SEKARANG!</a></p>
        </div>
        <div class="agile-login">
            <ul>
                <li><a href=""> Daftar</a></li>
                <li><a href=""> Masuk</a></li>
            </ul>
        </div>
        <div class="product_list_header">
                <a href="#"><button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                 </a>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>

<div class="logo_products">
    <div class="container">
    <div class="w3ls_logo_products_left1">
            <ul class="phone_email">
                <li><i class="fa fa-phone" aria-hidden="true"></i>Hubungi Kami : (+6282) 123 456 789</li>
            </ul>
        </div>
        <div class="w3ls_logo_products_left">
            <h1><a href="index.php">OKE JASA</a></h1>
        </div>
    <div class="w3l_search">
        <form action="search.php" method="post">
            <input type="search" name="Search" placeholder="Cari produk...">
            <button type="submit" class="btn btn-default search" aria-label="Left Align">
                <i class="fa fa-search" aria-hidden="true"> </i>
            </button>
            <div class="clearfix"></div>
        </form>
    </div>

        <div class="clearfix"> </div>
    </div>
</div>
<!-- //header -->

