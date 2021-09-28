<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <body>
    <div id="settaVar" style="visibility:hidden;">
      <?php 
      ini_set('display_errors', 1);

      session_start();
     
      $_SESSION['Data3'] = "";
      $_SESSION['Data4'] = "";
      $_SESSION['Stabilimento'] = "";
      $_SESSION['OreDaEscludere'] = "";
      $_SESSION['Inattivita'] = "";
      $_SESSION['Operatore'] = "";
      $_SESSION['Prodotto'] = "";
      $_SESSION['Data3'] = $_GET['Data3'];
      $_SESSION['Data4'] = $_GET['Data4'];
      $_SESSION['Stabilimento'] = $_GET['Stabilimento'];
      $_SESSION['OreDaEscludere'] = $_GET['OreDaEscludere'];
      $_SESSION['Inattivita'] = $_GET['Inattivita'];
      $_SESSION['Operatore'] = $_GET['Operatore'];
      $_SESSION['Prodotto'] = $_GET['Prodotto'];
      $_SESSION['Submit']= $_GET['Submit'];

      //##########################################################################
      //################## GRUPPO ################################################
      //##########################################################################

      if (isSet($_GET['PrimoLivello'])) {

        $_SESSION['LivelloGruppo'] = "PrimoLivello";
        $_SESSION['Gruppo'] = $_GET['PrimoLivello'];
      } else if (isSet($_GET['SecondoLivello'])) {

        $_SESSION['LivelloGruppo'] = "SecondoLivello";
        $_SESSION['Gruppo'] = $_GET['SecondoLivello'];
      } else if (isSet($_GET['TerzoLivello'])) {

        $_SESSION['LivelloGruppo'] = "TerzoLivello";
        $_SESSION['Gruppo'] = $_GET['TerzoLivello'];
      } else if (isSet($_GET['QuartoLivello'])) {

        $_SESSION['LivelloGruppo'] = "QuartoLivello";
        $_SESSION['Gruppo'] = $_GET['QuartoLivello'];
      } else if (isSet($_GET['QuintoLivello'])) {

        $_SESSION['LivelloGruppo'] = "QuintoLivello";
        $_SESSION['Gruppo'] = $_GET['QuintoLivello'];
      } else if (isSet($_GET['SestoLivello'])) {

        $_SESSION['LivelloGruppo'] = "SestoLivello";
        $_SESSION['Gruppo'] = $_GET['SestoLivello'];
      }
//##############################################################################
//################## GEOGRAFICO ################################################
//##############################################################################
      if (isSet($_GET['Mondo'])) {

        $_SESSION['TipoRiferimento'] = "Mondo";
        $_SESSION['Geografico'] = $_GET['Mondo'];
      
        
      } else if (isSet($_GET['Continente'])) {

        $_SESSION['TipoRiferimento'] = "Continente";
        $_SESSION['Geografico'] = $_GET['Continente'];
      
        
      } else if (isSet($_GET['Stato'])) {

        $_SESSION['TipoRiferimento'] = "Stato";
        $_SESSION['Geografico'] = $_GET['Stato'];
      
        
      } else if (isSet($_GET['Regione'])) {

        $_SESSION['TipoRiferimento'] = "Regione";
        $_SESSION['Geografico'] = $_GET['Regione'];
      
        
      } else if (isSet($_GET['Provincia'])) {

        $_SESSION['TipoRiferimento'] = "Provincia";
        $_SESSION['Geografico'] = $_GET['Provincia'];
     
        } else if (isSet($_GET['Comune'])) {

        $_SESSION['TipoRiferimento'] = "Comune";
        $_SESSION['Geografico'] = $_GET['Comune'];
      }


      //######################### LOG #############################################     

      echo "</br>SESSION['Data3'] : " . $_SESSION['Data3'];
      echo "</br>SESSION['Data4'] : " . $_SESSION['Data4'];
      echo "</br>SESSION['Stabilimento'] : " . $_SESSION['Stabilimento'];
      echo "</br>SESSION['OreDaEscludere'] : " . $_SESSION['OreDaEscludere'];
      echo "</br>SESSION['Inattivita'] : " . $_SESSION['Inattivita'];
      echo "</br>SESSION['Operatore'] : " . $_SESSION['Operatore'];
      echo "</br>SESSION['CodOperatore'] : " . $_SESSION['CodOperatore'];
      echo "</br>SESSION['Nominativo'] : " . $_SESSION['Nominativo'];
      echo "</br>SESSION['Prodotto'] : " . $_SESSION['Prodotto'];
      echo "</br>SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
      echo "</br>SESSION['DescriStab'] : " . $_SESSION['DescriStab'];

      echo "</br>SESSION['Gruppo'] : " . $_SESSION['Gruppo'];
      echo "</br>SESSION['LivelloGruppo'] : " . $_SESSION['LivelloGruppo'];
      echo "</br>SESSION['Geografico'] : " . $_SESSION['Geografico'];
      echo "</br>SESSION['TipoRiferimento'] : " . $_SESSION['TipoRiferimento'];
      echo "</br>SESSION['Submit'] : " . $_SESSION['Submit'];
      ?>
      <script type="text/javascript">
        window.close();
        window.opener.location.reload();
      </script>
    </div>
  </body>
</html>