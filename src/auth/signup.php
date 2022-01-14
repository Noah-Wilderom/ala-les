<?php
    require './../../helpers/DB.php';

    if(!isset($_SESSION)) session_start();

    $data = (Object) [
        'email' => '',
        'naam' => '',
        'wachtwoord' => ''
    ];

    $error = '';

    if(isset($_POST['submit'])) {
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // Tegen XSS
        if($_POST['wachtwoord'] !== $_POST['wachtwoord_confirm']) $error = "Wachtwoord komt niet overeen.";

        if(isset($_POST['email']) && isset($_POST['naam']) && isset($_POST['wachtwoord'])) {
            $data = (Object) [
                    'email' => $_POST['email'],
                    'naam' => $_POST['naam'],
                    'wachtwoord' => password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT)
            ];
            $sql = "SELECT email FROM users WHERE email=:email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $data->email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $error = "Email bestaat al.";
            }

            if(!$error) {
                $sql = "INSERT INTO users (email, naam, wachtwoord) VALUES (:email, :naam, :wachtwoord)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':email', $data->email);
                $stmt->bindValue(':naam', $data->naam);
                $stmt->bindValue(':wachtwoord', $data->wachtwoord);
                if($stmt->execute()) {
                    $_SESSION['user_email'] = $data->email;
                    $_SESSION['user_naam'] = $data->naam;
                    header("Location: ./../index.php");
                }

            }
        }
    }



?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALA LES</title>

    <!-- Custom styling -->
    <link rel="stylesheet" href="./../../assets/style.css">
    <script type="text/javascript" src="./../../assets/script.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            align-content: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }



    </style>

</head>
<body class="text-center">
<form class="form-signin" method="POST">
    <h1 class="h3 mb-5 font-weight-normal">Signup</h1>
    <input type="email" name="email" placeholder="Email" class="form-control" required>
    <input type="text" name="naam" placeholder="Naam" class="form-control" required>
    <input type="password" name="wachtwoord" placeholder="Wachtwoord" class="form-control" required>
    <input type="password" name="wachtwoord_confirm" placeholder="Wachtwoord Opnieuw" class="form-control" required>
    <p class="link-danger"><?php if($error) {echo $error;} ?></p>
    <button class="mt-5 btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign Up</button>
    <p>Al een account? </p><a class="link-primary" href="login.php">login</a>
</form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>




