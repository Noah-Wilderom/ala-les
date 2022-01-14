<?php
    if(!isset($_SESSION)) session_start();
    require './../../helpers/helpers.php';

?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">ALA LES - Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="producten.php">Producten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="winkelwagen.php">Bestellingen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./../index.php">Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./../index.php">Website</a>
                </li>
            </ul>
        </div>
    </div>
</nav>