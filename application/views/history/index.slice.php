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
              echo form_open('history')
            @endphp
              <div class="d-flex flex-wrap">
                <input type="date" class="form-control col-lg-2 m-1" id="start_end" name="start_date" value="{{ isset($start_date) ? $start_date : date('Y-m-d') }}" placeholder="Enter start date" />
                <input type="date" class="form-control col-lg-2 m-1" id="end_date" name="end_date" value="{{ isset($end_date) ? $end_date : date('Y-m-d') }}" placeholder="Enter end date" />
                <input type="text" class="form-control col-lg-3 m-1" id="start_end" name="name" value="{{ isset($name) ? $name : '' }}" placeholder="Enter name" />
                <button type="submit" class="btn btn-primary m-1" name="submit">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Status</th>
                <th>Type</th>
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
      "searching": false,
    });
  });
</script>
@endsection
