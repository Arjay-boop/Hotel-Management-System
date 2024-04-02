<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body {
            padding: 0 24px;
            color: black; /* Change my color to yellow */
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header {
            display: flex;
            justify-content: space-between; /* Align items to each end of the container */
            align-items: center; /* Center items vertically */
        }

        .logo-container {
            /* You can adjust the width of the logo container if needed */
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .clsu {
            max-width: 100%; /* Ensure the image fits within its container */
        }

        .text-container {
            flex: 1; /* Take up remaining space */
            text-align: center;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('assets/img/CLSULogo.png') }}" alt="clsu-logo" class="clsu">
        </div>
        <div class="text-container">
            <h4>Republic of the Philippines</h4>
            <h2 class="name">Central Luzon State University</h2>
            <h4>Science City of Muñoz, Nueva Ecija</h4>
            @if ($reportType === '*')
                <h3>Property Performance</h3>
            @endif
            @if ($reportType === 'revenue')
                <h3>Revenue Analysis</h3>
            @endif
            @if ($reportType === 'occupancy_rate')
                <h3>Occupancy Analysis</h3>
            @endif
            @if ($reportType === 'average_rate')
                <h3>Quality Ratings Summary</h3>
            @endif
            @if ($reportType === 'total_bookings')
                <h3>Bookings Trends and Analysis</h3>
            @endif
            @if ($reportType === 'total_customers_by_gender')
                <h3>Gender-Based Customer Insights</h3>
            @endif
            @if ($reportType === 'total_damage')
                <h3>Damage and Maintenance Report</h3>
            @endif
            <p>{{ $startDate }}-{{ $endDate }}</p>
            @if ($lodgeId === '*')
                <p>CLSU</p>
            @else
                <p>{{ $lodgeId }}</p>
            @endif
        </div>
    </div>

    <!-- Display report data here -->

    <!-- Example: Displaying a table of report data -->
    @if ($reportType === 'revenue' || $reportType === '*')
        <div class="chart-revenue">
            <canvas id="revenueChart" width="800" height="400"></canvas>
        </div>
        <div class="description">
            <span></span>
        </div>
    @endif
    <script>
        // Get chart data passed from the controller
        var revenueChart = {!! $revenueChart !!};

        // Render the chart
        if (revenueChart) {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // Change chart type if needed
                data: revenueChart,
                options: {
                    // Additional chart options if needed
                }
            });
        }
    </script>
</body>
</html>
