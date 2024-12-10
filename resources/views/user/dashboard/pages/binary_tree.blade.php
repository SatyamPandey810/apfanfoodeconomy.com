<!DOCTYPE html>
<html>

<head>
    <title>Binary Tree</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('user.dashboard.include.head') 
    <link rel="stylesheet"href="{{asset('public/user/panel/style.css')}}">

</head>
<body style="background: lightyellow;">
    <div class="container-scroller">
    @include('user.dashboard.include.header')
    <div class="tf-tree tf-gap-sm" style="margin-top: 100px;">
        @include('user/dashboard/pages/binary_tree_node', ['user' => $currentUser, 'generation' => 1])
    </div>
    </div>
</body>

</html>