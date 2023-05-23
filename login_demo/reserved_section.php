<?php
//si riprende sessione avviata durante login
session_start();

require_once('include/login_functions.php');




//per fare logout: invio query string ?act=out al file index.php
if(isset($_GET['act']) && $_GET['act'] == 'out'){

    $_SESSION['logged'] = false; //logout forzato

    //cancellazione sessione (al refresh successivo) & cookie sessione se presente
    session_destroy();  
    setcookie('logged', '0', time() - 3600);
}

//se non si è loggati, redirect verso login e blocco esecuzione script
if(!user_logged()){
    header('Location: login.php');
    exit();
}
?>

<h1>Benvenuto Doc. Jones </h1>
<a href="reserved_section.php?act=out"> Log Out </a>
