@extends('Admin.layout')

@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <h3 class="page-title mt-3">Good Morning {{ $fullname }}!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ $totalBookings }}</h3>
                            <h6 class="text-muted">Total Booking</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"> <i class="fas fa-book"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ $totalRevenue }}</h3>
                            <h6 class="text-muted">Revenue</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"> <span class="opacity-7 text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="#009688" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ $totalOccupancy }}</h3>
                            <h6 class="text-muted">Occupancy Rate</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0"> <i class="fas fa-percent"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ number_format($averageRate, 2) }}</h3>
                            <h6 class="text-muted">Ratings</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
        <div class="col-md-12 col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">OCCUPANCY RATE</h4>
                </div>
                <div class="card-body">
                    <canvas id="occupancyRateChart"></canvas>
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
                    <canvas id="guests-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: {!! json_encode($data['labels']) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Enable responsiveness
            maintainAspectRatio: false, // Do not maintain aspect ratio
            indexAxis: 'y',
        }
    });
    var ctxOccupancy = document.getElementById('occupancyRateChart').getContext('2d');
    var occupancyChart = new Chart(ctxOccupancy, {
        type: 'line',
        data: {
            labels: {!! json_encode($datas['labels']) !!},
            datasets: {!! json_encode($datas['datasets']) !!}
        },
        options: {
            responsive: true, // Enable responsiveness
            maintainAspectRatio: false, // Do not maintain aspect ratio
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Days of the Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Lodges'
                    }
                }
            }
        }
    });
    var ctxGuests = document.getElementById('guests-chart').getContext('2d');
    var guestsChart = new Chart(ctxGuests, {
        type: 'pie',
        data: {!! json_encode($guestsChartData) !!},
        options: {
            // Add any options as needed
            responsive: true, // Enable responsiveness
            maintainAspectRatio: false, // Do not maintain aspect ratio
        }
    });
</script>


@endsection
