<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        include('../Connessioni/serverdb.php');
        include('./sql/script_lab_peso.php');
        include('./sql/script_lab_bilancia.php');
        ?>
    </head>
    <body onBlur="self.focus();">

        <?php
        ini_set(display_errors, "1");
        $Codice="";       
        if (isset($_GET['Codice'])) {
//            echo "get settato";
            $Codice = $_GET['Codice'];
        } else if (isset($_POST['Codice'])) {
//            echo "post settato";
            $Codice = $_POST['Codice'];
        }

        
        $Peso = 0;
        $updatePeso = true;
        //Nuova selezione peso									
        $sqlPeso = findBilanciaByIdMacchina($_SESSION['lab_macchina']);
        while ($rowPeso = mysql_fetch_array($sqlPeso)) {

            $Peso = $rowPeso['bilancia1'] + $rowPeso['bilancia2'] + $rowPeso['bilancia3'];
        }

        //Aggiorno il peso della materia prima nella  tabella [lab_peso] 
        //con il valore letto dalla tabella [lab_bilancia]
        $updatePeso = aggiornaPeso($Codice, $_SESSION['lab_macchina'], $Peso);

        if (!$updatePeso) {
            echo $msgErroreVerificato;
        } else {
            echo "PESO REGISTRATO! " . $Peso." ".$filtroLabGrammo;
            echo "</br>RICARICARE LA PAGINA!"; 
         } ?>
<!--      <script language="javascript">
      window.close();
      window.opener.location.reload();
      </script>-->
    </body>
</html> 
