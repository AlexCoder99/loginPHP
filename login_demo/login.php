<?php

//inizio sessione
session_start();

//importazione funzioni
require_once('include/login_functions.php');

//controllo se utente è già loggato
if(user_logged()){

    //redirect verso pagina "reserved_section.php"
    header('Location: reserved_section.php');
    //blocco execution dello script dopo redirect in modo da non visualizzare nuovamente il form html
    exit();

}

//dati corretti per accedere
$user_corretto = 'test';
$password_corretta = md5('demo'); //hash md5 permette di crittografare password

//controllo se vi è già un cookie settato, che salva i dati di sessione e reindirizza l'utente nella sezione riservata
if(isset($_COOKIE['logged']) && $_COOKIE['logged'] == 1){

    // ricreazione sessione impostando utente come loggato
    $_SESSION['logged'] = true;

    //aggiornamento cookie per renderlo valido per altri 30 giorni
    setcookie('logged', '1', time() + 60*60*24*30);

    //redirect verso pagina "reserved_section.php"
    header('Location: reserved_section.php');

    //blocco esecuzione dello script dopo redirect in modo da non visualizzare nuovamente il form html
    exit();
}

//check submit
if(isset($_POST['sendLogin'])){
    $user = $_POST['user'];      
    $pass = md5($_POST['pass']);

    //check cookie policy (in modo da ricordare login in futuro)
    $ricorda = isset($_POST['ricorda']) ? true : false;

    //check correttezza dati login
    if($user == $user_corretto && $pass == $password_corretta){

        $_SESSION['logged'] = true;
        $_SESSION['error'] = false;

        if($ricorda){
            setcookie('logged', '1', time() + 60*60*24*30);
        }

        //redirect
        header('Location: reserved_section.php');

        exit();
    }
    
    else{
    //se dati login sbagliati, attivo errore e disattivo stato logged
    $_SESSION['logged'] = false;
    $_SESSION['error'] = true;
    }

    //se presente errore stampa messaggio di errore
    if(isset($_SESSION['error']) && $_SESSION['error'] === true){
        echo '<strong>Dati di accesso non validi</strong>';
        $_SESSION['error'] = false; //rimuovo mex
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="include/login_styles.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" defer></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" defer></script>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="post">
                    <h1>Login</h1>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" id="user" name="user" required>
                        <label for="user">Utente</label>
                    </div>    
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="pass" name="pass" required>
                        <label for="pass">Password</label>

                    </div>    
                    <div class="remember"> 
                        <label for="ricorda"><input type="checkbox" name="ricorda">Ricorda Login</label>
                        <a href="#">Non ricordi la password?</a>
                    </div>
                    <input type="submit" id="sendLogin" name="sendLogin" value="Log in">
                    <div class="register">
                        <p>Non hai un account? <a href="#">Registrati</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>


</body>
</html>