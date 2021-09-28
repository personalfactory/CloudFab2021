<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    //############# VERIFICA PERMESSO VISUALIZZAZIONE LISTA ####################
            $actionOnLoad = "";
            $elencoFunzioni = array("82");
            $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    
    ?>
    
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_categoria.php');
            include('../sql/script_valore_par_prod.php');

            
            
            $IdCategoria = $_GET['IdCategoria'];

            $sqlValore = selectNomeDescriCatById($IdCategoria);

            while ($rowValore = mysql_fetch_array($sqlValore)) {

                $NomeCategoria = $rowValore['nome_categoria'];
                $DescriCategoria = $rowValore['descri_categoria'];
                $Data = $rowValore['dt_abilitato'];
            }
            ?>
            <div id="container" style=" width:800px; margin:15px auto;">

                <form class="form" id="AssociaCategoriaPar" name="AssociaCategoriaPar" method="post" action="modifica_valore_categoria2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaModParProdotto ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCategoria ?></td>
                            <input type="hidden" name="IdCategoria" id="IdCategoria" value=<?php echo $IdCategoria; ?>></input>
                            <td class="cella1" title="<?php echo $DescriCategoria; ?>"><?php echo $NomeCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td class="cella3" ><?php echo $filtroId ?></td>
                            <td class="cella3" ><?php echo $filtroIdPar ?></td>
                            <td class="cella3" title=""><?php echo $filtroPar ?></td>
                            <td class="cella3" ><?php echo $filtroValore ?></td>
                            <td class="cella3" ><?php echo $filtroDtAbilitato ?></td>
                        </tr>   
                        <tr>
                            <?php
                            //Visualizzo l'elenco dei parametri presenti nella tabella valore_par_prod
                            $NPar = 1;
                            $sqlPar = selectValoreParByIdCat($IdCategoria);
                            while ($rowPar = mysql_fetch_array($sqlPar)) {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowPar['id_val_par_pr']) ?></td>
                                    <td class="cella4"><?php echo($rowPar['id_par_prod']) ?></td>
                                    <td class="cella4" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                    <td class="cella1"><nobr>
                                            <input type="text"style="width:50%" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" value="<?php echo($rowPar['valore_variabile']); ?>"/>
                                                <?php echo($rowPar['uni_mis']); ?>
                                            </nobr>
                                    
                                    </td>
                                    <td class="cella4"><?php echo($rowPar['dt_abilitato']) ?></td>
                                </tr>
                                <?php
                                $NPar++;
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="5">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" name="82" value="<?php echo $valueButtonSalva ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div><!--container-->

        </div><!--mainContainer-->
    </body>
</html>
