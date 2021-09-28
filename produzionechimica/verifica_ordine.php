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
            include('../include/gestione_date.php');
            include('../sql/script.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_macchina.php');
            
            if($DEBUG) ini_set("display_errors", "1");
            
            //Costruzione dell'array contenente i vari msg di errore
            $arrayMsgErrPhp = array($msgErrNumDoc, //0
                $msgErrDataDoc, //1
                $msgErrControlloDtDoc, //2
                $msgErrDataOrdine, //3
                $msgErrControlloDtOrdine, //4
                $msgErrSelectStab, //5
                $msgErrNumArticoli, //6                
                $msgErrQtaArticoli //7 
            );

            begin();
            //TODO: scrivere query
            $sqlArtico = findAllLottoArtico("codice");
            commit();
            ?>
            <script language="javascript" type="text/javascript">

                //Trasformo l'array da php a js
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

                function controllaCampi(arrayMsgErrJs) {

                    var rv = true;
                    var errorArtico = false;
                    var msg = "";


                    if (document.getElementById('NumArticoli').value === "") {

                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[6];
                    }
                    if (document.getElementById('NumArticoli').value > 0) {
                        for (i = 1; i <= document.getElementById('NumArticoli').value; i++) {

                            if (document.getElementById('Articolo' + i).value !== ""
                                    && isNaN(document.getElementById('QtaArticolo' + i).value)) {

                                errorArtico = true;

                            }
                            if (document.getElementById('Articolo' + i).value === ""
                                    || isNaN(document.getElementById('QtaArticolo' + i).value)) {

                                errorArtico = true;

                            }

                        }
                        if (errorArtico) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[7];
                        }

                    }

                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }

                function Aggiorna() {

                    document.forms["VerificaOrdine"].action = "verifica_ordine.php";

                }
      
				function Verifica() {

                    document.forms["VerificaOrdine"].action = "verifica_ordine2.php";

                }
				function Verifica2() {

                    document.forms["VerificaOrdine"].action = "verifica_ordine_10_2020.php";

                }

            </script>
            <?php
            if (!isset($_POST['NumArticoli']) && !isset($_POST['NumArticoli'])) {
                ?>

                <div id="container" style="width:60%; margin:50px auto;">
                    <form id="VerificaOrdine" name="VerificaOrdine" method="Post" onsubmit="return controllaCampi(arrayMsgErrJs)" enctype="multipart/form-data">
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo "VERIFICA CAPACITA' PRODUTTIVA" ?></td>
                            </tr>
                            <tr>
                                <td class="cella1"><?php echo $filtroNumTipoArticolo ?></td>
                                <td class="cella1"><input type="text" name="NumArticoli" id="NumArticoli" /></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonConferma ?>" onClick="return controllaCampi(arrayMsgErrJs);Aggiorna()"/></td>
								 
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
            } else {

          
                $NumArticoli = str_replace("'", "''", $_POST['NumArticoli']);
                
                ?>

                <div id="container" style="width:70%; margin:50px auto;">
                    <form id="VerificaOrdine" name="VerificaOrdine" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" enctype="multipart/form-data">
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo "VERIFICA CAPACITA PRODUTTIVA" ?></td>
                            </tr>
                          
                            <tr>
                                <td class="cella1"><?php echo $filtroNumTipoArticolo ?></td>
                                <td class="cella1"><input type="text" name="NumArticoli" id="NumArticoli" value="<?php echo $NumArticoli ?>"/></td>
                            </tr>
                            </table>
                        <table width="100%">

                            <tr>
                                <td class="cella4" ><?php echo $filtroArticolo ?></td>
                                <td class="cella4" ><?php echo $filtroQuantita ?></td>
                                <td class="cella4" ><?php echo $filtroUniMisura ?></td> 
								
                            </tr>
                            <?php
                            for ($i = 0; $i < $NumArticoli; $i++) {
                                if (isset($_POST['Articolo' . $i]) AND $_POST['Articolo' . $i] != "") {
                                    list($CodArticolo, $DescriArticolo) = explode(";", $_POST['Articolo' . $i]);
//                            echo "</br>i: ".$i." - CodArtocolo : ".$CodArticolo." - DescriArticolo : ".$DescriArticolo;
//                            echo "</br>i: ".$i." POST[Articolo i] : ".$_POST['Articolo'.$i];
                                    ?>
                                    <tr>
                                        <td class="cella1" >
                                            <select  name="Articolo<?php echo $i ?>" id="Articolo<?php echo $i ?>">
                                                <option value="<?php echo $_POST['Articolo' . $i] ?>" selected="<?php echo $_POST['Articolo' . $i] ?>"><?php echo $CodArticolo . " - " . $DescriArticolo ?></option>
                                                <?php
                                                mysql_data_seek($sqlArtico, 0);
                                                while ($rowArtico = mysql_fetch_array($sqlArtico)) {
                                                    ?>
                                                    <option value="<?php echo $rowArtico["codice"] . ";" . $rowArtico["descri"] ?>" size="40"><?php echo $rowArtico["codice"] . " - " . $rowArtico["descri"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="cella1"><input type="text" name="QtaArticolo<?php echo $i ?>" id="QtaArticolo<?php echo $i ?>" value="<?php echo $_POST['QtaArticolo' . $i] ?>"/></td>
                                        <td class="cella1"><?php echo $filtroPz ?></td>
                                    </tr>
                                    <?php
                                } else {
//                                    echo "Di nuovo campi vuoti non arriva il post</br>";
                                    ?>
                                    <tr>
                                        <td class="cella1">
                                            <select  name="Articolo<?php echo $i ?>" id="Articolo<?php echo $i ?>">
                                                <option value="" selected=""><?php echo $labelOptionSelectArticolo ?></option>
                                                <?php
                                                mysql_data_seek($sqlArtico, 0);
                                                while ($rowArtico = mysql_fetch_array($sqlArtico)) {
                                                    ?>
                                                    <option value="<?php echo $rowArtico["codice"] . ";" . $rowArtico["descri"] ?>" size="40"><?php echo $rowArtico["codice"] . " - " . $rowArtico["descri"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="cella1"><input type="text" name="QtaArticolo<?php echo $i ?>" id="QtaArticolo<?php echo $i ?>" /></td>
                                        <td class="cella1"><?php echo $filtroPz ?></td>
                                    </tr>	
                                    <?php
                                }
                            }
                            ?>
                            
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="4">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" name="submit1" value="<?php echo $valueButtonAggiorna ?>" onClick="Aggiorna()"/>
                                    <input type="submit" name="submit2" value="<?php echo $valueButtonVerifica ?>" onClick="Verifica()"/>
									<input type="submit" name="submit3" value="<?php echo "PRODUZIONE" ?>" onClick="Verifica2()"/>
								</td>
                                  
                            </tr> 
							  
                        </table>
                    </form>
                </div>


            <?php }
            ?>

        </div><!--mainContainer-->

    </body>
</html>

