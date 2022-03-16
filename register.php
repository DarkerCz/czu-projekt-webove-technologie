<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        if(isset($_POST["register"]))  
        {
            if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_confirm"]) || empty($_POST["jmeno"]) || empty($_POST["prijmeni"]) || empty($_POST["telefon"]))  {  
                 alert('Je nutné vyplnit všechna pole');  
            }
            else if($_POST["password"] != $_POST["password_confirm"]){
                alert('Hesla neodpovídají');  
            }
            else if(existujeEmail($pdo, $_POST["email"])){
                echo "<script>alert('Účet s tímto emailem již existuje');document.location='login.php'</script>";
            }
            else{
                register($pdo, $_POST["email"], $_POST["password"], $_POST["jmeno"], $_POST["prijmeni"], $_POST["telefon"]);
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
                        <form class="register-form" method="post">
                            <h1 class="h3 mb-3 fw-normal">Registrace</h1>
                            <div class="form-floating">
                                <input type="email" autocomplete="username" class="form-control" id="email" name="email" required>
                                <label for="email">Emailová adresa</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="password" autocomplete="new-password" class="form-control" id="password" name="password" pattern="^\S{6,}$" required>
                                <label for="password">Heslo (min. 6 znaků)</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="password" autocomplete="new-password" class="form-control" id="password_confirm" name="password_confirm" required>
                                <label for="password_confirm">Heslo znovu</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="text" autocomplete="given-name" class="form-control" id="jmeno" name="jmeno" required>
                                <label for="jmeno">Jméno</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="text" autocomplete="family-name" class="form-control" id="prijmeni" name="prijmeni" required>
                                <label for="prijmeni">Příjmení</label>
                            </div>
                            <br>
                            <div class="form-floating">
                                <input type="tel" autocomplete="tel" class="form-control" id="telefon" name="telefon" required>
                                <label for="telefon">Telefon</label>
                            </div>
                            <br>
                            <button class="w-100 btn btn-lg btn-zluty submit" type="submit" name="register">Registrovat</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- import footer.php paticka -->
        <?php
            include 'footer.php';
        ?>
        <script>
            var password = $("#password");
            var password_confirm = $("#password_confirm");

            function validaceHesla(){
              if(password.val() != password_confirm.val()) {
                password_confirm.get(0).setCustomValidity("Hesla nesouhlasí");
              } else {
                password_confirm.get(0).setCustomValidity('');
              }
            }
        </script>
    </body>
</html>
