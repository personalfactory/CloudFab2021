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
            if (!isSet($_POST['Codice']) || $_POST['Codice'] == "") {
                ?>

                <div id="container" style="width:50%; margin:15px auto;">
                    <form id="CercaCodice" name="CercaCodice" method="POST" action="">
                        <table width="100%">
                            <tr>
                                <td class="cella3" ><?php echo $titoloPaginaRicercaCodice ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="">
                                    <input type="text" name="Codice" id="Codice" size="50" style="font-size: 20px;"/></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right ">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonCerca ?>" /></td>
                            </tr>
                        </table>		
                    </form>
                </div>

            <?php
            } else {


                $action = "";
                $Codice = $_POST['Codice'];
                switch (substr($_POST['Codice'], 0, 1)) {
                    //########### CODICE SACCO FINITO ############################
                    case "S":

                        $action = "dettaglio_sacchetto.php?Sacco=" . $Codice;

                        break;
                    //########### CODICE LOTTO DI CHIMICA ########################
                    case "L":

                        $action = "dettaglio_lotto.php?Lotto=" . $Codice;

                        break;

                    case "K":

                        //############ CODICE KIT CHIMICO PRODUZIONE ###########
                        $action = "dettaglio_chimica.php?Chimica=" . $Codice;
                        break;
                    
                    default:
                        break;
                }
                ?>


                <script type="text/javascript">
                               location.href = "<?php echo $action; ?>"
                </script>  


            <?php } ?>

        </div><!-- mainContainer-->

    </body>
</html>
