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
    include('../sql/script_parametro_prod.php');
    
      $_SESSION['IdParProd'] = "";
      $_SESSION['NomeVariabile'] = "";
      $_SESSION['DescriVariabile'] = "";
      $_SESSION['Valore'] = "";
      $_SESSION['Abilitato'] = "";
      $_SESSION['DtAbilitato'] = "";

      if(isSet($_POST['IdParProd']))
      $_SESSION['IdParProd'] = trim($_POST['IdParProd']);
      
      if(isSet($_POST['NomeVariabile']))
      $_SESSION['NomeVariabile'] = trim($_POST['NomeVariabile']);
      
      if(isSet($_POST['DescriVariabile']))
      $_SESSION['DescriVariabile'] = trim($_POST['DescriVariabile']);
      
      if(isSet($_POST['Valore']))
      $_SESSION['Valore'] = trim($_POST['Valore']);
      
      if(isSet($_POST['Abilitato']))
      $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
      
      if(isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
  
  
  //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      $_SESSION['Filtro'] = "id_par_prod";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }
           
     //##################################################################
           $sql=selectParametroProdByFiltri($_SESSION['IdParProd'],
              $_SESSION['NomeVariabile'],
              $_SESSION['DescriVariabile'],
              $_SESSION['Valore'],
              $_SESSION['Abilitato'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro']);
     

            $trovati=  mysql_num_rows($sql);

    
    include('./moduli/visualizza_parametri_prodotto.php'); ?> 

</div>

</body>
</html>
