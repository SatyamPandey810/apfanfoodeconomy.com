<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible">
  <title>Admin Panel</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!--===============================================================================================-->	
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @include('admin.include.head')

  <style>
    body {
      text-align: center;
      background-color: #f0f0f0;
    }

   

    form {
      width: 70%;
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 0px 4px 8px rgba(0, 0, 0, 0.1);
      display: inline-block;
      border: 2px solid rgb(42, 184, 14);
    }

    .main {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      text-align: left;
    }

    .form-control {
      width: 100%;
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn {
      padding: 10px 20px;
      background-color: #ffc107;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #1a42f8;
    }

    center {
      display: flex;
      justify-content: center;
    }
  </style>
</head>
<body>
  @include('admin.include.header')
  @include('admin.include.sidebar')
  <div class="pcoded-content">
    <div class="container">
   <div class="content-head2">
     <h4 class="sub-content-head2" style="font-weight: 900;">Transfer Pin</h4>
    </div>
  </div>
    <div class="main-body">
      <div class="page-wrapper">
        <div class="same">
        @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
          <!-- Start Content Section -->          
          <form action="{{ route('transfer_pins.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="vendor_id" class="form-label">Vendor ID</label>
              <input type="text" class="form-control" id="vendor_id" name="vendor_id" required>
          </div>      
          <div class="mb-3">
              <label for="package" class="form-label">Package</label>
              <select class="form-control" id="package" name="package" required>
                  <option value="" disabled selected>Select a package</option>
                 @foreach($packages as $item)

                <option value="{{number_format($item->amount, 0, '', '') }}">{{$item->name}}({{number_format($item->amount, 0, '', '') }})</option>

                 @endforeach   

              </select>
          </div>      
          <div class="mb-3">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
            <button type="submit" class="btn btn-primary">Transfer Pin</button>
          </form>        
          <!-- End Content Section -->
        </div>
      </div>
    </div>
  </div>
  @include('admin.include.script')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
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
