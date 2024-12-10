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
    /* Table Container */
    .containers {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Title Styling */
    .containerss {
      height: 50px;
      background: linear-gradient(45deg, #ffaf03, #f8d778);
      text-align: center;
      margin-bottom: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    }

    .containerss h4 {
      margin: 0;
      padding-top: 10px;
      font-size: 26px;
      color: hsl(253, 72%, 72%);
      font-weight: bold;
    }

    /* Responsive Table */
    .responsive-table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 20px;
    }

    .responsive-table th, .responsive-table td {
      padding: 12px;
      text-align: left;
      border: 1px solid #e0e0e0;
      transition: background-color 0.3s ease;
    }

    .responsive-table thead {
      background-color: #1ca0d4;
      color: white;
      font-weight: bold;
      text-transform: uppercase;
    }

    .responsive-table tbody tr:nth-child(odd) {
      background-color: #f3f3f3;
    }

    .responsive-table tbody tr:hover {
      background-color: #e6f7ff; /* Add a subtle hover effect */
    }

    .responsive-table tbody td {
      color: #4e4e4e;
      font-family: 'Arial', sans-serif;
    }

    .responsive-table tbody tr td {
      font-size: 14px;
      padding: 14px 10px;
    }

    .responsive-table tbody td:first-child {
      font-weight: bold;
      color: #333;
    }

    /* Responsive Design */
    @media only screen and (max-width: 600px) {
      .table-responsive {
        overflow-x: auto; /* Enable horizontal scrolling on mobile */
        border-radius: 8px;
      }

      .responsive-table th, .responsive-table td {
        white-space: nowrap; /* Prevent text wrapping in table cells */
      }

      /* Optional: Add padding for mobile view */
      .containers {
        padding: 10px;
      }
    }

    /* Search Bar Styling */
    .search-container {
      float: right;
      margin-bottom: 10px;
    }

    @media only screen and (max-width: 600px) {
      .search-container {
        float: none;
        margin-bottom: 0;
      }
    }

    /* Print Styling */
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
  <!--======================================Include Header ===========================================-->
  @include('admin.include.header')
  <!--======================================Include Sidebar ==========================================-->
  @include('admin.include.sidebar')
  <!--======================================Include End =============================================-->
  <div class="pcoded-content">
    <div class="main-body">
      <div class="content-head">
        <h4 class="sub-content-head" style="font-weight: 900;">Used Pin</h4>
      </div>
      <div class="page-wrapper">
        <div class="same">
          <div class="panel-body">
            <div class="containers">
              <div class="table-responsive">
                <table id="datatables-example" class="table responsive-table">
                  <thead>
                    <tr>
                      <th>S.NO</th>
                      <th>user_id</th>
                      <th>Use Pin</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i = 1; @endphp
                    @foreach ($users as $index => $item)
                    <tr>
                      <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                      <td>{{$item->user_id}}</td>
                      <td>{{$item->use_pin}}</td>
                      <td>{{$item->updated_at}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div style="float:right; margin-bottom:10px;">
                {{ $users->links('pagination::bootstrap-4') }}
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

  @include('admin.include.script')
</body>
</html>
