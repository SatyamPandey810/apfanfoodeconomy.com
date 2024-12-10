<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Form</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{asset('public/website/css/register.css')}}">

</head>

<body>

    <div class="form-container">
    <div class="card-header">
               
              <h4 class="text-center fw-bold">  JOIN US</h4>
                 
            </div>
        <form class="registration-form" id="pinForm" action="{{ route('user.store') }}" method="post">

            @csrf

            <!-- <h2>JOIN US</h2> -->
           


            <div class="form-row">

                <div class="form-group">

                    <input type="text" id="referId" name="referId" placeholder="Referral ID" value="{{ old('referId') }}" required>

                    @error('referId')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

                

                <div class="form-group">

                    <input type="text" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}" required>

                    @error('name')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

            </div>



            <div class="form-row">

                <div class="form-group">

                    <input type="email" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>

                    @error('email')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>



                <div class="form-group">

                    <input type="number" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ old('mobile') }}" required>

                    @error('mobile')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

            </div>



            <div class="form-row">

                <div class="form-group">

                    <input type="text" id="address" name="address" placeholder="Address" value="{{ old('address') }}" required>

                    @error('address')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

            </div>



            <div class="form-row radio-group">

                <h5>Select Position:</h5>

                <div class="d-flex align-items-center">

                    <input type="radio" id="leftRadio" name="join" value="L" class="form-check-input" {{ old('join') == 'L' ? 'checked' : '' }} required>
                  <span>Left</span>

                </div>

                <div class="d-flex align-items-center">

                    <input type="radio" id="rightRadio" name="join" value="R" class="form-check-input" {{ old('join') == 'R' ? 'checked' : '' }}>
                    <span>  Right </span>

                 </div>

                @error('join')

                    <span class="error-text">{{ $message }}</span>

                @enderror

            </div>



            <div class="form-row">

                <div class="form-group">

                    <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>

                    @error('username')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>



                <div class="form-group position-relative">

                    <input type="password" id="password" name="password" placeholder="Password" required>

                    <span class="toggle-password" onclick="togglePassword('password')">👁️</span>

                    @error('password')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

            </div>



            <div class="form-row">

                <div class="form-group position-relative">

                    <select id="package" name="package" required>

                        <option value="" disabled selected>Select Package</option>

                        <option value="6000" {{ old('package') == '6000' ? 'selected' : '' }}>Starter (6000 NG)</option>

                    </select>

                    @error('package')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>



                <div class="form-group position-relative">

                    <input type="text" id="pin" name="pin" placeholder="Enter PIN" value="{{ old('pin') }}" required>

                    @error('pin')

                        <span class="error-text">{{ $message }}</span>

                    @enderror

                </div>

            </div>

            <div class="form-row">
                <div class="form-group">
                    <select id="bank_name" name="bank_name" required>
                        <option value="" disabled selected>Select Bank Name</option>
                        <option value="Access Bank Plc" {{ old('bank_name') == 'Access Bank Plc' ? 'selected' : '' }}>Access Bank Plc</option>
                        <option value="Fidelity Bank Plc" {{ old('bank_name') == 'Fidelity Bank Plc' ? 'selected' : '' }}>Fidelity Bank Plc</option>
                        <option value="First Bank of Nigeria Limited" {{ old('bank_name') == 'First Bank of Nigeria Limited' ? 'selected' : '' }}>First Bank of Nigeria Limited</option>
                        <option value="Union Bank of Nigeria Plc" {{ old('bank_name') == 'Union Bank of Nigeria Plc' ? 'selected' : '' }}>Union Bank of Nigeria Plc</option>
                        <option value="United Bank for Africa Plc" {{ old('bank_name') == 'United Bank for Africa Plc' ? 'selected' : '' }}>United Bank for Africa Plc</option>
                    </select>
                    @error('bank_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
        
                <div class="form-group">
                    <input type="text" id="bank_account" name="bank_account" placeholder="Bank Account Number" value="{{ old('bank_account') }}" required>
                    @error('bank_account')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="join-btn">Join Now</button>

        </form>

    </div>

    <script>

        function togglePassword(fieldId) {

            const field = document.getElementById(fieldId);

            if (field.type === "password") {

                field.type = "text";

            } else {

                field.type = "password";

            }

        }

    </script>

</body>

</html>

