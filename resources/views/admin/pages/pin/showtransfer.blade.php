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
    body {
      background-color: #f9f9f9;
      font-family: 'Arial', sans-serif;
    }

    .containers {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
    }

    .content-head h4 {
      font-weight: 900;
      color: #333;
      margin-bottom: 20px;
    }

    .export-btn {
      margin-right: 15px;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .export-btn:hover {
      background-color: #d9534f;
      color: #fff;
    }

    .search-container {
      float: right;
      margin-bottom: 10px;
    }

    .search-container input[type="text"] {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 200px;
      transition: border-color 0.3s;
    }

    .search-container input[type="text"]:focus {
      border-color: #007bff;
      outline: none;
    }

    .search-container button {
      padding: 10px 15px;
      background-color: firebrick;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .search-container button:hover {
      background-color: #c0392b;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color:black;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.8rem;
    }

    .bg-success {
      background-color: #28a745;
      color: white;
    }

    .bg-danger {
      background-color: #dc3545;
      color: white;
    }

    @media only screen and (max-width: 600px) {
      .search-container {
        float: none;
        margin-bottom: 10px;
      }
    }

    @media print {
      body * {
        visibility: hidden;
      }
      #datatables-example, #datatables-example * {
        visibility: visible;
      }
      #datatables-example {
        position: absolute;
        left: 0;
        top: 0;
      }
    }
  </style>  

</head>

<body> 

  <!-- Include Header -->
  @include('admin.include.header')

  <!-- Include Sidebar -->
  @include('admin.include.sidebar')

  <div class="pcoded-content">  
    <div class="container">
      <div class="content-head">
        <h4 class="sub-content-head">Transfer Pin</h4>
      </div>
    </div>

    <div class="main-body">
      <div class="page-wrapper">
        <div class="same">
          <div class="panel-body">
            <div class="responsive-table">
              <div class="containers">
                <button class="btn btn-danger export-btn">TOTAL PIN</button>
                <button class="btn btn-outline-info export-btn">{{$totalPins}}</button>

                <div class="search-container">
                  <form action="{{ route('transfer_pins.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search VendorId..." value="{{ request()->input('search') }}">
                    <button type="submit">Search</button>
                  </form>
                </div>

                <div id="searchResults" class="table-responsive">
                  <table id="datatables-example" class="table table-bordered">
                    <thead>
                      <tr class="text-nowrap table-info">
                        <th>S.No</th>
                        <th>Vendor ID</th>
                        <th>Package</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                          $i = ($transferpins->currentPage() - 1) * $transferpins->perPage() + 1;
                      @endphp
                      @foreach($transferpins as $item)
                      <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $item->vendor_id }}</td>
                          <td>{{ $item->package }}</td>
                          <td>{{ $item->quantity }}</td>
                          <td>{{ $item->created_at }}</td>
                          <td>
                              @if($item->status == 'unsold')
                                  <span class="badge bg-danger">Unsold</span>
                              @else
                                  <span class="badge bg-success">Sold</span>
                              @endif
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
                  </table>

                  <div style="float:right;margin-bottom:10px;">
                     {{ $transferpins->links('pagination::bootstrap-4') }} 
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <script>
    var searchByPinRoute = '{{ route("dashboard.search.by.pin") }}';

    $(document).ready(function() {
        $('#pin').on('keyup', function() {
            var pin = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: searchByPinRoute,
                data: {
                    _token: csrfToken,
                    pin: pin
                },
                success: function(response) {
                    displayPins(response.pins);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText); 
                    console.error("Status:", status);
                    console.error("Error:", error); 
                }
            });
        });

        function displayPins(pins) {
            var html = '';
            pins.forEach(function(pin) {
                html += '<tr>';
                html += '<td>' + pin.id + '</td>';
                html += '<td>' + pin.pin_no + '</td>';
                html += '<td>' + pin.amount + '</td>';
                html += '<td>' + pin.member_id + '</td>';
                html += '<td>' + pin.created_at + '</td>';
                html += '<td>';
                if (pin.status == 'activ') {
                    html += '<button class="btn btn-success">' + pin.status + '</button>';
                } else {
                    html += '<button class="btn btn-danger">Inactive</button>';
                }
                html += '</td>';
                html += '</tr>';
            });

            $('#datatables-example tbody').html(html);
            $('#datatables-example').DataTable();
        }
    });
  </script>

  @include('admin.include.script')

</body>
</html>
