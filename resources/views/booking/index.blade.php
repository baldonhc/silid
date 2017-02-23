@extends('layouts.master')
@section('content')
  <div class="col s12 m2 center-align">
    <p class="z-depth-3" style="padding: 15px 0">
      <i class="material-icons">info</i> Select a room, booking date, time and duration.
    </p>
  </div>

  @if (count($booking_errors) > 0)
  <blockquote class="red lighten-3 errors">
      <ul>
          @foreach ($booking_errors as $k=>$error)
              <li>
                @if ($k==0)
                  <i class="material-icons">warning</i>
                @endif
                {!! $error !!}
              </li>
          @endforeach
      </ul>
  </blockquote>
  @endif

  @if ($success_message != "")
  <blockquote class="green lighten-2 success">
    <i class="material-icons">info_outline</i> {{$success_message}}
  </blockquote>
  @endif

  <form class="col s12" name="booking" method="POST">
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="{{$purpose_label}}" type="text" id="purpose" name="purpose" value="{{@$booking_parameters['purpose']}}" maxlength="255">
        <label for="purpose">Purpose</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s6">
        <select name="room_id">
          <option value="" disabled selected>Select Room</option>
          @foreach ($rooms as $room)
            <option value="{{$room->id}}"
              @if (isset($booking_parameters['room_id']) &&
                   $room->id == $booking_parameters['room_id'])
              selected
              @endif
              >{{$room->name}}</option>
          @endforeach
        </select>
        <label>Select Room</label>
      </div>
      <div class="input-field col s6">
        <input placeholder="Email" id="reserved_by" type="text" value="{{$email}}" disabled>
        <label for="reserved_by">Reserved by</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Date" id="booking_date" type="text" class="datepicker" name="booking_date" value="{{@$booking_parameters['booking_date']}}">
        <label for="booking_date">Select booking date</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s6">
        <input placeholder="Time" id="booking_time" type="text" class="timepicker" name="booking_time" value="{{@$booking_parameters['booking_time']}}">
        <label for="booking_time">Select booking time</label>
      </div>
      <div class="input-field col s6">
        <select name="booking_duration" id="booking_duration">
          <option value="" disabled selected>Booking duration</option>
          @foreach ($booking_durations as $duration => $label)
            <option value="{{$duration}}"
            @if (isset($booking_parameters['booking_duration']) &&
                 $duration == $booking_parameters['booking_duration'])
            selected
            @endif
            >{{$label}}</option>
          @endforeach
        </select>
        <label>Duration</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <button class="btn waves-effect waves-light
        @if (env('COMPANY_BASE_THEME_COLOR')!='')
          {{env('COMPANY_BASE_THEME_COLOR')}}
        @else
          green accent-5
        @endif
        " type="submit" name="action">Submit
          <i class="material-icons right">send</i>
        </button>
        <a href="/booking/reset" onclick="return confirm('Are you sure you want to clear the form?')" class="waves-effect waves-teal btn-flat">Reset</a>
      </div>
    </div>
  </form>
@stop

@section('style')
  @if (env('COMPANY_PICKADATE_THEME_COLOR_TOP')!='')
  .picker__date-display, .picker__weekday-display{
      background-color: {{env('COMPANY_PICKADATE_THEME_COLOR_TOP')}};
  }
  @endif

  @if (env('COMPANY_PICKADATE_THEME_COLOR_TOP')!='')
  .picker__box{
    background-color: {{env('COMPANY_PICKADATE_THEME_COLOR_BOTTOM')}};
  }
  @endif
@stop


@section('script')
<script>
$(document).ready(function(){
  $('#purpose').focus();
  $('#booking_duration').change(function(){
    if (!Number.isInteger( parseInt($(this).val()) )) {
      $('#booking_time').attr('disabled', 'true');
    } else {
      $('#booking_time').removeAttr('disabled');
    }
  })
})
</script>
@stop
