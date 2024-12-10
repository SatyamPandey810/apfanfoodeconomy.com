<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Home</title>
  @include('admin.include.head')

  <style>
    /* General container styling */
    .containers {
      padding: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Table styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-size: 16px;
    }

    table th, table td {
      padding: 14px 16px;
      text-align: left;
      border: 1px solid #ddd;
    }

    table th {
      background-color: hsl(189, 53%, 52%);
      color: white;
      text-transform: uppercase;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tr:hover {
      background-color: #f1f1f1;
    }

    /* Search input styling */
    .search-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 10px;
    }

    .search-input {
      padding: 8px 12px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 14px;
      width: 250px; /* Adjust width as needed */
    }

    /* Status badge styling */
    .badge {
      padding: 8px 12px;
      font-size: 14px;
      border-radius: 12px;
      color: white;
      text-align: center;
      display: inline-block;
    }

    .badge-pending {
      background-color: #FFC107;
    }

    .badge-success {
      background-color: #28A745;
    }

    /* Select dropdown styling */
    select {
      padding: 8px 12px;
      font-size: 14px;
      border-radius: 4px;
      border: 1px solid #ccc;
      cursor: pointer;
      transition: border-color 0.3s;
      background-color: antiquewhite;
      
    }

    select:focus {
      border-color: hsl(189, 53%, 52%);
      outline: none;
    }

    /* Button styling */
    .btn {
      padding: 8px 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
   
    }

    .btn:hover {
      background-color: #45a049;
    }

    /* Responsive behavior */
    @media (max-width: 768px) {
      table th, table td {
        padding: 10px;
      }

      .btn {
        padding: 6px 12px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      table th, table td {
        font-size: 12px;
        padding: 8px;
      }
    }
  </style>
</head>
<body>
  @include('admin.include.header')
  @include('admin.include.sidebar')
  <div class="container">
    <div class="content-head6">
      <h4 class="sub-content-head6" style="font-weight: 900;"><span>Food</span><span> Purchase</span></h4>
    </div>
  </div>
  <div class="pcoded-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="same">
          <div class="panel-body">
            <div class="responsive-table">
              <div class="containers">
                <div id="searchResults">
                  <div class="table-responsive">
                    <table id="datatables-example" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Member ID</th>
                          <th>Username</th>
                          <th>Message</th>
                          <th>Food Purchase</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i = ($foodrequest->currentPage() - 1) * $foodrequest->perPage() + 1; @endphp
                        @foreach ($foodrequest as $item)
                         @if($item->status == 'pending')
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $item->user_id }}</td>
                          <td>{{ $item->username }}</td>
                          <td>{{ $item->message }}</td>
                          <td>{{ $item->purchase_amount }}</td>
                          <td>{{ $item->created_at }}</td>
                          <td>
                            <form action="{{ route('dashboard.food.list.update', $item->id) }}" method="POST">
                              @csrf
                              <select name="status" onchange="this.form.submit()">
                                <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ $item->status == 'success' ? 'selected' : '' }}>Success</option>
                              </select>
                            </form>
                          </td>
                        </tr>
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination-container" style="justify-content: flex-end;display: flex;">
                      {{ $foodrequest->links('pagination::bootstrap-4') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <script>
    function filterTable() {
      const input = document.getElementById('tableSearch');
      const filter = input.value.toLowerCase();
      const table = document.getElementById('datatables-example');
      const trs = table.getElementsByTagName('tr');

      for (let i = 1; i < trs.length; i++) {
        const tds = trs[i].getElementsByTagName('td');
        let isMatch = false;
        for (let j = 0; j < tds.length; j++) {
          if (tds[j]) {
            const txtValue = tds[j].textContent || tds[j].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
              isMatch = true;
              break;
            }
          }
        }
        trs[i].style.display = isMatch ? '' : 'none';
      }
    }
  </script>

  @include('admin.include.script')
</body>
</html>
