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
    include('../sql/script_parametro_ripristino.php');
    
      $_SESSION['IdParRip'] = "";
      $_SESSION['NomeVariabile'] = "";
      $_SESSION['DescriVariabile'] = "";
      $_SESSION['Abilitato'] = "";
      $_SESSION['DtAbilitato'] = "";
      
      
      if(isSet($_POST['IdParRip']))
      $_SESSION['IdParRip'] = trim($_POST['IdParRip']);
      
      if(isSet($_POST['NomeVariabile']))
      $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
      
      if(isSet($_POST['DescriVariabile']))
      $_SESSION['DescriVariabile'] = trim($_POST['DescriVariabile']);
      
      if(isSet($_POST['Abilitato']))
      $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
      
      if(isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
  
  
  //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      $_SESSION['Filtro'] = "id_par_ripristino";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }    
    
     $sql =selectParRipristinoByFiltri($_SESSION['IdParRip'],
            $_SESSION['NomeVariabile'],
            $_SESSION['DescriVariabile'],
            $_SESSION['Abilitato'],
            $_SESSION['DtAbilitato'],
            $_SESSION['Filtro']);
            
    $trovati=  mysql_num_rows($sql);
	    
	include('./moduli/visualizza_parametri_ripristino.php'); ?> 

</div>

</body>
</html>
