<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">

<?php 
    include('../include/menu.php'); 
    include('../Connessioni/serverdb.php');
    include('../sql/script_valore_par_prod.php');
    
      //######################## RICERCA #################################
      $_SESSION['IdValParProd'] = "";
      $_SESSION['IdParProd'] = "";
      $_SESSION['NomeVariabile'] = "";
      $_SESSION['NomeCategoria'] = "";
      $_SESSION['ValoreVariabile'] = "";
      $_SESSION['DtAbilitato'] = "";
      
      $_SESSION['IdValParProdList'] = "";
      $_SESSION['IdParProdList'] = "";
      $_SESSION['NomeVariabileList'] = "";
      $_SESSION['NomeCategoriaList'] = "";
      $_SESSION['ValoreVariabileList'] = "";
      $_SESSION['DtAbilitatoList'] = "";
       
      //##############################################################################
//Se e' il parametro e' stato scelto da list box lo memorizzo nella variabile di
//sessione altrimentri memorizzo il contenuto dell'input text     
      
      if (isSet($_POST['IdValParProd'])) 
      $_SESSION['IdValParProd'] = trim($_POST['IdValParProd']);
     
      if (isset($_POST['IdValParProdList']) AND $_POST['IdValParProdList'] != "") {
        $_SESSION['IdValParProd'] = trim($_POST['IdValParProdList']);
      } 
      
      if (isSet($_POST['IdParProd'])) 
      $_SESSION['IdParProd'] = trim($_POST['IdParProd']);
            
      if (isset($_POST['IdParProdList']) AND $_POST['IdParProdList'] != "") {
        $_SESSION['IdParProd'] = trim($_POST['IdParProdList']);
      } 
      
      if (isSet($_POST['NomeVariabile'])) 
      $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
     
      if (isset($_POST['NomeVariabileList']) AND $_POST['NomeVariabileList'] != "") {
        $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabileList']);
      } 
      
      if (isSet($_POST['NomeCategoria'])) 
      $_SESSION['NomeCategoria'] = trim($_POST['NomeCategoria']);
      
      if (isset($_POST['NomeCategoriaList']) AND $_POST['NomeCategoriaList'] != "") {
        $_SESSION['NomeCategoria'] = trim($_POST['NomeCategoriaList']);
      } 
      
      if (isSet($_POST['ValoreVariabile']))
      $_SESSION['ValoreVariabile'] = trim($_POST['ValoreVariabile']);
      
      if (isset($_POST['ValoreVariabileList']) AND $_POST['ValoreVariabileList'] != "") {
        $_SESSION['ValoreVariabile'] = trim($_POST['ValoreVariabileList']);
      } 
      
      if (isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
      
      if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
        $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
      } 
      
      
      //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      
      $_SESSION['Filtro'] = "id_val_par_pr";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }
      //########################################################################

      $sql = selectValParProdottoByFiltri(
        $_SESSION['IdValParProd'],
        $_SESSION['IdParProd'],
        $_SESSION['NomeVariabile'],
        $_SESSION['NomeCategoria'],
        $_SESSION['ValoreVariabile'],
        $_SESSION['DtAbilitato'],
        $_SESSION['Filtro'],'id_val_par_pr');
            
      $trovati = mysql_num_rows($sql);
      
       
    include('moduli/visualizza_valori_par_prod.php'); ?> 

</div>

</body>
</html>
