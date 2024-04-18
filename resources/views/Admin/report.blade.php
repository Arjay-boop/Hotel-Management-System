@extends('Admin.layout')

@section('content')
<style>
    .content-wrapper {
        width: 210mm; /* Set width to A4 width */
        height: 297mm; /* Set height to A4 height */
        padding: 20mm; /* Add padding for content spacing */
        color: black; /* Change my color to yellow */
        margin: 100px auto 0; /* Top margin to accommodate header height, center horizontally */
        display: flex;
        flex-direction: column; /* Change to column for vertical layout */
        align-items: center;
        font-family: 'Times New Roman', Times, serif;
    }
    .header-container {
        padding: 1rem;
        display: flex;
        justify-content: center;
        margin-right: 8rem;
    }
    .logo-container {
        padding: 2rem;
        align-items: center;
    }
    .text-container {
        padding: 1px;
        text-align: center;
    }

</style>

    <script src="path/to/dompurify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript">
        // Correct the window object
        window.html2canvas = html2canvas;
        window.jsPDF = window.jspdf.jsPDF; // Fix window reference

        function makePDF() {
            html2canvas(document.querySelector("#capture"), {
                allowTaint: true,
                useCORS: true,
                scale: 5 // Adjust scale as needed for better quality
            }).then(canvas => {
                var imgData = canvas.toDataURL("image/png");

                // Create PDF
                var doc = new jsPDF('p', 'mm', 'a4');
                var imgWidth = 210; // A4 width in mm
                var pageHeight = 297; // A4 height in mm
                var imgHeight = canvas.height * imgWidth / canvas.width;
                var heightLeft = imgHeight;

                var position = 0;

                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Save the PDF
                doc.save('report.pdf');
            });
        }


    </script>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <h3 class="page-title mt-3">Generate Report</h3>
                <button onclick="makePDF()" class="btn btn-primary">Export to PDF</button>
            </div>
        </div>
    </div>
    <div id="capture" style="padding: 10px; background: #ffffff" class="content-wrapper">
        <div class="header-container">
            <div class="logo-container">
                <img src="{{ asset('assets/img/CLSULogo.png') }}" width="100px" height="100px" alt="">
            </div>
            <div class="text-container">
                <p class="h4 lead">Republic of the Philippines</p>
                <p class="h3 lead">Central Luzon State University</p>
                <p class="h4 lead">Science City of Muñoz, Nueva Ecija</p>
                @if ($typeReport === '*')
                    <p class="h5 lead">Property Performance</p>
                @elseif ($typeReport === 'revenue')
                    <p class="h5 lead">Revenue Analysis</p>
                @elseif ($typeReport === 'occupancy_rate')
                    <p class="h5 lead">Occupancy Analysis</p>
                @elseif ($typeReport === 'average_rate')
                    <p class="h5 lead">Quality Ratings Summary</p>
                @elseif ($typeReport === 'total_bookings')
                    <p class="h5 lead">Bookings Trends and Analysis</p>
                @elseif ($typeReport === 'total_customers_by_gender')
                    <p class="h5 lead">Gender-Based Customer Insights</p>
                @elseif ($typeReport === 'damage_cost' || $typeReport === 'damage_rate')
                    <p class="h5 lead">Damage and Maintenance Report</p>
                @endif
                <p class="lead">{{ $startDate }} to {{ $endDate }}</p>
                @if ($lodgeSelected === '*')
                    <p class="lead">CLSU</p>
                @else
                    <p class="lead">{{ $lodgeArea }}</p>
                @endif
            </div>
        </div>
        <div class="content">
            <div class="chart">
                @if ($typeReport === 'revenue' || $typeReport === '*')
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                @elseif ($typeReport === 'occupancy_rate' || $typeReport === '*')
                    <canvas width="400" height="200" id="occupancyRateChart"></canvas>
                @elseif ($typeReport === 'damage_rate' || $typeReport === '*')
                    <canvas id="damageRateChart" width="400" height="200"></canvas>
                @elseif ($typeReport === 'average_rate' || $typeReport === '*')
                    <canvas id="averageRateChart" width="400" height="200"></canvas>
                @elseif ($typeReport === 'total_bookings' || $typeReport === '*')
                    <canvas id="totalGuestChart" width="400" height="200"></canvas>
                @elseif ($typeReport === 'total_customers_by_gender' || $typeReport === '*')
                    <canvas id="totalCustomerChart" width="400" height="200"></canvas>
                @elseif ($typeReport === 'damage_cost' || $typeReport === '*')
                    <canvas id="damageCostChart" width="400" height="200"></canvas>
                @endif
            </div>
            <div class="sub-content" style="padding: 4rem; text-align: justify;">
                @if ($typeReport === 'revenue' || $typeReport === '*')
                    @php
                        $totalRevenue = 0;
                    @endphp
                    @foreach ($revenues as $area => $revenue)
                        @php
                            $totalRevenue += $revenue;
                        @endphp
                    @endforeach
                    <p class="lead">
                        During the period from {{ strval($startDate) }} to {{ strval($endDate) }}, the total revenue generated by all lodges at CLSU amounted to {{ $totalRevenue }}. This revenue represents the collective earnings from accommodation charges, additional services, and amenities provided across all lodges.
                    </p>
                @elseif ($typeReport === 'occupancy_rate' || $typeReport === '*')
                    @php
                        $totalOccupancy = 0;
                    @endphp
                    @foreach ($averageOccupancyRates as $occupancyRates)
                        @php
                            $totalOccupancy += $occupancyRates;
                        @endphp
                    @endforeach
                    <p>
                        The average occupancy rate for all lodges at CLSU during the period from {{ strval($startDate) }} to {{ strval($endDate) }} was {{ $totalOccupancy }}%. This metric reflects the utilization level of available lodging facilities and indicates the effectiveness of marketing initiatives and pricing strategies.
                    </p>
                @elseif ($typeReport === 'damage_rate' || $typeReport === '*')
                @php
                    $totalDamage = 0;
                @endphp
                @foreach ($damageRates as $damage)
                    @php
                        $totalDamage += $damage;
                    @endphp
                @endforeach
                <p>
                    The overall damage rate for all lodges at CLSU from {{ strval($startDate) }} to {{ strval($endDate) }} was {{ $totalDamage }}%. This metric quantifies the extent of damage to property and facilities and highlights areas requiring maintenance and repairs.
                </p>
                @elseif ($typeReport === 'average_rate' || $typeReport === '*')
                @php
                    $averageRate = 0;
                @endphp
                @foreach ($averageRates as $average)
                    @php
                        $averageRate += $average;
                    @endphp
                @endforeach
                <p>
                    The average rate across all lodges at CLSU during {{ strval($startDate) }} to {{ strval($endDate) }} was {{ $averageRate }}. This metric represents the average price charged per accommodation unit and reflects the perceived value of lodging services.
                </p>
                @elseif ($typeReport === 'total_bookings' || $typeReport === '*')
                @php
                    $totalBookings = 0;
                @endphp
                @foreach ($totalGuests as $guest)
                    @php
                        $totalBookings += $guest;
                    @endphp
                @endforeach
                <p>
                    The total number of guests accommodated across all lodges at CLSU from {{ strval($startDate) }} to {{ strval($endDate) }} was {{ $totalBookings }}. This metric provides insights into guest traffic, booking trends, and market demand dynamics.
                </p>
                @elseif ($typeReport === 'total_customers_by_gender' || $typeReport === '*')
                @php
                    $totalCustomer = 0;
                @endphp
                @foreach ($totalCustomers as $customer)
                    @php
                        $totalCustomer += $customer;
                    @endphp
                @endforeach
                <p>
                    The total number of guests accommodated across all lodges at CLSU from {{ strval($startDate) }} to {{ strval($endDate) }} was {{ $totalCustomer }}. This metric provides insights into guest traffic, booking trends, and market demand dynamics.
                </p>
                @elseif ($typeReport === 'damage_cost' || $typeReport === '*')
                @php
                    $damageCost = 0;
                @endphp
                @foreach ($damageCosts as $damage)
                    @php
                        $damageCost += $damage;
                    @endphp
                @endforeach
                <p>
                    The total damage cost incurred by all lodges at CLSU during the specified period was {{ $damageCost }}. This metric represents the financial impact of property damage and maintenance expenses incurred to address property-related issues.
                </p>
                @endif

            </div>
        </div>
    </div>
