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
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
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
    // Add the following code for handling add event form submission
    document.getElementById('addEventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const eventName = document.getElementById('eventName').value;
        const description = document.getElementById('description').value;
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const lodgeId = document.getElementById('lodge_id').value; // Retrieve lodge_id if available

        const event = {
            name: eventName,
            description: description,
            start_date: startDate,
            end_date: endDate,
            lodge_id: lodgeId // Include lodge_id in the event object
        };

        addEvent(event);
        document.getElementById('addEventModal').modal('hide');
    });
    function addEvent(event) {
        // Send an asynchronous POST request to store the event data
        fetch('{{ route("admin.store-event") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(event)
        })
        .then(response => response.json())
        .then(data => {
            // Check if the request was successful
            if (data.success) {
                // Update the calendar with the newly added event
                renderEvents(data.events);
            } else {
                console.error('Failed to add event:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
    });
}
    // Add the following code for handling add event form submission
//     document.getElementById('addEventForm').addEventListener('submit', function(e) {
//     e.preventDefault();
//     const eventName = document.getElementById('eventName').value;
//     const description = document.getElementById('description').value;
//     const startDate = document.getElementById('start_date').value;
//     const endDate = document.getElementById('end_date').value;
//     const lodgeId = document.getElementById('lodge_id').value; // Retrieve lodge_id if available

//     const event = {
//         name: eventName,
//         description: description,
//         start_date: startDate,
//         end_date: endDate,
//         lodge_id: lodgeId // Include lodge_id in the event object
//     };

//     addEvent(event);
//     document.getElementById('addEventModal').modal('hide');
// });


    // Add the following code for handling add booking form submission
    document.getElementById('addBookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const bookingName = document.getElementById('bookingName').value;
    const bookingDate = document.getElementById('bookingDate').value;
    const bookingTime = document.getElementById('bookingTime').value;
    const booking = {
        name: bookingName,
        date: bookingDate,
        time: bookingTime};
    addBooking(booking);
    document.getElementById('addBookingModal').modal('hide');
    });

    // Add the following code for handling event clicks
    function onEventClick(e) {
    const eventEl = e.target.closest('.event');
    const event = {
        name: eventEl.dataset.name,
        date: eventEl.dataset.date,
        time: eventEl.dataset.time
    };
    console.log(event);
    }

    // Add the following code for handling booking clicks
    function onBookingClick(e) {
    const bookingEl = e.target.closest('.booking');
    const booking = {
        name: bookingEl.dataset.name,
        date: bookingEl.dataset.date,
        time: bookingEl.dataset.time
    };
    console.log(booking);
    }

    // Add the following code for rendering events
    function renderEvents(events) {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        eventClick: onEventClick
    });
    calendar.render();
    }

    // Add the following code for rendering bookings
    function renderBookings(bookings) {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: bookings,
        eventClick: onBookingClick
    });
    calendar.render();
    }

    // Add the following code for adding events
    function addEvent(event) {
    const events = getEvents();
    events.push(event);
    saveEvents(events);
    renderEvents(events);
    }

    // Add the following code for adding bookings
    function addBooking(booking) {
    const bookings = getBookings();
    bookings.push(booking);
    saveBookings(bookings);
    renderBookings(bookings);
    }

    // Add the following code for getting events from local storage
    function getEvents() {
    const events = localStorage.getItem('events');
    return events ? JSON.parse(events) : [];
    }

    // Add the following code for getting bookings from local storage
    function getBookings() {
    const bookings = localStorage.getItem('bookings');
    return bookings ? JSON.parse(bookings) : [];
    }

    // Add the following code for saving events to local storage
    function saveEvents(events) {
    localStorage.setItem('events', JSON.stringify(events));
    }

    // Add the following code for saving bookings to local storage
    function saveBookings(bookings) {
    localStorage.setItem('bookings', JSON.stringify(bookings));
    }

    // Initialize events and bookings arrays
    const events = getEvents();
    const bookings = getBookings();

    // Render events and bookings
    renderEvents(events);
    renderBookings(bookings);
</script>
@endsection

