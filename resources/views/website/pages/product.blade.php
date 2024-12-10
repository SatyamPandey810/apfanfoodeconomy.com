<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Product</title>

    @include('website/include/head')



</head>

<div>

    @include('website/include/header')

    <div class="container-fluid bg-dark p-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 text-white">Product</h1>
                <a href="">Home</a>
                <i class="far fa-square text-primary px-2"></i>
                <a href="">Product</a>
            </div>
        </div>
    </div>
    <div class="container-fluid p-5" style="background-color: #82d682cc;">
        <div class="row">
            <div class="col-md-3 col-xl-3 col-sm-1">
                <div class="cards">
                    <div class="wrappers">
                        <div class="banner-image">
                            <img src="public/website/img/agriculture.jpg"/>
                    </div>
                        <h1> Toyota Supra</h1>
                        <p>Lorem ipsum dolor sit amet, <br />
                            consectetur adipiscing elit.</p>
                    </div>
                    <div class="button-wrapper d-flex">
                        <button class="btn fill">BUY NOW</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3 col-sm-1">
                <div class="cards">
                    <div class="wrappers">
                        <div class="banner-image">
                            <img src="public/website/img/agriculture.jpg"/>
                    </div>
                        <h1> Toyota Supra</h1>
                        <p>Lorem ipsum dolor sit amet, <br />
                            consectetur adipiscing elit.</p>
                    </div>
                    <div class="button-wrapper d-flex">
                        <button class="btn fill">BUY NOW</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3 col-sm-1">
                <div class="cards">
                    <div class="wrappers">
                        <div class="banner-image">
                            <img src="public/website/img/agriculture.jpg"/>
                    </div>
                        <h1> Toyota Supra</h1>
                        <p>Lorem ipsum dolor sit amet, <br />
                            consectetur adipiscing elit.</p>
                    </div>
                    <div class="button-wrapper d-flex">
                        <button class="btn fill">BUY NOW</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3 col-sm-1">
                <div class="cards">
                    <div class="wrappers">
                        <div class="banner-image">
                            <img src="public/website/img/agriculture.jpg"/>
                    </div>
                        <h1> Toyota Supra</h1>
                        <p>Lorem ipsum dolor sit amet, <br />
                            consectetur adipiscing elit.</p>
                    </div>
                    <div class="button-wrapper d-flex">
                        <button class="btn fill">BUY NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('website/include/footer')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{asset('/public/website/lib/easing/easing.min.js')}}"></script>

<script src="{{asset('/public/website/lib/waypoints/waypoints.min.js')}}"></script>

<script src="{{asset('/public/website/lib/owlcarousel/owl.carousel.min.js')}}"></script>

<script src="{{asset('/public/website/js/main.js')}}"></script>

<script src="{{asset('/public/website/js/particles.js')}}"></script>

<script src="{{asset('/public/website/js/app.js')}}"></script>

</body>

</html>