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

        $IdValPar = $_GET['IdValPar'];

//Visualizzo le informazioni del parametro che intendo modificare all'interno della form
//Estraggo il parametro da modificare dalla tabella valore_par_sacchetto
        include('../Connessioni/serverdb.php');
        include('../sql/script_valore_par_sacchetto.php');
        
        /*
        $sqlParametro = mysql_query("SELECT
                                    valore_par_sacchetto.id_val_par_sac,
                                    valore_par_sacchetto.id_par_sac,
                                    parametro_sacchetto.nome_variabile,
                                    parametro_sacchetto.descri_variabile,
                                    parametro_sacchetto.valore_base,
                                    parametro_sacchetto.dt_abilitato
                            FROM
                                    valore_par_sacchetto
                            INNER JOIN parametro_sacchetto 
                                    ON valore_par_sacchetto.id_par_sac = parametro_sacchetto.id_par_sac
                            WHERE 
                                    valore_par_sacchetto.id_val_par_sac=" . $IdValPar)
                or die("Errore 112: " . mysql_error());
        */
        $sqlParametro = selectValoreParSacById($IdValPar);

        while ($rowPar = mysql_fetch_array($sqlParametro)) {
            $IdParametro = $rowPar['id_par_sac'];
            $NomeParametro = $rowPar['nome_variabile'];
            $DescriVariabile = $rowPar['descri_variabile'];
            $ValoreBase = $rowPar['valore_base'];
            $Data = $rowPar['dt_abilitato'];
        }
        ?>

         <div id="container" style=" width:800px; margin:15px auto;">

            <form class="form" id="ModificaValore" name="ModificaValore" method="post" action="modifica_valore_par_sac2.php">
                <table width="100%">
                    <tr>
                        <td class="cella3" colspan="2"><?php echo $titoloPaginaModificaParSac ?></td>
                    </tr>
<!--                    <tr>
                        <td class="cella2">ID VALORE</td>
                        <td class="cella1"><?php echo $IdValPar; ?></td>
                    </tr>-->
                     <input type="hidden" name="IdValPar" id="IdValPar" value=<?php echo $IdValPar; ?>></input>
                    <tr>
                        <td class="cella2"><?php echo $filtroIdPar ?></td>
                        <input type="hidden" name="IdParametro" id="IdParametro" value=<?php echo $IdParametro; ?>></input>
                        <td class="cella1"><?php echo $IdParametro; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroPar ?></td>
                        <td class="cella1"><?php echo $NomeParametro; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroDescrizione ?></td>
                        <td class="cella1"><?php echo $DescriVariabile; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroValoreBase ?></td>
                        <td class="cella1"><?php echo $ValoreBase; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroDt ?></td>
                        <td class="cella1"><?php echo $Data; ?></td>
                    </tr>
                </table>
                 <table width="100%">
                    <tr>
                        <td class="cella3"><?php echo $filtroCategorie ?></td>
                        <td class="cella3"><?php echo $filtroSolInsacco ?></td>
                    </tr>

<?php
//Visualizzo l'elenco delle categorie associate al parametro selezionato, presenti nella tabella [valore_par_sacchetto]
$NCat = 1;
$NSac = 1;
/*
$sqlCat = mysql_query("SELECT 
                            categoria.nome_categoria,
                            valore_par_sacchetto.id_cat
                        FROM
                                    valore_par_sacchetto
                        INNER JOIN categoria 
                        ON 
                                valore_par_sacchetto.id_cat = categoria.id_cat
                        WHERE 
                                valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                        GROUP BY 
                                categoria.nome_categoria
                        ORDER BY 
                                categoria.nome_categoria")
        or die("Errore 113: " . mysql_error());
*/
$sqlCat = selectNomeIdCatByIdPar($IdParametro);

while ($rowCat = mysql_fetch_array($sqlCat)) {
    ?>

    <tr>
        <td class="cella2"><?php echo($rowCat['nome_categoria']) ?></td>

    <?php
    //Per ogni categoria visualizzo num_sacchetti, sacchetto e valore e dt_abilitato presenti nella tabella [valore_par_sacchetto]
    /*
    $sqlValSac = mysql_query("SELECT 
                                    valore_par_sacchetto.sacchetto,
                                    num_sacchetto.num_sacchetti,
                                    valore_par_sacchetto.valore_variabile,
                                    valore_par_sacchetto.dt_abilitato
                                FROM
                                    valore_par_sacchetto
                                INNER JOIN
                                        num_sacchetto
                                        ON
                                                valore_par_sacchetto.id_num_sac=num_sacchetto.id_num_sac
                                WHERE 
                                    valore_par_sacchetto.id_par_sac=" . $IdParametro . "
                                    AND
                                    valore_par_sacchetto.id_cat=" . $rowCat['id_cat'] . "
                                ORDER BY 
                                        num_sacchetto.num_sacchetti, valore_par_sacchetto.sacchetto")
            or die("Errore 115: " . mysql_error());
      */      
     $sqlValSac = selectValoreByIdParAndIdCat($IdParametro, $rowCat['id_cat']);
     
    ?>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <tr>
                                            <td class="cella2" title="Numero totale di sacchetti di una soluzione"><?php echo $filtroSol?></td>
                                            <td class="cella2" title="Numero del sacchetto"><?php echo $filtroSac?></td>
                                            <td class="cella2" title="Valore del parametro in relazione al numero del sacchetto"><?php echo $filtroValore?></td>
                                            <td class="cella2" title="Data di ultima modifica del valore"><?php echo $filtroDt?></td>
                                        </tr>
                                    </tr>
                                    <?php
                                    //Per ogni soluzione sacchetto visualizzo i valori di tutti i sacchetti correnti
                                    while ($rowValSac = mysql_fetch_array($sqlValSac)) {
                                        ?>

                                        <tr>
                                            <td class="cella1"><?php echo($rowValSac['num_sacchetti']) ?></td>
                                            <td class="cella1"><?php echo($rowValSac['sacchetto']) ?>&deg;</td>        
                                            <td class="cella1"><input type="text" name="Valore<?php echo $NSac; ?>" id="Valore<?php echo $NSac; ?>" value="<?php echo($rowValSac['valore_variabile']); ?>"/></td>
                                            <td class="cella1"><?php echo($rowValSac['dt_abilitato']) ?></td>
                                            <?php
                                            $NSac++;
                                        }//fine while sacchetti
                                        ?> 
                                    </tr>
                                </table> 
                            </td>
                        </tr>
                        <?php
                        $NCat++;
                    }//fine while categorie
                    ?>
                    </tr>
<?php include('../include/tr_reset_submit.php'); ?>
                </table>

            </form> 
        </div>
        </div>
    </body>
</html>
