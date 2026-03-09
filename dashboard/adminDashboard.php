<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Only allow admin
if($_SESSION['role'] !== 'admin') {
    echo "Access denied. You must be an admin.";
    exit();
}

include '../config/config.php'; // DB connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Wither</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="../assets/style.css">

<style>
#map { height: 400px; width: 100%; margin-bottom: 20px; }
.sidebar { padding: 15px; background: #f9f9f9; border-radius: 8px; margin-bottom: 20px; }
.chart-box { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
.table-box { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); margin-top: 20px; }
.modal { display:none; position:fixed; z-index:1000; left:0; top:0;width:100%;height:100%;background:rgba(0,0,0,0.5); }
.modal-content { background:#fff; margin:10% auto; padding:20px; width:80%; border-radius:8px; }
.close-btn { float:right; cursor:pointer; }
</style>
</head>
<body>

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
                <h6>ADD MARKER</h6>
                <form id="addMarkerForm">
                    <input type="text" placeholder="Marker Name" id="markerName" required class="form-control mb-1">
                    <input type="text" placeholder="Latitude" id="markerLat" required class="form-control mb-1">
                    <input type="text" placeholder="Longitude" id="markerLng" required class="form-control mb-1">
                    <button type="submit" class="btn btn-primary btn-sm">Add Marker</button>
                </form>
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

    <!-- USERS TABLE -->
    <div class="row mt-3">
        <div class="col">
            <div class="table-box">
                <h6>USERS</h6>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = $conn->query("SELECT user_id, name, email, role, created_at FROM users");
                        while($u = $users->fetch_assoc()){
                            echo "<tr>
                                    <td>{$u['user_id']}</td>
                                    <td>{$u['name']}</td>
                                    <td>{$u['email']}</td>
                                    <td>{$u['role']}</td>
                                    <td>{$u['created_at']}</td>
                                  </tr>";
                        }
                        ?>
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

<!-- Your JS files -->
<script src="../assets/script.js"></script>
<script src="../assets/chart.js"></script>

</body>
</html>