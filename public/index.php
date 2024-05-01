<?php
    require '../vendor/autoload.php';
    require_once('../config/db.php');
    require_once('../validation/validation.php');

    use Firebase\JWT\JWT;

    $error = '';

    //echo validaNome('Márcio');
    //echo validaSenha("ddA1@nome");

    if(isset($_POST["login"]))
    {
        //global $connect;
        $connect = new PDO("mysql:host=localhost;dbname=jwtapi", "root", "P@ssWord");

        if(empty($_POST["nome"])){
            $error = 'Inserir login!';
        } elseif(empty($_POST["password"])){
            $error = 'Inserir senha!';
        } else {
            $query = "SELECT * FROM usuario WHERE nome = ?";
            $statement = $connect->prepare($query);
            $statement->execute([$_POST["nome"]]);
            $data = $statement->fetch(PDO::FETCH_ASSOC);

            if($data){
                if($data['senha'] === $_POST['password']){
                    $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';
                    $token = JWT::encode(
                        array(
                            'iat'		=>	time(),
                            'nbf'		=>	time(),
                            'exp'		=>	time() + 3600,
                            'data'	=> array(
                                'id'	=>	$data['id'],
                                'nome'	=>	$data['nome']
                            )
                        ),
                        $key,
                        'HS256'
                    );
                    setcookie("token", $token, time() + 3600, "/", "", true, true); // Tempo de expiração do token
                    header('location:welcome.php');

                } else {
                    $error = 'Password errada!';
                }
            } else {
                $error = 'Login errado!';
            }
        }
    }
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login em PHP com JWT Token</title>
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5 mb-5">Login em PHP com JWT Token</h1>
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
            <?php
                if($error !== '')
                {
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                }
            ?>
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label>Login</label>
                            <input type="text" name="nome" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="text-center">
                            <input type="submit" name="login" class="btn btn-primary" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
