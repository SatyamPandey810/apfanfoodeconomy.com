

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Admin Panel</title>

  <!--===============================================================================================-->	

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- <link rel="stylesheet" href="{{asset('public/asset/package/style.css')}}"> -->

  <!--===============================================================================================-->	

  @include('admin.include.head')

</head>

<body> 

  @include('admin.include.header')       

  @include('admin.include.sidebar')



  <div class="pcoded-content">

    <div class="container">
   <div class="content-head4">
     <h4 class="sub-content-head4" style="font-weight: 900;">Create Package</h4>
    </div>
  </div>
    <div class="main-body">

      <div class="page-wrapper">

        <div class="same shop-product-upload-form">

            <form class="pak" action="{{ route('packages.store') }}" method="POST">

                @csrf
             <div class="row align-items-center justify-content-center">
                <div class="form-group col-md-6">

                    <label for="packageName">Package Name</label>

                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="packageName" aria-describedby="name" placeholder="Enter Package Name" value="{{ old('name') }}">

                </div>

                <div class="form-group col-md-6">

                    <label for="exampleInputAmount">Amount</label>

                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" id="exampleInputAmount" placeholder="Enter Amount" value="{{ old('amount') }}">

                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Create Package</button>
              </div>
            </form>

       </div>

    </div> 

  </div>

</div>



 @include('admin.include.script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {

        @if (session('success'))

            Swal.fire({

              text: '{{ session('success') }}',

                icon: 'success',

                title: 'Success',

                timer: 2000,

                showConfirmButton: false

            });

        @endif

    });

</script>

</body>

</html>



