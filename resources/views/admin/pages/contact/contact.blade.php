<!DOCTYPE html>

<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Home</title>
  @include('admin.include.head')

  <style>
    /* Custom styling for better alignment */
    .search-container {
      max-width: 300px;
      margin-left: auto;
    }

    .btn-container {
      display: flex;
      align-items: center;
    }

    .btn-container button {
      margin-right: 10px;
    }

    @media (max-width: 768px) {
      .btn-container {
        flex-direction: column;
        margin-bottom: 15px;
      }

      .btn-container button {
        margin-bottom: 10px;
      }

      .search-container {
        margin-top: 10px;
        width: 100%;
      }
    }
  </style>
</head>

<body>
  @include('admin.include.header')
  @include('admin.include.sidebar')

  <div class="pcoded-content">
    <div class="container">
      <div class="content-head">
        <h4 class="sub-content-head" style="font-weight: 900;">Contact Us</h4>
      </div>
    </div>

    <div class="main-body container-fluid">
      <div class="page-wrapper">
        <div class="panel-body">
          <div class="d-flex justify-content-between mb-3">
            {{-- <div class="btn-container">
              <button class="btn btn-danger animated fadeInLeft export-btn">TOTAL PIN</button>
              <button class="btn btn-outline-info animated fadeInLeft export-btn">{{$totalPins}}</button>
            </div> --}}
{{-- 
            <div class="search-container">
              <input type="text" name="pin" id="pin" class="form-control" placeholder="Search...">
            </div> --}}
          </div>

          <div id="searchResults">
            <table id="datatables-example" class="table table-bordered">
              <thead>
                <tr class="table-info text-center">
                  <th>S.no</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone No.</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Action<th>
                </tr>
              </thead>
              <tbody>
                @php $i = 1; @endphp
                @foreach($contacts as  $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ $item->phone_no }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->message }}</td>
                  <td>
                    @if($item->status == 'activ')
                    <button class="btn btn-outline-success btn-sm">Activ</button>
                    @else
                    <button class="btn btn-danger">Inactive</button>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            {{-- <div style="float:right; margin-bottom:10px;">
              {{ $pins->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
            </div>  --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  @include('admin.include.script')
</body>

</html>
