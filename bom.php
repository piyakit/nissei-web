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
    <title>BOM</title>
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
                        <div class="card-header text-center">
                            <div class="row">
                                <div class="col-sm-5 col-md-11">
                                    <h2>BOM</h2>
                                </div>
                                <div class="col-sm-5 offset-sm-2 col-md-1 offset-md-0"><button class="btn btn-primary">Report</button></div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3 mb-2">
                                <div class="col-auto">
                                    <label for="material" class="form-label">Material Name:</label>
                                    <input class="form-input autocomplete_material_name" data-suggestions-threshold="0" id="material" />
                                </div>
                                <div class="col-auto">
                                    <label for="materialCode" class="form-label">Material Code:</label>
                                    <input class="form-input autocomplete_material_code" data-suggestions-threshold="0" id="materialCode" />
                                </div>
                                <div class="col-auto">
                                    <label for="vendor" class="form-label">Vendor:</label>
                                    <input class="form-input autocomplete_vendor" data-suggestions-threshold="0" id="vendor" />
                                </div>
                                <div class="col-auto">
                                    <label for="fgPart" class="form-label">F.G.Part:</label>
                                    <input class="form-input autocomplete_fgpart" data-suggestions-threshold="0" id="fgPart" />
                                </div>
                                <div class="col-auto"><button type="button" class="btn btn-primary" id="searchMaterialBtn">Search Material</button></div>
                                <div class="col-auto"><button type="button" class="btn btn-danger" id="clearFilterBtn">Clear</button></div>
                                <div class="col-auto"><button type="button" class="btn btn-primary" id="addBomBtn">Add BOM</button></div>
                                <div class="col-auto"><button type="button" class="btn btn-danger" id="delBomBtn">Delete BOM</button></div>
                            </div>

                            <!-- Modify the table definition -->
                            <div class="table-responsive" id="table-responsive">
                                <div id="spinner" class="text-center mb-3" style="display: none;">
                                    <div class="spinner-grow text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-secondary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-danger" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-warning" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-info" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="transactionTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2">ID</th>
                                            <th rowspan="2">FG_Part</th>
                                            <th rowspan="2">Customer Name</th>
                                            <th rowspan="2">Material</th>
                                            <th rowspan="2">Material Code</th>
                                            <th rowspan="2">Vendor</th>
                                            <th rowspan="2">Qty</th>
                                            <th rowspan="2">Unit</th>
                                            <th colspan="2" style="background-color:aquamarine;">Forecast</th>
                                            <th colspan="2">Order1</th>
                                            <th colspan="2">Order2</th>
                                            <th colspan="2">Order3</th>
                                            <th colspan="2">Order4</th>
                                            <th colspan="2">Order5</th>
                                            <th colspan="2">Order6</th>
                                            <th colspan="2">Order7</th>
                                            <th colspan="2">Order8</th>
                                            <th colspan="2">Order9</th>
                                            <th colspan="2">Order10</th>
                                            <th colspan="2">Order11</th>
                                            <th colspan="2">Order12</th>
                                            <th colspan="2" style="background-color:aquamarine;">Forecast</th>
                                            <th colspan="2">Usage1</th>
                                            <th colspan="2">Usage2</th>
                                            <th colspan="2">Usage3</th>
                                            <th colspan="2">Usage4</th>
                                            <th colspan="2">Usage5</th>
                                            <th colspan="2">Usage6</th>
                                            <th colspan="2">Usage7</th>
                                            <th colspan="2">Usage8</th>
                                            <th colspan="2">Usage9</th>
                                            <th colspan="2">Usage10</th>
                                            <th colspan="2">Usage11</th>
                                            <th colspan="2">Usage12</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color:aquamarine;">BOI</th>
                                            <th style="background-color:aquamarine;">Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th style="background-color:aquamarine;">BOI</th>
                                            <th style="background-color:aquamarine;">Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
                                            <th>BOI</th>
                                            <th>Local</th>
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
    <script type="module">
        import Autocomplete from "https://cdn.jsdelivr.net/gh/lekoala/bootstrap5-autocomplete@master/autocomplete.js";

        // Fetch data from getData_fgpart.php
        fetch('getData_fgpart.php')
            .then(response => response.json())
            .then(data => {
                // Process the data and create Autocomplete items
                const src = data.map((item, index) => ({
                    title: item.fg_part,
                    id: `opt${index}`,
                    data: {
                        key: index
                    },
                }));
                initAutocomplete(src);
            })
            .catch(error => console.error('Error fetching data:', error));

        fetch('getData_Vendorname.php')
            .then(response => response.json())
            .then(data => {
                // Process the data and create Autocomplete items
                const src = data.map((item, index) => ({
                    title: item.vendor,
                    id: `opt${index}`,
                    data: {
                        key: index
                    },
                }));

                initAutocompleteVendor(src);
            })
            .catch(error => console.error('Error fetching data:', error));

        fetch('getData_Material_Name.php')
            .then(response => response.json())
            .then(data => {
                // Process the data and create Autocomplete items
                const src = data.map((item, index) => ({
                    title: item.material,
                    id: `opt${index}`,
                    data: {
                        key: index
                    },
                }));

                initAutocompleteMaterialName(src);
            })
            .catch(error => console.error('Error fetching data:', error));

        fetch('getData_Material_Code.php')
            .then(response => response.json())
            .then(data => {
                // Process the data and create Autocomplete items
                const src = data.map((item, index) => ({
                    title: item.code,
                    id: `opt${index}`,
                    data: {
                        key: index
                    },
                }));

                initAutocompleteMaterialCode(src);
            })
            .catch(error => console.error('Error fetching data:', error));

        function initAutocomplete(src) {
            Autocomplete.init("input.autocomplete_fgpart", {
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

        function initAutocompleteVendor(src) {
            Autocomplete.init("input.autocomplete_vendor", {
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

        function initAutocompleteMaterialName(src) {
            Autocomplete.init("input.autocomplete_material_name", {
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

        function initAutocompleteMaterialCode(src) {
            Autocomplete.init("input.autocomplete_material_code", {
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
    </script>
    <script>
        $(document).ready(function() {
            function toggleSpinner(show) {
                if (show) {
                    $('#spinner').show();
                } else {
                    $('#spinner').hide();
                }
            }
            // Function to fetch and display data
            function fetchData() {
                toggleSpinner(true);
                var material = $('#material').val().trim();
                var materialCode = $('#materialCode').val().trim();
                var vendor = $('#vendor').val().trim();
                var fgPart = $('#fgPart').val().trim();

                $.ajax({
                    type: "GET",
                    url: "getData.php",
                    data: {
                        material: material,
                        material_code: materialCode,
                        vendor: vendor,
                        fgPart: fgPart
                    },
                    dataType: "json",
                    success: function(data) {
                        // Clear existing rows
                        $("#transactionTable tbody").empty();
                        toggleSpinner(false);
                        // Populate table with fetched data
                        $.each(data, function(index, item) {
                            var htmlTd = "";
                            htmlTd += "<td>" + item.forecast_boi + "</td>";
                            htmlTd += "<td>" + item.forecast_local + "</td>";
                            for (var i = 1; i <= 12; i++) {
                                htmlTd += `<td>${item['MONTH' + i + '_local']}</td>`;
                                htmlTd += `<td>${item['MONTH' + i + '_boi']}</td>`;
                            }
                            htmlTd += "<td>" + item.qty_boi + "</td>";
                            htmlTd += "<td>" + item.qty_local + "</td>";
                            for (var i = 1; i <= 12; i++) {
                                let localValue = item['MONTH' + i + '_local'] ?? 0;
                                let boiValue = item['MONTH' + i + '_boi'] ?? 0; 
                                let qty = item.qty ?? 0; 
                                let totalBoiValue = (boiValue * qty).toFixed(2); // แสดงทศนิยม 2 ตำแหน่ง
                                let totalLocalValue = (localValue * qty).toFixed(2); // แสดงทศนิยม 2 ตำแหน่ง
                                htmlTd += `<td>${totalLocalValue}</td>`;
                                htmlTd += `<td>${totalBoiValue}</td>`;
                            }

                            $("#transactionTable tbody").append(
                                "<tr>" +
                                "<td>" + (index + 1) + "</td>" +
                                "<td>" + item.fg_part + "</td>" +
                                "<td>" + item.customer + "</td>" +
                                "<td>" + item.material + "</td>" +
                                "<td>" + item.material_code + "</td>" +
                                "<td>" + item.vendor + "</td>" +
                                "<td>" + item.qty + "</td>" +
                                "<td>" + item.unit + "</td>" +
                                htmlTd +
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

            $('#searchMaterialBtn').on('click', function() {
                fetchData();
            });

            $('#clearFilterBtn').on('click', function() {
                // Clear the values in the input fields
                $('#material').val('');
                $('#materialCode').val('');
                $('#vendor').val('');
                $('#fgPart').val('');
                // Fetch data after clearing filters
                fetchData();
            });

            // Add event listener to the "Add Mat" button
            $('#addBomBtn').on('click', function() {
                // Navigate to the form input page
                window.location.href = 'add_bom.php';
            });
        });
    </script>
</body>

</html>