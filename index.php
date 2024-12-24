<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css">
    <title>CRUD System with Pagination and Search</title>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>
        
        <!-- Form Pencarian -->
        <form method="GET" class="search-form" action="">
            <input type="text" name="search" placeholder="Cari nama pengguna..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Cari</button>
        </form>
        
        <a href="create.php" class="btn">Tambah Pengguna Baru</a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Jumlah data per halaman
                    $limit = 5;

                    // Mendapatkan halaman saat ini dari URL (default ke halaman 1 jika tidak ada)
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Mengambil parameter pencarian
                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    // Hitung total data dengan pencarian
                    $countSql = "SELECT COUNT(*) as total FROM pendaftar WHERE name LIKE '%$search%'";
                    $countResult = $conn->query($countSql);
                    $totalData = $countResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalData / $limit);

                    // Query untuk mengambil data dengan batasan pagination dan pencarian
                    $sql = "SELECT * FROM pendaftar WHERE name LIKE '%$search%' LIMIT $limit OFFSET $offset";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["phone"] . "</td>
                                <td>
                                    <a href='update.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id=" . $row["id"] . "' class='btn-delete'>Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div style="text-align: center; margin-top: 20px;">
            <?php
            if ($totalPages > 1) {
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<strong>$i</strong> ";
                    } else {
                        echo "<a href='?page=$i&search=$search'>$i</a> ";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
