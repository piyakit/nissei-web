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
                <div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>Status Transaction</h2>
                        </div>
                        <div class="card-body p-4 p-sm-5">
                            <div class="row">
                                <div class="col-3">
                                    <div class="row m-2">
                                        <button type="button" class="btn btn-primary" style="font-size: 1.0rem;padding: 30px;justify-content: center;align-items: center;display: flex;">ปี 2567</button>
                                    </div>
                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">มกราคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">กุมภาพันธ์</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">มีนาคม</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">เมษายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">พฤษภาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">มิถุนายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">กรกฎาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">สิงหาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">กันยายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">ตุลาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">พฤศจิกายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-primary month-button">ธันวาคม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="row m-2">
                                        <button type="button" class="btn btn-success" style="font-size: 1.0rem;padding: 30px;justify-content: center;align-items: center;display: flex;">ปี 2568</button>
                                    </div>
                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">มกราคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">กุมภาพันธ์</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">มีนาคม</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">เมษายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">พฤษภาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">มิถุนายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">กรกฎาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">สิงหาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">กันยายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">ตุลาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">พฤศจิกายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-success month-button">ธันวาคม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="row m-2">
                                        <button type="button" class="btn btn-danger" style="font-size: 1.0rem;padding: 30px;justify-content: center;align-items: center;display: flex;">ปี 2569</button>
                                    </div>
                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">มกราคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">กุมภาพันธ์</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">มีนาคม</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">เมษายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">พฤษภาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">มิถุนายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">กรกฎาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">สิงหาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">กันยายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">ตุลาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">พฤศจิกายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-danger month-button">ธันวาคม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="row m-2">
                                        <button type="button" class="btn btn-warning" style="font-size: 1.0rem;padding: 30px;justify-content: center;align-items: center;display: flex;">ปี 2570</button>
                                    </div>
                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">มกราคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">กุมภาพันธ์</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">มีนาคม</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">เมษายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">พฤษภาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">มิถุนายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">กรกฎาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">สิงหาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">กันยายน</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-2" style="width: 100%;">
                                        <div class="box d-flex justify-content-around">
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">ตุลาคม</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">พฤศจิกายน</button>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-warning month-button">ธันวาคม</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            // Function to fetch and display data
            // $.ajax({
            //     type: "GET",
            //     url: "getData_Transaction.php",
            //     dataType: "json",
            //     success: function(data) {
            //         // Clear existing rows
            //         $("#transactionTable tbody").empty();

            //         // Populate table with fetched data
            //         $.each(data, function(index, item) {
            //             var manageButton = '<button class="btn btn-info manage-btn" data-transaction-id="' + item.id + '">Manage</button>';
            //             $("#transactionTable tbody").append(
            //                 "<tr>" +
            //                 "<td>" + item.id + "</td>" +
            //                 "<td>" + item.fg_part + "</td>" +
            //                 "<td>" + item.type + "</td>" +
            //                 "<td>" + item.status + "</td>" +
            //                 "<td>" + item.create_by + "</td>" +
            //                 "<td>" + item.create_date + "</td>" +
            //                 "</tr>"
            //             );
            //         });

            //         // Add click event for the "Manage" buttons
            //         $(".manage-btn").click(function() {
            //             var transactionId = $(this).data("transaction-id");
            //             // Implement logic to show details or modify data based on transactionId
            //             // You can use another AJAX request to fetch detailed information
            //             // or redirect the user to a new page for data modification.
            //             window.location.href = 'detail.php?transactionId=' + transactionId;
            //         });
            //     },
            //     error: function() {
            //         console.error("Error fetching data.");
            //     }
            // });
        });
    </script>
    <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
</body>

</html>