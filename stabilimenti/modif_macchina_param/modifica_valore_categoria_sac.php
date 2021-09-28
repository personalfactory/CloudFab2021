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
            include('../sql/script.php');
            include('../sql/script_valore_par_sacchetto.php');

           // echo "max_input_vars" . ini_get('max_input_vars') . "</br>";
            //echo "NEW post_max_size" . ini_get('post_max_size') . "</br>";

//Se è settata il GET della Categoria allora essa proviene 
//dalla pagina di modifica2 della categoria

            $IdCategoria = $_GET['IdCategoria'];
            //Visualizzo all'interno della form le informazioni della categoria contenute nel record che intendo modificare 
            //Estraggo la categoria da modificare dalla tabella valore_par_sacchetto
            begin();
            $sqlCat = findCategoriaFromValParSac($IdCategoria);

            while ($rowCat = mysql_fetch_array($sqlCat)) {
                $IdCategoria = $rowCat['id_cat'];
                $NomeCategoria = $rowCat['nome_categoria'];
                $DescriCategoria = $rowCat['descri_categoria'];
                $Data = $rowCat['dt_abilitato'];
            }
            $sqlPar = findParametriByCat($IdCategoria);
            ?>

            <div id="container" style=" width:900px; margin:15px auto;">

                <form class="form" id="ModificaValore" name="ModificaValore" method="post" action="modifica_valore_categoria_sac2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaModificaCatSac ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCategoria ?> </td>
                            <input type="hidden" name="IdCategoria" id="IdCategoria" value=<?php echo $IdCategoria; ?>></input>
                            <td class="cella1"><?php echo $NomeCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><?php echo $DescriCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDt ?></td>
                            <td class="cella1" title="Data di ultima modifica della categoria"><?php echo $Data; ?></td>
                        </tr>
                        <tr>
                            <td class="cella3"><?php echo $filtroParametri ?> </td>
                            <td class="cella3"><?php echo $filtroSolInsacco ?> </td>
                        </tr>
                        <?php
                        //Visualizzo l'elenco dei parametri associati alla categoria, 
                        //presenti nella tabella [valore_par_sacchetto]
                        $NPar = 1;
                        $NSac = 1;
                        //Per ogni parametro visualizzo num_sacchetti, sacchetto, valore 
                        //e dt_abilitato presenti nella tabella valore_par_sacchetto
                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                            $sqlValSac = findValSacByParCat($rowPar['id_par_sac'], $IdCategoria);
                            commit();
                            ?>
                            <tr>
                                <td class="cella2" title="<?php echo($rowPar['descri_variabile']) ?>"><?php echo($rowPar['nome_variabile']) ?></td>
                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td class="cella2" title="<?php echo $titleNumTotSacSol ?>"><?php echo $filtroSol ?></td>
                                            <td class="cella2" title="<?php echo $titleNumSacchetto ?>"><?php echo $filtroSac ?></td>
                                            <td class="cella2" title="<?php echo $titleValParNumSac ?>"><?php echo $filtroValore ?></td>
                                            <td class="cella2" title="<?php echo $titleDtUltMod ?>"><?php echo $filtroDt ?></td>
                                        </tr>
                                        <?php
                                        //Per ogni soluzione sacchetto visualizzo i valori di tutti i sacchetti correnti
                                        while ($rowValSac = mysql_fetch_array($sqlValSac)) {
                                            ?>
                                            <tr>
                                                <td class="cella1" title="<?php echo $titleNumTotSacSol ?>"><?php echo($rowValSac['num_sacchetti']) ?></td>
                                                <td class="cella1" title="<?php echo $titleNumSacchetto ?>"><?php echo($rowValSac['sacchetto']) ?>&deg;</td>        
                                                <td class="cella1" title="<?php echo $titleValParNumSac ?>"><input type="text" name="Valore<?php echo $NSac; ?>" id="Valore<?php echo $NSac; ?>" value="<?php echo($rowValSac['valore_variabile']); ?>"/></td>
                                                <td class="cella1" title="<?php echo $titleDtUltMod ?>"><?php echo($rowValSac['dt_abilitato']) ?></td>
                                                <?php
                                                $NSac++;
                                            }//fine while sacchetti
                                            ?> 
                                        </tr>
                                    </table> 
                                </td>
                            </tr>
                            <?php
                            $NPar++;
                        }//fine while categorie
                        mysql_close();
                        ?>
                        </tr>
<?php include('../include/tr_reset_submit.php'); ?>
                    </table>

                </form> 
            </div>

        </div><!--mainContainer-->

    </body>
</html>
