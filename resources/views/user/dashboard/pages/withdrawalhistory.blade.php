<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>User Panel</title>
    @include('user.dashboard.include.head')
    <style>
        th {
            background-color: #424040;
            color: #fff;
            font-weight: bold;
        }

        .text {
            color: rgb(238, 177, 8);


        }
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('user.dashboard.include.header')
        <div class="row">
            <div class="col-md-12 text-center mob-res">
                <h2>Withdrawal<span style='color:navy'> History</span></h2>
                <hr class="w-25 mx-auto bg-danger">
                <p class="card-description"> <code></code>
                </p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive border">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Bank</th>
                                    <th>Account</th>
                                    <th>Withdrawal Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($withdrawals as $withdrawal)
                                <tr>
                                    <td class="py-1">{{$i++}}</td>
                                    <td data-label="Bank">{{ $withdrawal->bank }}</td>
                                    <td data-label="Account">{{ $withdrawal->account }}</td>
                                    <td data-label="Withdrawal Amount">{{
                                        $withdrawal->withdrawal_amount+$withdrawal->commission}} (NG)</td>
                                    <td data-label="Date">{{ $withdrawal->created_at }}</td>
                                    @if($withdrawal->status === 'Rejected')
                                    <td data-label="Status" class="btn btn-danger">
                                        {{ ucfirst($withdrawal->status) }}
                                    </td>
                                    @elseif($withdrawal->status === 'Success')
                                    <td data-label="Status" class="btn btn-success">
                                        {{ ucfirst($withdrawal->status) }}
                                    </td>
                                    @else
                                    <td data-label="Status" class="btn btn-warning">
                                        {{ ucfirst($withdrawal->status) }}
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex" style="float:right;">
                            {{ $withdrawals->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('user.dashboard.include.footer') --}}
    </div>
</body>

</html>