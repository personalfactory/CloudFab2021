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
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_lotto_artico.php');


            ini_set(display_errors, "1"); 
            
            
            $arrayMsgErrPhp = array($msgErrQtaNumerica,$msgErrPercNonValida);
            
            if(!isSet($_POST['ValPercentuale'])){?>        
                        
            <script language="javascript" type="text/javascript">
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");
                function controllaCampi() {

                    var rv = true;
                    var msg = "";
                    
                    if (document.getElementById('ValPercentuale').value === ""
                            || isNaN(document.getElementById('ValPercentuale').value)) {
                        rv = false;
                        msg = msg + ' '+arrayMsgErrJs[0] ;
                    }
                    
                    if(document.getElementById('ValPercentuale').value.length > 2){
                        
                         rv = false;
                         msg = msg + ' '+arrayMsgErrJs[1] ;
                        
                    }
        
                if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }
                function Salva() {

                    document.forms["AggiornaListinoLotto"].action = "aggiorna_lotto_listino.php";
                }

            </script>

            <div id="container" style="width:50%; margin:15px auto;">
                <form id="AggiornaListinoLotto" name="AggiornaListinoLotto" method="post" onsubmit="return controllaCampi()" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaAggiornoListinoLotti ?></td>
                        </tr>
                           
                            <td class="cella4"><?php echo $filtroValPerc ?> </td>
                            <td class="cella1"><input type="text" name="ValPercentuale" id="ValPercentuale" size="10"/><?php echo $filtroPerc ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
               

            <?php } else {
                        
                   
            $percAumentoListino=$_POST['ValPercentuale'];
                    
            $updateListino = true;
            begin();

                $updateListino = aumentaListinoLotto($percAumentoListino);
               
            if (!$updateListino) {

                rollback();

                echo '<div id="msgErr">' . $msgErroreVerificato . '' . $msgErrContattareAdmin . ' <a href="gestione_lotti.php">' . $msgOk . '</a></div>';
            } else {

                commit();

                echo $msgModificaCompletata . ' <a href="gestione_lotti.php">' . $msgOk . '</a>';
            }
            
            }
            ?>
        </div>
    </body>
</html>