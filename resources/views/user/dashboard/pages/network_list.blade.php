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
    </style>
</head>

<body>
    @include('user.dashboard.include.header')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mob-res">
                <h2>Referral<span style='color:navy'> User</span></h2>
                <hr class="w-25 mx-auto bg-danger">
                <p class="card-description"> <code></code>
                </p>
            </div>
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
                                <th>Username</th>
                                <th>MemberId</th>
                                <th>position</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($directReferrals as $item)
                            <tr>
                                <td class="py-1">{{$i++}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->user_id}}</td>
                                <td>{{$item->user_position}}</td>
                                <td>{{$item->created_at}}</td>
                                <td><a class="btn btn-success">{{$item->status}}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex" style="float:right;">
                        {{ $directReferrals->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('user.dashboard.include.footer') --}}
</body>

</html>