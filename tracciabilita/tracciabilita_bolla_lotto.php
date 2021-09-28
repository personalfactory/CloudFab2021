<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body >
    
    <div id="tracciabilitaContainer">

      <?php 
      include('../include/menu.php'); 
      include('../include/precisione.php');
      include('../Connessioni/serverdb.php');
      include('../sql/script_gaz_movmag.php');
      include('../sql/script_macchina.php');
      include('../sql/script_lotto.php');
      include('../sql/script_bolla.php');
      
      
//##############################################################################     
//####################### CONTROLLI SUL DDT #################################### 
//##############################################################################
     
      $erroreDdt = false;      
      $messaggioDdt = $msgErroreVerificato.' <br />';
      $messaggioDdt = $messaggioDdt . '<a href="tracciabilita_bolla.php">'.$msgRicontrollaDati.'</a>';
      $CodStab="0";
      $IdMacchina=0;
      $NumLottiGazie=0;
	
      $NumDdt = $_POST['NumDdt'];
      $DataEmi = $_POST['DataEmi'];
      
//##############################################################################
//############# RECUPERO  COD STABILIMENTO #####################################
//##############################################################################

      $sqlCodStab = findInfoMovByDdtCatMer($NumDdt,$DataEmi,$valCatMerLotti);
              
//              mysql_query("SELECT * 
//                                    FROM serverdb.gaz_movmag 
//                                  WHERE 
//                                      num_doc='" . $NumDdt . "' 
//                                    AND 
//                                      dt_doc='" . $DataEmi . "'
//                                    AND 
//                                      cat_mer='" . $valCatMerLotti . "'
//                                    ")
//              or die("Errore 2 SELECT FROM gazie.gaz_movmag : " . mysql_error());


      //Recupero il cod stab della bolla
      while ($rowCodStab = mysql_fetch_array($sqlCodStab)) {
        $CodStab=  $rowCodStab['clfoco'];
        
      }
//##############################################################################
//############# CONTROLLO CODICE STABILIMENTO ##################################
//##############################################################################

      $sqlIdMacchina = findMacchinaByCodice($CodStab); 
              
//              mysql_query("SELECT id_macchina FROM serverdb.macchina
//                                      WHERE
//                                        cod_stab='" . $CodStab . "'")
//              or die("Errore 3 SELECT FROM serverdb.macchina : " . mysql_error());
      if (mysql_num_rows($sqlIdMacchina) == 0) {

        $erroreDdt = true;
        $messaggioDdt = $messaggioDdt . ' '.$msgErrCodStabNotInMacchine.'<br />';
      }
      //Recupero l'id_macchina da inserire nella tabella bolla
      while ($rowIdMacchina = mysql_fetch_array($sqlIdMacchina)) {

        $IdMacchina = $rowIdMacchina['id_macchina'];
      }
//##############################################################################
//############# NUMERO DI LOTTI DA ASSOCIARE  ##################################
//##############################################################################
      $sqlNumLottiGazie = findTotLottiInDdtGazmovmag($NumDdt,$DataEmi,$valCatMerLotti);
              
//              mysql_query("SELECT SUM(quanti) as numlotti, artico 
//                                        FROM 
//                                          serverdb.gaz_movmag	
//                                        WHERE 
//                                          num_doc=" . $NumDdt . "
//                                        AND 
//                                          dt_doc='" . $DataEmi . "'
//                                        AND 
//                                            cat_mer='" . $valCatMerLotti . "'")
//              or die("Errore 4: " . mysql_error());
       if (mysql_num_rows($sqlNumLottiGazie) == 0) {

        $erroreDdt = true;
        $messaggioDdt = $messaggioDdt . ' ' .$msgErrDdtNotInInephos.' <br />';
      }		  
      while ($rowNumLottiGazie = mysql_fetch_array($sqlNumLottiGazie)) {

        $NumLottiGazie = $rowNumLottiGazie['numlotti'];
         if($NumLottiGazie==0){
            $erroreDdt = true;
          $messaggioDdt = $messaggioDdt . ' '.$msgErrZeroLottiNelDdt.'<br />';
         }
      }
          
      
//##############################################################################
//############# VERIFICA NUMERO DI LOTTI DA ASSOCIARE SU SERVERB ###############
//##############################################################################

      //Verifico che il numero di lotti da associare sia minore o uguale 
      //a quelli disponibili nella tabella lotto
      //non ancora associati ad una bolla
      $sqlNumLotti = findLottiNonAssociatiInLotto();
              
//              mysql_query("SELECT * FROM serverdb.lotto 
//                                      WHERE
//                                        lotto.id_bolla is null;")
//              or die("Errore 5 SELECT FROM serverdb.lotto : " . mysql_error());
      if (mysql_num_rows($sqlNumLotti) < $NumLottiGazie) {

        $erroreDdt = true;
        $messaggioDdt = $messaggioDdt .' '.$msgErrLottiNotDisponibiliServerdb.'<br />';
      }


//##############################################################################
//############# VERIFICA ESISTENZA BOLLA NELLA TABELLA BOLLA DI SERVERDB #######
//##############################################################################
      
//Verifico che la bolla non sia già stata caricata nella tab bolla     
      $sqlEsisteBolla = findDdtInBolla($NumDdt,$DataEmi);
//              mysql_query("SELECT * FROM serverdb.bolla
//                                      WHERE
//                                        num_bolla='" . $NumDdt . "' 
//                                      AND 
//                                        dt_bolla='" . $DataEmi . "'")
//              or die("Errore 6 SELECT FROM serverdb.bolla : " . mysql_error());

      if (mysql_num_rows($sqlEsisteBolla) != 0) {
        //Se entro nell'if vuol dire che la bolla è già stata caricata nella tabella bolla
        $erroreDdt = true;
        $messaggioDdt = $messaggioDdt .' '.$msgErrDdtGiaAssInServerdb.'<br/>';
      }

//##############################################################################
      
      if ($erroreDdt) {
        
        echo $messaggioDdt;
        
      } else {

        $_SESSION['NumCodiciLottoTot'] = $NumLottiGazie;
		
		//Inizializzo array dei codici lotto
		for ($j = 0; $j < $NumLottiGazie; $j++) {
			echo $_SESSION['CodLotto'][$j]="";
        }
			
		
        $_SESSION['Bolla'][0] = $NumDdt;
        $_SESSION['Bolla'][1] = $DataEmi;
        $_SESSION['Bolla'][2] = $CodStab;
        $_SESSION['Bolla'][3] = $IdMacchina;
        $_SESSION['Bolla'][4] = $NumLottiGazie;
      ?>
       
      <script type="text/javascript">
        location.href="tracciabilita_bolla_lotto1.php"
      </script>
        
      <?php       
      }
      ?>
       


        
      </div>

   </body>
</html>

