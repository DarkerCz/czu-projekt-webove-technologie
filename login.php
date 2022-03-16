<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        if(isset($_POST["login"]))  
        {
            if(empty($_POST["email"]) || empty($_POST["password"]))  {  
                 alert('Je nutné vyplnit všechna pole');  
            }
            else{
                login($pdo, $_POST["email"], $_POST["password"]);
            }
        }
    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include 'header.php';
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <div class="row">
                        <form class="login-form" method="post">
                            <h1 class="h3 mb-3 fw-normal">Přihlášení</h1>
                            <div class="form-floating">
                                <input type="email" autocomplete="username" class="form-control" id="email" name="email" required>
                                <label for="email">Emailová adresa</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="password" autocomplete="current-password" class="form-control" id="password" name="password" required>
                                <label for="password">Heslo</label>
                            </div>
                            <button class="w-100 btn btn-lg btn-zluty submit" name="login" type="submit">Přihlásit</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- import footer.php paticka -->
        <?php
            include 'footer.php';
        ?>      
    </body>
</html>
