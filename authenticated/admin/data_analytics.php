<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total number of appointments
$sql = "SELECT COUNT(*) as total_appointments FROM appointment";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_appointments = $row['total_appointments'];

// Get total number of pet records
$sql = "SELECT COUNT(*) as total_pets FROM pets";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pets = $row['total_pets'];

// Get total number of complaints
$sql = "SELECT COUNT(*) as total_complaints FROM messages WHERE category = 'Complaint'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_complaints = $row['total_complaints'];

// Get total number of reports
$sql = "SELECT COUNT(*) as total_reports FROM messages WHERE category = 'Report'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_reports = $row['total_reports'];

// Get total income
$sql = "SELECT SUM(price) as total_income FROM appointment";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_income = $row['total_income'];

// Get daily income for the past 7 days
$sql = "SELECT DATE(date) as date, SUM(price) as daily_income 
        FROM appointment 
        WHERE date >= CURDATE() - INTERVAL 7 DAY 
        GROUP BY DATE(date) 
        ORDER BY DATE(date) ASC";
$result = $conn->query($sql);
$daily_income_data = [];
while ($row = $result->fetch_assoc()) {
    $daily_income_data[] = $row;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard_style.css">
    <style>
        .chart-container {
            background-color: transparent;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .dashboard-card {
            background-color: #F5F5F5; /* Light background for the cards */
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
        }
        .analytics-container {
            background-color: #FFF; /* White background for analytics */
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- Include header -->
    <?php include('header.php'); ?>

    <div class="container-fluid">
        <div class="main-container">
            <div class="d-flex flex-wrap justify-content-start">
                <!-- Existing Dashboard Cards -->
                <div class="card-container">
                    <div class="dashboard-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h5>Appointment</h5>
                        <p>Total: <?php echo number_format($total_appointments, 0); ?></p>
                    </div>
                </div>
                <div class="card-container">
                    <div class="dashboard-card">
                        <i class="fas fa-paw"></i>
                        <h5>Pet Records</h5>
                        <p>Total: <?php echo number_format($total_pets, 0); ?></p>
                    </div>
                </div>
                <div class="card-container">
                    <div class="dashboard-card">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h5>Complaints & Reports</h5>
                        <p>Complaints: <?php echo number_format($total_complaints, 0); ?></p>
                        <p>Reports: <?php echo number_format($total_reports, 0); ?></p>
                    </div>
                </div>
                <div class="card-container">
                    <div class="dashboard-card">
                        <i class="fas fa-money-bill-wave"></i>
                        <h5>Total Income</h5>
                        <p>Total Income: ₱<?php echo number_format($total_income, 2); ?></p>
                    </div>
                </div>
                <!-- Daily Income Card -->
                <div class="card-container">
                    <div class="dashboard-card">
                        <i class="fas fa-calendar-day"></i>
                        <h5>Daily Income</h5>
                        <p>Total Income for the Past 7 Days:</p>
                        <?php foreach ($daily_income_data as $daily) : ?>
                            <p><?php echo $daily['date']; ?>: ₱<?php echo number_format($daily['daily_income'], 2); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Analytics Section -->
            <div class="analytics-container mt-5">
                <h3>Data Analytics</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="appointmentStatusChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="petTypesChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="servicesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="paymentMethodsChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="petGenderChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <canvas id="appointmentRecordsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <canvas id="dailyIncomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        const appointmentStatusCtx = document.getElementById('appointmentStatusChart').getContext('2d');
        const appointmentStatusChart = new Chart(appointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($appointment_status, 'status')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($appointment_status, 'count')); ?>,
                    backgroundColor: ['#8B4513', '#F5F5DC', '#FFCE56'],
                }]
            },
            options: {
                responsive: true
            }
        });

        const petTypesCtx = document.getElementById('petTypesChart').getContext('2d');
        const petTypesChart = new Chart(petTypesCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($pet_types, 'pet_type')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($pet_types, 'count')); ?>,
                    backgroundColor: ['#8B4513', '#F5F5DC', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                }]
            },
            options: {
                responsive: true
            }
        });

        const servicesCtx = document.getElementById('servicesChart').getContext('2d');
        const servicesChart = new Chart(servicesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($services, 'service_needed')); ?>,
                datasets: [{
                    label: 'Number of Requests',
                    data: <?php echo json_encode(array_column($services, 'count')); ?>,
                    backgroundColor: <?php echo json_encode(array_map(function($i) {
                        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    }, range(1, count($services)))); ?>,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const paymentMethodsCtx = document.getElementById('paymentMethodsChart').getContext('2d');
        const paymentMethodsChart = new Chart(paymentMethodsCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($payment_methods, 'payment_option')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($payment_methods, 'count')); ?>,
                    backgroundColor: ['#8B4513', '#F5F5DC', '#FFCE56'],
                }]
            },
            options: {
                responsive: true
            }
        });

        const petGenderCtx = document.getElementById('petGenderChart').getContext('2d');
        const petGenderChart = new Chart(petGenderCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($pet_gender, 'gender')); ?>,
                datasets: [{
                    label: 'Number of Pets',
                    data: <?php echo json_encode(array_column($pet_gender, 'count')); ?>,
                    backgroundColor: ['#8B4513', '#F5F5DC'],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const appointmentRecordsCtx = document.getElementById('appointmentRecordsChart').getContext('2d');
        const appointmentRecordsChart = new Chart(appointmentRecordsCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($appointment_records, 'date')); ?>,
                datasets: [{
                    label: 'Appointments',
                    data: <?php echo json_encode(array_column($appointment_records, 'count')); ?>,
                    borderColor: '#8B4513',
                    backgroundColor: 'rgba(139, 69, 19, 0.2)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const dailyIncomeCtx = document.getElementById('dailyIncomeChart').getContext('2d');
        const dailyIncomeChart = new Chart(dailyIncomeCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($daily_income_data, 'date')); ?>,
                datasets: [{
                    label: 'Daily Income',
                    data: <?php echo json_encode(array_column($daily_income_data, 'daily_income')); ?>,
                    backgroundColor: '#8B4513',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
