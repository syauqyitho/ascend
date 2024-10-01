@extends('layouts.app')

@section('title', 'Create Reservation')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <!-- <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div> -->
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <?= form_open('reservation/store') ?>
              <div class="form-group">
                <label for="reservation_status">Reservation Status</label>
                <select class="custom-select rounded-0" id="reservation_status" name="reservation_status">
                  @foreach ($reservation_status as $status)
                    <option value="{{ $status->reservation_status_id }}" {{ isset($data['reservation_status_id']) && $data['reservation_status_id'] == $status->reservation_status_id ? 'selected' : '' }}>{{ $status->reservation_status_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="reservation_type">Reservation Type</label>
                <select class="custom-select rounded-0" id="reservation_type" name="reservation_type">
                  @foreach ($reservation_type as $type)
                    <option value="{{ $type->reservation_type_id }}">{{ $type->reservation_type_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="room_type">Room Type</label>
                <select class="custom-select rounded-0" id="room_type" name="room_type">
                  @foreach ($room_type as $room)
                    <option value="{{ $room->room_type_id }}">{{ $room->room_type_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name">
              </div>
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name">
              </div>
              <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="child">Child</label>
                <input type="number" class="form-control" id="child" name="child" placeholder="Total Child">
              </div>
              <div class="form-group">
                <label for="adult">Adult</label>
                <input type="number" class="form-control" id="adult" name="adult" placeholder="Total Adult">
              </div>
              <div class="form-group">
                <label>Arrival</label>
                <input type="datetime-local" class="form-control" id="arrival" name="arrival" placeholder="Enter arrival">
                  <!-- <div class="input-group date" id="arrival" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#arrival" name="arrival"/>
                      <div class="input-group-append" data-target="#arrival" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div> -->
              </div>
              <div class="form-group">
                <label>Departure</label>
                <input type="datetime-local" class="form-control" id="departure" name="departure" placeholder="Enter departure">
                  <!-- <div class="input-group date" id="departure" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#departure" name="departure"/>
                      <div class="input-group-append" data-target="#departure" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div> -->
              </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="<?= base_url('reservation') ?>" class="btn btn-primary">Back</a>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('add-script')
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#arrival').datetimepicker({ icons: { time: 'far fa-clock' } });
    $('#departure').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
@endsection
