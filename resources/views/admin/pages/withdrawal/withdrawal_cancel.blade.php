
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
    .containerss {
      height:50px;
      background: #0c0a05;
      text-align: center; 
      margin-bottom: 20px; 
      box-shadow:0px 0px 5px 1px #4e4e4e99;
    }
  
    .containerss h4 {
      margin: 0;
      padding-top: 10px;
      font-size: 26px; 
      color:white; 
      text-transform: uppercase;
    }
      .responsive-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
      }
  
      .responsive-table thead {
        background-color: rgb(75, 133, 78);
        color: white;
      }
      
      .responsive-table tbody {
        color: rgb(78, 70, 70);
      }
      
      .responsive-table th, .responsive-table td {
        padding: 10px;
        text-align: left;
      }
      
      @media only screen and (max-width: 600px) {
        .responsive-table th, .responsive-table td {
          display: block;
          width: 100%;
        }
        
        .responsive-table thead, .responsive-table tbody, .responsive-table th, .responsive-table td, .responsive-table tr {
          display: block;
        }
        
        .responsive-table tbody tr {
          margin-bottom: 20px;
        }
      }
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
  .containers{
    background: #f3f3f3;
    padding: 20px;
  }
    </style>
</head>
<body>
    @include('admin.include.header')     
    @include('admin.include.sidebar')
    <div class="container">
    <div class="content-head4">
      <h4 class="sub-content-head4" style="font-weight: 900;"><span>Withdrawal</span><span> Cancel</span></h4>
    </div>
  </div>
    <div class="pcoded-content">
         <div class="main-body">
           <div class="page-wrapper">
             <div class="same">
               <div class="panel-body">
                 <div class="table-responsive" style="border: none !important;padding:1px !important;">
                   <div class="containers">
                   <div id="searchResults">
            <table class="table" style="background: rgb(255, 253, 253);">
                <thead class="thead-dark">
                    <tr style="background: rgb(64, 52, 113);color:white; text-transform: uppercase">
                        <th>S.No</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Bank</th>
                        <th>Account</th>
                        <th>Withdrawal</th>
                        <th>To Receive</th>
                        <th>Charge(5%)</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($withdrawals as $withdrawal)
                        <tr>
                          @if($withdrawal->status =='Rejected')
                            <td>{{ $i++ }}</td>
                            <td>{{ $withdrawal->user_id }}</td>
                            <td>{{ $withdrawal->username }}</td>
                            <td>{{ $withdrawal->bank }}</td>
                            <td>{{ $withdrawal->account }}</td>
                            <td>{{ $withdrawal->withdrawal_amount+$withdrawal->commission }}</td>
                            <td>{{ $withdrawal->withdrawal_amount }}</td>
                            <td>{{ $withdrawal->commission }}</td>
                            <td><button class="btn btn-danger">{{ $withdrawal->status }}</button></td>
                        @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
    @include('admin.include.script')
</body>
</html>