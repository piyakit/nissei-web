<?php
// Start session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Data Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        <?php include './css/style.css'; ?>
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 py-6 justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <div class="row g-3 mb-2">
                                <div class="col-auto">
                                    <h3>Get Data Transaction</h3>
                                </div>

                            </div>

                            <!-- Modify the table definition -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="transactionTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Usage</th>
                                            <th>Material</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>FG_Part</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
    <script>
        $(document).ready(function() {

            // Function to fetch and display data
            function fetchData() {
                var material = $('#material').val();

                $.ajax({
                    type: "GET",
                    url: "getData_Backup.php",
                    data: {
                        material: material
                    },
                    dataType: "json",
                    success: function(data) {
                        // Clear existing rows
                        $("#transactionTable tbody").empty();

                        // Populate table with fetched data
                        $.each(data, function(index, item) {
                            $("#transactionTable tbody").append(
                                "<tr>" +
                                "<td>" + (index + 1) + "</td>" +
                                "<td>" + item.usage_all + "</td>" +
                                "<td>" + item.material + "</td>" +
                                "<td>" + item.qty + "</td>" +
                                "<td>" + item.unit + "</td>" +
                                "<td>" + item.fg_part + "</td>" +
                                "</tr>"
                            );
                        });
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
                    // error: function(textStatus) {
                    //     // Log the SQL command
                    //     console.log("SQL Command:", textStatus.responseText);

                    // }
                });
            }

            // Fetch data on page load
            fetchData();

            // Apply filters on input change
            $('#material').on('change', function() {
                fetchData();
            });
        });
    </script>
</body>

</html>