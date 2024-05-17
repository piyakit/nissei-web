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
  <title>Mat Local</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <style>
    <?php include './css/style.css'; ?>.td-min-width {
      min-width: 100px;
      height: 100%;
    }
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
              <div class="row">
                <div class="col-sm-5 col-md-11">
                  <h2>Mat. Local</h2>
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
                  <label for="groups" class="form-label">Type:</label>
                  <input class="form-input autocomplete_groups" data-suggestions-threshold="0" id="groups" />
                </div>
                <div class="col-auto">
                  <label for="vendor" class="form-label">Vendor:</label>
                  <input class="form-input autocomplete_vendor" data-suggestions-threshold="0" id="vendor" />
                </div>
                <div class="col-auto"><button type="button" class="btn btn-primary" id="searchMaterialBtn">Search Material</button></div>
                <div class="col-auto"><button type="button" class="btn btn-danger" id="clearFilterBtn">Clear</button></div>
              </div>
              <!-- Modify the table definition -->
              <div class="table-responsive" id="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="transactionTable">
                  <thead class="table-light">
                    <tr>
                      <th rowspan="4">No</th>
                      <th rowspan="4">Material</th>
                      <th rowspan="4">Vendor</th>
                      <th rowspan="4">Type</th>
                      <th rowspan="4">QTY</th>
                      <th rowspan="4">UNIT</th>
                      <th rowspan="4">Price Local</th>
                      <th rowspan="4">Price BOI</th>
                      <th rowspan="4">ST Store</th>
                      <th rowspan="4">ST After</th>
                      <th rowspan="4">ST Aom</th>
                      <th rowspan="4">ST Jha</th>
                      <th rowspan="4">ST ATT</th>
                      <th rowspan="4">ST Misuki</th>
                      <th rowspan="4">ST Dead</th>
                      <th colspan="7" style="text-align: center;">Jan</th>
                      <script>
                        const months = ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        // Loop through the months to generate headers
                        months.forEach(month => {
                          document.write(`<th colspan="6" style="text-align: center;">${month}</th>`);
                        });
                      </script>
                    </tr>
                    <tr>
                      <th rowspan="3">Use</th>
                      <th rowspan="3">Use</th>
                      <th colspan="4" style="text-align: center;">PURCHASE</th>
                      <th rowspan="3">BALANCE</th>
                      <script>
                        // Loop through the months to generate headers
                        months.forEach(month => {
                          document.write(`<th rowspan="3">Forecast</th>`);
                          document.write(`<th colspan="4" style="text-align: center;">PURCHASE</th>`);
                          document.write(`<th rowspan="3">BALANCE</th>`);
                        });
                      </script>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align: center;">RECEIVED</th>
                      <th colspan="2" style="text-align: center;">INCOMING</th>
                      <script>
                        // Loop through the months to generate headers
                        months.forEach(month => {
                          document.write(`<th colspan="2" style="text-align: center;">RECEIVED</th>`);
                          document.write(`<th colspan="2" style="text-align: center;">INCOMING</th>`);
                        });
                      </script>
                    </tr>
                    <tr>
                      <th>QTY.</th>
                      <th>DATE</th>
                      <th>QTY.</th>
                      <th>DATE</th>
                      <script>
                        // Loop through the months to generate headers
                        months.forEach(month => {
                          document.write(`<th>QTY.</th>`);
                          document.write(`<th>DATE</th>`);
                          document.write(`<th>QTY.</th>`);
                          document.write(`<th>DATE</th>`);
                        });
                      </script>
                    </tr>
                  </thead>
                  <tbody id="data3">
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
  <script type="module">
    import Autocomplete from "https://cdn.jsdelivr.net/gh/lekoala/bootstrap5-autocomplete@master/autocomplete.js";

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

    fetch('getData_Group.php')
      .then(response => response.json())
      .then(data => {
        // Process the data and create Autocomplete items
        const src = data.map((item, index) => ({
          title: item.groups,
          id: `opt${index}`,
          data: {
            key: index
          },
        }));

        initAutocompleteGroups(src);
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

    function initAutocompleteGroups(src) {
      Autocomplete.init("input.autocomplete_groups", {
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
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#clearFilterBtn').on('click', function() {
        // Clear the values in the input fields
        $('#material').val('');
        $('#groups').val('');
        $('#vendor').val('');
        // Fetch data after clearing filters
        fetchData();
      });

      // Function to fetch and display data
      $(document).on('input', ".editable-cell-receive-qty", function() {
        // Get the updated content
        var updatedContent = $(this).text().trim();

        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Extract the column number from the id (assuming the format is "stock_i_local_j")
        var columnNumber = columnId.split('_')[1];

        // Call the update function with the updated content, row index, and column number
        updateDataReceivedQuantity(index, columnNumber, updatedContent);
      });

      $(document).on('input', ".editable-cell-receive-date", function() {
        // Get the updated content
        var updatedContent = $(this).text().trim();
        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Extract the column number from the id (assuming the format is "stock_i_local_j")
        var columnNumber = columnId.split('_')[1];

        // Call the update function with the updated content, row index, and column number
        updateDataReceivedDate(index, columnNumber, updatedContent);
      });

      $(document).on('input', ".editable-cell-incoming-qty", function() {
        // Get the updated content
        var updatedContent = $(this).text().trim();

        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Extract the column number from the id (assuming the format is "stock_i_local_j")
        var columnNumber = columnId.split('_')[1];

        // Call the update function with the updated content, row index, and column number
        updateDataIncomingQuantity(index, columnNumber, updatedContent);
      });

      $(document).on('input', ".editable-cell-incoming-date", function() {
        // Get the updated content
        var updatedContent = $(this).text().trim();
        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Extract the column number from the id (assuming the format is "stock_i_local_j")
        var columnNumber = columnId.split('_')[1];

        // Call the update function with the updated content, row index, and column number
        updateDataIncomingDate(index, columnNumber, updatedContent);
      });

      $(document).on('input', ".editable-cell", function() {
        // Get the updated content
        var updatedContent = $(this).text();

        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Extract the column number from the id (assuming the format is "stock_i_local_j")
        var columnNumber = columnId.split('_')[1];

        // Call the update function with the updated content, row index, and column number
        updateData(index, columnNumber, updatedContent);
      });

      $(document).on('input', ".editable-cell-price", function() {
        // Get the updated content
        var updatedContent = $(this).text();

        // Get the corresponding row index and column id
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        // Call the update function with the updated content, row index, and column number
        updatePrice(index, updatedContent);
      });

      function updateData(index, columnNumber, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text();

        console.log("index", index);
        console.log("columnNumber", columnNumber);
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updateStock.php",
          data: {
            material_name: material,
            new_qty: updatedContent,
            stock_id: columnNumber,
            type: "local"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      function updateDataReceivedQuantity(index, columnNumber, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text().trim();
        var vendor = $("#data3 tr:eq(" + index + ") td:nth-child(3)").text().trim();
        console.log("index", index);
        console.log("columnNumber", columnNumber);
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        console.log("vendor", vendor);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updateReceivedQuantity.php",
          data: {
            material_name: material,
            new_qty: updatedContent,
            vendor: vendor,
            month: columnNumber,
            type: "local"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      function updateDataIncomingQuantity(index, columnNumber, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text().trim();
        var vendor = $("#data3 tr:eq(" + index + ") td:nth-child(3)").text().trim();
        console.log("index", index);
        console.log("columnNumber", columnNumber);
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        console.log("vendor", vendor);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updateIncomingQuantity.php",
          data: {
            material_name: material,
            new_qty: updatedContent,
            vendor: vendor,
            month: columnNumber,
            type: "local"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      function updateDataReceivedDate(index, columnNumber, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text().trim();
        var vendor = $("#data3 tr:eq(" + index + ") td:nth-child(3)").text().trim();
        console.log("index", index);
        console.log("columnNumber", columnNumber);
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        console.log("vendor", vendor);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updateReceivedIncomingDate.php",
          data: {
            material_name: material,
            new_date: updatedContent,
            vendor: vendor,
            month: columnNumber,
            type: "received"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      function updateDataIncomingDate(index, columnNumber, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text().trim();
        var vendor = $("#data3 tr:eq(" + index + ") td:nth-child(3)").text().trim();
        console.log("index", index);
        console.log("columnNumber", columnNumber);
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        console.log("vendor", vendor);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updateReceivedIncomingDate.php",
          data: {
            material_name: material,
            new_date: updatedContent,
            vendor: vendor,
            month: columnNumber,
            type: "incoming"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      function updatePrice(index, updatedContent) {
        // Fetch the material information from the corresponding cell
        var material = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text().trim();
        var vendor = $("#data3 tr:eq(" + index + ") td:nth-child(3)").text().trim();
        console.log("updatedContent", updatedContent);
        console.log("Material", material);
        // You can use the 'material' variable as needed, for example, displaying it on the page.

        //Make an AJAX request to updateStock.php
        $.ajax({
          type: "POST",
          url: "updatePrice.php",
          data: {
            material_name: material,
            new_qty: updatedContent,
            type: "local"
          },
          dataType: "json",
          success: function(response) {
            // Log the response to the console (optional)
            console.log(response);

            // You can handle success response here if needed
          },
          error: function(error) {
            // Log the error to the console (optional)
            console.error(error);

            // You can handle error response here if needed
          }
        });
      }

      $('#searchMaterialBtn').on('click', function() {
        fetchData();
      });

      function fetchData() {
        var material = $('#material').val().trim();
        var groups = $('#groups').val().trim();
        var vendor = $('#vendor').val().trim();
        $.ajax({
          type: "GET",
          url: "getData_All_local.php",
          dataType: "json",
          data: {
            material: material,
            groups: groups,
            vendor: vendor
          },
          success: function(data) {
            // Clear existing rows
            // $("#data2").empty();
            $("#data3").empty();
            // Check if there is at least one item in the data
            if (data.length > 0) {
              var firstItem = data[0]; // Assuming you want the first item's transaction_id

              // Display the transaction_id in cell A1
              $("#data td:nth-child(1)").text(firstItem.transaction_id);

              // Populate table with fetched data
              var row = 1;
              var balance = 0;
              var totalLocalValue = 0;
              $.each(data, function(index, item) {
                var htmlCode = '';
                for (var month = 1; month <= 12; month++) {
                  let qty = 1;
                  let localValue = (item['MONTH' + month + '_QTY'] * qty); // แสดงทศนิยม 2 ตำแหน่ง
                  let forcast = (item.qty_local * qty);
                  //forcast
                  if (localValue === 0) {
                    htmlCode += "<td style='width:100px;'></td>";
                  } else {
                    htmlCode += "<td style='width:100px;'>" + localValue.toFixed(2) + "</td>";
                  }

                  if (month == 1) {
                    if (forcast === 0) {
                      htmlCode += "<td style='width:100px;'></td>";
                    } else {
                      htmlCode += "<td style='width:100px;'>" + forcast.toFixed(2) + "</td>";
                    }
                  }
                  //receive qty 
                  htmlCode += "<td contenteditable='true' id='receive_" + month + "_qty" + index + "' class='editable-cell-receive-qty'>" +
                    (item['received_month' + month + '_qty'] !== null && item['received_month' + month + '_qty'] !== 0 ?
                      item['received_month' + month + '_qty'] : '') +
                    "</td>";
                  //receive date
                  htmlCode += "<td contenteditable='true' id='receive_" + month + "_date" + index + "' class='editable-cell-receive-date'>" +
                    (item['received_month' + month + '_date'] != null ?
                      item['received_month' + month + '_date'] : '') +
                    "</td>";


                  //incoming qty 
                  htmlCode += "<td contenteditable='true' id='incoming_" + month + "_qty" + index + "' class='editable-cell-incoming-qty'>" +
                    (item['incoming_month' + month + '_qty'] !== null && item['incoming_month' + month + '_qty'] !== 0 ?
                      item['incoming_month' + month + '_qty'] : '') +
                    "</td>";
                  //incoming date
                  htmlCode += "<td contenteditable='true' id='incoming_" + month + "_date" + index + "' class='editable-cell-incoming-date'>" +
                    (item['incoming_month' + month + '_date'] != null ?
                      item['incoming_month' + month + '_date'] : '') +
                    "</td>";

                  var stock = 0;
                  var reduce = 0;
                  var cumulativeIncomingQty = 0;
                  var cumulativeReceiveQty = 0;
                  //var cumulativeForcast = 0;
                  if (month == 1) {
                    cumulativeIncomingQty = item['incoming_month1_qty'];
                    cumulativeReceiveQty = item['received_month1_qty'];
                    //cumulativeForcast = item['MONTH1_QTY'];
                  } else {

                    for (var i = 1; i <= month; i++) {
                      cumulativeIncomingQty += item['incoming_month' + i + '_qty'];
                    }


                    for (var i = 1; i <= month; i++) {
                      cumulativeReceiveQty += item['received_month' + i + '_qty'];
                    }

                    // for (var i = 1; i <= month; i++) {
                    //     var monthQty = parseInt(item['MONTH' + i + '_QTY'], 10);
                    //     cumulativeForcast += monthQty;
                    // }
                  }

                  // Calculate Stock and reduce
                  stock = item.stock1 + item.stock2 + item.stock3 + item.stock4 + item.stock5 + item.stock6 + item.stock7 + cumulativeIncomingQty + cumulativeReceiveQty;
                  reduce = forcast;
                  totalLocalValue = totalLocalValue + localValue;
                  //balance
                  balance = stock - reduce - totalLocalValue;
                  var textColor = balance < 0 ? "red" : "black";
                  htmlCode += "<td style='color: " + textColor + "'>" + balance.toFixed(2) + "</td>";
                }

                $("#data3").append(
                  "<tr>" +
                  "<td>" + row + "</td>" +
                  "<td>" + item.material + "</td>" +
                  "<td>" + item.vendor + "</td>" +
                  "<td>" + item.groups + "</td>" +
                  "<td>" + item.qty + "</td>" +
                  "<td>" + item.unit + "</td>" +
                  // "<td>" + item.price_local + "</td>" +
                  "<td contenteditable='true' id='pricelocal_" + index + "' class='editable-cell-price'>" + (item.price_local === 0 ? '' : item.price_local) + "</td>" +
                  "<td>" + (item.price_boi === 0 ? '' : item.price_boi) + "</td>" +
                  "<td contenteditable='true' id='stock_1_" + index + "' class='editable-cell'>" + (item.stock1 !== null && item.stock1 !== 0 ? item.stock1 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_2_" + index + "' class='editable-cell'>" + (item.stock2 !== null && item.stock2 !== 0 ? item.stock2 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_3_" + index + "' class='editable-cell'>" + (item.stock3 !== null && item.stock3 !== 0 ? item.stock3 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_4_" + index + "' class='editable-cell'>" + (item.stock4 !== null && item.stock4 !== 0 ? item.stock4 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_5_" + index + "' class='editable-cell'>" + (item.stock5 !== null && item.stock5 !== 0 ? item.stock5 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_6_" + index + "' class='editable-cell'>" + (item.stock6 !== null && item.stock6 !== 0 ? item.stock6 : '') + "</td>" +
                  "<td contenteditable='true' id='stock_7_" + index + "' class='editable-cell'>" + (item.stock7 !== null && item.stock7 !== 0 ? item.stock7 : '') + "</td>" +
                  htmlCode +
                  "</tr>"
                );

                row++;
              });

              // Add click event for the "Manage" buttons
              $(".manage-btn").click(function() {
                var transactionId = $(this).data("transaction-id");
                // Implement logic to show details or modify data based on transactionId
                // You can use another AJAX request to fetch detailed information
                // or redirect the user to a new page for data modification.
                window.location.href = 'detail.php?transactionId=' + transactionId;
              });
            } else {
              console.error("No data received.");
            }
          },
          error: function() {
            console.error("Error fetching data.");
          }
        });
      }

      fetchData();
    });
  </script>
  <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
</body>

</html>