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
            <img src="<?php echo e(asset('assets/img/CLSULogo.png')); ?>" alt="clsu-logo" class="clsu">
        </div>
        <div class="text-container">
            <h4>Republic of the Philippines</h4>
            <h2 class="name">Central Luzon State University</h2>
            <h4>Science City of Muñoz, Nueva Ecija</h4>
            <?php if($reportType === '*'): ?>
                <h3>Property Performance</h3>
            <?php endif; ?>
            <?php if($reportType === 'revenue'): ?>
                <h3>Revenue Analysis</h3>
            <?php endif; ?>
            <?php if($reportType === 'occupancy_rate'): ?>
                <h3>Occupancy Analysis</h3>
            <?php endif; ?>
            <?php if($reportType === 'average_rate'): ?>
                <h3>Quality Ratings Summary</h3>
            <?php endif; ?>
            <?php if($reportType === 'total_bookings'): ?>
                <h3>Bookings Trends and Analysis</h3>
            <?php endif; ?>
            <?php if($reportType === 'total_customers_by_gender'): ?>
                <h3>Gender-Based Customer Insights</h3>
            <?php endif; ?>
            <?php if($reportType === 'total_damage'): ?>
                <h3>Damage and Maintenance Report</h3>
            <?php endif; ?>
            <p><?php echo e($startDate); ?>-<?php echo e($endDate); ?></p>
            <?php if($lodgeId === '*'): ?>
                <p>CLSU</p>
            <?php else: ?>
                <p><?php echo e($lodgeId); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Display report data here -->

    <!-- Example: Displaying a table of report data -->
    <?php if($reportType === 'revenue' || $reportType === '*'): ?>
        <div class="chart-revenue">
            <canvas id="revenueChart" width="800" height="400"></canvas>
        </div>
        <div class="description">
            <span></span>
        </div>
    <?php endif; ?>
    
    <script>
        // Get chart data passed from the controller
        var revenueChart = <?php echo $revenueChart; ?>;

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
<?php /**PATH C:\xampp\htdocs\HMS\resources\views/Admin/report.blade.php ENDPATH**/ ?>