<div class="box-navigation-container">
<div class="navigation d-flex justify-content-between align-items-center">
    <div class="navigation-logo">
        <a href="forcast.php"><img src="./image/Logo7777.png" alt="" style="width: 140px;margin-left:103px;" /></a>
    </div>
    <div class="navigation-container">
        <!-- Navigation items -->
        <div class="navigation-item p-3"><span><a href="./index.php" target="_blank">Home</a></span></div>
        <div class="navigation-item p-3"><span><a href="./forcast.php" target="_blank">Use</a></span></div>
        <div class="navigation-item p-3"><span><a href="./mat_total.php" target="_blank">Mat.Total</a></span></div>
        <div class="navigation-item p-3"><span><a href="./mat_boi.php" target="_blank">Mat.Boi</a></span></div>
        <div class="navigation-item p-3"><span><a href="./mat_local.php" target="_blank">Mat.Local</a></span></div>
        <div class="navigation-item p-3"><span><a href="./bom.php" target="_blank">BOM</a></span></div>
        <div class="navigation-item p-3"><span><a href="./meterial_lists.php" target="_blank">Mat.Data</a></span></div>
        <div class="header-button-detail ps-5 d-flex justify-content-end">
            <div class="header-detail">
                <div class="d-flex flex-column">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<label style="color: pink;margin:0 auto;">' . $_SESSION['username'] . '</label>';
                        echo '<div><img src="./image/user.jpg" /></div>';
                        echo '<label style="color: red;margin:0 auto;" id="logoutBtn">' . 'Log-out' . '</label>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $("#logoutBtn").on("click", function() {
            // Make an AJAX request to log out
            $.ajax({
                type: "POST",
                url: "logout_process.php", // Point this to your server-side logout script
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        // Redirect to the login page after successful logout
                        window.location.href = "login.php"; // Change to your login page URL
                    } else {
                        // Handle error, e.g., show an alert
                        alert("Logout failed. Please try again.");
                    }
                },
                error: function() {
                    // Handle unexpected error, e.g., show an alert
                    alert("An unexpected error occurred. Please try again.");
                }
            });
        });
    });
</script>