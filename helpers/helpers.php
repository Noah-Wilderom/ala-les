<?php
if(!isset($_SESSION)) session_start();

function isLoggedIn() {
    if(isset($_SESSION['user_email'])) return true;
    return false;
}
function isAdmin() {
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') return true;
    return false;
}