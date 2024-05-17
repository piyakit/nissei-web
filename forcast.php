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
  <title>FORCAST</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    <?php include './css/style.css'; ?>
    .card-forecast {
      height: 85vh;
      overflow: hidden;
    }

    #table-responsive  {
      max-height: 600px;
      /* overflow: hidden; */
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="m-5">
    <div class="body-main">
      <div class="row flex-center min-vh-100 py-6 justify-content-center">
        <div>
          <div class="card card-forecast">
            <div class="card-header text-center">
              <div class="row">
                <div class="col-sm-5 col-md-11">
                  <h2>Forecast</h2>
                </div>
                <div class="col-sm-5 offset-sm-2 col-md-1 offset-md-0"><button class="btn btn-primary">Report</button></div>
              </div>
            </div>
            <div class="card-body p-4">
              <div class="row g-3 mb-2">
                <div class="col-auto">
                  <label for="customer" class="form-label">Customer Name:</label>
                  <input class="form-input autocomplete2" data-suggestions-threshold="0" id="customer" />
                </div>
                <div class="col-auto">
                  <label for="fgPart" class="form-label">F.G.Part:</label>
                  <input class="form-input autocomplete" data-suggestions-threshold="0" id="fgPart" />
                </div>
                <div class="col-auto"><button type="button" class="btn btn-primary btn-sm" id="searchBtn">Search</button></div>
                <div class="col-auto"><button type="button" class="btn btn-danger btn-sm" id="clearFilterBtn">Clear</button></div>
              </div>
              <div class="table-responsive" id="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="transactionTable">
                  <thead class="table-light">
                    <tr>
                      <th rowspan="2">Customer Name</th>
                      <th rowspan="2">Part Number</th>
                      <th colspan="2" style="text-align: center;background-color:aquamarine;">Forcast</th>
                      <th colspan="2" style="text-align: center;">Jan</th>
                      <th colspan="2" style="text-align: center;">Feb</th>
                      <th colspan="2" style="text-align: center;">Mar</th>
                      <th colspan="2" style="text-align: center;">Apr</th>
                      <th colspan="2" style="text-align: center;">May</th>
                      <th colspan="2" style="text-align: center;">Jun</th>
                      <th colspan="2" style="text-align: center;">Jul</th>
                      <th colspan="2" style="text-align: center;">Aug</th>
                      <th colspan="2" style="text-align: center;">Sep</th>
                      <th colspan="2" style="text-align: center;">Oct</th>
                      <th colspan="2" style="text-align: center;">Nov</th>
                      <th colspan="2" style="text-align: center;">Dec</th>
                    </tr>
                    <tr>
                      <th style="background-color:aquamarine;">Local</th>
                      <th style="background-color:aquamarine;">BOI</th>
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
                      <th>BOI</th>
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
  </div>
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

    fetch('getData_customer.php')
      .then(response => response.json())
      .then(data => {
        // Process the data and create Autocomplete items
        const src = data.map((item, index) => ({
          title: item.customer,
          id: `opt${index}`,
          data: {
            key: index
          },
        }));

        initAutocompleteVendor(src);
      })
      .catch(error => console.error('Error fetching data:', error));


    function initAutocomplete(src) {
      Autocomplete.init("input.autocomplete", {
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
      Autocomplete.init("input.autocomplete2", {
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
      // $(document).on('click', '.editable-cell', function() {
      //     $('.editable-cell').not(this).popover('hide');

      //     var index = $(this).closest('tr').index();
      //     var fgPart = checkFgPart(index);
      //     var customerName = '<span style="color: red;">' + checkCustomerName(index) + '</span>';

      //     $(this).popover({
      //         content: 'Customer Name: ' + customerName + '<br>' + 'FG Part: ' + fgPart,
      //         trigger: 'manual',
      //         placement: 'top',
      //         html: true,
      //         template: '<div class="popover" style="max-width: 100%; width: auto;"><div class="popover-body"></div></div>'
      //     }).popover('show');
      // });

      $(document).on('input', ".editable-cell", function() {
        // Get the updated content
        var updatedContent = $(this).text();
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');

        var monthNumber = columnId.split('_')[1];
        var localOrboi = columnId.split('_')[2];

        updateData(index, updatedContent, monthNumber, localOrboi);
      });

      $(document).on('input', ".editable-cell-forcast", function() {
        // Get the updated content
        var updatedContent = $(this).text();
        var index = $(this).closest('tr').index();
        var columnId = $(this).attr('id');
        var localOrboi = columnId.split('_')[1];

        updateDataForcast(index, updatedContent, localOrboi);
      });

      function updateData(index, updatedContent, monthNumber, localOrboi) {
        var fgPart = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text();
        console.log("fgPart", fgPart);
        console.log("updatedContent", updatedContent);
        console.log("monthNumber", monthNumber);
        console.log("localOrboi", localOrboi);

        $.ajax({
          type: "POST",
          url: "updateForcast.php",
          data: {
            fgPart: fgPart,
            new_qty: updatedContent,
            type: localOrboi,
            month: monthNumber
          },
          dataType: "json",
          success: function(response) {
            console.log(response);
          },
          error: function(error) {
            console.error(error);
          }
        });
      }

      function updateDataForcast(index, updatedContent, localOrboi) {
        var fgPart = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text();
        console.log("fgPart", fgPart);
        console.log("updatedContent", updatedContent);
        console.log("localOrboi", localOrboi);

        $.ajax({
          type: "POST",
          url: "updateForcastData.php", // ปรับเป็น updateQuantity.php
          data: {
            fgPart: fgPart,
            new_qty: updatedContent,
            type: localOrboi
          },
          dataType: "json",
          success: function(response) {
            console.log(response);
            // ดำเนินการตามการตอบกลับจากเซิร์ฟเวอร์ (response) ตามที่คุณต้องการ
          },
          error: function(error) {
            console.error(error);
            // จัดการข้อผิดพลาดในการส่งคำขอ AJAX ตามที่คุณต้องการ
          }
        });

      }

      function checkFgPart(index) {
        var fgPart = $("#data3 tr:eq(" + index + ") td:nth-child(2)").text();
        return fgPart;
      }

      function checkCustomerName(index) {
        var customerName = $("#data3 tr:eq(" + index + ") td:nth-child(1)").text();
        return customerName;
      }

      function fetchData() {
        var customer = $('#customer').val().trim();
        var fgPart = $('#fgPart').val().trim();
        console.log(customer);
        console.log(fgPart);
        $.ajax({
          type: "GET",
          url: "getData_Transaction.php",
          dataType: "json",
          data: {
            customer: customer,
            fgPart: fgPart
          },
          success: function(data) {

            // Clear existing rows
            $("#transactionTable tbody").empty();

            // Populate table with fetched data
            $.each(data, function(index, item) {
              var buttonId = "updateBtn_" + index;
              var html = "";
              for (var i = 1; i < 13; i++) {
                html += "<td class='editable-cell' contenteditable='true' id='m_" + i + "_local_" + index + "'>" + (item["month" + i + "_local"] !== null ? item["month" + i + "_local"] : '') + "</td>" +
                  "<td class='editable-cell' contenteditable='true' id='m_" + i + "_boi_" + index + "'>" + (item["month" + i + "_boi"] !== null ? item["month" + i + "_boi"] : '') + "</td>";
              }
              $("#transactionTable tbody").append(
                "<tr>" +
                "<td>" + item.customer_name + "</td>" +
                "<td>" + item.fg_part + "</td>" +
                "<td class='editable-cell-forcast' contenteditable='true' id='forcast_local_" + index + "'>" + (item["qty_local"] !== null ? item["qty_local"] : '') + "</td>" +
                "<td class='editable-cell-forcast' contenteditable='true' id='forcast_boi_" + index + "'>" + (item["qty_boi"] !== null ? item["qty_boi"] : '') + "</td>" +
                html +
                "</tr>"
              );

              $("#" + buttonId).on('click', function() {
                for (let i = 1; i <= 12; i++) {
                  var updatedLocal = $("#m" + i + "_local_" + index).text();
                  var updatedBoi = $("#m" + i + "_boi_" + index).text();
                  console.log("item.material_code", item.fg_part);
                  updateQuantity(i, 'local', item.fg_part, updatedLocal);
                  updateQuantity(i, 'boi', item.fg_part, updatedBoi);
                }
              });
            });

            // Add click event for the "Manage" buttons
            $(".manage-btn").click(function() {
              var transactionId = $(this).data("transaction-id");
              window.location.href = 'detail.php?transactionId=' + transactionId;
            });
          },
          error: function() {
            console.error("Error fetching data.");
          }
        });
      }

      fetchData();

      $('#searchBtn').on('click', function() {
        fetchData();
      });

      $('#clearFilterBtn').on('click', function() {
        // Clear the values in the input fields
        $('#customer').val('');
        $('#fgPart').val('');
        // Fetch data after clearing filters
        fetchData();
      });
    });

    function updateQuantity(month, type, fgPart, qty) {
      $.ajax({
        type: "POST",
        url: "updateForcast.php",
        data: {
          month: month,
          fgPart: fgPart,
          new_qty: qty,
          type: type
        },
        success: function(response) {
          console.log("Quantity updated successfully.", response);
        },
        error: function() {
          console.error("Error updating quantity.");
        }
      });
    }
  </script>
  <footer style="text-align: center;"><?php include 'footer.php'; ?></footer>
</body>

</html>