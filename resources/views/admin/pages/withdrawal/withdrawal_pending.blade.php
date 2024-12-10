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
</head>
<body>
    @include('admin.include.header')
    @include('admin.include.sidebar')
    <div class="pcoded-content">
        <!-- <div class="containerss"><center><h4><b>Withdrawal Pending</b></h4></center></div> -->
        <div class="container">
            <div class="content-head3">
                <h4 class="sub-content-head3" style="font-weight: 900;">Withdrawal Pending</h4>
            </div>
        </div>
        <div class="main-body">
            <div class="page-wrapper">
                <div class="panel-body s-3">
                    <div id="searchResults" class=" table-responsive table-responsive{-sm|-md|-lg|-xl|-xxl}">
                        <table class="table table-bordered ">
                            <thead>
                                <tr class="text-nowrap table-info text-center">
                                    <th>S.No</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Withdrawal Amount</th>
                                    <th>Commission</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($withdrawals as $withdrawal)
                                <tr class="text-center">
                                    @if($withdrawal->status =='pending')
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $withdrawal->user_id }}</td>
                                    <td>{{ $withdrawal->username }}</td>
                                    <td>{{ $withdrawal->withdrawal_amount }}</td>
                                    <td>{{ $withdrawal->commission }}</td>
                                    <td>{{ $withdrawal->created_at }}</td>
                                    <td><button class="btn btn-warning">{{ $withdrawal->status }}</button>
                                    </td>
                                    <td><a href="{{route('withdrawal.update',$withdrawal->id)}}"
                                            class="btn btn-primary">Details</a></td>
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
    @include('admin.include.script')
</body>
</html>