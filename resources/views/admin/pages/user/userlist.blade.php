<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Home</title>
  @include('admin.include.head')
 
</head>
<body> 
  <!--======================================Include Header ===========================================-->
  @include('admin.include.header')
   <!--======================================Include Sidbar ==========================================-->
  @include('admin.include.sidebar')
   <!--======================================Include End =============================================-->

  <div class="pcoded-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="same">
          <div class="panel-body">
            <div class="responsive-table" >
              <div class="containers">
              <div id="searchResults">
                <table id="datatables-example" class="table responsive-table">
                </table>
            </div>
              <div id="searchResults">
                @php
                $totalUsers = $users->total();
            @endphp
            <div class="d-flex align-items-center justify-content-between p-2">
            <div class="pv-date-2">
                <button class="btn btn-warning">Total Users</button>
                <button class="btn btn-success">{{ $totalUsers }}</button> 
            </div>
            <div>
              <form action="{{ route('user') }}" method="GET" class="d-flex">
                  <input type="text" name="search" class="form-control" placeholder="Search Pin or username" value="{{ request()->input('search') }}">
                  <button type="submit" class="btn btn-info">Search</button>
              </form>
            </div>
          </div>
                <div class="table-responsive">
                  <table id="datatables-example"  class="table table-bordered table-responsive{-sm|-md|-lg|-xl|-xxl}">
                    <thead>
                        <tr class="text-nowrap table-info">
                            <th>S.NO</th>
                            <th>User Id</th>
                            <th>Name</th>                           
                            <th>Username</th>
                            <th>Password</th>                              
                            <th>Package</th> 
                            <th>Pin</th>                        
                            <th>User Email</th>
                            <th>Date</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                            <td>{{ $item->user_id }}</td>
                            <td>{{ $item->name }}</td>                          
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->conform_password }}</td>                           
                            <td>{{ $item->package }}</td>
                            <td>{{ $item->use_pin }}</td> 
                            <td>{{ $item->email }}</td>  
                            <td>{{ $item->created_at }}</td>                                                  
                            <td>                         
                              <a href="{{ route('edit.user', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>                                                      
                              <form action="{{ route('delete.user', $item->id) }}" method="POST" style="display:inline;">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                              </form>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div style="float:right; margin-bottom:10px;">
                  {{ $users->appends(['search' => request()->input('search')])->links('pagination::bootstrap-4') }}
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

   @include('admin.include.script')
</body>
</html>