@extends('layouts.app')

@section('title', 'List Room');

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- <div class="card-header">
            <a href="<?= base_url('reservation/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Reservation</a>
          </div> -->
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Room Id</th>
                <th>Room Type</th>
                <th>Room Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($rooms as $room)
                <tr>
                  <td>{{ $room->room_id }}</td>
                  <td>{{ $room->room_type }}</td>
                  <td>{{ $room->room_status }}</td>
                  <td>
                    <a href="<?= base_url('room/show/'.$room->room_id) ?>" class="btn btn-primary">Detail</a>
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
