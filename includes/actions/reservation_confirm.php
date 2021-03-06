<?php 
session_start();
require_once('../config/db.php');   

$staffData = array();

if (isset($_SESSION['staff_session'])) {
    $staffData = $_SESSION['staff_session'];
}

if (isset($_GET['event_id']) && isset($_GET['reservation_id'])) {
    $event_id = $conn->real_escape_string($_GET['event_id']);
    $reservation_id = $conn->real_escape_string($_GET['reservation_id']);
    $staff_number = $conn->real_escape_string($staffData[0]['staff_number']);

    // 1st step: GET first name and last name from reservation table
    $query_1 = "SELECT * FROM reservation WHERE reservation_id = {$reservation_id}";
    $result_1 = $conn->query($query_1);
    if ($result_1->num_rows > 0) {
        $row = $result_1->fetch_assoc();

        $last_name = $row['last_name'];
        $first_name = $row['first_name'];
        $pastor_number = $row['pastor_number'];
        $contact_number = $row['contact_number'];
        $email = $row['email'];

        // 2nd step: INSERT event_id, reservation_id and staff_number to registration table
        $query_2 = "INSERT INTO registration VALUES ({$reservation_id}, {$event_id}, '{$last_name}', '{$first_name}', {$staff_number})";
        if ($conn->query($query_2)) {   
            // Update the status from reserved to registered in reservation table
            $up_query0 = "UPDATE audit SET event_registrants_count = event_registrants_count + 1, event_earning = event_fee * event_registrants_count WHERE event_id = {$event_id}";
            if ($conn->query($up_query0)) {
                $up_query = "UPDATE reservation SET status = 'Registered' WHERE event_id = {$event_id} AND reservation_id = {$reservation_id}";
                if ($conn->query($up_query)) {
                    // 3rd step: Check if name exists in member table
                    $query_3 = "SELECT last_name, first_name FROM member WHERE last_name = '{$last_name}' AND first_name = '{$first_name}'";
                    $result_3 = $conn->query($query_3);
    
                    if ($result_3->num_rows > 0) {
                        // 4th step 1A: Redirect to reservations page
                        header('location: ../../staff_management/navigation/reservations.php?event_id='.$event_id);
                    }
                    else {
                        // 4th step 2A: INSERT names to member table
                        $query_4 = "INSERT INTO member (last_name, first_name, contact_number, email, pastor_number) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query_4);
                        $stmt->bind_param('ssssi', $last_name, $first_name, $contact_number, $email, $pastor_number);
                        if ($stmt->execute()) {
                            header('location: ../../staff_management/navigation/reservations.php?event_id='.$event_id);
                        }
                        else {
                            echo $query_4 . "<br>" . $conn->error;
                        }
                    }
                }
                else {
                    echo $up_query . "<br>" . $conn->error;
                }
            }
            else {
                echo $up_query0 . "<br>" . $conn->error;
            }
        }
        else {
            echo $query_2 . "<br>" . $conn->error;
        }
    }
    else {
        echo $query_1 . "<br>" . $conn->error;
    }
}
else {
    header('location: ../../staff_management/navigation/reservations.php?event_id='.$event_id);
}
?>