<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
    <a href="{{route('index')}}" class="navbar-brand p-0">
        <!-- <h1 class="m-0 text-uppercase text-info" style="color: #129ad1 !important">apfan food economy</h1> -->
      <img src='public/website/img/logo7.png' class="logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 me-n3">
            <a href="{{route('index')}}" class="nav-item nav-link active">Home</a>
            <a href="{{route('about')}}" class="nav-item nav-link">About</a>
            <a href="{{route('testimonials')}}" class="nav-item nav-link">Plan</a>
            <a href="{{route('product')}}" class="nav-item nav-link">Product</a>
           
            <a href="{{route('contact')}}" class="nav-item nav-link">Contact</a>
            <a href="{{route('faq')}}" class="nav-item nav-link">FAQ</a>
            {{-- <a href="service.html" class="nav-item nav-link"><button class="btn btn-info">Sign in</button></a>
            <a href="{{route('user.register')}}" class="nav-item nav-link"><button class="btn btn-primary btn btn-lg">Sign Up</button></a> --}}
        </div>
    </div>
</nav>