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
     <h4 class="sub-content-head4" style="font-weight: 900;">Edit Package</h4>
    </div>
  </div>
    <div class="main-body">
      <div class="page-wrapper">
        <div class="same-p shop-product-upload-form">
            <form action="{{ route('packages.update', $package->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Package Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="amount">Amount:</label>
                    <input type="text" name="amount" class="form-control" value="{{ $package->amount }}" required>
                </div>

                   </div>
                   <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Package</button>
                <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
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