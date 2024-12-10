<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    @include('user.dashboard.include.head')
    @include('user.dashboard.pages.css.network')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #e0e8f0);
            margin: 0;
            padding: 0;
        }
        .profile{
                background: #ffe7e7;
    padding: 27px;
    border-radius: 50%;
    font-size: 36px;
    color: black;
    border: 0px solid darkb
        }

        .container {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
            margin-bottom: 20px;
            width: 100%;
        }

        @media (min-width: 768px) {
            .profile-card {
                flex-direction: row;
            }
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color:#098153;
            color: #fff;
            padding: 30px;
            text-align: center;
            flex: 1;
        }

        .btn {
            background-color: lightseagreen !important;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
        }

        .profile-section h3 {
            font-size: 1.5rem;
            margin: 10px 0 5px;
        }

        .profile-section p {
            font-size: 16px;
            opacity: 0.9;
            margin: 5px 0;
        }

        .profile-section hr {
            width: 80%;
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin: 15px 0;
        }

        .form-section {
            flex: 2;
            padding: 30px 20px;
            background: #f9f9f9;
            border-left: 2px solid #eef2f3;
        }

        .form-section h5 {
            font-size: 1.4rem;
            color: lightseagreen;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 1rem;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 15px rgba(0, 91, 187, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-icon {
            margin-right: 10px;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                width: 100%;
            }

            .profile-section,
            .form-section {
                padding: 20px;
            }

            .profile-section h3 {
                font-size: 1.2rem;
            }

            .profile-section p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="row profile-card">
            <div class="profile-section">
                <div class="profile">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <hr>
                <p><strong>Username:</strong> {{ $user->username ?? 'Not provided' }}</p>
                <p><strong>Password:</strong> {{ $user->conform_password ?? 'Not provided' }}</p>
                <p><strong>Phone:</strong> {{ $user->mobile ?? 'Not provided' }}</p>
                <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
            </div>

            <div class="form-section">
                <h5>Edit Profile</h5>
                @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">&#10004;</span> {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <span class="alert-icon">&#10060;</span>
                    <ul style="list-style-type: none; padding-left: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('profile.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password (leave blank to keep current password)</label>
                        <div class="position-relative">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="New Password">
                            <i id="passwordIcon" class="fas fa-eye position-absolute"
                                onclick="togglePasswordVisibility('password', 'passwordIcon')"
                                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="position-relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Confirm New Password">
                            <i id="passwordConfirmIcon" class="fas fa-eye position-absolute"
                                onclick="togglePasswordVisibility('password_confirmation', 'passwordConfirmIcon')"
                                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>

</html>
