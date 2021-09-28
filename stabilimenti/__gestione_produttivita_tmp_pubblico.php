<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body>
  <div id="mainContainer">
  <?php
//    include('../include/menu.php');
      include('../Connessioni/serverdb.php');
      include('../sql/script_produttivita.php');
      
//##############################################################################      
//########## Variabili dallo script gestione_produttivita.php ##################
//##############################################################################      
      if (isset($_GET['DataFrom']) && isset($_GET['DataTo'])) {

        $_SESSION['DataFrom'] = $_GET['DataFrom'];
        $_SESSION['DataTo'] = $_GET['DataTo'];
        $_SESSION['InServizio'] = $_GET['InServizio'];
        $_SESSION['Attivo'] = $_GET['Attivo'];
                
      }
      
      if (isset($_POST['DataFrom'])) {
               
        $_SESSION['DataFrom'] = $_POST['DataFrom'];
        
      }
      if (isset($_POST['DataTo'])) {
               
        $_SESSION['DataTo'] = $_POST['DataTo'];
        
      }
      
      if(isset($_GET['CodProdotto'])){ 
          
          $_SESSION['CodProdotto']=$_GET['CodProdotto'];
      
      }
      if(isset($_POST['CodProdotto'])){ 
          
          $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);}
     
     
     //########### VARIABILE DI ORDINAMENTO DELLA QUERY #############################
      $_SESSION['Filtro'] = "id_processo";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }
      
//##############################################################################
//########## Variabili che arrivano dal form di ricerca  #######################
//##############################################################################   
      
      $_SESSION['IdProcesso'] = trim($_POST['IdProcesso']);
      $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
      $_SESSION['CodChimica'] = trim($_POST['CodChimica']);
      $_SESSION['CodSacco'] = trim($_POST['CodSacco']);
      $_SESSION['DataProd'] = trim($_POST['DataProd']);
      $_SESSION['prec'] = trim($_POST['prec']);
      $_SESSION['att'] = trim($_POST['att']);
      $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
      $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
     
      //#################### LOG ####################################################
//      echo "</br>SESSION['DataFrom'] : ".$_SESSION['DataFrom'];
//      echo "</br>SESSION['DataTo'] : ".$_SESSION['DataTo'];
//      echo "</br>SESSION['InServizio'] : ".$_SESSION['InServizio'];
//      echo "</br>SESSION['Attivo'] : ".$_SESSION['Attivo'];
//      echo "</br>SESSION['IdProcesso'] : ".$_SESSION['IdProcesso'];
//      echo "</br>SESSION['NomeProdotto'] : ".$_SESSION['NomeProdotto'];
//      echo "</br>SESSION['CodChimica'] : ".$_SESSION['CodChimica'];
//      echo "</br>SESSION['CodSacco'] : ".$_SESSION['CodSacco'];
//      echo "</br>SESSION['DataProd'] : ".$_SESSION['DataProd'];
//      echo "</br>SESSION['prec'] : ".$_SESSION['prec'];
//      echo "</br>SESSION['att'] : ".$_SESSION['att'];
//      echo "</br>SESSION['Nominativo'] : ".$_SESSION['Nominativo'];
//      echo "</br>SESSION['DescriStab'] : ".$_SESSION['DescriStab'];


      //###########################################################
if($_SESSION['IdMacchina']!=0){
      $sql = selectProcessiTempByFiltri2($_SESSION['IdMacchina'],
                            $_SESSION['DataTo'],
                            $_SESSION['DataFrom'],
                            $_SESSION['InServizio'],
                            $_SESSION['Attivo'],
                            $_SESSION['IdProcesso'],
                            $_SESSION['CodProdotto'],
                            $_SESSION['CodChimica'],
                            $_SESSION['CodSacco'],
                            $_SESSION['Nominativo'],
                            $_SESSION['att'],
                            $_SESSION['prec'],
                            $_SESSION['NomeProdotto'],
                            $_SESSION['DescriStab'],
                            $_SESSION['id_utente'],
                            $_SESSION['Filtro']);       
} else {
    
    $sql = selectProcessiTempAllByFiltri(
                            $_SESSION['DataTo'],
                            $_SESSION['DataFrom'],
                            $_SESSION['InServizio'],
                            $_SESSION['Attivo'],
                            $_SESSION['IdProcesso'],
                            $_SESSION['CodProdotto'],
                            $_SESSION['CodChimica'],
                            $_SESSION['CodSacco'],
                            $_SESSION['Nominativo'],
                            $_SESSION['att'],
                            $_SESSION['prec'],
                            $_SESSION['NomeProdotto'],
                            $_SESSION['DescriStab'],
                            $_SESSION['id_utente'],
                            $_SESSION['Filtro']);       
    
    
}      

      $trovati = mysql_num_rows($sql);

      echo "</br>".$msgRecordTrovati.$trovati."</br>";
      echo "</br>" . $msgSelectCriteriRicerca . "</br>";
      
      ?>
    </div>  
    <?php
    include('./moduli/visualizza_produttivita_tmp_pubblico.php');
    
    ?>

  </body>
</html>
