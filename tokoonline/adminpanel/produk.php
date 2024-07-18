<?php
require "session.php";
require "koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id = b.id");
$jumlahproduk = mysqli_num_rows($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
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
                    <span>Produk</span>
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6"></div>
        <h3>Tambah Produk</h3>

        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="Nama">Nama</label>
                <input type="text" id="Nama" name="Nama" class="form-control" autocomplete="off" required>
            </div>
            <div>
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="">Pilih satu</option>
                    <?php while ($data = mysqli_fetch_array($queryKategori)) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['Nama']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" required>
            </div>
            <div>
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div>
                <label for="detail">Detail</label>
                <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div>
                <label for="ketersediaan_stok">Ketersediaan Stok</label>
                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                    <option value="">Pilih salah satu</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </div>
        </form>

        <?php
        if (isset($_POST['simpan'])) {
            $nama = htmlspecialchars($_POST['Nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

            // File upload handling
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                // Move uploaded file
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name)) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Error uploading file.";
                }

                echo "Target Directory: " . $target_dir . "<br>";
                echo "Image File Name: " . $nama_file . "<br>";
                echo "Target File: " . $target_file . "<br>";
                echo "Image File Type: " . $imageFileType . "<br>";
                echo "Image Size: " . $image_size . "<br>";
            } else {
                echo "Error uploading file.";
            }

            if ($nama == '' || $kategori == '' || $harga == '') {
                echo '<div class="alert alert-warning mt-3" role="alert">
                        Nama, kategori, dan harga wajib diisi.
                      </div>';
            } else {
                // Query insert to produk table
                $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");
                if ($queryTambah) {
                    echo '<div class="alert alert-success mt-3" role="alert">
                            Produk berhasil ditambahkan.
                          </div>';
                    // Redirect to produk.php after 2 seconds
                    echo '<meta http-equiv="refresh" content="2; url=produk.php" />';
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">
                            Error: ' . mysqli_error($con) . '
                          </div>';
                }
            }
        }
        ?>

        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahproduk == 0) {
                            echo '<tr><td colspan="6" class="text-center">Data produk tidak tersedia.</td></tr>';
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                        ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['Nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['harga']; ?></td>
                                    <td><?php echo $data['Ketersediaan_stok']; ?></td>
                                    <td>
                                    <a href="produk_detail.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-info">
    <i class="fas fa-search"></i> Detail
</a>

                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

</body>
</html>
