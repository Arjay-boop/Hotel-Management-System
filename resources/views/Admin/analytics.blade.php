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
                <form action="">
                    <div class="row formtype">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lodge Area</label>
                                <select name="lodge_id" id="lodge_id" class="form-control">
                                    <option selected>Select Lodge</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-8 pt-3">
                                    <a href="" class="btn btn-primary viewbutton">Generate Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Occupancy Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="occupancyRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
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
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Average Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="averageRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
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
        <div class="col-md-12 col-lg-12">
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
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Damage Cost</h4>
                </div>
                <div class="card-body">
                    <canvas id="damageCostChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
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
        <div class="col-md-12 col-lg-12">
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
<script>
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
            options: {}
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
            options: {}
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
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
</script>
@endsection
