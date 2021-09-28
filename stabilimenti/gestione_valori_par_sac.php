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
      include('../sql/script_valore_par_sacchetto.php');

      //######################## RICERCA #################################
      $_SESSION['IdValParSac'] = "";
      $_SESSION['IdParSac'] = "";
      $_SESSION['NomeVariabile'] = "";
      $_SESSION['NomeCategoria'] = "";
      $_SESSION['NumSacchi'] = "";
      $_SESSION['DtAbilitato'] = "";
      
      
      $_SESSION['IdValParSacList'] = "";
      $_SESSION['IdParSacList'] = "";
      $_SESSION['NomeVariabileList'] = "";
      $_SESSION['NomeCategoriaList'] = "";
      $_SESSION['NumSacchiList'] = "";
      $_SESSION['DtAbilitatoList'] = "";

  
      
      //##############################################################################
//Se e' il parametro e' stato scelto da list box lo memorizzo nella variabile di
//sessione altrimentri memorizzo il contenuto dell'input text      
      
      if(isSet($_POST['IdValParSac']))
      $_SESSION['IdValParSac'] = trim($_POST['IdValParSac']);
      
      if (isset($_POST['IdValParSacList']) AND $_POST['IdValParSacList'] != "") {
        $_SESSION['IdValParSac'] = trim($_POST['IdValParSacList']);
      } 
      
      if(isSet($_POST['IdParSac']))
      $_SESSION['IdParSac'] = trim($_POST['IdParSac']);
      
      if (isset($_POST['IdParSacList']) AND $_POST['IdParSacList'] != "") {
        $_SESSION['IdParSac'] = trim($_POST['IdParSacList']);
      } 
      
      if(isSet($_POST['NomeVariabile']))
      $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
      
      if (isset($_POST['NomeVariabileList']) AND $_POST['NomeVariabileList'] != "") {
        $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabileList']);
      } 
      
      if(isSet($_POST['NomeCategoria']))
      $_SESSION['NomeCategoria'] = trim($_POST['NomeCategoria']);
      if (isset($_POST['NomeCategoriaList']) AND $_POST['NomeCategoriaList'] != "") {
        $_SESSION['NomeCategoria'] = trim($_POST['NomeCategoriaList']);
      } 
      
      if(isSet($_POST['NumSacchi']))
      $_SESSION['NumSacchi'] = trim($_POST['NumSacchi']);
      
      if (isset($_POST['NumSacchiList']) AND $_POST['NumSacchiList'] != "") {
        $_SESSION['NumSacchi'] = trim($_POST['NumSacchiList']);
      } 
      
      if(isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
      
      if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
        $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
      } 
      
      
      //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      $_SESSION['Filtro'] = "id_val_par_sac";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }
      //##################################################################

      $sql = selectValParSacchettoByFiltri(
        $_SESSION['IdValParSac'],
        $_SESSION['IdParSac'],
        $_SESSION['NomeVariabile'],
        $_SESSION['NomeCategoria'],
        $_SESSION['NumSacchi'],
        $_SESSION['DtAbilitato'],
        $_SESSION['Filtro'],'id_val_par_sac');
            
      $trovati = mysql_num_rows($sql);
      
      include('./moduli/visualizza_valori_par_sac.php');
      ?> 

    </div>

  </body>
</html>
