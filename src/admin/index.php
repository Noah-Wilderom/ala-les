<?php
require './../../helpers/DB.php';

require './layouts/head.php';
require './layouts/nav.php';
?>

    Welkom bij het admin paneel <?php if(isset($_SESSION['user_naam'])) {echo $_SESSION['user_naam'];} ?>
























<?php
require './layouts/footer.php';
?>