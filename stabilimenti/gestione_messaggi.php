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
      include('../sql/script_messaggio_macchina.php');

      $_SESSION['IdMessaggio'] = "";
      $_SESSION['Messaggio'] = "";
      $_SESSION['Abilitato'] = "";
      $_SESSION['DtAbilitato'] = "";
      
      if(isSet($_POST['IdMessaggio']))
      $_SESSION['IdMessaggio'] = trim($_POST['IdMessaggio']);
      if(isSet($_POST['Messaggio']))
      $_SESSION['Messaggio'] = trim($_POST['Messaggio']);
      if(isSet($_POST['Abilitato']))
      $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
      if(isSet($_POST['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);


      //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
      $_SESSION['Filtro'] = "id_messaggio";
      if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_POST['Filtro']);
      }
	/*
      $sql = mysql_query("SELECT * FROM messaggio_macchina 
                    WHERE
                        id_messaggio LIKE '%" . $_SESSION['IdMessaggio'] . "%'
                      AND
                        messaggio LIKE '%" . $_SESSION['Messaggio'] . "%'
                      AND
                        abilitato LIKE '%" . $_SESSION['Abilitato'] . "%'
                      AND
                       dt_abilitato LIKE '%" . $_SESSION['DtAbilitato'] . "%'
                      ORDER BY " . $_SESSION['Filtro']) or die("ERRORE SELECT FROM messaggio_macchina: " . mysql_error());
		*/
      $sql = selectMessaggioMacchina($_SESSION['IdMessaggio'], $_SESSION['Messaggio'], $_SESSION['Abilitato'], $_SESSION['DtAbilitato'], $_SESSION['Filtro'] );
      $trovati=  mysql_num_rows($sql);
      include('./moduli/visualizza_messaggi.php');
      ?> 

    </div>
  </body>
</html>
