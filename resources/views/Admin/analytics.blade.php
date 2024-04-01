@extends('Admin.layout')

@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="col">
            <div class="col-sm-6 mt-5">
                <h3 class="page-title mt-3">Analytics</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row formtype">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-8 pt-3">
                                <button type="button" onclick="showReportForm(event)" class="btn btn-primary">Generate Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-6" id="occupancy">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Occupancy Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="occupancyRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6" id="room_damage">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Room Damage Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="damageRateChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6" id="average_rate">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Average Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="averageRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6" id="revenue">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">REVENUE</h4>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12" id="total_guest">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">TOTAL GUESTS</h4>
                </div>
                <div class="card-body">
                    <canvas id="totalGuestsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6" id="damage_cost">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Damage Cost</h4>
                </div>
                <div class="card-body">
                    <canvas id="damageCostChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6" id="total_rooms">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Total Rooms</h4>
                </div>
                <div class="card-body">
                    <canvas id="totalRoomsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12" id="customer_rate">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Customer Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="totalCustomersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
     // Function to set chart dimensions
    function setChartDimensions(chartId) {
        var chartCanvas = document.getElementById(chartId);
        if (chartCanvas) {
            chartCanvas.width = 400; // Set width to desired value
            chartCanvas.height = 300; // Set height to desired value
        }
    }

    // Call function to set dimensions for each chart
    setChartDimensions('revenueChart');
    setChartDimensions('occupancyRateChart');
    setChartDimensions('damageRateChart');
    setChartDimensions('averageRateChart');
    setChartDimensions('totalGuestsChart');
    setChartDimensions('damageCostChart');
    setChartDimensions('totalRoomsChart');
    setChartDimensions('totalCustomersChart');

    //revenue
        var ctx = document.getElementById('revenueChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [
                @foreach($revenues as $lodgeName => $revenue)
                    {
                        label: "{{ $lodgeName }}",
                        data: {!! json_encode($revenue) !!},
                        borderColor: getRandomColor(), // Function to get random color for each lodge
                        fill: false
                    },
                @endforeach
            ]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    //Occupancy Rate
        var ctx = document.getElementById('occupancyRateChart').getContext('2d');

        var dates = {!! json_encode($dailyReports->pluck('report_date')->toArray()) !!};

        var data = {
            labels: dates,
            datasets: [
                @foreach($occupancyRates as $lodgeName => $occupancyRate)
                    {
                        label: "{{ $lodgeName }}",
                        data: {!! json_encode($occupancyRate) !!},
                        borderColor: getRandomColor(), // Function to get random color for each lodge
                        fill: false
                    },
                @endforeach
            ]
        };

        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    //Damage Rate
        var ctx = document.getElementById('damageRateChart').getContext('2d');

        var dates = {!! json_encode($dailyReports->pluck('report_date')->toArray()) !!};

        var data = {
            labels: dates,
            datasets: [
                @foreach($damageRates as $lodgeName => $damageRate)
                    {
                        label: "{{ $lodgeName }}",
                        data: {!! json_encode($damageRate) !!},
                        borderColor: getRandomColor(), // Function to get random color for each lodge
                        fill: false
                    },
                @endforeach
            ]
        };

        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    //Average Rate
        var ctx = document.getElementById('averageRateChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                data: {!! json_encode(array_values($averageRates)) !!},
                backgroundColor: [
                    @foreach($averageRates as $lodgeName => $averageRate)
                        getRandomColor(),
                    @endforeach
                ],
                borderColor: 'transparent'
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'polarArea',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    //Total Guest
        var ctx = document.getElementById('totalGuestsChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                data: {!! json_encode(array_values($totalGuests)) !!},
                backgroundColor: [
                    @foreach($totalGuests as $lodgeName => $totalGuest)
                        getRandomColor(),
                    @endforeach
                ]
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    //Damage Cost
        var ctx = document.getElementById('damageCostChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                label: 'Damage Cost',
                data: {!! json_encode(array_values($damageCosts)) !!},
                backgroundColor: [
                    @foreach($damageCosts as $lodgeName => $damageCost)
                        getRandomColor(),
                    @endforeach
                ],
                borderColor: 'transparent',
                borderWidth: 1
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    //Total Rooms
        var ctx = document.getElementById('totalRoomsChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                data: {!! json_encode(array_values($totalRooms)) !!},
                backgroundColor: [
                    @foreach($totalRooms as $lodgeName => $totalRoom)
                        getRandomColor(),
                    @endforeach
                ]
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    //Total Customer per gender
        var ctx = document.getElementById('totalCustomersChart').getContext('2d');

        var data = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [
                {
                    label: 'Male',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: {!! json_encode(array_column($totalCustomers, 'male')) !!}
                },
                {
                    label: 'Female',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: {!! json_encode(array_column($totalCustomers, 'female')) !!}
                }
            ]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    //Generate Report

    function showReportForm(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Generate Report',
            html: `
                <form id="reportForm">
                    @csrf
                    <div class="col formtype">
                        <div class="row-md-3">
                            <div class="form-group">
                                <label>Type of Report</label>
                                <select name="type_report" id="type_report" class="form-control">
                                    <option selected>Select Type of Report</option>
                                    <option value="*">All</option>
                                    <option value="revenue">Revenue</option>
                                    <option value="occupancy_rate">Occupancy Rate</option>
                                    <option value="average_rate">Ratings</option>
                                    <option value="total_bookings">Bookings</option>
                                    <option value="total_customers_by_gender">Customer-By-Gender</option>
                                    <option value="total_damage">Damages</option>
                                </select>
                            </div>
                        </div>
                        <div class="row-md-3">
                            <div class="form-group">
                                <label>Lodge Area</label>
                                <select name="lodge_id" id="lodge_id" class="form-control">
                                    <option selected>Select Lodge</option>
                                    <option value="*">All</option>
                                    @foreach ($lodges as $lodge)
                                        <option value="{{ $lodge->lodge_id }}">{{ $lodge->area }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="row-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Generate',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                console.log('Report Type:', document.getElementById('type_report').value);
                console.log('Lodge ID:', document.getElementById('lodge_id').value);
                console.log('Start Date:', document.getElementById('start_date').value);
                console.log('End Date:', document.getElementById('end_date').value);

                return {
                    reportType: document.getElementById('type_report').value,
                    lodgeId: document.getElementById('lodge_id').value,
                    startDate: document.getElementById('start_date').value,
                    endDate: document.getElementById('end_date').value
                };
            }
        }).then(result => {
            if (result.isConfirmed) {
                generateReport(result.value);
            }
        });
    }

    function generateReport(formData) {
    // Send AJAX request to Laravel controller
    // Get CSRF token value from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Append CSRF token to the form data
    formData._token = csrfToken;
    $.ajax({
        type: 'GET',
        url: '/generate-report',
        data: formData,
        success: function(response) {
            // Check if the response is a PDF file
            if (response) {
                // Directly open the PDF in the browser
                window.open('/generate-report?reportType=' + formData.reportType + '&lodgeId=' + formData.lodgeId + '&startDate=' + formData.startDate + '&endDate=' + formData.endDate);
            } else {
                // Handle empty response or other errors
                console.error('Empty response or error occurred');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Handle errors
        }
    });
}

</script>

<style>
    .reportForm {
        width: 60% !important; /* Adjust the width as needed */
        max-width: 800px !important; /* Adjust the max-width as needed */
    }
</style>
@endsection
