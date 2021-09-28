<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>    
    <script language="javascript" type="text/javascript">

        function controllaCampi(msgErrCodice, msgErrValoreNumerico, filtroScortaMinima, filtroGiacenzaIniziale) {

            var rv = true;
            var msg = "";

            if (document.getElementById('ScortaMinima').value !== "" & isNaN(document.getElementById('ScortaMinima').value)) {
                rv = false;
                msg = msg + ' ' + filtroScortaMinima + ' ' + msgErrValoreNumerico;
            }

            if (!rv) {
                alert(msg);
                rv = false;
            }
            return rv;
        }

        function Salva() {

            document.forms["InserisciMateria"].action = "carica_materia2.php";
        }

        //Funzioni per la visualizzazione del form relativo al tipo di mt
        function visualizzaFormMtCompound() {
            document.getElementById("Compound").style.visibility = "visible";
            document.getElementById("CodDrymix").style.visibility = "hidden";

        }
        function visualizzaFormMtDrymix() {
            document.getElementById("Compound").style.visibility = "hidden";
            document.getElementById("CodDrymix").style.visibility = "visible";
        }
        function redirectAvvisoPermessoNegato() {
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }
        
        function Ricerca() {
            document.forms["InserisciMateria"].action = "carica_materia.php";
            document.forms["InserisciMateria"].submit();
        }
    </script>
    <body>
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set(display_errors, 1);

            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../sql/script.php');
            include('../sql/script_persona.php');
            include('../sql/script_materia_prima.php');

            //############ STRINGA UTENTI E AZIENDE VIS ########################
            $strUtentiAziendeLabMat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');

            $_SESSION['Codice'] = "";
            $_SESSION['Descrizione'] = "";
            if (isset($_POST['Codice']) AND $_POST['Codice'] != "") {
                $_SESSION['Codice'] = trim($_POST['Codice']);
            }
            if (isset($_POST['Descrizione']) AND $_POST['Descrizione'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }



            begin();
//            $sqlForn = findPersoneByTipo("FURNISHER", "nominativo", $strUtentiVisPer, $strAziendeVisPer);
//                    selectPersoneByTipo("FURNISHER", "nominativo");
            $sqlMtLab = findAllLabMatNotInProd($prefissoCodComp, $strUtentiAziendeLabMat, $_SESSION['Codice'], $_SESSION['Descrizione']);
            commit();
            ?>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciMateria" name="InserisciMateria" method="post" onsubmit="return controllaCampi('<?php echo $msgErrCodice ?>', '<?php echo $msgErrValoreNumerico ?>', '<?php echo $filtroScortaMinima ?>', '<?php echo $filtroGiacenzaIniziale ?>')" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovaMatPrima ?></td>
                        </tr>
                        <tr>
                            <td class="cella1center"colspan="2" >
                                <input type="text" name="Codice" value="<?php echo $_SESSION['Codice'] ?>" placeholder="<?php echo $filtroRicercaPerCodice ?>" onChange="Ricerca();"/>
                                <input type="text" name="Descrizione" value="<?php echo $_SESSION['Descrizione'] ?>" placeholder="<?php echo $filtroRicercaPerNome ?>" onChange="Ricerca();"/>
                                <input type="reset" value="<?php echo $filtroApplicaFiltri ?>" onClick="Ricerca();"/>
                               
                            </td>
                        </tr>
                        <tr>
                           
                            <td class="cella1center" colspan="2"> 
                                <select  name="MatPrima" id="MatPrima">
                                    <option value="" selected=""><?php echo $labelOptionSelectMatPri ?></option>
                                    <?php
                                    while ($rowMtLab = mysql_fetch_array($sqlMtLab)) {
                                        ?>
                                        <option value="<?php echo $rowMtLab["id_mat"] ?>" ><?php echo $rowMtLab["cod_mat"] . " " . $rowMtLab["descri_materia"] ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella1"><?php echo $filtroUniMisura ?></td>
                            <td class="cella1"><?php echo $filtroKg ?></td>
                        </tr>
                        <tr>
                            <td class="cella1"><?php echo $filtroScortaMinima ?></td>
                            <td class="cella1"><input type="text" name="ScortaMinima" id="ScortaMinima" title="<?php echo $titleScortaMinima ?>"/><?php echo $filtroKgBreve ?></td>
                        </tr>

                        <tr>
                            <td class="cella1"><?php echo $filtroNote ?> </td>
                            <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella1"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                        </tr>

                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:location.href='gestione_materie_prime.php'"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella lab_materie_prime: utenti e aziende visibili " . $strUtentiAziendeLabMat;
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
