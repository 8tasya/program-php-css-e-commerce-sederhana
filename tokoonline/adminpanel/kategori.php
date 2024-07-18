<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "session.php";
require "koneksi.php";

$con = mysqli_connect("localhost", "root", "", "toko_online");

if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$newCategory = "";
$kategoriBerhasilTersimpan = false;
$kategoriSudahAda = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_kategori'])) {
    $kategori = htmlspecialchars($_POST['kategori']);

    $queryExist = "SELECT Nama FROM kategori WHERE Nama = ?";
    $stmt = mysqli_prepare($con, $queryExist);
    mysqli_stmt_bind_param($stmt, 's', $kategori);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $jumlahDataKategoriBaru = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($jumlahDataKategoriBaru > 0) {
        $kategoriSudahAda = true;
    } else {
        $insertQuery = "INSERT INTO kategori (Nama) VALUES (?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, 's', $kategori);
        if (mysqli_stmt_execute($stmt)) {
            $newCategory = $kategori;
            $kategoriBerhasilTersimpan = true;
            mysqli_stmt_close($stmt);
            $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
            $jumlahKategori = mysqli_num_rows($queryKategori);
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item .fas {
            margin-right: 5px;
        }

        .breadcrumb-item span {
            font-family: 'Arial Black', sans-serif;
            font-size: 0.9rem;
            margin-left: 5px;
        }

        .breadcrumb-item + .breadcrumb-item {
            margin-left: 10px;
        }

        .highlight {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-5"> 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> 
                    </a>
                    <span>Home</span>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span>Kategori</span>
                </li>
            </ol>
        </nav>  
        
        <div class="my-5">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="Input nama kategori" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button type="submit" name="simpan_kategori" class="btn btn-primary">Tambah</button>
                </div>
            </form>

            <?php
            if (isset($kategoriSudahAda) && $kategoriSudahAda) {
                echo '<div class="alert alert-warning mt-3" role="alert">Kategori sudah ada.</div>';
            }

            if ($kategoriBerhasilTersimpan) {
                echo '<div class="alert alert-primary mt-3" role="alert">Kategori Berhasil Tersimpan</div>';
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>Daftar Kategori</h2>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    if ($jumlahKategori == 0) {
        echo '<tr><td colspan="3" class="text-center">Data kategori tidak tersedia</td></tr>';
    } else {
        $number = 1;
        while ($row = mysqli_fetch_assoc($queryKategori)) {
            // Highlight new category if applicable
            $highlightClass = ($row['Nama'] === $newCategory) ? 'highlight' : '';
            echo '<tr class="' . htmlspecialchars($highlightClass) . '">';
            echo '<td>' . $number . '</td>';
            echo '<td>' . htmlspecialchars($row['Nama']) . '</td>';
            echo '<td>
                    <a href="kategori-detail.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-info">
                        <i class="fas fa-search"></i> Detail
                    </a>
                  </td>';
            echo '</tr>';
            $number++;
        }
    }
    ?>
</tbody>

                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
