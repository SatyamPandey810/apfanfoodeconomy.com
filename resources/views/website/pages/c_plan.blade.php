<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Compensation Plan</title>

    @include('website/include/head')

    <style>
        .header-section {

            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);

            padding: 5rem 0;

        }

        .header-section h1 {

            font-size: 3rem;

            color: white;

            font-weight: 700;

            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);

        }

        .breadcrumb a {

            color: #27cf11;

            text-decoration: none;

        }

        .breadcrumb a:hover {

            text-decoration: underline;

        }

        .card {

            border-radius: 15px;

            overflow: hidden;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

            transition: transform 0.3s ease, box-shadow 0.3s ease;

            background-color: #fff;

        }

        .card:hover {

            transform: translateY(-10px);

            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);

        }

        .card-title {

            font-size: 1.5rem;

            font-weight: 600;

            text-align: center;

            color: #0275d8;

        }

        .card img {

            height: 200px;

            width: 100%;

            /* object-fit: cover; */

        }

        .card-body p {

            font-size: 1rem;

            color: #333;

        }

        .incentives {

            font-weight: 500;

            color: #0275d8;

        }

        .display-5 {

            font-weight: bold;

            color: #333;

        }

        hr {

            border-top: 3px solid #0275d8;

            width: 50px;

            margin: 1rem auto;

        }

        /* New stylish card */

        .new-card {

            border: 2px solid #0275d8;

            border-radius: 20px;

            background: linear-gradient(135deg, #0275d8 0%, #6dd5fa 100%);

            color: white;

            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);

            transition: all 0.4s ease;

        }

        .new-card:hover {

            transform: scale(1.05);

            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);

        }

        .new-card img {

            border-top-left-radius: 20px;

            border-top-right-radius: 20px;

            height: 200px;

            object-fit: cover;

        }

        .new-card .card-title {

            font-size: 1.75rem;

            margin: 15px 0;

            color: #fff;

        }

        .new-card .card-body p {

            color: #e5f4f9;

        }
    </style>

</head>

<div>

    @include('website/include/header')

    <div class="container-fluid bg-dark p-5">

        <div class="row">

            <div class="col-12 text-center">

                <h1 class="display-4 text-white">Compensation Plan</h1>

                <a href="{{route('index')}}">Home <i class="fas fa-home" style="color: rgb(39, 207, 17);"></i></a>



                <a href="{{route('testimonials')}}">Compensation Plan <i class="fas fa-sitemap"
                        style="color: rgb(39, 207, 17);"></i></a>

            </div>

        </div>

    </div>

    <div class="container-fluid py-6 px-5" style="background-color: #82d682cc;">

        <!-- <div class="text-center mx-auto mb-5" style="max-width: 600px;">

            <h1 class="display-5 mb-0">What We Offer</h1>

            <hr class="w-25 mx-auto bg-primary">

        </div> -->



        <div class="row mt-3">
            <div class="col-lg-3 col-md-4">

                <div class="card h-100 p-3 h-100">

                    <img src="{{asset('public/website/img/4th.jpg')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Starter: 2*2 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #1000</p>

                        <p class="mb-0"><b>Level 2:</b> #2,000</p>
                        <p class="card-text">TOTAL LEVEL BONUS: #500* 6 = #3,000</p>

                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-3">

                <div class="card  p-3 h-100">

                    <img src="{{asset('public/website/img/binarymlm.png')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Stage one: 2 * 3 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #2000</p>

                        <p class="mb-0"><b>Level 2:</b> #4,000</p>

                        <p class="mb-0"><b>Level 3:</b> #8,000</p>

                        <p class="mb-0"><b>Total level bonus:</b> #1,000 * 14 = #14,000</p>

                        <p class="mb-0"><b>Added incentives:</b>Apfan Economy food items worth #10,000<br>

Free skill acquisitions </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-3">

                <div class="card  p-3 h-100">

                    <img src="{{asset('public/website/img/binarymlm.png')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Stage2: 2*3 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #12,000</p>

                        <p class="mb-0"><b>Level 2:</b> #24,000</p>

                        <p class="mb-0"><b>Level 3:</b> #48,000</p>

                        <p class="mb-0"><b>Total level bonus:</b> #6,000 * 14 = #84,000</p>

                        <p class="mb-0"><b>Added incentives:</b>Apfan Economy food items worth #50,000<br>

Free skill acquisitions </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-3">

                <div class="card  p-3 h-100">

                    <img src="{{asset('public/website/img/binarymlm.png')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Stage3: 2*3 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #76,000</p>

                        <p class="mb-0"><b>Level 2:</b> #152,000</p>

                        <p class="mb-0"><b>Level 3:</b> #304,000</p>

                        <p class="mb-0"><b>Total level bonus:</b> #38,000 * 14 = #532,000</p>

                        <p class="mb-0"><b>Added incentives:</b>Apfan Economy food items worth #218,000<br>

Free skill acquisitions 
</p>

                    </div>

                </div>

            </div>
<div class="row mt-3 d-flex justify-content-center">
            <div class="col-lg-3 col-md-3">

                <div class="card  p-3 h-100">

                    <img src="{{asset('public/website/img/binarymlm.png')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Stage 4: 2*3 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #400,000</p>

                        <p class="mb-0"><b>Level 2:</b> #800,000</p>

                        <p class="mb-0"><b>Level 3:</b> #1,600,000</p>

                        <p class="mb-0"><b>Total level bonus:</b> #200,000 * 14 = #2.8m</p>

                        <p class="mb-0"><b>Added incentives:</b>Apfan Economy food items worth #700,000<br>

Laptop/Iphone/Ipad worth #1m<br>

Free skill acquisitions 
 </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-3">

                <div class="card p-3 h-100">

                    <img src="{{asset('public/website/img/binarymlm.png')}}" class="card-img-top" alt="...">

                    <div class="card-body">

                        <h5 class="card-title text-center">Stage 5: 2*3 Matrix</h5>

                        <p class="mb-0"><b>Level 1:</b> #1,000,000</p>

                        <p class="mb-0"><b>Level 2:</b> #2,000,000</p>

                        <p class="mb-0"><b>Level 3:</b> #4,000,000</p>

                        <p class="mb-0"><b>Total level bonus:</b>#500,000 * 14 = #7m</p>

                        <p class="mb-0"><b>Added incentives:</b>Apfan Economy food items worth #1m

Exotic Car  worth #7m

3 bedroom flat worth #18m.

Int'l Trip plus shipping voucher worth #,2m

Youth empowerment for (5 beneficiaries) #1m

Monthly Stipends of 1m for thirty six months= #36m

Free skill acquisitions </p>

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