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
      include('../sql/script_dizionario.php');

      $_SESSION['IdDiz'] = "";
      $_SESSION['DizionarioTipo'] = "";
      $_SESSION['IdVocabolo'] = "";
      $_SESSION['Vocabolo'] = "";
      $_SESSION['DtAbilitato'] = "";
      $_SESSION['LinguaScelta'] = "";

      $_SESSION['IdDizList'] = "";
      $_SESSION['DizionarioTipoList'] = "";
      $_SESSION['IdVocaboloList'] = "";
      $_SESSION['VocaboloList'] = "";
      $_SESSION['DtAbilitatoList'] = "";
      $_SESSION['LinguaSceltaList'] = "";
      
//      $_SESSION['IdDiz'] = trim($_POST['IdDiz']);
//      $_SESSION['DizionarioTipo'] = trim($_POST['DizionarioTipo']);
//      $_SESSION['IdVocabolo'] = trim($_POST['IdVocabolo']);
//      $_SESSION['Vocabolo'] = trim($_POST['Vocabolo']);
//      $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);


       //##############################################################################
//Se e' il parametro e' stato scelto da list box lo memorizzo nella variabile di
//sessione altrimenti memorizzo il contenuto dell'input text      
     if(isSet($_GET['IdDiz']))
      $_SESSION['IdDiz'] = trim($_GET['IdDiz']);
      if (isset($_GET['IdDizList']) AND $_GET['IdDizList'] != "") {
        $_SESSION['IdDiz'] = trim($_GET['IdDizList']);
      } 
      
      if(isSet($_GET['DizionarioTipo']))
      $_SESSION['DizionarioTipo'] = trim($_GET['DizionarioTipo']);
      if (isset($_GET['DizionarioTipoList']) AND $_GET['DizionarioTipoList'] != "") {
        $_SESSION['DizionarioTipo'] = trim($_GET['DizionarioTipoList']);
      } 
      
      if(isSet($_GET['IdVocabolo']))
      $_SESSION['IdVocabolo'] = trim($_GET['IdVocabolo']);
      if (isset($_GET['IdVocaboloList']) AND $_GET['IdVocaboloList'] != "") {
        $_SESSION['IdVocabolo'] = trim($_GET['IdVocaboloList']);
      } 
      
      if(isSet($_GET['Vocabolo']))
      $_SESSION['Vocabolo'] = trim($_GET['Vocabolo']);
      if (isset($_GET['VocaboloList']) AND $_GET['VocaboloList'] != "") {
        $_SESSION['Vocabolo'] = trim($_GET['VocaboloList']);
      } 
      
      if(isSet($_GET['DtAbilitato']))
      $_SESSION['DtAbilitato'] = trim($_GET['DtAbilitato']);
      if (isset($_GET['DtAbilitatoList']) AND $_GET['DtAbilitatoList'] != "") {
        $_SESSION['DtAbilitato'] = trim($_GET['DtAbilitatoList']);
      } 
      
      if(isSet($_GET['LinguaScelta']))
      $_SESSION['LinguaScelta'] = trim($_GET['LinguaScelta']);
      if (isset($_GET['LinguaSceltaList']) AND $_GET['LinguaSceltaList'] != "") {
        $_SESSION['LinguaScelta'] = trim($_GET['LinguaSceltaList']);
      } 
      
      
      //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################

      $_SESSION['Filtro'] = "id_dizionario";
      if (isset($_GET['Filtro']) AND $_GET['Filtro'] != "") {
        $_SESSION['Filtro'] = trim($_GET['Filtro']);
      }

      
      $sql = selectDizionarioByFiltri( $_SESSION['LinguaScelta'],
              $_SESSION['IdDiz'],
              $_SESSION['DizionarioTipo'],
              $_SESSION['IdVocabolo'],
              $_SESSION['Vocabolo'],
              $_SESSION['DtAbilitato'],
              $_SESSION['Filtro'],
              'id_dizionario');
             
      $trovati = mysql_num_rows($sql);
      
//      
//        echo "</br>SESSION['LinguaScelta'] : " . $_SESSION['LinguaScelta'];
//        echo "</br>SESSION['IdDiz'] : " . $_SESSION['IdDiz'];
//        echo "</br>SESSION['DizionarioTipo'] : " . $_SESSION['DizionarioTipo'];
//        echo "</br>SESSION['IdVocabolo'] : " . $_SESSION['IdVocabolo'];
//        echo "</br>SESSION['Vocabolo'] : " . $_SESSION['Vocabolo'];
//        echo "</br>SESSION['DtAbilitato'] : " . $_SESSION['DtAbilitato'];
//        echo "</br>SESSION['Filtro'] : " . $_SESSION['Filtro'];
      

      include('./moduli/visualizza_dizionario.php');
      ?>

    </div>
  </body>
</html>
