<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            ini_set("display_errors", "1");
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_valore_par_sacchetto.php');

            $IdCategoria = 0;
            $NumSacchetti = 0;

            if (isSet($_GET['IdCategoria']) AND isSet($_GET['NumSacchetti'])) {

                $IdCategoria = $_GET['IdCategoria'];
                $NumSacchetti = $_GET['NumSacchetti'];
            }

            begin();
            $sqlCat = findCategoriaFromValParSac($IdCategoria);

            while ($rowCat = mysql_fetch_array($sqlCat)) {
                $NomeCategoria = $rowCat['nome_categoria'];
                $DescriCategoria = $rowCat['descri_categoria'];
                $Data = $rowCat['dt_abilitato'];
            }

            $sqlValori = selectValoriByIdCatNumSacchi($IdCategoria, $NumSacchetti);

            commit();
            ?>

            <div id="container" style=" width:80%; margin:15px auto;">

                <form class="form" id="ModificaSoluzioneInsacco" name="ModificaSoluzioneInsacco" method="post" action="manage_val_par_sacco2.php">
                    <input type="hidden" name="IdCategoria" id="IdCategoria" value=<?php echo $IdCategoria; ?>></input>
                    <input type="hidden" name="NumSacchetti" id="NumSacchetti" value=<?php echo $NumSacchetti; ?>></input>
                    <table width="100%">
                        <tr>
                            <td  class="cella3" colspan="2"><?php echo $titoloPaginaModificaCatSac ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroCategoria ?> </td>                            
                            <td class="cella1" ><?php echo $NomeCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDescrizione ?></td>
                            <td class="cella1" ><?php echo $DescriCategoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDt ?></td>
                            <td class="cella1" ><?php echo $Data; ?></td>
                        </tr>                        
                    </table>
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="5"><?php echo "SOLUZIONE " . $NumSacchetti . " SACCHI" ?> </td>
                        </tr>
                        <tr>
                            <td class="cella2" width="10%"><?php echo $filtroSac ?></td>
                            <td class="cella2" width="5%"><?php echo $filtroId ?></td>
                            <td class="cella2" width="30%"><?php echo $filtroPar ?></td>
                            <td class="cella2" width="20%" title="<?php echo $titleValParNumSac ?>"><?php echo $filtroValore ?></td>
                            <td class="cella2" width="20%" title="<?php echo $titleDtUltMod ?>"><?php echo $filtroDtUltimaMod ?></td>
                        </tr> <?php
                        $classeCella = "cella1";
                        while ($row = mysql_fetch_array($sqlValori)) {
                            switch ($row['tipo']) {
                                case "1":
                                    $classeCella = "cella1";
                                    break;
                                case "2":
                                    $classeCella = "cella2";
                                    break;
                                case "3":
                                    $classeCella = "cella1";
                                    break;
                                case "4":
                                    $classeCella = "cella2";
                                    break;
                                case "5":
                                    $classeCella = "cella1";
                                    break;
                                case "1-O4":
                                    $classeCella = "cella2";
                                    break;
                                case "3-O4":
                                    $classeCella = "cella1";
                                    break;
                                case "4-O4":
                                    $classeCella = "cella2";
                                    break;
                                case "5-O4":
                                    $classeCella = "cella1";
                                    break;
                                default:
                                    break;
                            }
                            ?>
                            <tr>
                                <td class="<?php echo $classeCella ?>" title="<?php echo $titleNumSacchetto ?>"><?php echo($row['sacchetto']) ?>&deg;</td>
                                <td class="<?php echo $classeCella ?>" ><?php echo ($row['id_par_sac']) ?></td>
                                <td class="<?php echo $classeCella ?>" title="<?php echo($row['descri_variabile']) ?>"><?php echo ($row['nome_variabile']) ?></td>
                                <td class="<?php echo $classeCella ?>" title="<?php echo $titleValParNumSac ?>"><input type="text" name="Valore<?php echo $row['id_val_par_sac']; ?>" id="Valore<?php echo $row['id_val_par_sac']; ?>" value="<?php echo($row['valore_variabile']); ?>"/></td>
                                <td class="<?php echo $classeCella ?>" title="<?php echo $titleDtUltMod ?>"><?php echo($row['dt_abilitato']) ?></td>
    <?php }
?> 
                        </tr>      

                        <tr>
                            <td class="cella2" style="text-align: right " colspan="5">
                                <input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                <input id="Salva" type="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>
                    </table>

                </form> 
            </div>

        </div><!--mainContainer-->

    </body>
</html>
