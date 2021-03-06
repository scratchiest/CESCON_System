<?php 
require_once('../config/db.php');
require_once('../function/crypt.php');

if (isset($_POST['submit'])) {
    $pastor_number = $_POST['submit'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = encrypt_decrypt($_POST['password'], "encrypt");
    $access_level = $_POST['access_level'];

    $query = "UPDATE staff SET last_name = ?, first_name = ?, contact_number = ?, username = ?, password = ?, access_level = ? WHERE staff_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssii', $last_name, $first_name, $contact_number, $username, $password, $access_level, $pastor_number);
    if ($stmt->execute()) {
        header('location: ../../staff_management/navigation/staffs-list.php');
    }
    else {
        echo $stmt->error;
    }
}
else {
    header('location: ../../staff_management/forms/edit/pastors-edit.php');
}
?>