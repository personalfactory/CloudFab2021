<html>
  <body>
    <div id="resetVar" style="visibility:hidden;">
<?php

//La pagina php sara fatta così
session_start();

//Inizializzazzione delle variabili di sessione
        $_SESSION['Data3'] = "";
        $_SESSION['Data4'] = "";
        $_SESSION['Stabilimento'] = "";
        $_SESSION['OreDaEscludere'] = "";
        $_SESSION['Inattivita'] = "";
        $_SESSION['Operatore'] = "";
        $_SESSION['CodOperatore'] = "";
        $_SESSION['Nominativo'] = "";
        $_SESSION['Prodotto'] = "";
        $_SESSION['IdMacchina'] = "";
        $_SESSION['DescriStab'] = "";
        $_SESSION['Gruppo'] = "Universale";
        $_SESSION['LivelloGruppo'] = "SestoLivello";
        $_SESSION['Geografico'] = "Mondo";
        $_SESSION['TipoRiferimento'] = "Mondo";
        $_SESSION['Submit']="";
        ?>
  
 <script type="text/javascript">
   window.close();
   window.opener.location.reload();
</script>
    </div>
</body>
</html>
