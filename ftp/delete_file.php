<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <<body>
        <div id="mainContainer">
            <div id="container" style="margin:50px auto;font-size:20px;">
                <div style='width:50%;height:80px;'>
                    <div style='float:left;margin:10px;'><img src='../images/FTP.png' style='height:100px;width:100px'/></div>
    <?php
    
    //TO DO importante : evitare che ad ogni esecuzione dello script venga rieffettuato connessione e login!!!!
    
    $ftp_server = "195.110.124.133";

    if (isSet($_GET['NomeFile'])) {
        
        $server_file = $_GET['NomeFile'];
        $refBack= $_GET['RefBack'];
    }

    $_SESSION['conn_id'] = ftp_connect($ftp_server) or die("Impossibile connettersi a " . $ftp_server);
?>
                        <div style='float:right;color:#008000;padding-top:50px;'>
                            <?php
//Prova a connettersi
    if (ftp_login($_SESSION['conn_id'], $_SESSION['ftp_user'], $_SESSION['ftp_pass'])) {

        echo "Connesso come " . $_SESSION['ftp_user'] . "@$ftp_server\n";
        echo "<br/>";
    
    } else {

        echo "Impossibile connettersi come " . $_SESSION['ftp_user'] . "\n";
        echo "<br/>";
    }
    ?> </div>
                </div>
                <br/>
                <br/>
<?php
// Try to delete file
    if (ftp_delete($_SESSION['conn_id'], $server_file)) {
        echo "Eliminato file ".$server_file;
        ?>
                <script type="text/javascript">
                    location.href = "<?php echo $refBack ?>?Dir=<?php echo $_SESSION['Dir']?>"
                </script>
<?php
    } else {
        echo "Impossibile eliminare il file ".$server_file;
    }

// close the connection
//    ftp_close($conn_id);
    ?>
                 </div>
            </div>
     </body>

</html>