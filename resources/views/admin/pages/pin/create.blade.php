

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Admin Panel</title>

  <!--===============================================================================================-->	

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

      box-shadow: 0px 0px  4px 8px rgba(0, 0, 0, 0.1); 

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

    }

  

    .form-control {

      width: 100%;

      border: 1px solid #ccc;

      border-radius: 4px;

    }

  

    

  

    

          

  </style>

</head>

<body> 

  @include('admin.include.header')

     

          

  @include('admin.include.sidebar')



    

  <div class="pcoded-content">
    <div class="container">
   <div class="content-head4">
     <h4 class="sub-content-head4" style="font-weight: 900;">Create Member Pin</h4>
    </div>
  </div>
    <div class="main-body">
      <div class="page-wrapper">     
        <div class="same">        
          <form method="POST" action="{{route('dashboard.store-pin')}}">
         @csrf
           
            <div class="main">
              <label class="form-label">Amount</label>

              <select name="amount" id="package" class="form-control" required>

                <option value=""> Select Package</option>

                @foreach($packages as $item)

                <option value="{{number_format($item->amount, 0, '', '') }}">{{$item->name}}({{number_format($item->amount, 0, '', '') }})</option>

                 @endforeach   

              </select>

            </div>

            <div class="main">

              <label>Quantity</label>

              <input type="text" name="quantity" placeholder="Quantity" class="form-control form-control-rounded"

                required="">

            </div>

             <br>

            <div class="main">



              <center><button type="submit" class="btn btn-warning">submit</button></center>

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

