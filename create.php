<?php
// Mengecek apakah form telah dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = substr(preg_replace("/\D/", "", $_POST["phone"]), 0, 13);

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "crud_db");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error); // Menghentikan koneksi gagal
    }

    // Menyusun query untuk memasukkan data ke tabel users
    $sql = "INSERT INTO pendaftar (name, email, phone) VALUES ('$name', '$email', '$phone')";

    // Menjalankan query dan mengecek apakah berhasil
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect ke halaman utama jika berhasil
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Menampilkan pesan kesalahan jika gagal
    }

    // Menutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Mengatur area container form */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        /* Mengatur label input dan spasi antar elemen */
        form label {
            display: block;
            margin-top: 10px;
        }
        form input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Mengatur gaya tombol submit */
        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Mengatur gaya tombol submit saat di-hover */
        form button:hover {
            background-color: #45a049;
        }

        form label b {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <label><b>Nama:</b> <input type="text" name="name" required></label>
        <label><b>Email:</b> <input type="email" name="email" required></label>
        <label><b>Telepon:</b> <input type="text" name="phone" required></label>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
