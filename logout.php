<?php
    include 'database.php';

    session_destroy();
    alert("Byli jste odhlášeni");
    header("location:index.php"); 
?>