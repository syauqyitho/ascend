@extends('layouts.app')

@section('title', 'List Reservation History');

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            @php
              echo form_open('history/date/')
            @endphp
              <div class="form-group d-flex col-6">
                <input type="date" class="form-control" id="start_end" name="start_date" value="{{ isset($start_date) ? $start_date : date('Y-m-d') }}" placeholder="Enter start date" />
                <input type="date" class="form-control mx-2" id="end_date" name="end_date" value="{{ isset($end_date) ? $end_date : date('Y-m-d') }}" placeholder="Enter end date" />
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Phone Number</th>
                <th>Departure</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($reservations as $reservation)
                <tr>
                  <td>{{ $reservation->first_name.' '.$reservation->last_name }}</td>
                  <td>{{ $reservation->room_id }}</td>
                  <td>{{ $reservation->room_type_name }}</td>
                  <td>{{ $reservation->phone_number }}</td>
                  <td>{{ $reservation->departure }}</td>
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
