@php
defined('BASEPATH') OR exit('No direct script access allowed');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
      table {
        width: 100%;
        /* border: 1px solid #000; */
        border-spacing: 0;
      }
      table tr:first-child th,
      table tr:first-child td {
        border-top: 1px solid #2A2D34;
      }
      table tr th:first-child,
      table tr td:first-child {
        border-left: 1px solid #2A2D34;
      }
      table tr th,
      table tr td {
        border-right: 1px solid #2A2D34;
        border-bottom: 1px solid #2A2D34;
      }
      th {
        font-size: 0.8rem;
      }
      td {
        font-size: 0.7rem;
      }
      h2 {
        text-align: center;
        padding-bottom: 1rem;
      }
    </style>
</head>
<body>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h2>Laporan Reservasi</h2>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Room</th>
                <th>Type</th>
                <th>Status</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Check In</th>
                <th>Check Out</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->first_name.' '.$reservation->last_name }}</td>
                  <td>{{ $reservation->phone_number }}</td>
                  <td>{{ $reservation->room_number }}</td>
                  <td>{{ $reservation->room_type_name }}</td>
                  <td><span class="btn btn-sm btn-info">{{ $reservation->reservation_status_name }}</span></td>
                  <td>{{ $reservation->arrival }}</td>
                  <td>{{ $reservation->departure }}</td>
                  <td>{{ $reservation->check_in }}</td>
                  <td>{{ $reservation->check_out }}</td>
                </tr>
              @endforeach
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
</body>
</html>