<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            ini_set(display_errors, "1");
            include('../include/menu.php');
            ?>

            <div id="container" style=" width:600px; margin:15px auto;">

                <form class="form" id="AssociaCategoria" name="AssociaCategoria" method="post" action = "associa_categoria_parametri2.php">
                    <table width="600px">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $msgAssociaCatAParametri ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCategoria ?></td>
                            <td class="cella1">
                                <select name="Categoria" id="Categoria" >
                                    <option value="0" selected><?php echo $labelOptionCatDefault ?></option>
                                    <?php
                                    include('../Connessioni/serverdb.php');
                                    include('../sql/script_categoria.php');
                                    include('../sql/script_parametro_prodotto.php');
                                    /*
                                      $sqlCat = mysql_query("SELECT * FROM categoria
                                      WHERE
                                      id_cat NOT IN (SELECT id_cat FROM valore_par_prod)
                                      ORDER BY nome_categoria")
                                      or die("Errore 112: " . mysql_error());
                                     */
                                    $sqlCat = findCategoriaWhereIdCatNotIn();
                                    while ($rowCat = mysql_fetch_array($sqlCat)) {
                                        ?>
                                        <option value="<?php echo($rowCat['id_cat']) ?>"><?php echo($rowCat['nome_categoria']) ?></option>
<?php } ?>
                                </select>
                        </tr>

                        <tr>
                            <td colspan="2" class="cella3"><?php echo $titoloPaginaParProdotto ?> </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPar ?></td>
                            <td class="cella2"><?php echo $filtroValoreBase ?></td>
                        </tr>
                        <?php
                        //Visualizzo l'elenco dei parametri presenti nella tabella parametro_prodotto e consento di digitare un valore per ciascun parametro
                        $NComp = 1;
                        /*
                          $sqlParametro = mysql_query("SELECT * FROM parametro_prodotto ORDER BY nome_variabile")
                          or die("Errore 113: " . mysql_error());
                         */
                        $sqlParametro = findAllParametroProdottoOrderByNome();
                        while ($rowParametro = mysql_fetch_array($sqlParametro)) {
                            ?>
                            <tr>
                                <td class="cella4" > <?php echo($rowParametro['nome_variabile']) ?></td>
                                <td  class="cella1"><input type="text" name="Valore<?php echo($NComp); ?>" id="Valore<?php echo($rowParametro['id_par_prod']); ?>" value="<?php echo($rowParametro['valore_base']); ?>"></td>
                            </tr>

                            <?php
                            $NComp++;
                        }
                        ?>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit"  value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>  
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
