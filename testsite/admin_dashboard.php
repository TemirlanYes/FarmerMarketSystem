<?php
// Start session and connect to the database
session_start();
$servername = "localhost";
$username = "root";
$password = "root123456"; // Add your password
$dbname = "FarmersMarketDatabase";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending farmers
$sqlPending = "SELECT f.farmerID, f.fname, f.sname, f.email, farm.farmSize, farm.farmLoc
                FROM Farmer f JOIN farm ON f.farmerID = farm.farmerID WHERE f.status = 'pending'";
$resultPending = $conn->query($sqlPending);

// Fetch approved farmers
$sqlApprovedFarmers = "SELECT f.farmerID, f.fname, f.sname, f.email, f.is_enabled
                        FROM Farmer f WHERE f.status = 'approved'";
$resultApprovedFarmers = $conn->query($sqlApprovedFarmers);

// Fetch buyers
$sqlBuyers = "SELECT b.buyerID, b.fname, b.sname, b.email, b.is_enabled
               FROM Buyer b";
$resultBuyers = $conn->query($sqlBuyers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .tab, .subtab {
            display: none;
        }
        .tab.active, .subtab.active {
            display: block;
        }
        .subtab {
            margin-top: 10px;
        }
        .subtab-buttons {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function showTab(tabName) {
            // Hide all tabs
            var tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Show the selected tab
            var activeTab = document.getElementById(tabName);
            activeTab.classList.add('active');
        }

        function showSubtab(tabName) {
            // Hide all subtabs
            var subtabs = document.querySelectorAll('.subtab');
            subtabs.forEach(subtab => subtab.classList.remove('active'));

            // Show the selected subtab
            var activeSubtab = document.getElementById(tabName);
            activeSubtab.classList.add('active');
        }

        function approveFarmer(farmerID) {
            if (confirm("Are you sure you want to approve this farmer?")) {
                window.location.href = "approve_farmer.php?id=" + farmerID;
            }
        }

        function rejectFarmer(farmerID) {
            let reason = prompt("Enter reason for rejection:");
            if (reason) {
                window.location.href = "reject_farmer.php?id=" + farmerID + "&reason=" + encodeURIComponent(reason);
            }
        }

        function toggleFarmerStatus(farmerID, isEnabled) {
            let action = isEnabled ? 'disable' : 'enable';
            if (confirm(`Are you sure you want to ${action} this farmer?`)) {
                window.location.href = `toggle_farmer_status.php?id=${farmerID}&action=${action}`;
            }
        }

        function toggleBuyerStatus(buyerID, isEnabled) {
            let action = isEnabled ? 'disable' : 'enable';
            if (confirm(`Are you sure you want to ${action} this buyer?`)) {
                window.location.href = `toggle_buyer_status.php?id=${buyerID}&action=${action}`;
            }
        }

        // Show the initial tab
        window.onload = function() {
            showTab('pendingFarmers');
        };
    </script>
</head>
<body>
    <?php if (isset($_GET['message'])): ?>
        <p><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <h2>Admin Dashboard</h2>

    <button onclick="showTab('pendingFarmers')">Pending Farmers</button>
    <button onclick="showTab('manageUsers')">Manage Users</button>

    <div id="pendingFarmers" class="tab">
        <h3>Pending Farmers</h3>
        <?php if ($resultPending->num_rows > 0): ?>
            <?php while ($row = $resultPending->fetch_assoc()): ?>
                <div class="farmer-profile">
                    <p>Name: <?php echo htmlspecialchars($row['fname'] . " " . $row['sname']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                    <p>Farm Size: <?php echo htmlspecialchars($row['farmSize']); ?> acres</p>
                    <p>Location: <?php echo htmlspecialchars($row['farmLoc']); ?></p>
                    <button onclick="approveFarmer(<?php echo $row['farmerID']; ?>)">Approve</button>
                    <button onclick="rejectFarmer(<?php echo $row['farmerID']; ?>)">Reject</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No pending farmers found.</p>
        <?php endif; ?>
    </div>

    <div id="manageUsers" class="tab">
        <h3>Manage Users</h3>

        <div class="subtab-buttons">
            <button onclick="showSubtab('approvedFarmersTab')">Approved Farmers</button>
            <button onclick="showSubtab('buyersTab')">Buyers</button>
        </div>

        <div id="approvedFarmersTab" class="subtab">
            <h4>Approved Farmers</h4>
            <?php if ($resultApprovedFarmers->num_rows > 0): ?>
                <?php while ($row = $resultApprovedFarmers->fetch_assoc()): ?>
                    <div class="farmer-profile">
                        <p>Name: <?php echo htmlspecialchars($row['fname'] . " " . $row['sname']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                        <p>Status: <?php echo htmlspecialchars($row['is_enabled'] ? 'Enabled' : 'Disabled'); ?></p>
                        <button onclick="toggleFarmerStatus(<?php echo $row['farmerID']; ?>, <?php echo $row['is_enabled']; ?>)">
                            <?php echo $row['is_enabled'] ? 'Disable' : 'Enable'; ?>
                        </button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No approved farmers found.</p>
            <?php endif; ?>
        </div>

        <div id="buyersTab" class="subtab">
            <h4>Buyers</h4>
            <?php if ($resultBuyers->num_rows > 0): ?>
                <?php while ($row = $resultBuyers->fetch_assoc()): ?>
                    <div class="buyer-profile">
                        <p>Name: <?php echo htmlspecialchars($row['fname'] . " " . $row['sname']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                        <p>Status: <?php echo htmlspecialchars($row['is_enabled'] ? 'Enabled' : 'Disabled'); ?></p>
                        <button onclick="toggleBuyerStatus(<?php echo $row['buyerID']; ?>, <?php echo $row['is_enabled']; ?>)">
                            <?php echo $row['is_enabled'] ? 'Disable' : 'Enable'; ?>
                        </button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No buyers found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
