<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Withdrawal Request</title>
  @include('user.dashboard.include.head')
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:  #f7fff4;
    }

    .encashment-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .encashment-header h2 {
      font-size: 32px;
      font-weight: bold;
      color: #444;
    }

    .form-container {
      background-color: #fff;
      border-radius: 8px;
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .form-container label {
      font-weight: bold;
      color: #2a6cc4;
    }

    .form-control {
      border-radius: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      transition: border-color 0.3s;
    }

    .form-control:focus {
      border-color: #2a6cc4;
      box-shadow: 0 0 5px rgba(42, 108, 196, 0.3);
    }

    .btn-success {
      background-color: #2a6cc4;
      border: none;
      padding: 12px;
      font-size: 18px;
      width: 100%;
      border-radius: 30px;
      transition: background-color 0.3s;
    }

    .btn-success:hover {
      background-color: #235a9e;
    }

    .alert {
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .btn-success {
        font-size: 16px;
      }
    }

    .toggle-container {
      text-align: center;
      margin-bottom: 20px;
      padding-top: 30px;
    }

    .toggle-container label {
      margin-right: 10px;
      font-weight: bold;
      font-size: 25px;
    }

    .hidden {
      display: none;
    }
    /* Container styling */
.toggle-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    padding: 15px;
/*    border: 2px solid #ddd;*/
    border-radius: 10px;
/*    background-color: #f9f9f9;*/
}

/* Label styling */
.toggle-container label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: bold;
    color: #555;
    transition: color 0.3s;
}

.toggle-container label:hover {
    color: #007bff;
}

/* Radio input styling */
.toggle-container input[type="radio"] {
    display: none;
}

/* Custom radio button appearance */
.toggle-container span {
    position: relative;
    padding-left: 25px;
    font-size: 16px;
}

/* Custom radio circle */
.toggle-container span::before {
    content: '';
    position: absolute;
    left: 0;
    top: 2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #007bff;
    transition: background-color 0.3s;
}

/* Checked state styling */
.toggle-container input[type="radio"]:checked + span::before {
    background-color: #007bff;
    border-color: #007bff;
}

  </style>
</head>

<body>
  @include('user.dashboard.include.header')
  <div class="container">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mob-res">
                <h2 class="text-center">Withdrawal<span style='color:navy'> Form</span></h2>
                <hr class="w-25 mx-auto bg-danger">

                <p class="card-description"> <code></code>
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="toggle-container">
    <label>
        <input type="radio" name="option" value="form1" onclick="toggleForms(this.value)" checked class="form-control">
        <span>Withdrawal Request</span>
    </label>
    <label>
        <input type="radio" name="option" value="form2" onclick="toggleForms(this.value)" class="form-control">
        <span>Food Request</span>
    </label>
