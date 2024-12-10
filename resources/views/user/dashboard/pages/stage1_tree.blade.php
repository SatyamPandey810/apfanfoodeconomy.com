<!DOCTYPE html>

<html>



<head>

    <title>Binary Tree</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @include('user.dashboard.include.head') 

    <link rel="stylesheet"href="{{asset('public/user/panel/style.css')}}">

    <style>

        #hading {

            width: 30%;

            padding: 5px;

            margin-top: 10px;

            border-radius: 50px;

            background-color: rgb(255, 167, 40);

            text-align: center; 

        }

        @media (max-width: 940px) {

            #hading {

                width: 50%;

                margin-top: 100px;

            }

        }

        /* @media (min-width: 768px) {

            #hading {

                width: 50%;

                margin-top: 100px;

            }

        } */

    

        @media (max-width: 480px) {

            #hading {

                width: 80%; 

                padding: 10px; 

                margin-top: 100px;

            }

        }

    </style>

    

</head>

<body style="background: rgb(10 187 172);">

    <div class="container-scroller">

    @include('user.dashboard.include.header')

    <center class="mt-2">

        <h2 class="text-center">Stage -<span style='color:navy'>1</span></h2>
        <hr class="w-25 mx-auto bg-danger">

    </center>

    @if($status == true)

    <div class="tf-tree tf-gap-sm" style="margin-top: 40px;">

        @include('user/dashboard/pages/stage1_node', ['user' => $matrix1s, 'generation' => 1])

    </div>

    </div>

    @endif

</body>



</html>