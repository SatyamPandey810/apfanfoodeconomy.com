<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Apfan food economy</title>
    @include('website/include/head')
    
</head>
<div>
    @include('website/include/header')
    <div id="particles-js">
        <div class="main-banner row d-flex justify-content-center align-items-center ">
            <div class="col-md-12 text-center">
                <h1 class="type" >Welcome to apfan food economy</h1>
                <div class="d-flex justify-content-center gap-3" >
                    <button class="glow-on-hover" data-aos="fade-left" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign In Now</button>
                    <a href="{{route('user.register')}}" style="color: #64ff17 !important;"><button class="glow-on-hover">Sign Up Now</button></a>
                    
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid p-0" style="background-color: #aada90;">
            <div class="row g-0">
                <div class="col-lg-6 py-6 px-5">
                    <h1 class="display-5 mb-4">Welcome to <span class="text-primary">apfan food economy</span></h1>
                    <!-- <h5 class="text-primary mb-4"><i>Apfan food economy is an organic food and cash network marketing
                            organization, with the sole aim of making organic food available for all </i></h5> -->
                    <p class="mb-4 text-dark">APFAN is a registered non-governmental agro empowerment organisation, established solely to complement the efforts of the government in promoting the growth and development of agriculture in the country.</p>
                </div>
                <div class="col-lg-6 py-6 px-5">
                    <div class="h-100 d-flex flex-column justify-content-center">
                        <section class="left-side">
                            <div class="agriculture-img ">
                                <div class="img-part first">
                                    <img src="public/website/img/agriculture.jpg" class="">
                                </div>
                                <div class="img-part second">
                                    <img src="public/website/img/tomato.jpg" class="">
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    <!-- Services Start -->
    <div class="container-fluid pt-6 px-5" style="    background-color: #8bb276;">
        <div class="text-center mx-auto mb-5">
            <h3 class="display-5 mb-0">Mission<span class="text-primary"> Apfan Food Economy</span> </h3>
            <hr class="w-25 mx-auto bg-primary">
        </div>
        <div class="row g-5 pa-5">
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-money-bill-wheat fs-4"></i>
                    </div>
                    <h3 class="mb-3">Agricultural Developmental</h3>
                    <p class="mb-0 text-dark" id="text-1-short">
                        This initiative is introduced to enable individuals interested in farming/agriculture...
                    </p>
                    <p class="mb-0 text-dark collapse" id="text-1-full">
                        This initiative is introduced purposely to enable individuals across the country, who are interested in farming/agriculture but may lack resources such as land or time. It aims to support their involvement in agriculture through innovative solutions.
                    </p>
                    <button class="btn btn-primary btn-sm mt-2" onclick="toggleReadMore('1')">Read More</button>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-lock fs-4"></i>
                    </div>
                    <h3 class="mb-3">Unemployment Security</h3>
                    <p class="mb-0 text-dark" id="text-2-short">
                        To be the number one solution provider for unemployment, poverty, and food scarcity...
                    </p>
                    <p class="mb-0 text-dark collapse" id="text-2-full">
                        To be the top solution provider addressing current issues such as unemployment, poverty, food scarcity, and the widespread hunger. The program aims to empower individuals by creating sustainable jobs through agriculture.
                    </p>
                    <button class="btn btn-primary btn-sm mt-2" onclick="toggleReadMore('2')">Read More</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa fa-chart-line fa-2x"></i>
                    </div>
                    <h3 class="mb-3">Crowd-Funding and Reward System</h3>
                    <p class="mb-0 text-dark" id="text-3-short">
                        This initiative allows potential investors to engage in our referral and commission program...
                    </p>
                    <p class="mb-0 text-dark collapse" id="text-3-full">
                        This initiative enables potential investors across the country/globe to participate in our referral and commission program. Investors can choose from our membership packages and join us in the effort to raise global investors, benefiting from rewards and growth opportunities.
                    </p>
                    <button class="btn btn-primary btn-sm mt-2" onclick="toggleReadMore('3')">Read More</button>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-money-bill-wheat fs-4"></i>
                    </div>
                    <h3 class="mb-3">Agricultural developmental</h3>
                     <p class="mb-0 text-dark">This initiative is introduced purposely to enable the individuals across the country, who are of interest in farming/agriculture, but due to some factors (land, time etc)</p> -->
                </div>
            </div> --}}
            {{-- <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-lock fs-4"></i>
                    </div>
                    <h3 class="mb-3">unemployment security</h3>
                 <p class="mb-0 text-dark">To be the number one solution provider to the current unemployment
                        security,
                        poverty, food scarcity and the ravaging hunger at hand</p> 
                </div>
            </div> --}}
            {{-- <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa fa-chart-line fa-2x"></i>
                    </div>
                    <h3 class="mb-3">Crowd-Funding and reward system</h3>
                  <p class="mb-0 text-dark">This initiative is introduced purposely
                 to enable the potential investors across the country/globe, who are of interest
                  in our referral and commission programme, invest into any of our already designed
                   membership packages, then join us in the race to raise global investors.</p>
                </div>
            </div> --}}
               <!-- Service Item 4 -->
                {{-- <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa fa-chart-area fa-2x"></i>
                    </div>
                    <h3 class="mb-3">Apfan’s Vision</h3>
                     <p class="mb-0 text-dark">To be the number one solution provider to the current unemployment,  poverty, food scarcity and the ravaging hunger at hand in the country, through the promotion of agriculture or farming culture

                        👉 To build the interest of Nigerian youths in agriculture
                        👉 To ensure the pure organic food is affordable, accessible and available for all 
                        👉 To ensure there is a rapid decrease in the rate and cost of food importations into the country</p> 
                </div>
            </div> --}}
        <div class="col-lg-4 col-md-6">
            <div class="service-item text-center px-5 rounded">
                <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                    style="width: 90px; height: 90px;">
                    <i class="fa fa-chart-area fa-2x"></i>
                </div>
                <h3 class="mb-3">Apfan’s Vision</h3>
                <p class="mb-0 text-dark" id="text-4-short">
                    To become a leading solution provider in tackling unemployment and food scarcity...
                </p>
                <p class="mb-0 text-dark collapse" id="text-4-full">
                    Apfan aims to reduce unemployment, alleviate poverty, and address food scarcity. The vision includes building youth interest in agriculture, ensuring affordable organic food, and reducing food importation rates.
                </p>
                <button class="btn btn-primary btn-sm mt-2" onclick="toggleReadMore('4')">Read More</button>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="service-item text-center px-5 rounded">
                <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                    style="width: 90px; height: 90px;">
                    <i class="fa-solid fa-bullseye fs-4"></i>
                </div>
                <h3 class="mb-3">Apfan’s Mission</h3>
                <p class="mb-0 text-dark" id="mission-short">
                    To achieve the above visions, the following missions are set to embark upon:
                </p>
                <p class="mb-0 text-dark collapse" id="mission-full">
                    👉 To empower ten million youths across the country through agricultural developmental training, with financial support of ₦200,000 minimum each before December 31st, 2050.<br>
                    👉 To massively invest in agriculture, selling farm produce to the public at a subsidized price.
                </p>
                <button class="btn btn-primary btn-sm mt-2" data-bs-toggle="collapse" 
                        data-bs-target="#mission-full" aria-expanded="false" aria-controls="mission-full" 
                        onclick="toggleButtonText(this)">
                    Read More
                </button>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="service-item text-center px-5 rounded">
                <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                    style="width: 90px; height: 90px;">
                    <i class="fa fa-house-damage fa-2x"></i>
                </div>
                <h3 class="mb-3">Apfan’s Products And Services</h3>
                <p class="mb-0 text-dark" id="services-short">
                    Apfan offers various services including human capital development and food security...
                </p>
                <p class="mb-0 text-dark collapse" id="services-full">
                    👉 Human capital development through agro skills acquisition.<br>
                    👉 Food security services through agriculture.<br>
                    👉 Financial empowerment services.<br>
                    👉 Assets and property acquisition.<br>
                    👉 Tourism services.<br>
                    👉 Humanitarian (youth empowerment) services.<br>
                    👉 Monthly stipend collection.<br>
                    👉 Loan accessibility.
                </p>
                <button class="btn btn-primary btn-sm mt-2" data-bs-toggle="collapse" 
                        data-bs-target="#services-full" aria-expanded="false" aria-controls="services-full" 
                        onclick="toggleButtonText(this)">
                    Read More
                </button>
            </div>
        </div>
            {{-- <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-bullseye fs-4"></i>
                    </div>
                    <h3 class="mb-3">Apfan’s Mission</h3>
                    <p class="mb-0 text-dark">TTo achieve the above visions, the following missions are thereby set to embark opon:
 
                        👉 To empower ten million youths minimum across the country through agricultural developmental training, with financial support of ₦200,000 minimum each before December 31st, 2050
                        👉 To massively invest into the agriculture, thereby able to sell our farm produce to the public at a subsidized price</p> 
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item text-center px-5 rounded">
                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-circle mx-auto mb-4"
                        style="width: 90px; height: 90px;">
                        <i class="fa fa-house-damage fa-2x"></i>
                    </div>
                    <h3 class="mb-3">Apfan’s Products And Services</h3>
                     <p class="mb-0 text-dark">👉 Human capital development through agro skills acquisition 

                        👉 Food security services through agriculture 
                        👉 Financial empowerment services 
                        👉 Assets and property acquisition
                        👉 Tourism services
                        👉 Humanitarian (youth empowerment) services
                        👉 Monthly stipend collection
                        👉 Loan accessibility
                    </p>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- Quote Start -->
    <div class="container-fluid px-0" style="background-color: #9ac485;">
        <div class="row g-0">
            <div class="col-lg-12 py-6 px-5">
                <h1 class="display-5 mb-4 text-center">Our <span class="text-primary">Services</span></h1>
                <hr class="w-25 mx-auto bg-primary">
                <p class="mb-4 text-dark mt-3">This initiative is introduced purposely to enable the potential investors across the
                    country/globe, who are of interest in our
                    referral and commission program, invest into any of our already designed membership packages, then
                    join us in the race to
                    raise global investors. </p>

            </div>

        </div>
    </div>
    <!-- Quote End -->
    <!-- Team Start -->
    <div class="container-fluid py-6 px-5" style="background-color: #98ca7f;">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-0">Fresh and <span class="text-primary">Organic</span> </h1>
            <hr class="w-25 mx-auto bg-primary">
        </div>
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="team-item position-relative overflow-hidden fresh-food-img">
                    <img class="img-fluid w-100 " src="public/website/img/img-1.jpg" alt="">
                    <!-- <div class="team-text w-100 position-absolute top-50 text-center bg-primary p-4">
                        <h3 class="text-white">Fresh and</h3>
                        <p class="text-white text-uppercase mb-0">Organic</p>
                    </div> -->
                </div>
            </div>
             <div class="col-lg-4">
                <div class="team-item position-relative overflow-hidden fresh-food-img">
                    <img class="img-fluid w-100" src="public/website/img/fruit3.jpg " alt="">
                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="team-item position-relative overflow-hidden fresh-food-img">
                    <img class="img-fluid w-100" src="public/website/img/img-2.jpg" alt="">
                    <!-- <div class="team-text w-100 position-absolute top-50 text-center bg-primary p-4">
                        <h3 class="text-white">Fresh and</h3>
                        <p class="text-white text-uppercase mb-0">Organic</p>
                    </div> -->
                </div>
            </div>
           
        </div>
    </div>
   @include('website/include/footer')
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title text-center">
                    SIGN IN
                  </div>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="wrapper">
                    <form method="POST" action="{{ route('check.login') }}">
                         @csrf
                        <div class="field">
                            <input type="text" placeholder="Username" name="username" value="{{ old('username') }}" required>
                            <span class="focus-input100"></span>
                            @error('username')
                            <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <div class="field">
                            <input type="password" name="pass" placeholder="Password" id="password"class="form-control form-control-lg input100 border" />
                           
                            <span class="focus-input100"></span>
                            @error('pass')
                            <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <div class="content">
                            <div class="pass-link">
                            </div>
                        </div>
                        <div class="field">
                            <input type="submit" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init({
        duration: 1200,
    })
</script>
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });



function toggleReadMore(id) {
    const shortText = document.getElementById(`text-${id}-short`);
    const fullText = document.getElementById(`text-${id}-full`);
    const button = document.querySelector(`[onclick="toggleReadMore('${id}')"]`);

    if (fullText.classList.contains('show')) {
        fullText.classList.remove('show');
        button.innerText = 'Read More';
    } else {
        fullText.classList.add('show');
        button.innerText = 'Read Less';
    }
}

</script>
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