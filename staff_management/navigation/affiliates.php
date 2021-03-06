<?php 
session_start();

$staffData = '';

if (!isset($_SESSION['staff_session'])) {
    header('location: ../../index.php');
}
else {
    $staffData = $_SESSION['staff_session'];
}
?>
<!DOCTYPE html>
<meta lang = "utf-8">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<html>
    <head>
        <title>Church affiliates</title>
        <link rel = "stylesheet" media = "all" href = "../../styles/style.css">
        <link rel = "shortcut icon" href = "../../images/logo.jpeg" type = "image/x-icon">
    </head>
    <body>
        
        <div class="top-bar">

            <div class="label-box">
                <p class = "page-label">Affiliates</p>
            </div>

            <div class="label-box">
                <p class = "page-label"></p>
            </div>

            <label class="account-menu">

                <input type="checkbox" name="" id=""> <!-- For the onclick menu -->

                <div class="menu">
                    <a href="../../includes/actions/logout.php">Logout</a>
                </div>

                <div class="menu-button"></div>
                
                <p class="username"> <!--Name of user will be displayed here -->
                    Hello, <?php echo $staffData[0]['first_name'].' '.$staffData[0]['last_name']; ?>
                </p>
                
            </label>

            <label class = "navigation-menu">

                <input type="checkbox" name="" id="">

                <div class = "hamburger-menu">
                    <!--
                    <div class="hamburger-lines"></div>
                    <div class="hamburger-lines"></div>
                    <div class="hamburger-lines"></div> -->
                </div>
                
                <div class = "navigation-items">
                    
                    <a href="events-manage.php">Events</a>
                    <a href="event-select-registration.php">Registrations</a>
                    <a href="event-select-reservation.php">Reservations</a>
                    <a href="branches.php">Branches</a>
                    <a href="affiliates.php">Affiliates</a>
                    <a href="audit.php">Audit</a>
                    
                </div>

            </label>

        </div>

        <div class="content-container church-affiliates">

            <h2 class = "church-affiliates">Church affiliates</h2>

            <a href="pastors-list.php">
                <img src="../../images/pastor.png" alt="">
                Pastors
            </a>
            <?php 
            if ($staffData[0]["access_level"] == 1) {
            ?>
            <a href="staffs-list.php">
                <img src="../../images/staff.png" alt="">
                Staffs
            </a>
            <?php } ?>
            <a href="members-list.php">
                <img src="../../images/member.png" alt="">
                Members
            </a>

        </div>

    </body>
</html>