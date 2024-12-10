<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>
    @include('admin.include.head')
    <style>
        .form-container {
            background-color: #f3f3f3;
            padding: 20px;
            box-shadow: 0px 0px 5px 1px #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-actions {
            margin-top: 20px;
            text-align: right;
        }

        .form-actions button {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-submit {
            background-color: #28a745;
        }

        .btn-cancel {
            background-color: #dc3545;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<!--====================================== Include Header & Sidebar ==========================================-->
@include('admin.include.header')
@include('admin.include.sidebar')

<div class="pcoded-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="panel-body">
                <div class="form-container">
                    <h4>Edit User</h4>

                    <!-- Form for editing user -->
                    <form action="{{ url('update-user/'.$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                      

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" class="form-control" required>
                        </div>
                                             
                        
                        <div class="form-group">
                            <label for="conform_password">Password</label>
                            <input type="password" name="conform_password" value="{{ $user->conform_password }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Orange Money</label>
                            <input type="text" name="orange_money" value="{{ $user->orange_money }}" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="payment_number">Mtn Money</label>
                            <input type="text" name="mtn_money" value="{{ $user->mtn_money }}" class="form-control" >
                        </div>

                          <div class="form-group">
                            <label for="payment_number">TRC20 Address</label>
                            <input type="text" name="TRC20_address" value="{{ $user->TRC20_address }}" class="form-control" >
                        </div>

                          <div class="form-group">
                            <label for="payment_number">Moov Money</label>
                            <input type="text" name="moov_money" value="{{ $user->moov_money }}" class="form-control" >
                        </div>

                          <div class="form-group">
                            <label for="payment_number">Wave</label>
                            <input type="text" name="wave" value="{{ $user->wave }}" class="form-control" >
                        </div>
                         <div class="form-group">
                            <label for="payment_number">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ $user->bank_name }}" class="form-control" >
                        </div>
                         <div class="form-group">
                            <label for="payment_number">Bank Account</label>
                            <input type="text" name="bank_account" value="{{ $user->bank_account }}" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" name="user_email" value="{{ $user->user_email }}" class="form-control" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-submit">Update</button>
                            <a href="{{ route('user') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.include.script')
</body>
</html>
