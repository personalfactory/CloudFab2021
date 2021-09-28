<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <?php
        include('../include/menu.php');
        include('../include/gestione_date.php');
        include('../include/funzioni.php');
        include('../include/precisione.php');
        include('sql/script_lab_allegato.php');
        
        ini_set(display_errors, "1");
        
        $IdCarat=$_POST['IdCarat'];
        $Descri=str_replace("'","''",$_POST['Descri']);
        $IdEsper=$_POST['IdEsper'];
                
        $uploadEffettuato=false;
        $destFileName="";
        //print_r( $_FILES['user_file']);
        
   //########### UPLOAD DEL FILE ##################################
        if (isset($_FILES['user_file']) AND $_FILES['user_file'] != "") {
            
            $destFileName=  $preFileLab."_".dataCorrenteFile()."_". $_FILES['user_file']['name'];
            
            //GENERAZIONE DEL NOME DEL FILE DA CARICARE SUL SERVER
            $uploadEffettuato = uploadFile($_FILES['user_file'],$destLabUploadDir, $destFileName, "");
            //Se il file viene caricato si salva il link nella tabella lab_allegato
            if ($uploadEffettuato) {
                
                inserisciNuovoAllegato($IdCarat, $IdEsper, $Descri, $destFileName, $valRifEsperimento);               
                echo $msgInfoDocCaricato;
                echo ' <a href="modifica_lab_risultati.php?IdEsperimento='.$IdEsper.'">' . $msgOk . ' </a>';
             }
            else {
                $destNomeFile = "";
                echo $msgErrDocNonCaricato; 
                echo ' <a href="modifica_lab_risultati.php?IdEsperimento='.$IdEsper.'">' . $msgOk . ' </a>';}
                
        }
        ?>
    </body>
</html>