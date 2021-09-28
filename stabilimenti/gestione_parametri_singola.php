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
    include('../sql/script_parametro_sing_mac.php');
    
      $_SESSION['IdParSm'] = "";
      $_SESSION['NomeVariabile'] = "";
      $_SESSION['DescriVariabile'] = "";
      $_SESSION['ValoreBase'] = "";
      $_SESSION['Abilitato'] = "";
      $_SESSION['DtAbilitato'] = "";
      
      
      if(isSet($_POST['IdParSm']))
      $_SESSION['IdParSm'] = trim($_POST['IdParSm']);
      
      if(isSet($_POST['NomeVariabile']))
      $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
      
      if(isSet($_POST['DescriVariabile']))
      $_SESSION['DescriVariabile'] = trim($_POST['DescriVariabile']);
      
      if(isSet($_POST['ValoreBase']))
      $_SESSION['ValoreBase'] = trim($_POST['ValoreBase']);
      
      if(isSet($_POST['Abilitato']))
      $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
      
      if(isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
  
  
  //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      $_SESSION['Filtro'] = "id_par_sm";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }    
    
    
    $sql =selectParSingMacByFiltri($_SESSION['IdParSm'],
            $_SESSION['NomeVariabile'],
            $_SESSION['DescriVariabile'],
            $_SESSION['ValoreBase'],
            $_SESSION['Abilitato'],
            $_SESSION['DtAbilitato'],
            $_SESSION['Filtro']);
        
    
    $trovati=  mysql_num_rows($sql);
    
    include('./moduli/visualizza_parametri_singola.php'); ?> 

</div>

</body>
</html>
