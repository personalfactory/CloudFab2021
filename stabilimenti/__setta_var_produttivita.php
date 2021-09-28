<html>
  <body>
    <div id="settaVar" style="visibility:hidden;">
      <?php

      session_start();

      $_SESSION['Data3'] = "";
      $_SESSION['Data4'] = "";
      $_SESSION['Stabilimento'] = "";
      $_SESSION['OreDaEscludere'] = "";
      $_SESSION['Prodotto'] = "";
      $_SESSION['Data3'] = $_GET['Data3'];
      $_SESSION['Data4'] = $_GET['Data4'];
      $_SESSION['Stabilimento'] = $_GET['Stabilimento'];
      $_SESSION['OreDaEscludere'] = $_GET['OreDaEscludere'];
      $_SESSION['Inattivita'] = $_GET['Inattivita'];
      $_SESSION['Prodotto'] = $_GET['Prodotto'];
      $_SESSION['Submit']= $_GET['Submit'];
    


      //######################### LOG #############################################     

      echo "</br>SESSION['Data3'] : " . $_SESSION['Data3'];
      echo "</br>SESSION['Data4'] : " . $_SESSION['Data4'];
      echo "</br>SESSION['Stabilimento'] : " . $_SESSION['Stabilimento'];
      echo "</br>SESSION['OreDaEscludere'] : " . $_SESSION['OreDaEscludere'];
      echo "</br>SESSION['Inattivita'] : " . $_SESSION['Inattivita'];
      echo "</br>SESSION['Prodotto'] : " . $_SESSION['Prodotto'];
      echo "</br>SESSION['IdMacchina'] : " . $_SESSION['IdMacchina'];
      echo "</br>SESSION['DescriStab'] : " . $_SESSION['DescriStab'];

            
      ?>
      <script type="text/javascript">
        window.close();
        window.opener.location.reload();
      </script>
    </div>
  </body>
</html>