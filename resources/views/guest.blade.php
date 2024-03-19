<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>PPOB New</title>
    <!-- /SEO Ultimate -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Latest compiled and minified CSS -->
    <link href="{{url('assets/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="./assets/js/bootstrap.min.js">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- StyleSheet link CSS -->
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/responsive.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <!--Header  -->
    <div class="banner_outer">
        <header>
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="/"><figure class="mb-0"><img src="./assets/images/logo.png" alt="" class="img-fluid"></figure></a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" 
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('about')}}">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('faq')}}">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link try_free_btn" href="{{route('login')}}">Try For Free</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <figure class="mb-0 bannersidelayer">
            <img src="./assets/images/banner-sidelayer.png" alt="">
        </figure>
        

        @yield('content')
<!-- Footer -->
<section class="footer-section">
    <div class="container">
        <div class="middle-portion">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                    <div class="icons">
                        <a href="/">
                            <figure class="footer-logo">
                                <img src="./assets/images/logo2.png" alt="">
                            </figure>
                        </a>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a> 
                            </li>
                            <li>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a> 
                            </li>
                            <li>
                                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a> 
                            </li>
                            <li>
                            <a href="#"><i class="fa-brands fa-pinterest"></i></a> 
                            </li>
                            <li>
                            <a href=""><i class="fa-brands fa-instagram"></i></a> 
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 d-lg-block d-none">
                    <div class="services">
                        <h3 class="heading">Services</h3>
                        <ul class="list-unstyled mb-0">
                            <li><a href="/#statistics" class=" text text-decoration-none">Statistics</a></li>
                            <li><a href="/#basic-feature" class=" text text-decoration-none">Basic Features</a></li>
                            <li><a href="./features.html#about-app" class=" text text-decoration-none">About App</a></li>
                            <li><a href="./pricing.html" class=" text text-decoration-none">Pricing</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 d-sm-block">
                    <div class="links">
                        <h3 class="heading">Quick Links</h3>
                        <ul class="list-unstyled mb-0">
                            <li><a href="/faq" class=" text text-decoration-none">FAQs</a></li>
                            <li><a href="/" class=" text text-decoration-none">Home</a></li>
                            <li><a href="/contact" class=" text text-decoration-none">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 d-md-block d-none">
                    <div class="aboutus">
                        <h3 class="heading">About Us</h3>
                        <ul class="list-unstyled mb-0">
                            <li><a href="/about" class=" text text-decoration-none">About Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-lower">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <p class="mb-0 text-size-18">© 2024 PPOB NEW. All Rights Reserved</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-md-block d-none">
                    <p class="mb-0 term text-size-18">Term of Use  |  Privacy Policy</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest compiled JavaScript -->
<script src="{{url('assets/js/jquery-3.6.0.min.js')}}"> </script>
<script src="{{url('assets/js/bootstrap.min.js')}}"> </script>
<script src="{{url('assets/js/video_link.js')}}"></script>
<script src="./assets/js/video.js"></script>
<script src="{{url('assets/js/counter.js')}}"></script>
<script src="{{url('assets/js/custom.js')}}"></script>
<script src="{{url('assets/js/animation_links.js')}}"></script>
<script src="{{url('assets/js/animation.js')}}"></script>
</body>
</html>