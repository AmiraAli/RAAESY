<head>
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
@extends('app')
@section('content')
<div class="container">
      
        <div class=" col-sm-10 col-md-6 col-lg-4 ">
          <img class="img-circle glyphicon glyphicon-list-alt" src="/images/reports1.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a  href="{{ url('/reports/summary') }}">Summary</a></h2>
          <p>Build a ticket-report by date range, category, status and all details.</p>
        </div><!-- /.col-lg-4 -->
        <div class=" col-sm-10 col-md-6 col-lg-4">
          <img class="img-circle" src="/images/reports11.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/disthour') }}">Tickets per Hour</a></h2>
          <p>Distription of tickets per hour.</p>
        </div><!-- /.col-lg-4 -->
        <div class=" col-sm-10 col-md-6 col-lg-4 ">
          <img class="img-circle" src="/images/reports9.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/ticketsPerTime') }}">Tickets per Day</a></h2>
          <p>Distription of tickets per day,week.month and custome Date.</p>
        </div><!-- /.col-lg-4 -->
      

      
        <div class=" col-sm-10 col-md-6 col-lg-4">
          <img class="img-circle glyphicon glyphicon-list-alt" src="/images/reports5.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/logs') }}">Deletion Log</a></h2>
          <p>Contains entries of all destructive actions like deleting and spaning tickets,categories, assets, users,articles, etc.</p>
        </div><!-- /.col-lg-4 -->
        <div class=" col-sm-10 col-md-6 col-lg-4">
          <img class="img-circle" src="/images/reports12.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/technicianStatistics') }}">Technician Statistics</a></h2>
          <p>Tickets handled by a user within a date range.</p>
        </div><!-- /.col-lg-4 -->

        <div class="col-sm-10 col-md-6 col-lg-4">
          <img class="img-circle" src="/images/reports13.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/problemMangement') }}">Problem Mangement</a></a></h2>
          <p>Analysis no of tickets solved in each subject and which subject has problem.</p>
        </div><!-- /.col-lg-4 -->
      

      
        <div class="col-sm-10 col-md-6 col-lg-4 ">
          <img class="img-circle glyphicon glyphicon-list-alt" src="/images/reports8.png" alt="Generic placeholder image" width="140" height="140">
          <h2><a href="{{ url('/reports/reportTicketStatus') }}">Tickets History</h2></a>
          <p>Contains all history of each ticket no of open , no of close and the date of when opend and when closed.</p>
        </div><!-- /.col-lg-4 -->
      
@endsection
</body>