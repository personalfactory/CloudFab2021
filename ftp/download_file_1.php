<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
     <body>
        <div id="mainContainer">
            <div id="container" style="margin:50px auto;font-size:20px">
    <?php
    
    //TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!
    
    $ftp_server = "195.110.124.133";
    
    if (isSet($_GET['NomeFile'])) {
         $server_file = $_GET['NomeFile'];
    }
    
    $_SESSION['conn_id'] = ftp_connect($ftp_server) or die("Impossibile connettersi a " . $ftp_server);

//Prova a connettersi
    if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {

        echo "Connesso come " . $_SESSION['ftp_user'] . "@$ftp_server\n";
        echo "<br/>";
        
    } else {

        echo "Impossibile connettersi come " . $_SESSION['ftp_user'] . "\n";
        echo "<br/>";
    }

    $local_file="/var/www/CloudFab/test.zip";
    
// Try to download $server_file and save to $local_file
    if (ftp_get($_SESSION['conn_id'], $local_file, $server_file, FTP_BINARY)) {
        echo "Scaricato file $local_file\n";
    } else {
        echo "Impossibile scaricare il file\n";
    }

// close the connection
//    ftp_close($conn_id);
    ?>
    </div>
            </div>
     </body>
</html>