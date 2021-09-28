<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        

        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <?php include('../Connessioni/serverdb.php');
            include('../sql/script_categoria.php');
            include('../sql/script_num_sacchetto.php');
            include('../sql/script_parametro_sacchetto.php');
             ?>

            <script language="javascript">
                function Carica(){
                    document.forms["AssociaCategoria"].action = "associa_categoria_parametri_sac2.php";
                    document.forms["AssociaCategoria"].submit();
                }
                function Aggiorna(){
                    document.forms["AssociaCategoria"].action = "associa_categoria_parametri_sac.php";
                    document.forms["AssociaCategoria"].submit();
                }
            </script>

            <?php
//Se la categoria non � stato settata o � vuota allora viene visualizzata la form di inserimento vuota
            if ((!isset($_POST['Categoria']) AND !isset($_GET['Categoria'])) ) {
                ?>

                <div id="container" style=" width:700px; margin:15px auto;">

                    <form class="form" id="AssociaCategoria" name="AssociaCategoria" method="post" >
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $msgAssociaCatAParametri ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCategoria?></td>
                                <td class="cella1">
                                    <select name="Categoria" id="Categoria" onChange="Aggiorna()">
                                        <option value="" selected><?php echo $labelOptionCatDefault?></option>
                                        <?php
                                        /*
                                        $sqlCat = mysql_query("SELECT * FROM categoria                                             
                                                ORDER BY nome_categoria")
                                                or die("Errore 112: " . mysql_error());
										*/
										$sqlCat = findAllCategoriaOrderByNome();
                                        while ($rowCat = mysql_fetch_array($sqlCat)) {
                                            ?>
                                            <option value="<?php echo($rowCat['id_cat']) . ";" . ($rowCat['nome_categoria']); ?>"><?php echo($rowCat['nome_categoria']); ?></option>
                                        <?php } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" /></td>
                            </tr>  
                        </table> 
                    </form>
                    </td>
                </div>
                <?php
            } else {//Se la categoria � stata settata avviene l'aggiornamento della pagina
                ///////////////////AGGIORNAMENTO/////////////////////////////////////////////////////////// 
               
               
                list($IdCategoria, $NomeCategoria) = explode(';', $_POST['Categoria']);
                
                ?>
                <div id="container" style=" width:700px; margin:15px auto;">  
                    <form class="form" id="AssociaCategoria" name="AssociaCategoria" method="post" >
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $msgAssociaCatAParametri ?> </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCategoria?></td>
                                <td  class="cella1">
                                    <select name="Categoria" id="Categoria" onChange="Aggiorna()">
                                        <option value="<?php echo $_POST['Categoria']; ?>" selected><?php echo $NomeCategoria; ?></option>
                                        <?php
                                        /*
                                        $sqlCat = mysql_query("SELECT * FROM categoria                                             
                                                ORDER BY nome_categoria")
                                                or die("Errore 112: " . mysql_error());
										*/
										$sqlCat = findAllCategoriaOrderByNome();
                                        while ($rowCat = mysql_fetch_array($sqlCat)) {
                                            ?>
                                            <option value="<?php echo($rowCat['id_cat']) . ";" . ($rowCat['nome_categoria']); ?>"><?php echo($rowCat['nome_categoria']); ?></option>
                                        <?php } ?>
                                    </select>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td class="cella3"><?php echo $filtroPar?> </td>
                                <td class="cella3"><?php echo $filtroValoreBase?> </td>
                                <td class="cella3" ><?php echo $filtroNumSacchi?></td>
                            </tr> 

                            <?php
                            //Visualizzo l'elenco dei parametri presenti nella tabella parametro_sacchetto

                            $NPar = 1;
                            /*
                            $sqlPar = mysql_query("SELECT *
                                                    FROM parametro_sacchetto 
                                                    ORDER BY nome_variabile")
                                    or die("Errore 113: " . mysql_error());
*/
							$sqlPar = findAllParSacchettoOrderByNome();
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                ?>

                                <tr>
                                    <td  class="cella2"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td  class="cella2"><?php echo($rowPar['valore_base']) ?></td>
                                    <?php
                                    $NSac = 1;
                                    /*
                                    $sqlSac = mysql_query("SELECT num_sacchetti	
                                                                FROM 
                                                                        num_sacchetto 
                                                                WHERE  	
                                                                        id_cat='" . $IdCategoria . "'
                                                                ORDER BY num_sacchetti")
                                            or die("Errore 113: " . mysql_error());
									*/
									$sqlSac = findNumSaccByIdCat($IdCategoria);
                                    ?>
                                    <td>
                                        <table  width="100%">
                                            <?php while ($rowSac = mysql_fetch_array($sqlSac)) { ?>
                                                <tr>
                                                    <td  class="cella1" ><?php echo($rowSac['num_sacchetti']) ?></td>
                                                    <?php
                                                    $NSac++;
                                                }//fine while sacchetti
                                                ?> 
                                                </tr>
                                        </table> 
                                        <?php
                                        $NPar++;
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="cella2" style="text-align: right " colspan="3">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla?>"/>
<!--                                    <input type="button" onclick="javascript:Aggiorna();" value="AGGIORNA" />-->
                                    <input type="button" onclick="javascript:Carica();" value="<?php echo $valueButtonSalva ?>" />
                                </td>
                            </tr>  
                        </table> 
                    </form>
                </div>
                <?php
            }//end aggiornamento
            ?> 

        </div><!--mainContainer-->

    </body>
</html>
