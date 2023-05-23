<?php
//controlla se utente è loggato
function user_logged() : bool{
    if(isset($_SESSION['logged'])){
        return $_SESSION['logged'];  //restituiamo true se siamo loggati, false altrimenti
    }
    else{
        return false;
    }
}
?>
