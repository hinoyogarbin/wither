<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Micro Climate Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="stylesheet" href="../assets/style.css">

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-light bg-white shadow-sm px-3">

        <span class="navbar-brand fw-bold">Wither</span>

        <div class="ms-auto">

            <span class="me-3">Logged in as: <?php echo $_SESSION['name']; ?></span>

            <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>

        </div>

    </nav>


    <div class="container-fluid mt-3">

        <div class="row">

            <!-- SIDEBAR -->

            <div class="col-md-3">

                <div class="sidebar">

                    <h6>SENSOR READINGS</h6>

                    <p>Temperature</p>
                    <h3 class="text-success" id="tempValue">-- °C</h3>

                    <p>Humidity</p>
                    <h3 class="text-success" id="humValue">-- %</h3>

                    <hr>

                    <h6>LOCATION</h6>

                    <p>Lat: 8.3049</p>
                    <p>Lng: 124.8674</p>
                    <p>Zoom: 16</p>

                </div>

            </div>

            <!-- MAP -->

            <div class="col-md-9">

                <div id="map"></div>

            </div>

        </div>


        <!-- CHARTS -->

        <div class="row mt-3">

            <div class="col-md-6">

                <div class="chart-box">

                    <canvas id="tempChart"></canvas>

                </div>

            </div>

            <div class="col-md-6">

                <div class="chart-box">

                    <canvas id="humChart"></canvas>

                </div>

            </div>

        </div>


        <!-- MONITORING LOG -->

        <div class="row mt-3">

            <div class="col">

                <div class="table-box">

                    <h6>Monitoring Log</h6>

                    <table class="table table-striped">

                        <thead>

                            <tr>
                                <th>Temperature</th>
                                <th>Humidity</th>
                                <th>Time</th>
                            </tr>

                        </thead>

                        <tbody id="logTable">

                            <tr>
                                <td>27.7</td>
                                <td>62.3</td>
                                <td>1:20 AM</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <!-- MODAL -->

    <div id="mapModal" class="modal">

        <div class="modal-content">

            <span class="close-btn">&times;</span>

            <div id="modalBody"></div>

        </div>

    </div>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="../assets/script.js"></script>
    <script src="../assets/chart.js"></script>


</body>

</html>