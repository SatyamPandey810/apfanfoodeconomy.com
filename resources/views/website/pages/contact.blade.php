<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Contact Us</title>

    @include('website/include/head')

    

</head>

<div>

    @include('website/include/header')
    <div class="container-fluid bg-dark p-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 text-white">Contact-us</h1>
                <a href="">Home</a>
                <i class="far fa-square text-primary px-2"></i>
                <a href="">Contact</a>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid px-0" style="background-color: #82d682cc;">
        <div class="row g-0 ">
            <div class="col-lg-12 py-6 px-5 d-flex justify-content-center">
                <form class="w-50">
                    <!-- <h1 class="display-5 mb-4 text-center">Contact For <span class="text-primary">Any Queries</span></h1>
                    <hr class="w-25 mx-auto bg-primary"> -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="form-floating-1" placeholder="John Doe">
                                <label for="form-floating-1">Full Name</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="form-floating-2" placeholder="name@example.com">
                                <label for="form-floating-2">Email address</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="form-floating-3" placeholder="Subject">
                                <label for="form-floating-3">Subject</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Message" id="form-floating-4" style="height: 150px"></textarea>
                                <label for="form-floating-4">Message</label>
                              </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
  

    @include('website/include/footer')



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