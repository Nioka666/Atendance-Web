<?php
    require 'functions.php';
    if( isset($_POST["register"]) ) {
        if( registrasi($_POST) > 0 ) {
            echo "<script>
                alert('User baru berhasil ditambahkan');
                document.location.href = 'login.php';
                </script>";
            
        } else {
            echo mysqli_error($conn);
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
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/style.css">
    <title>Registrasi Admin</title>
</head>
<body class="login">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <form action="" class="panel" method="post">
                    <h3 class="mb-4 text-center text-uppercase">Registrasi Admin</h3>
                    <div class="form-group ml-5 mr-5">
                        <input type="text" name="username" id="username" class="form-control form-control-lg radius" placeholder="Username">
                    </div>
                    <div class="form-group ml-5 mr-5">
                        <input type="password" name="password" id="password" class="form-control form-control-lg radius" placeholder="Password">
                    </div>
                    <div class="form-group ml-5 mr-5">
                        <input type="password" name="password2" id="password2" class="form-control form-control-lg radius" placeholder="Konfirmasi Password">
                    </div>
                    

                    <div class="form-group mt-4 ml-5 mr-5">
                    <button type="submit" class="btn btn-info btn-login block radius" name="register">Registrasi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    <script src="js/bootstrap.min.js" ></script>
</body>
</html>