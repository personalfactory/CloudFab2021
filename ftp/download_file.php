<?php
session_start();
if (!isset($_SESSION['username'])) {

    header('Location: /CloudFab/login.php');
    
} else {


$file = basename($_GET['NomeFile']);
$file = $file;

if ($file) { // file does not exist
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($file);
} else {?>
    
    
    <?php 
    
    die('File not found!');
    
}
//TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!


}?>
