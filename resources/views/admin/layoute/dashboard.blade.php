<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin.include.head')

  <style>
    /* Dashboard Layout */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7fa;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .dashboard-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 30px;
      gap: 10px;
      margin-top: -16px!important;
    }

    .card {
      background: linear-gradient(135deg, #5b86e5 0%, #36d1dc 100%);
      border-radius: 12px;
      width: 100%;
      max-width: 280px;
      padding: 25px 20px;
      text-align: center;
      color: #fff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      position: relative;
      overflow: hidden;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    /* Card Content */
    .card-icon {
      font-size: 48px;
      margin-bottom: 20px;
      transition: color 0.4s;
    }

    .card-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }

    .card-value {
      font-size: 30px;
      font-weight: bold;
      color: #fff;
      margin-top: 10px;
    }

    /* Card Animation and Overlay */
    .card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0) 70%);
      transform: rotate(30deg);
      opacity: 0.3;
    }

    .card:hover .card-icon {
      color: #ffe082;
    }

    /* Responsive Cards */
    @media (max-width: 1024px) {
      .card {
        max-width: 48%; /* Show two cards per row on medium screens */
      }
    }

    @media (max-width: 768px) {
      .card {
        max-width: 100%; /* Stack cards on small screens */
      }
    }
  </style>
</head>

<body>

  @include('admin.include.header')
  @include('admin.include.sidebar')

  <div class="pcoded-content">
    <div class="dashboard-container">
      <!-- Card 1 -->
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <div class="card-title">Total Sales</div>
        <div class="card-value">NG {{$totalUser*6000}}</div>
      </div>

      <!-- Card 2 -->
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-title">New Users</div>
        <div class="card-value">{{$totalUser}}</div>
      </div>

      <!-- Card 3 -->
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="card-title">Revenue</div>
        <div class="card-value">NG {{$totalUser*6000}}</div>
      </div>

      <!-- Card 4 -->
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-comments"></i>
        </div>
        <div class="card-title">Feedback</div>
        <div class="card-value">86%</div>
      </div>
    </div>
  </div>

  @include('admin.include.content')
  @include('admin.include.script')

</body>

</html>
