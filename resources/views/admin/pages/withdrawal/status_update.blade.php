
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Panel</title>
  <!--===============================================================================================-->	
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!--===============================================================================================-->	
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @include('admin.include.head')
  <style>
   /* public/css/custom.css */
/* public/css/custom.css */

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    font-weight: bold;
    text-align: center;
}

.card-body p {
    margin-bottom: 0.5rem;
}


    </style>
</head>
<body>
    @include('admin.include.header')
     
          
    @include('admin.include.sidebar')
    <div class="pcoded-content">
        <!-- <div class="containerss"><center><h4><b>Withdrawal Pending</b></h4></center></div> -->
        <div class="container">
   <div class="content-head2">
     <h4 class="sub-content-head2" style="font-weight: 900;">Withdrawal Pending</h4>
    </div>
  </div>
        
        <div class="container">
    
            <div class="row">
                @foreach ($withdrawals as $withdrawal)
                    <div class="col-md-12 col-lg-12 mb-12">
                        <div class="card shadow-sm border-0 rounded-lg" style="background: rgb(255, 253, 253); border: 1px solid rgb(64, 52, 113);">
                            <div class="card-header" style="background: rgb(64, 52, 113); color: white; text-transform: uppercase;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Withdrawal #{{ $withdrawal->id }}</span>
                                    <button class="btn btn-warning btn-sm">{{ $withdrawal->status }}</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>User ID:</strong> {{ $withdrawal->user_id }}</p>
                                <p class="card-text"><strong>Username:</strong> {{ $withdrawal->username }}</p>
                                <p class="card-text"><strong>Account Name:</strong> {{ $withdrawal->account_name }}</p>
                                <p class="card-text"><strong>Bank:</strong> {{ $withdrawal->bank }}</p>
                                <p class="card-text"><strong>Account:</strong> {{ $withdrawal->account }}</p>
                                <p class="card-text"><strong>Total Amount:</strong> {{ $withdrawal->total_amount }}</p>
                                <p class="card-text"><strong>Withdrawal Amount:</strong> {{ $withdrawal->withdrawal_amount }}</p>
                                <p class="card-text"><strong>Commission:</strong> {{ $withdrawal->commission }}</p>
    
                                <!-- Status Update Form -->
                                <form action="{{ route('withdrawal.status', $withdrawal->id) }}"  method="get">
                                    @csrf

                                    <div class="form-group">
                                        <label for="status">Update Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Pending" {{ $withdrawal->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Success" {{ $withdrawal->status == 'Success' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ $withdrawal->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>
</div>
    @include('admin.include.script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                  text: '{{ session('success') }}',
                    icon: 'success',
                    title: 'Success',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                Swal.fire({
                  text: '{{ session('error') }}',
                    icon: 'error',
                    title: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</body>
</html>