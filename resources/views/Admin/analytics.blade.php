@extends('Admin.layout')

@section('content')
<style>
    .d-none {
        display: none;
    }
</style>
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
                    <form id="reportForm" action="{{ route('generate.report') }}" method="POST">
                        @csrf
                        <div class="row formtype">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Type of Report</label>
                                    <select onchange="showChart(this)" name="type_report" id="type_report" class="form-control">
                                        <option value="*" selected>Select All</option>
                                        <option value="revenue">Revenue</option>
                                        <option value="occupancy_rate">Occupancy Rate</option>
                                        <option value="average_rate">Ratings</option>
                                        <option value="total_bookings">Bookings</option>
                                        <option value="total_customers_by_gender">Customer-By-Gender</option>
                                        <option value="damage_rate">Damage Rate</option>
                                        <option value="damage_cost">Damage Cost</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Lodge Area</label>
                                    <select name="lodge_id" id="lodge_id" class="form-control">
                                        <option value="*" selected>Select All Lodge</option>
                                        @foreach ($lodges as $lodge)
                                            <option value="{{ $lodge->lodge_id }}">{{ $lodge->area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input onchange="filterDateArray()" type="date" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input onchange="filterDateArray()" type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                            <div class="row-md-3">
                                <div class="col">
                                    <div class="row-md-8 pt-3">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-6" id="occupancy_rate">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Occupancy Rate</h4>
                </div>
                <div class="card-body">
                    <canvas id="occupancyRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6" id="damage_rate">
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
        <div class="col-md-12 col-lg-12" id="total_bookings">
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
        <div class="col-md-12 col-lg-12" id="total_customers_by_gender">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
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

        var revenueData = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode(array_values($revenues)) !!},
                backgroundColor: [
                    @foreach($revenues as $lodgeName => $occupancy)
                        getRandomColor(),
                    @endforeach
                ],
                borderColor: 'transparent',
                borderWidth: 1
            }]
        };

        var revenueChart = new Chart(ctx, {
            type: 'bar',
            data: revenueData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
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

        var occupancyRateData = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                label: 'Occupancy Rate',
                data: {!! json_encode(array_values($averageOccupancyRates)) !!},
                backgroundColor: [
                    @foreach($averageOccupancyRates as $lodgeName => $occupancy)
                        getRandomColor(),
                    @endforeach
                ],
                borderColor: 'transparent',
                borderWidth: 1
            }]
        };

        var occupancyRateChart = new Chart(ctx, {
            type: 'bar',
            data: occupancyRateData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y:{
                        beginAtZero: true
                    }
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

        var damageRateData = {
            labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
            datasets: [{
                label: 'Damage Rate',
                data: {!! json_encode(array_values($damageRates)) !!},
                backgroundColor: [
                    @foreach($damageRates as $lodgeName => $occupancy)
                        getRandomColor(),
                    @endforeach
                ],
                borderColor: 'transparent',
                borderWidth: 1
            }]
        };

        var damageRateChart = new Chart(ctx, {
            type: 'bar',
            data: damageRateData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y:{
                        beginAtZero: true
                    }
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

        var averageRateData = {
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

        var averageRateChart = new Chart(ctx, {
            type: 'polarArea',
            data: averageRateData,
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

        var totalGuestsData = {
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

        var totalGuestsChart = new Chart(ctx, {
            type: 'pie',
            data: totalGuestsData,
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

        var damageCostData = {
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

        var damageCostChart = new Chart(ctx, {
            type: 'bar',
            data: damageCostData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y:{
                        beginAtZero: true
                    }
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

        var totalRoomsData = {
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

        var totalRoomsChart = new Chart(ctx, {
            type: 'pie',
            data: totalRoomsData,
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

        var totalCustomersData = {
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

        var totalCustomersChart = new Chart(ctx, {
            type: 'bar',
            data: totalCustomersData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    //Filtering chart
        function showChart(chartId) {

            const card = document.querySelectorAll('.col-md-12');

            card.forEach(hideAll);
            function hideAll(cardChart) {
                cardChart.classList.add('d-none');
            }

            if (chartId.value === '*') {
                card.forEach(showAll);
                function showAll(cardChart) {
                    cardChart.classList.remove('d-none');
                }
            };

            if (chartId.value !== '*') {
                document.getElementById(chartId.value).classList.remove('d-none');
            };
        }


        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const lodge = document.getElementById('lodge_id');


        // Add event listeners to the start date and end date inputs
        startDateInput.addEventListener('change', filterChartsByDateRange);
        endDateInput.addEventListener('change', filterChartsByDateRange);
        lodge.addEventListener('change', filterChartsByDateRange);

        function filterChartsByDateRange() {
            // Get the selected start and end dates
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            // Get the selected lodge
            const selectedLodgeId = lodge.value;

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // AJAX request to fetch filtered data
            $.ajax({
                url: '/fetch-data',
                type: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    lodge_id: selectedLodgeId,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                },
                dataType: 'json',
                success: function(response) {
                    // Update the charts with the filtered data
                    console.log(response)
                    updateCharts(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }


        function updateCharts(data) {
            // Update revenue chart
            updateChartData(revenueChart, data.revenues);

            // Update occupancy rate chart
            updateChartData(occupancyRateChart, data.averageOccupancyRates);

            // Update damage rate chart
            updateChartData(damageRateChart, data.damageRates);

            // Update average rate chart
            updateChartData(averageRateChart, data.averageRates);

            // Update total guests chart
            updateChartData(totalGuestsChart, data.totalGuests);

            // Update damage cost chart
            updateChartData(damageCostChart, data.damageCosts);

            // Update total rooms chart
            updateChartData(totalRoomsChart, data.totalRooms);

            // Update total customers chart
            updateChartData(totalCustomersChart, data.totalCustomers);
        }


        function updateChartData(chart, newData) {
            chart.data.labels = Object.keys(newData);
            chart.data.datasets[0].data = Object.values(newData);
            chart.update();
        }


</script>
@endsection
