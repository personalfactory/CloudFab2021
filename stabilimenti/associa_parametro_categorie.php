<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        

        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <?php include('../Connessioni/serverdb.php'); ?>
            <?php include('../sql/script_parametro_prodotto.php'); ?>
            <?php include('../sql/script_categoria.php'); ?>
            <?php include('../sql/script_num_sacchetto.php'); ?>

            <script language="javascript">
                function Carica(){
                    document.forms["AssociaParametro"].action = "associa_parametro_categorie2.php";
                    document.forms["AssociaParametro"].submit();
                }
                function ImpostaValori(){
                    document.forms["AssociaParametro"].action = "associa_parametro_categorie.php";
                    document.forms["AssociaParametro"].submit();
                }
            </script>

            <?php
//Se il parametro prodotto non � stato settato o � vuoto allora viene visualizzata la form di inserimento vuota
            if (!isset($_GET['ParametroProdotto']) || trim($_GET['ParametroProdotto']) == "") {
                ?>
                <div id="container" style=" width:600px; margin:15px auto;">

                    <form class="form" id="AssociaParametro" name="AssociaParametro" method="GET" >
                        <table width="600px">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $msgAssociaParACategorie ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroPar?></td>
                                <td class="cella1">
                                    <select name="ParametroProdotto" id="ParametroProdotto" onchange="ImpostaValori()">
                                        <option value="" selected><?php echo $labelOptionParDefault ?></option>
                                        <?php
                                        /*
                                        $sqlPar = mysql_query("SELECT * FROM parametro_prodotto  
                                                                WHERE 
                                                                    id_par_prod NOT IN 
                                                                (SELECT id_par_prod FROM valore_par_prod) 
                                                                ORDER BY descri_variabile")
                                                or die("Errore 112: " . mysql_error());
                                          */      
										$sqlPar = findParametroProdottoWhereIDNotIn();
										
                                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                                            ?>
                                            <option value="<?php echo($rowPar['id_par_prod']) . ";" . ($rowPar['descri_variabile']) . ";" . ($rowPar['valore_base']); ?>"><?php echo($rowPar['descri_variabile']); ?></option>
                                        <?php
                                                                              
                                        } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella3" ><div id="MSG"><?php echo $filtroCategoria?></div></td>
                                <td class="cella3" ><div id="MSG"><?php echo $filtroValore." ".$filtroPar?></div></td>
                            </tr>
                            <?php
                            //Visualizzo l'elenco delle categorie presenti nella tabella categoria e visualizzo un input text per inserire il valore del parametro per ciascuna categoria
                            $NCat = 1;
                            /*
                            $sqlCategoria = mysql_query("SELECT * FROM categoria ORDER BY nome_categoria")
                                    or die("Errore 113: " . mysql_error());
                                    */
                            $sqlCategoria = findAllCategoriaOrderByNome();
                            while ($rowCategoria = mysql_fetch_array($sqlCategoria)) {
                                ?>
                                <tr>
                                    <td class="cella2"> <?php echo($rowCategoria['nome_categoria']) ?></td>
                                    <td class="cella1"><input type="text" name="Valore<?php echo($NCat); ?>" id="Valore<?php echo($rowCategoria['id_cat']); ?>" value="0"></td>
                                </tr>
                                <?php
                                $NCat++;
                            }
                            ?>
                            </tr>

                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">

                                    <input type="reset" value="<?php echo $valueButtonAnnulla?>" onClick="javascript:history.back();"/>
                                    <input type="button" onclick="javascript:ImpostaValori();" value="<?php echo $valueButtonValoreBase?>" />
                                    <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva?>" /></td>
                            </tr>  
                        </table> 
                    </form>
                </div>
                <?php
            } else {//Se il Parametro Prodotto � stato settato avviene l'aggiornamento dello script
                //che consente di impostare i valori base del parametro selezionato
//##############################################################################		
///////////////////AGGIORNAMENTO////////////////////////////////////////////////
////############################################################################
                list($IdParametro, $DescriParametro) = explode(';', $_GET['ParametroProdotto']);
                /*
                 $sqlValoreBase = mysql_query("SELECT valore_base FROM parametro_prodotto  
							WHERE 
                                                            id_par_prod=". $IdParametro) 
                         or die("Errore 112: " . mysql_error());
				*/
				$sqlValoreBase = findValoreBaseByIdParProd($IdParametro);
				
                                        while ($rowValBase = mysql_fetch_array($sqlValoreBase)) {
                                        
                                            $ValoreBase=$rowValBase['valore_base'];
                                        }
                ?>

                <div id="container" style=" width:600px; margin:15px auto;">  
                    <form class="form" id="AssociaParametro" name="AssociaParametro" method="GET" action="associa_parametro_categorie2.php">
                        <table width="600px">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $titoloAssociaParametroCategoria?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroPar?> :</td>
                                <td class="cella1">
                                    <select name="ParametroProdotto" id="ParametroProdotto" onchange="ImpostaValori()">
                                        <option value="<?php echo $_GET['ParametroProdotto']; ?>" selected><?php echo $DescriParametro; ?></option>
                                        <?php
                                        /*
                                        $sqlPar = mysql_query("SELECT * FROM parametro_prodotto  
							WHERE 
                                                            id_par_prod NOT IN 
							(SELECT id_par_prod FROM valore_par_prod)
                                                        ORDER BY nome_variabile") or die("Errore 112: " . mysql_error());
										*/
										$sqlPar = findParametroProdottoWhereIDNotInOrdByNome();
										
                                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                                            ?>
                                            <option value="<?php echo($rowPar['id_par_prod']) . ";" . ($rowPar['descri_variabile']) . ";" . ($rowPar['valore_base']); ?>"><?php echo($rowPar['descri_variabile']); ?></option>
    <?php } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella3" ><div id="MSG"><?php echo $filtroCategoria?></div></td>
                                <td class="cella3" ><div id="MSG"><?php echo $filtroValoreParametro?></div></td>
                            </tr>
                            <?php
                            //Visualizzo l'elenco delle categorie presenti nella tabella categoria e i valori base del parametro
                            $NCat = 1;
                            /*
                            $sqlCategoria = mysql_query("SELECT * FROM categoria ORDER BY nome_categoria")
                                    or die("Errore 113: " . mysql_error());
                                    */
                            $sqlCategoria = findAllCategoriaOrderByNome();
                            while ($rowCategoria = mysql_fetch_array($sqlCategoria)) {
                                ?>
                                <tr>
                                    <td class="cella2"><?php echo($rowCategoria['nome_categoria']) ?></td>
                                    <td class="cella1"><input type="text" name="Valore<?php echo($NCat); ?>" id="Valore<?php echo($rowCategoria['id_cat']); ?>" value="<?php echo $ValoreBase; ?>"/></td>
                                </tr>
                                <?php
                                //}
                                $NCat++;
                            }
                            ?>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">

                                    <input type="reset" value="<?php echo $valueButtonAnnulla?>" onClick="javascript:history.back();"/>
                                    <input type="button" onclick="javascript:ImpostaValori();" value="<?php echo $valueButtonValoreBase?>" />
                                    <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva?>" /></td>
                            </tr>  
                        </table> 
                    </form>
                </div>
                <?php
            }
            ?>

        </div><!--mainContainer-->

    </body>
</html>
