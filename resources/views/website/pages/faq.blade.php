<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FAQ</title>
    @include('website/include/head')
</head>

<body>
    @include('website/include/header')

    <div class="container-fluid bg-dark p-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 text-white">FREQUENTLY ASKED <span class='text-primary'>QUESTIONS</span></h1>
                <a href="">Home</a>
                <i class="far fa-square text-primary px-2"></i>
                <a href="">FAQ</a>
            </div>
        </div>
    </div>
    <div style="background-color: #82d682cc;">
        <div class="container">
            <div class="row p-5">
                <div class="col-sm-12" style="color:black;">
                    <h4>As you are here to get answers to your questions :</h4>
                </div>

                <div class="Track-order" style="color:black;">
                    <ul>
                        <!-- FAQ Item -->
                        <li class="list-item-c">
                            <a href="#"
                                class="toggle title__master d-flex justify-content-between align-items-center rounded p-2 text-dark">
                                <strong class="text-capitalize"><i class="fa-regular fa-hand-point-right"></i> IS THIS
                                    AN AGRICULTURAL / FARMING INVESTMENT PROGRAMME ?
                                </strong>
                                <div> <i class="fas fa-chevron-down"></i></div>
                            </a>
                            <div class="details" style="display: none;">
                                <p>Answer: Yes this initiative is introduced purposely to enable the individuals across
                                    the country, who are of interest into farming/agriculture,
                                    but due to land or time factor, could not do so, join our agribusiness projects with
                                    a minimum of #1,000,000 sum, thereby
                                    stands the privilege to enjoy an annual return of 25%.</p>
                            </div>
                        </li>

                        <!-- Repeat for other FAQ items -->
                        <li class="list-item-c mt-3 ">
                            <a href="#"
                                class="toggle title__master d-flex justify-content-between align-items-center rounded p-2 text-dark">
                                <strong><i class="fa-regular fa-hand-point-right"></i> IS THIS AN CROWD-FUNDING AND
                                    REWARD SYSTEM ?
                                </strong>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="details" style="display: none;">
                                <p>Answer: Yes this initiative is introduced purposely to enable the potential investors
                                    across the country/globe, who are of interest in our
                                    referral and commission program, invest into any of our already designed membership
                                    packages, then join us in the race to
                                    raise global investors. </p>
                            </div>
                        </li>
                        <li class="list-item-c mt-3 ">
                            <a href="#"
                                class="toggle title__master d-flex justify-content-between align-items-center rounded p-2 text-dark">
                                <strong><i class="fa-regular fa-hand-point-right"></i> IS THIS AN HOW DO I JOIN APFAN’S
                                    REFERRAL AND COMMISSION PROGRAMME ?
                                </strong>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="details" style="display: none;">
                                <p>Answer:</p>
                                <p>Our membership packages are in three categories as follow:
                                </p>
                                <p>CATEGORY A… BRONZE PACKAGE [#6,000 Only] </p>
                                <p>CATEGORY B… SILVER PACKAGE [#24,000 Only]</p>
                                <p>CATEGORY C… GOLD PACKAGE [#120,000 Only]</p>
                                <p>CATEGORY D… DIAMOND PACKAGE [#300,000 Only]</p>
                                <p>CATEGORY E… Total Package [#450,000 Only]
                                </p>
                            </div>
                        </li>
                        <li class="list-item-c mt-3 ">
                            <a href="#"
                                class="toggle title__master d-flex justify-content-between align-items-center rounded p-2 text-dark">
                                <strong><i class="fa-regular fa-hand-point-right"></i> APFAN’S ADVANCE PACKAGE
                                </strong>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="details" style="display: none;">
                                <p>Answer:</p>
                                <p>ELITE CLASS [Combination of BRONZE and SILVER]: #30,000 Only
                                </p>
                                <p>Welcome Pack: Food items worth 33.34% [#10,000] or cash equivalent </p>
                                <p>EXECUTIVE CLASS [Combination of BRONZE, SILVER and GOLD]: #150,000 Only</p>
                                <p>Welcome Pack: Food items worth 33.34% [#50,000] or cash equivalent</p>
                                <p>PRESIDENT CLASS [Combination of BRONZE, SILVER, GOLD and DIAMOND]: #450,000 Only </p>
                                <p>Welcome Pack: Food items worth 33.34% [#150,000] or cash equivalent
                                </p>
                            </div>
                        </li>

                        <!-- Add more FAQ items as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('website/include/footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.toggle');

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function (event) {
                    event.preventDefault();

                    const details = this.nextElementSibling;
                    const icon = this.querySelector('i');

                    if (details.style.display === 'none' || details.style.display === '') {
                        details.style.display = 'block';
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        details.style.display = 'none';
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                });
            });
        });
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