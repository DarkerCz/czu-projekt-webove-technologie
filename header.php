<?php
    session_start();
?>
<header>
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/img/logo.png" alt="Logo autopůjčovna" height="36" width="287">
            </a>
            
            <?php if( isset($_SESSION["uzivatel"])): ?>
                <div class="btn-group" role="group">
                    <button id="ucet-btn" type="button" class="btn btn-zluty dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        Můj účet
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="ucet-btn">
                        <?php if (je_spravce($pdo)): ?>
                            <li><a id="nove-vozidlo-btn" class="dropdown-item" href="nove_vozidlo.php">Přidat vozidlo</a></li>
                        <?php endif; ?>
                        <li><a id="rezervace-btn" class="dropdown-item" href="rezervace.php">Rezervace</a></li>
                        <li><a id="logout-btn" class="dropdown-item" href="logout.php">Odhlásit</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <div class="btn-group" role="group">
                    <button id="login-btn" type="button" class="btn btn-zluty dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        Přihlášení / registrace
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="login-btn">
                        <li><a class="dropdown-item" href="login.php">Přihlásit</a></li>
                        <li><a class="dropdown-item" href="register.php">Registrace</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>