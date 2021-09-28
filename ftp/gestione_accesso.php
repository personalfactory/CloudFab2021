<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
    //Aggiorna lo script tenendo presente i vari filtri di ricerca impostati
    function AccediComeAmministratore() {
        
        location.href="gestione_ftp_admin.php";
    }
    
//    function AccediComeServer() {
//        location.href="gestione_ftp_server.php";
//    }
    function AccediComeMacchina() {
        
        location.href="../stabilimenti/gestione_macchine.php";
     
    }
    </script>

    <body>
        <div id="mainContainer">
        <form id='GestisciAccesso' name='GestisciAccesso' method="POST">
        
            <div id="container" style="margin:200px auto;font-size:20px">

                <div id="pulsanteAccessoFtp" onclick="AccediComeAmministratore()">
                    
                    <?php echo $titoloPaginaAccessoAdminFtp ?>
                    
                </div>
             
                
                <div id="pulsanteAccessoFtpMac" onclick="AccediComeMacchina()">
                    
                    <?php echo $titoloPaginaAccessoMacFtp ?>
                    
                </div>
            </div>
      
            
            </form>
          </div>
    </body>
    
</html>