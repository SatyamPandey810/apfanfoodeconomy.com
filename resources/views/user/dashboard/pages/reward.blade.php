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

            color: green;



        }
    </style>

</head>

<body>

    @include('user.dashboard.include.header')




    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mob-res">
                <h2 class="text-center">Rewards<span style='color:navy'> Bonus</span></h2>
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
                            {{-- <th>UserId</th> --}}
                            <th>Level</th>
                            <th>Bonus</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $count = ($reward->currentPage() - 1) * $reward->perPage() + 1;
                       @endphp
                        @foreach($reward as $item)
                        <tr>
                            <td class="py-1">{{$count}}</td>
                            <td>{{$item->option}}</td>
                            {{-- <td>{{$item->user_id}}</td> --}}
                            <td class="text">+{{$item->bonus}}</td>
                            <td>{{$item->created_at}}</td>

                            <td><a class="btn btn-success">{{$item->status}}</a></td>

                        </tr>
                        @php $count++; @endphp
                        @endforeach

                    </tbody>

                </table>

                <div class="d-flex" style="float:right;">

                    {{ $reward->links('pagination::bootstrap-4') }}

                </div>

            </div>
        </div>
    </div>
      </div>


    {{-- @include('user.dashboard.include.footer') --}}



</body>

</html>