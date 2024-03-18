<?php
session_start();
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'koneksi.php';

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM guru WHERE email = '$email' AND password = '$password'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Pengecekan status
        if ($row["status"] == "admin") {
            $_SESSION["login"] = true;
            $_SESSION['guru_id'] = $row["id_guru"];
            $_SESSION['guru_user_email'] = $email;
            $_SESSION['guru_user_name'] = $row["nama"];
            $_SESSION['guru_user_foto'] = $row["foto"];
            $_SESSION['guru_user_last_login'] = $row["last_login"];
            header("Location: admin.php"); // Redirect ke halaman admin
            exit;
        } elseif ($row["status"] == "guru") {
            $_SESSION["login"] = true;
            $_SESSION['guru_id'] = $row["id_guru"];
            $_SESSION['guru_user_email'] = $email;
            $_SESSION['guru_user_name'] = $row["nama"];
            $_SESSION['guru_user_foto'] = $row["foto"];
            $_SESSION['guru_user_last_login'] = $row["last_login"];
            header("Location: index.php"); // Redirect ke halaman guru
            exit;
        } else {
            // Status tidak valid
            $error = true;
        }
    } else {
        // Data tidak ditemukan
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Admin</title>
</head>

<body class="login">
    <div class="container">
        <div class="row justify-content-center form-login mt-5">
            <div class="col-md-6">
                <form action="" class="panel" method="post">
                    <h3 class="mb-4 text-center text-uppercase">Login </h3>
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger mr-5 ml-5 radius" role="alert">
                            Email / Password salah
                        </div>
                    <?php endif; ?>
                    <div class="form-group ml-5 mr-5">
                        <input type="text" name="email" id="email" class="form-control form-control-lg radius" placeholder="Email">
                    </div>
                    <div class="form-group ml-5 mr-5">
                        <input type="password" name="password" id="password" class="form-control form-control-lg radius" placeholder="Password">
                    </div>
                    <div class="form-group mt-4 ml-5 mr-5">
                        <button type="submit" class="btn btn-info btn-login block radius" name="login">Login</button>
                    </div>
                    <!-- <div class="form-group mt-4 ml-5 mr-5">
                    <a href="registrasiguru.php" class="btn btn-info btn-regis block radius" role="button">Registrasi</a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>