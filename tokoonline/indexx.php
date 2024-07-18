<?php
    require "koneksi.php"; //nanti masukin koneksinya
    $queryproduk = mysqli_query($con, "SELECT id,nama,harga,foto,detail FROM produk LIMIT 6"); //masukin dari database
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko online | home </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="indexx.css"> <!-- Add this line to link your CSS file -->
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center ">
        <h1>toko online fashion</h1>
        <h3>mau cari apa bos?</h3>
        <div class="col-md-8 offset-md-2">
        <form methode="get"action="produk.php">
        <div class="input-group input-group-lg my-4">
            <input type="text" class="form-control" placeholder=" nama barang"
            aria-label="recipient's username" aria-describedby="basic-addon2" name="keyword">
            <button button type="submit" class="btn warna3 text-white"> telusuri</button>
        </div>
        </form>
        </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3> kategori terlaris</h3>

            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center"></div>
                    <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju pria">baju pria</a></h4>
                </div>
                <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center"></div>
                    <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju wanita">baju wanita</a></h4>
                </div>
                <div class="col-md-4 mb-3">
                <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center"></div>
                    <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju pria">baju pria</a></h4>
                </div>
        
            </div>
        </div>
    </div>
<!-- 
    <div class="container-fluid-warna3 py-5">
        <div class="container text-center">
            <h3> tentang kami</h3>
            <p class="fs-5 mt-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia aut, tempora nemo doloribus 
                dignissimos officia aliquid, numquam, culpa asperiores, id cupiditate eveniet
                quisquam quaerat distinctio itaque. Sit deserunt at ex? Eius nobis vel illum voluptates                 
                dolores minus autem qui modi, similique labore, sit corrupti vitae quas! Repellat officia 
                asperiores tempora delectus fuga  doloremque iste suscipit libero, nulla nobis, ratione, 
                itaque quisquam sint in perferendis praesentium magnam eum repellendus.
                cum nam aliquid consectetur tenetur? Asperiores quis et suscipit rerum, alias voluptatem 
                
            </p>
        </div>
    </div> -->

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>produk</h3>
            <div class="row mt-5">
                <!-- Looping untuk membuat card -->
                <?php while($data = mysqli_fetch_array($queryproduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <!-- Foto, nama dll=ambil dari database -->
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="<?php echo $data['nama']; ?>">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp<?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna2 text-white">Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-warning mt-3 p-3 fs-3" href="produk.php">see more</a>
        </div>
    </div>
    
    <div class="container-fluid-warna3 py-5">
        <div class="container text-center">
            <h3> tentang kami</h3>
            <p class="fs-5 mt-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia aut, tempora nemo doloribus 
                dignissimos officia aliquid, numquam, culpa asperiores, id cupiditate eveniet
                quisquam quaerat distinctio itaque. Sit deserunt at ex? Eius nobis vel illum voluptates                 
                dolores minus autem qui modi, similique labore, sit corrupti vitae quas! Repellat officia 
                asperiores tempora delectus fuga  doloremque iste suscipit libero, nulla nobis, ratione, 
                itaque quisquam sint in perferendis praesentium magnam eum repellendus.
                cum nam aliquid consectetur tenetur? Asperiores quis et suscipit rerum, alias voluptatem 
                
            </p>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>

</body>
</html>