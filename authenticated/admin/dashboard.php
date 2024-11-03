<?php include "session.php"; ?>

<?php 
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
    $sql = "SELECT COUNT(*) as total_feedback FROM feedback";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_feedback = $row['total_feedback'];

    // Data for analytics
    // Appointments by status
    $sql = "SELECT visit_type, COUNT(*) as count FROM appointment GROUP BY visit_type";
    $result = $conn->query($sql);
    $appointment_status = [];

    while ($row = $result->fetch_assoc()) {
        $appointment_status[] = $row;
    }

    // Most requested services
    $sql = "SELECT service_needed, COUNT(*) as count FROM appointment GROUP BY service_needed";
    $result = $conn->query($sql);
    $services = [];

    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    // Get data for monthly appointment records
    $sql = "SELECT MONTHNAME(appointment_datetime) as month, COUNT(*) as count FROM appointment GROUP BY month";
    $result = $conn->query($sql);
    $appointment_records = [];

    while ($row = $result->fetch_assoc()) {
        $appointment_records[] = $row;
    }

    // Get data for daily income
    $sql = "SELECT DATE(appointment_datetime) as date, SUM(price) as income FROM appointment GROUP BY date ORDER BY date";
    $result = $conn->query($sql);
    $daily_income = [];

    while ($row = $result->fetch_assoc()) {
        $daily_income[] = $row;
    }

    /**
     * GET MONTHLY REPORT
     * TRENDS OF DISEASE FOR EACH MONTH
     */
    $trends_query = $conn->query("SELECT pd.disease, DATE_FORMAT(pmh.created_at, '%M') AS month, YEAR(pmh.created_at) AS year, COUNT(pmh.disease_diagnosed) AS total FROM pet_med_history pmh JOIN pet_diseases pd ON pmh.disease_diagnosed = pd.id GROUP BY pd.disease, year, month ORDER BY year, month");
    $trends_data = [];

    while ($row = $trends_query->fetch_assoc()) {
        $month = $row['month'];
        $year = $row['year'];
        $disease = $row['disease'];
        
        if (!isset($trends_data["$month"])) {
            $trends_data["$month"] = [];
        }

        $trends_data["$month"][] = [
            'disease' => $disease,
            'count' => $row['total']
        ];
    }
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">dashboard</span>
                    <strong class="mt-1">Dashboard</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4">
                    <a href="pets.php">
                        <div class="card card-hover-zoom bg-danger">
                            <div class="card-body text-white text-center">
                                <span class="material-icons-outlined">pets</span>
                                <h5 class="text-bold">Pet Records</h5>
                                <?= $total_pets ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4">
                    <a href="feedback.php">
                        <div class="card card-hover-zoom bg-danger">
                            <div class="card-body text-white text-center">
                                <span class="material-icons-outlined">report</span>
                                <h5 class="text-bold">Feedback</h5>
                                <?= $total_feedback ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4">
                    <a href="appointments.php">
                        <div class="card card-hover-zoom bg-danger">
                            <div class="card-body text-white text-center">
                                <span class="material-icons-outlined">event</span>
                                <h5 class="text-bold">Appointment Records</h5>
                                <?= $total_appointments ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-12">
                    <div class="card card-outline rounded-0 card-danger">
                        <div class="card-header">
                            Data Analytics
                        </div>

                        <div class="card-body">
                            <div class="analytics-container">
                                <div class="row">
                                    <div class="col-xl-12 mb-4">
                                        <div class="text-center">
                                            <label class="small">Appointments Group</label>
                                        </div>

                                        <div class="chart-container d-flex justify-content-center" style="height: 500px">
                                            <canvas id="appointmentStatusChart" style="height: 100px"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 mb-4">
                                        <div class="text-center">
                                            <label class="small">Needed Services Count</label>
                                        </div>

                                        <div class="chart-container">
                                            <canvas id="servicesChart"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 mb-4">
                                        <div class="text-center">
                                            <label class="small">Monthly Appointments Count</label>
                                        </div>

                                        <div class="chart-container">
                                            <canvas id="appointmentRecordsChart"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 mb-4">
                                        <div class="text-center">
                                            <label class="small">Monthly Income</label>
                                        </div>

                                        <div class="chart-container">
                                            <canvas id="dailyIncomeChart"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 mb-4">
                                        <div class="text-center">
                                            <label class="small">Monthly Trends of Disease</label>
                                        </div>

                                        <div class="chart-container">
                                            <canvas id="trendsOfDiseaseChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const appointmentStatusCtx = document.getElementById('appointmentStatusChart').getContext('2d');
    const appointmentStatusChart = new Chart(appointmentStatusCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($appointment_status, 'visit_type')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($appointment_status, 'count')); ?>,
                backgroundColor: ['maroon', '#F5F5DC', '#FFCE56'],
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
            labels: <?php echo json_encode(array_map(function($service) {
                return $service['service_needed'] ?: 'Services Request'; 
            }, $services)); ?>,
            datasets: [{
                label: 'Services Request',
                data: <?php echo json_encode(array_column($services, 'count')); ?>,
                backgroundColor: 'maroon',
            }]
        },
        options: {
            responsive: true
        }
    });

    const appointmentRecordsCtx = document.getElementById('appointmentRecordsChart').getContext('2d');
    const appointmentRecordsChart = new Chart(appointmentRecordsCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($appointment_records, 'month')); ?>,
            datasets: [{
                label: 'Appointments',
                data: <?php echo json_encode(array_column($appointment_records, 'count')); ?>,
                backgroundColor: 'maroon',
                borderColor: 'maroon',
                fill: false,
            }]
        },
        options: {
            responsive: true
        }
    });

    const IncomeCtx = document.getElementById('dailyIncomeChart').getContext('2d');
    const IncomeChart = new Chart(IncomeCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($daily_income, 'date')); ?>,
            datasets: [{
                label: 'Income (₱)',
                data: <?php echo json_encode(array_column($daily_income, 'income')); ?>,
                backgroundColor: 'maroon',
                borderColor: 'maroon',
                fill: false,
            }]
        },
        options: {
            responsive: true
        }
    });

    /**
     * TRENDS OF DISEASE
     * CHART JS FUNCTION
     */
    const trendsData = <?php echo json_encode($trends_data); ?>;
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const labels = months.map(month => month);
    const datasets = [];
    const diseaseMap = {};

    labels.forEach(monthYear => {
        if (trendsData[monthYear]) {
            trendsData[monthYear].forEach(diseaseData => {
                const disease = diseaseData.disease;
                const count = diseaseData.count;

                // Initialize disease array if not already in the map
                if (!diseaseMap[disease]) {
                    diseaseMap[disease] = Array(labels.length).fill(0);  // Fill with zeros initially
                }

                // Add the count of the disease for the specific month-year
                const monthIndex = labels.indexOf(monthYear);
                diseaseMap[disease][monthIndex] = count;
            });
        } else {
            // Ensure every disease has an entry for each month
            Object.keys(diseaseMap).forEach(disease => {
                diseaseMap[disease][labels.indexOf(monthYear)] = 0;
            });
        }
    });

    Object.keys(diseaseMap).forEach(disease => {
        datasets.push({
            label: disease,
            data: diseaseMap[disease],
            fill: false,
            borderColor: getRandomColor(),  // Optional: Function to generate random colors
            tension: 0.1
        });
    });

    const trendsOfDiseaseChartCTX = document.getElementById('trendsOfDiseaseChart').getContext('2d');
    const trendsOfDiseaseChart = new Chart(trendsOfDiseaseChartCTX, {
        type: 'line',
        data: {
            labels: labels,  // Month-Year labels for the x-axis
            datasets: datasets.map(dataset => ({
                ...dataset,
                tension: 0.4,  // Set tension to make the line curvy (0.4 is a common value for smooth curves)
                fill: false,  // Set to true if you want to fill the area under the curve
            }))
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    beginAtZero: true,
                    ticks: {
                        // Configure y-axis to display integer values
                        callback: function(value, index, values) {
                            return Math.floor(value);  // Remove decimal part
                        },
                        stepSize: 1,
                    },
                    grid: {
                        drawOnChartArea: true,
                        drawBorder: true
                    }
                }
            }
        }
    });

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>

<?php include "../../footer.php"; ?>