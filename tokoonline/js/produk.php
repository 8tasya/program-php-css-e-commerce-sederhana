<?php
require "koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// get produk by nama produk/keyword
if (isset($_GET['keyword'])) {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%" . $_GET['keyword'] . "%'");
}
// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='" . $_GET['kategori'] . "'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='" . $kategoriId['id'] . "'");
}
// get produk default
else {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5" style="border:solid red; height:300px">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a href="produk.php?kategori=<?php echo $kategori['Nama']; ?>">
                            <li class="list-group-item"><?php echo $kategori['Nama']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                    if (mysqli_num_rows($queryProduk) < 1) {
                        echo '<h4 class="text-center">Produk yang anda cari tidak tersedia</h4>';
                    } else {
                        while ($produk = mysqli_fetch_array($queryProduk)) {
                    ?>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="image-box">
                                        <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $produk['Nama']; ?></h4>
                                        <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                        <p class="card-text text-harga"><?php echo $produk['harga']; ?></p>
                                        <a href="produk_detail.php?nama=<?php echo $produk['Nama']; ?>" class="btn warna2 text-black">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
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