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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        <?php include './css/style.css'; ?>
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 py-6 justify-content-center">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>Add Local/BOI</h2>
                        </div>
                        <div class="card-body p-4 p-sm-5">
                            <form id="addData" action="add_data.php" method="post">
                                <select class="form-select" name="type">
                                    <option value="boi">BOI</option>
                                    <option value="local">Local</option>
                                </select>

                                <select class="form-select" name="material_name" id="typeDropdown">
                                    <!-- Dropdown options will be dynamically added here -->
                                </select>
                                <div class="mb-3"><input class="form-control" type="text" name="qty" placeholder="Qty" /></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
    <script type="text/javascript">
        $(document).ready(function() {
            // Function to fetch and display data
            function fetchFgPartData() {
                $.ajax({
                    type: "GET",
                    url: "getData_fgpart.php",
                    data: {
                        material: material
                    },
                    dataType: "json",
                    success: function(data) {
                    // Populate dropdown with fetched data
                    var dropdown = $('#typeDropdown');
                    $.each(data, function(index, item) {
                        dropdown.append($('<option>').text(item.material).val(item.material));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error:", textStatus, errorThrown);
                }
                });
            }

            $.ajax({
                type: "GET",
                url: "getData.php", // Point this to the correct processing file
                dataType: "json",
                success: function(data) {
                    // Populate dropdown with fetched data
                    var dropdown = $('#typeDropdown');
                    $.each(data, function(index, item) {
                        dropdown.append($('<option>').text(item.material).val(item.material));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error:", textStatus, errorThrown);
                }
            });

            $("#addData").submit(function(e) {
                e.preventDefault();

                // Perform the form submission using AJAX
                $.ajax({
                    type: "POST",
                    url: "add_data.php", // Point this to the correct processing file
                    data: $("#addData").serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // Show success SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'data added successfully!',
                            }).then(() => {
                                window.location.href = 'show_data.php';
                            });
                        } else {
                            // Show error SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
</body>

</html>