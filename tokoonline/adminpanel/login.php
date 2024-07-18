<?php
session_start();

// Fungsi koneksi ke database
$con = mysqli_connect("localhost", "root", "", "Toko_online");
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$error = ""; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan username
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $countdata = mysqli_num_rows($result);

        if ($countdata > 0) {
            $user = mysqli_fetch_assoc($result);
            // Verifikasi password
            if ($password == $user['password']) { // Anda perlu menggunakan metode enkripsi yang tepat di sini
                $_SESSION['login'] = true;
                header('Location: index.php');
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    } else {
        $error = "Query gagal dieksekusi: " . mysqli_error($con);
    }

    mysqli_close($con); // Tutup koneksi setelah selesai
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif; /* Font default untuk halaman */
        }
        h2 {
            font-family: Arial Black, sans-serif; /* Font untuk judul */
        }
        .form-group label {
            font-weight: bold; /* Membuat label input tebal */
        }
        .btn-login {
            background-color: #000;
            color: #ff69b4;
            border-color: #000;
            font-family: Arial Black, sans-serif; /* Menggunakan Arial Black untuk tombol */
            font-size: 16px; /* Ukuran font tombol */
            width: 100%; /* Lebar tombol mengikuti parent elementnya */
        }
        .btn-login:hover {
            background-color: #ff69b4;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Login</h2>
                <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
                ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
