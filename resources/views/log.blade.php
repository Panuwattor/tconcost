<!-- 
PROJECT: Medic | Medical HTML Template
VERSION: 1.0.0
AUTHOR: Themefisher
WEBSITE: https://themefisher.com
-->

<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- ** Basic Page Needs ** -->
    <meta charset="utf-8">
    <title>TCON COST</title>

    <!-- ** Mobile Specific Metas ** -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Medical HTML Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Medical HTML Template v1.0">

    <!-- ** Plugins Needed for the Project ** -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="plugins/slick/slick.css">
    <link rel="stylesheet" href="plugins/slick/slick-theme.css">
    <!-- FancyBox -->
    <link rel="stylesheet" href="plugins/fancybox/jquery.fancybox.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <!-- animate.css -->
    <link rel="stylesheet" href="plugins/animation/animate.min.css">
    <!-- jquery-ui -->
    <link rel="stylesheet" href="plugins/jquery-ui/jquery-ui.css">
    <!-- timePicker -->
    <link rel="stylesheet" href="plugins/timePicker/timePicker.css">

    <!-- Stylesheets -->
    <link href="css/style.css" rel="stylesheet">

    <!--Favicon-->
    <link rel="icon" href="icon.jpg" type="image/x-icon">

</head>


<body>

    <div class="page-wrapper">
        <section class="header-uper">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-3">
                        <div class="logo">
                            <a href="index.html">
                                <img loading="lazy" class="img-fluid" src="images/logo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-9">
                        <div class="right-side">
                            <ul class="contact-info pl-0 mb-4 mb-md-0">
                                <li class="item text-left">
                                    <div class="icon-box">
                                        <i class="far fa-envelope"></i>
                                    </div>
                                    <strong>Email</strong>
                                    <br>
                                    <a href="mailto:info@medic.com">
                                        <span>info@medic.com</span>
                                    </a>
                                </li>
                                <li class="item text-left">
                                    <div class="icon-box">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <strong>Call Now</strong>
                                    <br>
                                    <span>+ (88017) - 123 - 4567</span>
                                </li>
                            </ul>
                            <div class="link-btn text-center text-lg-right">
                                <!-- <a href="#" class="btn-style-one">LOGIN</a> -->
                                <button type="button" class="btn-style-one" data-toggle="modal" data-target="#exampleModalCenter"> LOGIN</button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">LOGIN</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                                                <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
                                                <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                                <!------ Include the above in your HEAD tag ---------->

                                                <div class="wrapper fadeInDown">


                                                    <div id="formContent">
                                                        <!-- Tabs Titles -->

                                                        <!-- Icon -->
                                                        <div class="fadeIn first">
                                                            <div class="col-sm-6 col-md-6">
                                                                <img src="icon.jpg" id="icon" alt="User Icon">
                                                            </div>
                                                        </div>

                                                        <!-- Login Form -->
                                                        <form method="POST" action="{{ route('login') }}">
                                                            @csrf
                                                            <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email">
                                                            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
                                                            <input type="submit" style="cursor: grab;" class="fadeIn fourth" value="Log In">
                                                        </form>

                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarLinks" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarLinks">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">หน้าหลัก</a>
                        </li>
                        <li class="nav-item @@about">
                            <a class="nav-link" href="https://tconhouse.com/">สินค้า</a>
                        </li>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item @@blog" href="blog.html">Blog</a></li>
                            <li><a class="dropdown-item @@blogDetails" href="blog-details.html">Blog Details</a></li>
                            <li class="dropdown dropdown-submenu dropright">
                                <a class="dropdown-item dropdown-toggle" href="#!" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="index.html">Submenu 01</a></li>
                                    <li><a class="dropdown-item" href="index.html">Submenu 02</a></li>
                                </ul>
                            </li>
                        </ul>
                        </li>
                        <li class="nav-item @@contact">
                            <a class="nav-link" href="https://tconbuild.com/">สร้างบ้าน</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="hero-slider">
            <!-- Slider Item -->
            <div class="slider-item slide1" style="background-image:url(images/slider/slider-bg-1.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Slide Content Start -->
                            <div class="content style text-center">
                                <h2 class="text-white text-bold mb-2" data-animation-in="slideInLeft">TCON HOUSE</h2>
                                <p class="tag-text mb-4" data-animation-in="slideInRight">จำหน่าย "อุปกรณ์เครื่องมือช่าง วัสดุก่อสร้าง เครื่องใช้ไฟฟ้า ครบที่สุดในอำเภอราษีไศล จังหวัดศรีสะเกษ" <br> สนใจติดต่อ 045-691-999</p>
                                <a href="https://tconhouse.com/category" class="btn btn-main btn-white" data-animation-in="slideInLeft" data-duration-in="1.2">ไปที่เว็บไซต์ TCON HOUSE</a>
                            </div>
                            <!-- Slide Content End -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-item slide1" style="background-image:url(images/slider/slider-bg-4.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Slide Content Start -->
                            <div class="content style text-center">
                                <h2 class="text-white text-bold mb-2" data-animation-in="slideInLeft">"WINDOW WIDE"</h2>
                                <p class="tag-text mb-4" data-animation-in="slideInRight">"รับทำโครงสร้างหลังคาเเบบสำเร็จรูป" <br> สนใจติดต่อ 045-691-999</p>
                                <a href="https://www.facebook.com/WindowWideWW" class="btn btn-main btn-white" data-animation-in="slideInLeft" data-duration-in="1.2">ติดต่องาน WINDOW WIDE</a>
                            </div>
                            <!-- Slide Content End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slider Item -->
            <div class="slider-item" style="background-image:url(images/slider/slider-bg-2.jpg);">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Slide Content Start-->
                            <div class="content style text-center">
                                <h2 class="text-white" data-animation-in="slideInRight">Smart Hat</h2>
                                <p class="tag-text mb-4" data-animation-in="slideInRight" data-duration-in="0.6">เป็นบริษัทรับทำโครงหลังคาสำเร็จรูป โดยวิศวะกร เเละสถาปนิก มืออาชีพ <br>ติดต่อ 063-905-4914  </p>
                                <a href="https://www.facebook.com/smarthatroof/photos/?ref=page_internal" class="btn btn-main btn-white" data-animation-in="slideInRight" data-duration-in="1.2">ติดต่องานโครงหลังคาสำเร็จรูป</a>
                            </div>
                            <!-- Slide Content End-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slider Item -->
            <div class="slider-item" style="background-image:url(images/slider/slider-bg-3.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <!-- Slide Content Start -->
                            <div class="content text-center style">
                                <h2 class="text-white text-bold mb-2" data-animation-in="slideInRight">TAWEECHAI CONCRETE</h2>
                                <p class="tag-text mb-4" data-animation-in="slideInLeft">บริษัท THAWEECHAI CONCRETE มีรถเทปูนซีเมนต์คุณภาพ มาตรฐานจาก SCG<br> ติดต่อ 097-343-1257  </p>
                                <a href="https://tconhouse.com/contact" class="btn btn-main btn-white" data-animation-in="slideInRight" data-duration-in="1.2">ติดต่องานปูนซีเมนต์ </a>
                            </div>
                            <!-- Slide Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        


        <!-- jquery -->
        <script src="plugins/jquery.min.js"></script>
        <!-- bootstrap -->
        <script src="plugins/bootstrap/bootstrap.min.js"></script>
        <!-- Slick Slider -->
        <script src="plugins/slick/slick.min.js"></script>
        <script src="plugins/slick/slick-animation.min.js"></script>
        <!-- FancyBox -->
        <script src="plugins/fancybox/jquery.fancybox.min.js" defer></script>
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <script src="plugins/google-map/gmap.js" defer></script>

        <!-- jquery-ui -->
        <script src="plugins/jquery-ui/jquery-ui.js" defer></script>
        <!-- timePicker -->
        <script src="plugins/timePicker/timePicker.js" defer></script>

        <!-- script js -->
        <script src="js/script.js"></script>
</body>

</html>