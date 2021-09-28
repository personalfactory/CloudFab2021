<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
//        function disabilitaAction90() {
//            //PERMESSO VISTA DETTAGLIO SACCO
//            location.href = '../permessi/avviso_permessi_visualizzazione.php'
//        }
        </script>
    <?php
  
    if ($DEBUG) ini_set('display_errors', 1);
    //L'elenco delle funzioni relative ad una voce-sottovoce in generale relativo ad una pagina
    //può essere recuperato dalla tabella voce_funzione di dbutente
//    $elencoFunzioni = array("90");
//    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
   
    //##########################################################################
    ?>    
<!--    <body onLoad="<?php echo $actionOnLoad ?>">-->
    <body>
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:50%; margin:100px auto;">
                <form id="InserisciSacchetto" name="InserisciSacchetto" method="GET" action="/CloudFab/produzionechimica/dettaglio_sacchetto.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" ><?php echo $titoloPaginaRicercaSacchetto ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="">
                                <input type="text" name="Sacco" id="Sacco" size="50" style="font-size: 20px;"/></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right ">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonCerca ?>" /></td>
                        </tr>
                    </table>		
                </form>
            </div>
<div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>ActionOnLoad : " . $actionOnLoad;
                
            }
            ?>
            </div>
        </div><!-- mainContainer-->

    </body>
</html>
