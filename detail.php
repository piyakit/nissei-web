<?php
// detail.php

// Retrieve the transactionId from the URL
$transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : null;

if ($transactionId) {
    // Use $transactionId to fetch and display details
    // ... your code to fetch and display details based on $transactionId
    //echo json_encode(['status' => 'success', 'data' => $yourDetails]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Transaction ID not provided.']);
}
?>


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
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Manage Transaction</h2>
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <form id="addData" action="add_data_detail.php" method="post">
                            <div class="row align-items-start">
                                <div class="col">
                                    <div class="mb-3"><label>F.G.Part</label><input class="form-control" type="text" name="fgPart" placeholder="F.G. Part" disabled /></div>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col">
                                    <div class="mb-3"><label>Qty</label><input class="form-control" type="text" name="qty" placeholder="Type" disabled /></div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label>Type</label><input class="form-control" type="text" name="type" placeholder="Type" disabled /></div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label>Create_by</label><input class="form-control" type="text" name="create_by" placeholder="Type" disabled /></div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label>Create_Date</label><input class="form-control" type="text" name="create_date" placeholder="Type" disabled /></div>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col">
                                    <div class="mb-3"><label>Month</label><input class="form-control" type="text" name="month" placeholder="Month" /></div>
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                                <div class="col">
                                </div>
                            </div>
                            <div id="material_data"></div>
                            <div class="mb-3 text-end"><button class="btn btn-primary d-block mt-3" type="button" name="add_material">Add Mat.</button></div>
                            <div class="mb-3 text-end"><button class="btn btn-primary d-block mt-3" type="submit" name="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
        <script type="text/javascript">
            $(document).ready(function() {
                // Submit form to add material
                $.ajax({
                    type: "GET",
                    url: "getData_Transaction.php",
                    data: {
                        transactionId: <?php echo $transactionId; ?>
                    },
                    dataType: "json",
                    success: function(data) {
                        // Clear existing rows
                        // Assuming you want to fill the form controls with the first row of data
                        if (data && data.length > 0) {
                            // Use the first row of data
                            var item = data[0];

                            // Fill form controls with data
                            $("input[name='fgPart']").val(item.fg_part);
                            $("input[name='qty']").val(item.qty);
                            $("input[name='type']").val(item.type);
                            $("input[name='create_by']").val(item.create_by);
                            $("input[name='create_date']").val(item.create_date);
                        }
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
                });
            });

            // Form submission logic
            $("form#addData").submit(function(e) {
                e.preventDefault();
                var transactionId = <?php echo json_encode($transactionId); ?>;

                // Fetch existing data
                var existingData = {
                    fgPart: $("input[name='fgPart']").val(),
                    qty: $("input[name='qty']").val(),
                    type: $("input[name='type']").val(),
                    create_by: $("input[name='create_by']").val(),
                    create_date: $("input[name='create_date']").val(),
                    month: $("input[name='month']").val(),
                    transaction_id: transactionId,
                };

                // Fetch new material data
                var newMaterialData = [];
                $("div#material_data input[name='new_material[]']").each(function() {
                    newMaterialData.push({
                        material_name: $(this).val()
                    });
                });

                // Prepare data to be sent
                var postData = {
                    existingData: existingData,
                    newMaterialData: newMaterialData,
                };

                // Send data to add_data_detail.php
                $.ajax({
                    type: "POST",
                    url: "add_data_detail.php",
                    data: postData,
                    dataType: "json",
                    success: function(response) {
                        // Handle success response
                        if (response.status === "success") {
                            // Show success SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'data added successfully!',
                            }).then(() => {
                                // Redirect based on the 'type' parameter
                                if (postData.existingData.type === "local") {
                                    window.location.href = 'mat_local.php';
                                } else if (postData.existingData.type === "boi") {
                                    window.location.href = 'mat_boi.php';
                                } else {
                                    // Default redirection or handle other cases
                                    window.location.href = 'forcast.php';
                                }
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
                    error: function() {
                        console.error("Error submitting form data.");
                    },
                });

            });
        </script>
        <script type="module">
            import Autocomplete from "https://cdn.jsdelivr.net/gh/lekoala/bootstrap5-autocomplete@master/autocomplete.js";
            $(document).ready(function() {
                // Function to fetch and display data
                let src;
                // Add Mat. button click event
                $("button[name='add_material']").click(function() {
                    // Create a new div with input fields
                    var newMaterialDiv = $("<div class='row align-items-start'>" +
                        "<div class='col'><label>Material</label><input type='text' class='form-control autocomplete' data-suggestions-threshold='0' name='new_material[]' placeholder='Material' /></div>" +
                        "</div>");

                    // Append the new div to the form
                    $("#material_data").append(newMaterialDiv);

                    initAutocomplete(newMaterialDiv.find("input.autocomplete"));
                });

                fetch('getData_Material_Name.php')
                    .then(response => response.json())
                    .then(data => {
                        // Process the data and create Autocomplete items
                        src = data.map((item, index) => ({
                            title: item.material,
                            id: `opt${index}`,
                            data: {
                                key: index
                            },
                        }));

                        initAutocomplete();
                    })
                    .catch(error => console.error('Error fetching data:', error));

                function initAutocomplete(inputField) {
                    // Find all input fields with the 'autocomplete' class and initialize Autocomplete
                    Autocomplete.init(this, {
                        items: src,
                        valueField: "id",
                        labelField: "title",
                        highlightTyped: false,
                        onSelectItem: console.log,
                    });

                    const opts = {
                        onSelectItem: console.log,
                    };
                }



            });
        </script>

</body>

</html>