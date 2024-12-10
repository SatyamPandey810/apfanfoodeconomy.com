

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
     <h4 class="sub-content-head4" style="font-weight: 900;">Add Gallery Item</h4>
    </div>
  </div>
    <div class="main-body">

      <div class="page-wrapper">

        <div class="same shop-product-upload-form">

        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Add Gallery Item</button>
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