</div>


    <div id="form1" class="form-container">
      <form id="withdrawalForm" method="POST" action="{{route('withdrawal.storeuser')}}">
        @csrf
        <div class="row">
          <div class="form-group col-md-6">
            <label for="accountNumber">Username</label>
            <input type="text" class="form-control" name="username" disabled value="{{$Name}}" style="color: #2a6cc4;">
          </div>
          <div class="form-group col-md-6">
            <label for="accountNumber">Total Balance</label>
            <input type="text" class="form-control" value="{{$totalwallet}}" disabled style="color: #2a6cc4;">
          </div>
          <div class="form-group col-md-6">
            <label for="withdrawalAmount">Withdrawal Amount</label>
            <input type="number" class="form-control" id="withdrawalAmount" name="w_amount" placeholder="Minimum 3000 (NG)" oninput="calculateCommission()">
          </div>
          <div class="form-group col-md-6">
            <label for="commission">Receiver Amount In (NG)</label>
            <input type="text" class="form-control" id="commission" name="commission" disabled style="color: #2a6cc4;">
          </div>
          <div class="form-group col-md-6">
            <label for="payment_method">Payment Method</label>
            <select id="userSelect" name="bank" class="form-control" required>
              <option value="" disabled selected>Select Payment Method</option>
              <option value="Access Bank Plc" >Access Bank Plc</option>
              <option value="Fidelity Bank Plc">Fidelity Bank Plc</option>
              <option value="First Bank of Nigeria Limited">First Bank of Nigeria Limited</option>
              <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
              <option value="United Bank for Africa Plc">United Bank for Africa Plc</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="accountNumber">Account Number</label>
            <input type="text" id="accountNumber" name="account" class="form-control" required style="color: #2a6cc4;">
          </div>
        </div>
        <div class="row  d-flex justify-content-center">
        <div class="col-md-4 p-3">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
       </div>
      </form>
    </div>

    <div id="form2" class="form-container hidden">
      <form id="foodRequestForm" method="POST" action="{{route('food.store')}}">
        @csrf
        <div class="row">
          <div class="form-group col-md-6">
            <label for="accountNumber">Username</label>
            <input type="hidden" name="user_id" value="{{$user->user_id }}">
            <input type="text" class="form-control" name="username" disabled value="{{$Name}}" style="color: red;">
          </div>
          <div class="form-group col-md-6"> 
            <label for="totalBalance">Total Balance</label>
            <input type="text" class="form-control" value="{{$user->total_food}}" name="total_amount" disabled style="color: red;">
          </div>
          <div class="form-group col-md-6">
            <label for="foodAmount">Food Purchase Amount</label>
            <input type="number" class="form-control" id="foodAmount" name="purchase_amount" placeholder="Food Purchase Amount" required>
          </div>
          <div class="form-group col-md-6">
            <label for="commission">Message</label>
            <input type="text" class="form-control" id="message" name="message" required>
          </div>

        </div>
        <div class="row  d-flex justify-content-center">
        <div class="col-md-4 p-3">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
       </div>
      </form>
    </div>
  </div>
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    function toggleForms(formId) {
      document.querySelectorAll('.form-container').forEach(form => form.classList.add('hidden'));
      document.getElementById(formId).classList.remove('hidden');
    }

    function calculateCommission() {
      var amount = document.getElementById("withdrawalAmount").value;
      if (amount && amount >= 3000) {
        var commission = (amount * 0.05).toFixed(2);
        document.getElementById("commission").value = (amount - commission) + " NG";
      } else {
        document.getElementById("commission").value = "";
      }
    }
  </script>
<script>
   $(document).ready(function() {
      $('#userSelect').change(function() {
        var userId = $(this).val(); 
        $.ajax({
            url: '{{ route("getUserAccount") }}', 
            method: 'GET',
            data: { user_id: userId }, 
            success: function(response) {
                if (response.account_number) {
                    $('#accountNumber').val(response.account_number).prop('readonly', true);
                    $('#accountError').remove(); 
                } else {
                    $('#accountNumber').val('').prop('readonly', false); 

                    if (!$('#accountError').length) {
                        $('#accountNumber').after('<span id="accountError" style="color:red;">Your account number is not registered.</span>');
                    }
                }
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseText); 
            }
        });
    });
});

function calculateCommission() {
    var withdrawalAmount = document.getElementById("withdrawalAmount").value;
  
    if (withdrawalAmount && withdrawalAmount >= 12) {
        var commission = (withdrawalAmount * 0.05).toFixed(2);
        const remaning = withdrawalAmount-commission;
        document.getElementById("commission").value = "$" + remaning ;
    } else {
        document.getElementById("commission").value = "";
    }
}
</script>
<script>
  // Only allow submission if it's Monday or Tuesday
  $(document).ready(function() {
    var today = new Date().getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
    if (today !== 1 && today !== 2) {
      $('#withdrawalForm').find('button[type="submit"]').prop('disabled', true);
    }
  });
</script>
  <!-- @include('user.dashboard.include.footer') -->
</body>

</html>
