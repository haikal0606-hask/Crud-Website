<?php
include "../koneksi.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Bandingkan password dengan username
        if($password == $user['password']) {
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
        }else {
            echo "Password Salah";
        }
    }else{
        echo "Username tidak terdaftar";
    }
    $stmt->close();
}
$conn->close();





?>