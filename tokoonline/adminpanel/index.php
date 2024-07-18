<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "session.php"; 
require "koneksi.php";

$con = mysqli_connect("localhost", "root", "", "Toko_online");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk);

mysqli_close($con); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
            font-family: 'Arial Black', sans-serif;
            font-size: 1rem;
        }

        .breadcrumb-item .fas {
            margin-right: 1rem;
        }

        .kotak {
            border: 2px solid black;
        }

        .summary-kategori {
            background-color: #A9ACB0;
            border-radius: 15px;
        }
        
        .summary-produk {
            background-color: #0a516b;
            border-radius: 15px;
        }
        
        .summary-box {
            margin-right: 10px;
            padding: 10px;
        }

        .summary-box h3, .summary-box p {
            font-size: 1rem;
            margin: 5px 0;
        }

        .summary-box i {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i>
                    <span style="margin-left: 10px;">Home</span>
                </li>
            </ol>
        </nav>

        <?php if (isset($_SESSION['username'])) : ?>
            <h2>Halo <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <?php else : ?>
            <h2>Halo Pengguna</h2>
        <?php endif; ?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="summary-box summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-align-justify fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3>Kategori</h3>
                                <p><?php echo $jumlahKategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="summary-box summary-produk p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3>Produk</h3>
                                <p><?php echo $jumlahProduk; ?> Produk</p>
                                <p><a href="produk.php" class="text-white">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
