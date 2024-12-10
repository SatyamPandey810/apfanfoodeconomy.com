<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Admin Panel</title>

  <!--===============================================================================================-->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- <link rel="stylesheet" href="{{asset('public/asset/package/style2.css')}}"> -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--===============================================================================================-->

  @include('admin.include.head')

</head>

<body>

  @include('admin.include.header')

  @include('admin.include.sidebar')



  <div class="pcoded-content">

    <div class="container">
      <div class="content-head2">
        <h4 class="sub-content-head2" style="font-weight: 900;">View Package</h4>
      </div>
    </div>

    <div class="main-body">

      <div class="page-wrapper">

        <div class="same">       
         <div class="mb-2">
            <a href="{{ route('packages.create') }}">
              <button class="btn btn-warning fw-bold">Add new packages</button>
            </a>
        </div>
            <div class="table-responsive">
              <table class="table table-bordered table-responsive{-sm|-md|-lg|-xl|-xxl}">

                <thead>

                  <tr class="table-info text-center">

                    <th>SN.</th>

                    <th>Package name</th>

                    <th>Amount</th>

                    <th>Date</th>

                    <th colspan="2">Action</th>

                  </tr>

                </thead>

                <tbody>
                @php $i=1; @endphp
                  @foreach ($packages as $package)

                  <tr>

                    <td>{{ $i++ }}</td>

                    <td>{{ $package->name }}</td>

                   <td>{{ number_format($package->amount) }} (NG)</td>

                    <td>{{ $package->created_at }}</td>

                    <td>
                      <a href="{{ route('packages.edit', $package->id) }}">
                        <button class="btn btn-outline-info">Edit</button>
                      </a>
                    </td>
                    <td>
                      <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this package?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Remove</button>
                      </form>
                    </td>

                  </tr>

                  @endforeach

                </tbody>

              </table>
            </div>       
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