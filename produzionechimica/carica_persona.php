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
            //           include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_persona.php');
            include('../sql/script.php');

            if ($DEBUG)
                ini_set(display_errors, "1");
            $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'persona');

            $HrefBack = $_GET['HrefBack'];

            begin();
            $sqlTipo = findAllTipoPersona();
            commit();
            ?>
            <script language="javascript" type="text/javascript">

                function controllaCampi(msgErrTipo, msgErroreNome) {

                    var rv = true;
                    var msg = "";



                    if (document.getElementById('TipoEs').value === "" && document.getElementById('TipoNu').value === "") {
                        rv = false;
                        msg = msg + ' ' + msgErrTipo;
                    }

                    if (document.getElementById('Nome').value === "") {
                        rv = false;
                        msg = msg + ' ' + msgErroreNome;
                    }

                    if (!rv) {
                       
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }


                function Salva() {

                    document.forms["InserisciPersona"].action = "carica_persona2.php";
                }



                //Funzioni per la visualizzazione del form relativo al sottotipo
                function visualizzaListBoxTipoEsistente() {
                    document.getElementById("TipoEs").style.visibility = "visible";
                    document.getElementById("TipoNu").style.visibility = "hidden";

                }
                function visualizzaFormNuovoTipo() {
                    document.getElementById("TipoEs").style.visibility = "hidden";
                    document.getElementById("TipoNu").style.visibility = "visible";

                }
            </script>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciPersona" name="InserisciPersona" method="post" onsubmit="return controllaCampi('<?php echo $msgErrTipo ?>', '<?php echo $msgErroreNome ?>')" >
                    <table width="100%">
                        <input type="hidden" name="HrefBack" value="<?php echo $HrefBack ?>"/>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovaPersona ?></td>
                        </tr>


                        <tr>
                            <td class="cella4"><?php echo $filtroLabTipo ?></td>
                            <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaListBoxTipoEsistente();" value="TipoEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                        <td class="cella1">
                                            <div id="TipoEsistente" >
                                                <select id="TipoEs" name="TipoEs">
                                                    <option value="" selected=""><?php echo $labelOptionSelectTipoEs ?></option>
                                                    <?php while ($rowSTipo = mysql_fetch_array($sqlTipo)) { ?>
                                                        <option value="<?php echo($rowSTipo['tipo']) ?>"><?php echo($rowSTipo['tipo']) ?></option>
<?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleLabDigitaNomeTipo ?>">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormNuovoTipo();" value="TipoNu" /><?php echo $filtroLabNuovo ?></td>
                                        <td class="cella1">
                                            <div id="TipoNuovo" style="visibility:hidden;">
                                                <input type="text" name="TipoNu" id="TipoNu" size="50" title="<?php echo $titleLabDigitaNomeTipo ?>"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroNominativo ?> </td>
                            <td class="cella1"><input type="text" name="Nome" id="Nome" size="50" style="text-transform: uppercase;"/></td>
                        </tr>

                        <tr>
                            <td class="cella4"><?php echo $filtroDescrizione ?> </td>
                            <td class="cella1"><input type="text" name="Descrizione" id="Descrizione" size="50"/></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabData ?></td>
                            <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
                                    <?php
                                    //Si selezionano solo le aziende che l'utente ha il permesso di editare
                                    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                        if ($idAz != $_SESSION['id_azienda']) {
                                            ?>
                                            <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                        </tr>
                    </table>
                </form>
            </div>



        </div><!--mainContainer-->

    </body>
</html>
