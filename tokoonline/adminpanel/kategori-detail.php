<?php
require "session.php";
require "koneksi.php";

// Initialize variables
$errorMessage = '';
$successMessage = '';

// Check if 'p' parameter is available in the URL
if (isset($_GET['p'])) {
    $id = $_GET['p'];

    // Query to fetch category details
    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id = '$id'");
    $data = mysqli_fetch_array($query);

    // Retrieve category name
    $kategori = htmlspecialchars($data['Nama']);
} else {
    // If 'p' parameter is not present, set category name to empty string
    $kategori = '';
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editBtn'])) {
        $newKategori = htmlspecialchars($_POST['kategori']);

        // Check if new category name is the same as the current one
        if ($kategori == $newKategori) {
            $successMessage = "Kategori tidak diubah karena nama sama.";
        } else {
            // Query to check if the new category name already exists
            $query = mysqli_query($con, "SELECT * FROM kategori WHERE Nama='$newKategori'");
            $jumlahData = mysqli_num_rows($query);

            if ($jumlahData > 0) {
                $errorMessage = "Kategori sudah ada.";
            } else {
                // Update category name in the database
                $querySimpan = mysqli_query($con, "UPDATE kategori SET Nama='$newKategori' WHERE id='$id'");
                if ($querySimpan) {
                    $successMessage = "Kategori berhasil diupdate.";
                    header("Location: kategori.php");
                    exit;
                } else {
                    $errorMessage = "Gagal mengupdate kategori. Error: " . mysqli_error($con);
                }
            }
        }
    } elseif (isset($_POST['deleteBtn'])) {
        // Prepare a statement to check if there are any products related to the category
        $stmtCheck = mysqli_prepare($con, "SELECT * FROM produk WHERE kategori_id=?");
        mysqli_stmt_bind_param($stmtCheck, "i", $id);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);
        $dataCount = mysqli_num_rows($resultCheck);

        if ($dataCount > 0) {
            $errorMessage = "Kategori tidak bisa dihapus karena masih ada produk terkait.";
        } else {
            // Prepare a statement to delete the category
            $stmtDelete = mysqli_prepare($con, "DELETE FROM kategori WHERE id=?");
            mysqli_stmt_bind_param($stmtDelete, "i", $id);
            mysqli_stmt_execute($stmtDelete);

            if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                $successMessage = "Kategori berhasil dihapus.";
                header("Location: kategori.php");
                exit;
            } else {
                $errorMessage = "Gagal menghapus kategori. Error: " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $kategori; ?>">
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
            // Display error or success messages
            if (!empty($errorMessage)) {
                echo "<div class='alert alert-danger mt-3' role='alert'>$errorMessage</div>";
            } elseif (!empty($successMessage)) {
                echo "<div class='alert alert-success mt-3' role='alert'>$successMessage</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
