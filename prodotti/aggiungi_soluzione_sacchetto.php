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
            include('../sql/script_num_sacchetto.php');
            include('../sql/script_parametro_sacchetto.php');
            ?>
            <script language="javascript">

                function Carica() {
                    document.forms["AggiungiSoluzioneSac"].action = "aggiungi_soluzione_sacchetto2.php";
                    document.forms["AggiungiSoluzioneSac"].submit();
                }
                function Aggiorna() {
                    document.forms["AggiungiSoluzioneSac"].action = "aggiungi_soluzione_sacchetto.php";
                    document.forms["AggiungiSoluzioneSac"].submit();
                }

            </script>

            <?php            

            if (!isset($_POST['NumSacchetti']) || trim($_POST['NumSacchetti']) == "") {


                $IdCategoria = $_POST['IdCategoria'];
                $NomeCategoria = $_POST['NomeCategoria'];
                ?>

                <div id="container" style="width:500px; margin:15px auto;">
                    <form class="form" id="AggiungiSoluzioneSac" name="AggiungiSoluzioneSac" method="post">
                        <table width="100%">
                            <input type="hidden" name="IdCategoria" id="IdCategoria" value="<?php echo $IdCategoria; ?>"></input>
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPagNuovaSolSacchi?></td>                            
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCategoria?></td>
                                <td class="cella1"><?php echo $NomeCategoria; ?></td>
                                <input type="hidden" name="NomeCategoria" id="NomeCategoria" value="<?php echo $NomeCategoria; ?>"/>
                            </tr>
                            <tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroNumSacchetti?></td>
                                    <td class="cella1"><input type="text" name="NumSacchetti" id="NumSacchetti" value=""/></td>
                                </tr>
                            </tr>  

                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla?>" onClick="javascript:history.back();"/>
                                    <input type="button" value="<?php echo $valueButtonAggiorna?>"  onclick="javascript:Aggiorna();" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            } else {

                //############################################################################
                //################ AGGIORNAMENTO SCRIPT ######################################
                //############################################################################
                $errore = false;
                $messaggio="";
                $erroreEs=false;
                $messaggioEs="";
                $IdCategoria = $_POST['IdCategoria'];
                $NomeCategoria = $_POST['NomeCategoria'];
                

                //TODO:
                //Verificare che la soluzione di numero sacchi che si vuole aggiungere non sia già
                //presente 
            if (!isset($_POST['NumSacchetti']) || trim($_POST['NumSacchetti']) == "") {

                $errore = true;
                $messaggio = $messaggio .' '. $msgErrNumSacchi.'<br />';
            }
            if (!is_numeric($_POST['NumSacchetti'])) {
                $errore = true;
                $messaggio = $messaggio . ' ' .$msgErrNumSacchi . ' '.$msgNumerico.'<br />';
            }

//Verifica esistenza
//Apro la connessione al db

            
            $messaggio=$messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';


            if ($errore) {
                //Ci sono errori quindi non salvo
                echo $messaggio;
            } else {
                
                $NumSacchetti = $_POST['NumSacchetti'];                
                
                $result = findSoluzioneByIdCat($IdCategoria,$NumSacchetti);

                if (mysql_num_rows($result) != 0) {
                    //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
                    $erroreEs = true;
                    $messaggioEs = $messaggioEs . ' '.$msgErrSolSacchiEsistente.'<br />';
                }
                if ($erroreEs) {
                //Ci sono errori quindi non salvo
                echo $messaggioEs . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';
                
            } else {
                ?>
                <div id="container" style="width:600px; margin:15px auto;">
                    <form class="form" id="AggiungiSoluzioneSac" name="AggiungiSoluzioneSac" method="post">
                        <table width="100%">
                            <input type="hidden" name="IdCategoria" id="IdCategoria" value="<?php echo $IdCategoria; ?>"></input>
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloPagNuovaSolSacchi?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCategoria?></td>
                                <td class="cella1"><?php echo $NomeCategoria; ?></td>
                            </tr>
                            <tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroNumSacchetti?></td>
                                    <td class="cella1"><input type="text" name="NumSacchetti" id="NumSacchetti" value="<?php echo $NumSacchetti; ?>"/></td>
                                </tr>
                            </tr>  
                        </table>  
                        <table width="100%">
                            <tr>
                                <td class="cella3"><?php echo $filtroParametri?></td>
                                <td class="cella3"><?php echo $filtroValoreBase ?></td>
                                <td class="cella3"><?php echo $filtroNumSacchetti?></td>
                            </tr> 

    <?php
    //Visualizzo l'elenco dei parametri presenti nella tabella parametro_sacchetto
    $NPar = 1;
    $sqlPar = findAllParSacchettoOrderByNome();
    while ($rowPar = mysql_fetch_array($sqlPar)) {
        ?>
                                <tr>
                                    <td  class="cella2"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td  class="cella2"><?php echo($rowPar['valore_base']) ?></td>
                                    <td  class="cella2"><?php echo($NumSacchetti) ?></td>
                                </tr>

        <?php
        $NPar++;
    }
    ?>                           
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="3">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="button" value="<?php echo $valueButtonSalva ?>"onclick="javascript:Carica();" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
<?php }
            } }?>





        </div>
    </body>
</html>
