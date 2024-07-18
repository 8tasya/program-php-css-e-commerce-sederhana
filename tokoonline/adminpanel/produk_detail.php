<?php
require "session.php";
require "koneksi.php";

// Initialize variables
$id = null;
$produk = null;
$resultProdukTerkait = null;

// Check if 'p' parameter is available in the URL
if (isset($_GET['p'])) {
    $id = $_GET['p'];

    // Query to fetch product details
    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $produk = mysqli_fetch_assoc($query);

    // Check if product is found
    if (!$produk) {
        echo "Produk tidak ditemukan.";
        exit;
    }

    // Fetch related products
    $queryProdukTerkait = "SELECT * FROM produk WHERE id != '$id' LIMIT 4";
    $resultProdukTerkait = mysqli_query($con, $queryProdukTerkait);
} else {
    echo "Parameter 'p' tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <h2> Detail Produk</h2>
    <div class="container-fluid py-5">
        <div class="row">
            <?php if ($produk): ?>
            <div class="col-md-5 mb-5">
                <?php if (!empty($produk['foto'])): ?>
                    <img src="image/<?php echo htmlspecialchars($produk['foto']); ?>" class="w-100" alt="">
                <?php else: ?>
                    <p>Produk tidak memiliki gambar.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6 offset-md-1">
                <h1><?php echo htmlspecialchars($produk['Nama']); ?></h1>
                <p class="fs-5"><?php echo htmlspecialchars($produk['detail']); ?></p>
                <p class="text-harga">Rp <?php echo htmlspecialchars($produk['harga']); ?></p>
                <p class="fs-5">Status Ketersediaan: <strong><?php echo htmlspecialchars($produk['Ketersediaan_stok']); ?></strong></p>
            </div>
            <?php else: ?>
            <div class="col-md-12">
                <p>Produk tidak ditemukan.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- produk terkait -->
    <?php if ($resultProdukTerkait): ?>
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>
            <div class="row">
                <?php while ($data = mysqli_fetch_assoc($resultProdukTerkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="produk_detail.php?p=<?php echo htmlspecialchars($data['id']); ?>">
                            <?php if (!empty($data['foto'])): ?>
                                <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" class="img-fluid img img-thumbnail" alt="">
                            <?php else: ?>
                                <p>Produk tidak memiliki gambar.</p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
