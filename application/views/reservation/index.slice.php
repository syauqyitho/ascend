@extends('layouts.app')

@section('title', 'List Reservation');

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <!-- <h3 class="card-title">DataTable with default features</h3> -->
            <a href="<?= base_url('reservation/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Reservation</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Guest Name</th>
                <th>Phone Number</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Status</th>
                <th>Room</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->first_name.' '.$reservation->last_name }}</td>
                  <td>{{ $reservation->phone_number }}</td>
                  <td>{{ $reservation->arrival }}</td>
                  <td>{{ $reservation->departure }}</td>
                  <td><span class="btn btn-sm btn-info">{{ $reservation->reservation_status_name }}</span></td>
                  <td>{{ $reservation->room_type_name }}</td>
                  <td>
                    <a href="<?= base_url('reservation/show/'.$reservation->reservation_id) ?>" class="btn btn-primary">Detail</a>
                  </td>
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
@endsection

@section('add-script')
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
</script>
@endsection
