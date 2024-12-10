<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background: linear-gradient(to right, #8e44ad, #3498db);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #ffffff;
        }

        .card-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #6a11cb;
        }

        .btn-primary {
            background-color: #6a11cb;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #2575fc;
        }

        .card-footer {
            text-align: center;
            padding: 1rem;
            background-color: #f1f1f1;
        }
        b{
            color:red;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .login-container {
                max-width: 350px;
            }

            .card-header {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .card-header {
                font-size: 2rem;
            }

            .login-container {
                max-width: 300px;
            }
        }
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .password-container .fa-eye {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 1.2rem;
            cursor: pointer;
        }
        .password-container .fa-eye-slash {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 1.2rem;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="login-container">
        <div class="card">
            <div class="card-header">
                Admin Sign in
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.logins') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="username">Username<b>*</b></label>
                        <input type="text" value="{{ old('username') }}" name="username" id="username"
                            class="form-control" required>
                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="password">Password<b>*</b></label>
                        <div class="password-container">
                        <input type="password" class="form-control" name="password" id="password" required>
                        <i class="fa-solid fa-eye" id="togglePassword"></i>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
            <div class="card-footer">
               
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
