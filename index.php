<?php

    if ( is_home() && ( ! is_front_page() )) {
        include 'archive.php';
        return;
    }
   
?>

<h1>You should not be here!</h1>