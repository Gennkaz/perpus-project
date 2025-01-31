<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE Username='$username'");
    $data = mysqli_fetch_array($sql);
}
?>