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

    </style>
</head>

<body>
    @include('admin.include.header')

    @include('admin.include.sidebar')
    <div class="pcoded-content">
        <div class="container">
            <div class="content-head3">
                <h4 class="sub-content-head3" style="font-weight: 900;">Withdrawal Success</h4>
            </div>
        </div>
        <div class="main-body">
            <div class="page-wrapper">                
                    <div class="panel-body s-3">
                        <div id="searchResults" class="table-responsive"
                            style="border: none !important;padding:1px !important;">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Bank</th>
                                        <th>Account</th>
                                        <th>Withdrawal</th>
                                        <th>To Receive</th>
                                        <th>Charge(5%)</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        @if($withdrawal->status =='Success')
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $withdrawal->user_id }}</td>
                                        <td>{{ $withdrawal->username }}</td>
                                        <td>{{ $withdrawal->bank }}</td>
                                        <td>{{ $withdrawal->account }}</td>
                                        <td>{{ $withdrawal->withdrawal_amount+$withdrawal->commission }}</td>
                                        <td>{{ $withdrawal->withdrawal_amount }}</td>
                                        <td>{{ $withdrawal->commission }}</td>
                                        <td>
                                            <button class="btn btn-success">{{ $withdrawal->status }}</button>
                                        </td>
                                        <!-- <td><a href="#" class="btn btn-primary">Details</a></td> -->
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