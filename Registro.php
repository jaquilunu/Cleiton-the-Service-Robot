<?php 
require ("database.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BioTrade</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <span>★ BioTrade</span>
        </div>
        <nav
        
            <button class="theme-toggle"></button>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <h1>Bem-vindo de volta!</h1>
            <?php 
             if (isset($_POST['entrar'])){
                

                $email = $_POST["email"];
                $senha = $_POST["password"];
                $senha2 = $_POST["password2"];

                if ($senha != $senha2) {
                    echo "Senhas não condizem";
                    
                }
                else{
                    $sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')";
                    $result = $connection->query($sql);

                            header("Location: index.php");
                             
                }

             }
            
            ?>
            <form method="POST"> 
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" id="email" placeholder="Digite seu e-mail" required>
                </div>
                <div class="input-group">
                    <label for="password">Senha</label>
                    <input name="password" type="password" id="password" placeholder="Digite sua senha" required>
                </div>
                <div class="input-group">
                    <label for="password">Confirmar Senha</label>
                    <input name="password2" type="password" id="password" placeholder="Confirme sua senha" required>
                </div>
                <button name="entrar" type="submit" class="login-btn">Registro</button>
                <div class="separator">ou</div>

                <a href="index.php" type="button" class="google-btn"> Login
            </a>
            </form>
        </section>
        <section class="illustration-section">
            <img src="img/illustration.png" alt="Ilustração de equipe" class="illustration">
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
