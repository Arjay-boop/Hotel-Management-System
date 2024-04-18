@extends('Admin.layout')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col" style="gap: 6px;">
                <div class="mt-5">
                    <h4 class="card-title float-left mt-2">Calendar</h4>
                    <button type="button" class="btn btn-primary float-right veiwbutton" data-toggle="modal" data-target="#addEventModal">Add Event</button>
                    <button type="button" class="btn btn-primary float-right veiwbutton" data-toggle="modal" data-target="#addBookingModal">Add Booking</button>
                    <button onclick="removeEventsFromCalendar()" type="button" class="btn btn-primary float-right veiwbutton">Remove Events</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-8">
        <div class="card">
            <div class="card-body">
                <div style="width: 100%;" id="calendar"></div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('assets/js/calendar.js') }}"></script> --}}
</div>
<div id="addEventModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addEventForm" action="{{ route('admin.store-event') }}" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Add Event</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lodgeArea">Lodge Area</label>
                        <select name="lodge_id" id="lodge_id" class="form-control">
                            <option selected>Select</option>
                            @foreach ($lodge as $lodges)
                                <option value="{{ $lodges->lodge_id }}">{{ $lodges->area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="eventName">Event Name:</label>
                        <input type="text" class="form-control" id="eventName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDetails">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Event Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Event End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add the following HTML code for adding bookings -->
<div id="addBookingModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addBookingForm">
                <div class="modal-header">
                    <h4 class="modal-title">Add Booking</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bookingName">Booking Name:</label>
                        <input type="text" class="form-control" id="bookingName" required>
                    </div>
                    <div class="form-group">
                        <label for="bookingDate">Booking Date:</label>
                        <input type="date" class="form-control" id="bookingDate" required>
                    </div>
                    <div class="form-group">
                        <label for="bookingTime">Booking Time:</label>
                        <input type="time" class="form-control" id="bookingTime" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add this JavaScript function to remove the events
function removeEventsFromCalendar() {
    const eventsToRemove = [
        "3:40p test Event 1",
        // Add the descriptions of the other events you want to remove here
        "Description of event 2",
        "Description of event 3",
        "Description of event 4"
    ];

    eventsToRemove.forEach(eventDesc => {
        // Find the index of the event to remove
        const indexToRemove = calendar.events.findIndex(event => event.desc === eventDesc);

        // Remove the event from the events array
        if (indexToRemove !== -1) {
            calendar.events.splice(indexToRemove, 1);
        }
    });

    // Call renderEvents to update the calendar display
    calendar.renderEvents();
}

</script>
@endsection