<div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script>
    //Occupancy
        if ("{{ $typeReport }}" === "occupancy_rate" || "{{ $typeReport }}" === "*"){

            var ctx = document.getElementById('occupancyRateChart').getContext('2d');
            var occupancyRateData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                occupancyRateData = {
                    labels: ['Occupancy Rate'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Occupancy Rate',
                        data: [{{ isset($averageOccupancyRates[$lodgeArea]) ? $averageOccupancyRates[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                    occupancyRateData = {
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
            }

            console.log(occupancyRateData);

            var occupancyRateChart = new Chart(ctx, {
                type: 'bar',
                data: occupancyRateData,
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
        }
    //Revenue
        else if ("{{ $typeReport }}" === "revenue" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                    revenueData = {
                    labels: ['Ravenue'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Revenue',
                        data: [{{ isset($revenues[$lodgeArea]) ? $revenues[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                    revenueData = {
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
            }

            console.log(revenueData);

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
        }

    //Damage Rate
        else if ("{{ $typeReport }}" === "damage_rate" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('damageRateChart').getContext('2d');
            var damageRateData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                damageRateData = {
                    labels: ['Damage Rate'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Damage Rate',
                        data: [{{ isset($damageRates[$lodgeArea]) ? $damageRates[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                damageRateData = {
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
            }

            console.log(damageRateData);

            var revenueChart = new Chart(ctx, {
                type: 'bar',
                data: damageRateData,
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
        }

    //Average Rate
        else if ("{{ $typeReport }}" === "average_rate" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('averageRateChart').getContext('2d');
            var averageRateData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                averageRateData = {
                    labels: ['Average Rate'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Average Rate',
                        data: [{{ isset($averageRates[$lodgeArea]) ? $averageRates[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                averageRateData = {
                        labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
                        datasets: [{
                            label: 'Average Rate',
                            data: {!! json_encode(array_values($averageRates)) !!},
                            backgroundColor: [
                                @foreach($averageRates as $lodgeName => $occupancy)
                                    getRandomColor(),
                                @endforeach
                            ],
                            borderColor: 'transparent',
                            borderWidth: 1
                        }]
                    };
            }

            console.log(averageRateData);

            var averageRateChart = new Chart(ctx, {
                type: 'polarArea',
                data: averageRateData,
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
        }

    //Total Guest
        else if ("{{ $typeReport }}" === "total_bookings" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('totalGuestChart').getContext('2d');
            var totalGuestData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                totalGuestData = {
                    labels: ['Total Guest'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Total Guest',
                        data: [{{ isset($totalGuests[$lodgeArea]) ? $totalGuests[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                totalGuestData = {
                        labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
                        datasets: [{
                            label: 'Total Guest',
                            data: {!! json_encode(array_values($totalGuests)) !!},
                            backgroundColor: [
                                @foreach($totalGuests as $lodgeName => $occupancy)
                                    getRandomColor(),
                                @endforeach
                            ],
                            borderColor: 'transparent',
                            borderWidth: 1
                        }]
                    };
            }

            console.log(totalGuestData);

            var totalGuestChart = new Chart(ctx, {
                type: 'bar',
                data: totalGuestData,
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
        }

    //Total Customer
        else if ("{{ $typeReport }}" === "total_customers_by_gender" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('totalCustomerChart').getContext('2d');
            var totalCustomerData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                totalCustomerData = {
                    labels: ['Total Guest'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Total Guest',
                        data: [{{ isset($totalCustomers[$lodgeArea]) ? $totalCustomers[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                totalCustomerData = {
                        labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
                        datasets: [{
                            label: 'Total Guest',
                            data: {!! json_encode(array_values($totalGuests)) !!},
                            backgroundColor: [
                                @foreach($totalCustomers as $lodgeName => $occupancy)
                                    getRandomColor(),
                                @endforeach
                            ],
                            borderColor: 'transparent',
                            borderWidth: 1
                        }]
                    };
            }

            console.log(totalCustomerData);

            var totalCustomerChart = new Chart(ctx, {
                type: 'bar',
                data: totalCustomerData,
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
        }

    //Damage Cost
        else if ("{{ $typeReport }}" === "damage_cost" || "{{ $typeReport }}" === "*") {
            var ctx = document.getElementById('damageCostChart').getContext('2d');
            var damageCostData;

            // Check if lodgeSelected is not '*' (indicating all lodges)
            if ("{{ $lodgeSelected }}" !== '*') {
                // If a specific lodge is selected, create a new dataset for that lodge only
                var lodgeArea = "{{ $lodgeArea }}"; // Define the lodgeArea variable here
                damageCostData = {
                    labels: ['Damage Cost'], // Just one label for the selected lodge
                    datasets: [{
                        label: 'Damage Cost',
                        data: [{{ isset($damageCosts[$lodgeArea]) ? $damageCosts[$lodgeArea] : 0 }}], // Check if $averageOccupancyRates[$lodgeArea] exists
                        backgroundColor: getRandomColor(), // Use a random color or specify one
                        borderColor: 'transparent',
                        borderWidth: 1
                    }]
                };
            } else {
                // If all lodges are selected, display data for all lodge

                damageCostData = {
                        labels: {!! json_encode($lodges->pluck('area')) !!}, // Lodge names as labels
                        datasets: [{
                            label: 'Damage Cost',
                            data: {!! json_encode(array_values($damageCosts)) !!},
                            backgroundColor: [
                                @foreach($damageCosts as $lodgeName => $occupancy)
                                    getRandomColor(),
                                @endforeach
                            ],
                            borderColor: 'transparent',
                            borderWidth: 1
                        }]
                    };
            }

            console.log(damageCostData);

            var damageCostChart = new Chart(ctx, {
                type: 'bar',
                data: damageCostData,
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
        }


</script>
@endsection
