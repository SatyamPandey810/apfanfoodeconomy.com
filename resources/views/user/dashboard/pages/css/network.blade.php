<style>

  body {

      background-color: #f0f2f5;

      font-family: 'Poppins', sans-serif;

  }



  .dashboard-container {

      padding-top: 8px;

  }



  .chart-container {

      background-color: #fff;

      padding: 10px;

      border-radius: 10px;

      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);

      text-align: center;

     

  } 



  .chart-container h2 {

      font-size: 1.8em;

      margin-bottom: 20px;

      color: #333;

  }



  .dashboard-summary {

      display: flex;

      flex-wrap: wrap; 

      gap: 20px;

  }

   
  .summary-card {

      flex: 510px; 

      position: relative;

      background-color: #fff;

       padding: 70px;

      border-radius: 5px;

      text-align: center;

      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);

      font-size: 1.4em;

      color: #555;

      transition: transform 0.4s ease, box-shadow 0.4s ease;

      overflow: hidden;

      cursor: pointer;

  }



  .summary-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);

  }



  .summary-card .icon {

      font-size: 70px;

      margin-bottom: 10px;

      color: #fff;

  }



  /* Updated Gradient Backgrounds */

  .summary-card:nth-child(1) {

      background: linear-gradient(135deg, #4CAF50, #32a852);
    display: flex;
    color: white;
    justify-content: center;
    align-items: center;
    gap: 38px;
  }



  .summary-card:nth-child(2) {

      background: linear-gradient(135deg, #FFC107, #FF9800);
      display: flex;
    color: white;
    justify-content: center;
    align-items: center;
    gap: 38px;
      color: white;

  }



  .summary-card:nth-child(3) {

      background: linear-gradient(135deg, #64B5F6, #2196F3);
      display: flex;
    color: white;
    justify-content: center;
    align-items: center;
    gap: 38px;
      color: white;

  }



  .summary-card:nth-child(4) {

      background: orangered;
      display: flex;
    color: white;
    justify-content: center;
    align-items: center;
    gap: 38px;
      color: white;

  }

  .summary-card p{
    font-size: 20px;
    font-weight: 900;
    
  }
@media (max-width: 767.98px) {
    .summary-card .icon {

font-size: 40px;

margin-bottom: 10px;

color: #fff;

}
.summary-card p{
    font-size: 20px;
    font-weight: 900;
    
  }
  .summary-card:nth-child(1) {

background: linear-gradient(135deg, #4CAF50, #32a852);
display: flex;
color: white;
justify-content: center;
align-items: center;
gap: 30px;
}



.summary-card:nth-child(2) {

background: linear-gradient(135deg, #FFC107, #FF9800);
display: flex;
color: white;
justify-content: center;
align-items: center;
gap: 30px;
color: white;

}



.summary-card:nth-child(3) {

background: linear-gradient(135deg, #64B5F6, #2196F3);
display: flex;
color: white;
justify-content: center;
align-items: center;
gap: 30px;
color: white;

}



.summary-card:nth-child(4) {

background: linear-gradient(135deg, #EF5350, #F44336);
display: flex;
color: white;
justify-content: center;
align-items: center;
gap: 30px;
color: white;

}
}
</style>