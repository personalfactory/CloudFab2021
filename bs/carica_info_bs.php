<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>

        <script language="javascript" type="text/javascript">
            if(history.length>0)history.forward();
            
            function BloccaTastoInvio(evento)
            {
                codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
                if (codice_tasto == 13)
                {
                    event.returnValue = false;
                }
            }
            
            //In questo modo evito che la pagina venga refreshata dal pulsante del browser o tasto f5
            //e sblocco il refresc solo quando eseguo la funzione AggiornaPagina()
            var _canRefresh = true;
            window.setInterval('_canRefresh && location.reload( );', 600000);
            
            function AggiornaPagina() {
                _canRefresh = false;
                document.forms["CaricaCrm"].action = "carica_info_bs.php";
                document.forms["CaricaCrm"].submit();
            }

            function Salva() {
                document.forms["CaricaCrm"].action = "salva_info_bs.php";
                document.forms["CaricaCrm"].submit();
            }

        </script>
    </head>
    <?php
    include('../Connessioni/serverdb.php');
    include('../include/precisione.php');
    include('../sql/script_componente.php');
    include('../sql/script_bs_valore_dato.php');
    include('../sql/script_bs_dato.php');
    include('../sql/script_bs_cliente.php');
    include('../sql/script_bs_comp_cliente.php');
    include('../include/gestione_date.php');

    //######################################################################
    if ($DEBUG)
        ini_set('display_errors', '1');

    //###### VERIFICA PERMESSI #################################################
    $actionOnLoad = "";
    $elencoFunzioni = array("129"); //AGGIUNGERE FUNZIONALITA 
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    $strUtentiAziendeComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
    $strUtentiAziendeDatiBs = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_dato');

    //Sapendo l'id dell'utente corrente vado a cercare nella tabella bs_cliente
    //l'id del cliente in modo da recuperare e visualizzare solo i suoi dati.
    //1)Se si vuole rivedere e modificare una simulazione esistente
    //si selezionano i dati dalle tabelle bs_valori_dati e bs_componenti    
    //2)Se si vuole creare una nuova simulazione si leggono i valori di default dalla tabella bs_dati
    //e componenti-materia_prima
//    $_SESSION['Anno'] = "";
    $_SESSION['NumSimulazione'] = "";

    //##################### SIMULAZIONE ESISTENTE ##########################
    if (isSet($_GET['IdCliente']) AND isSet($_GET['Anno']) AND isSet($_GET['IdAzienda'])) {

        //Se si arriva nella pagina dal link di gestione info bs
        $_SESSION['id_cliente'] = $_GET['IdCliente'];
        $_SESSION['Anno'] = $_GET['Anno'];
        $_SESSION['id_azienda'] = $_GET['IdAzienda'];
        $_SESSION['TODO_bs'] = "MODIFY";
    }

    //##################### NUOVA SIMULAZIONE ##############################
    if ($_SESSION['TODO_bs'] == "NEW"
            AND isSet($_POST['Cliente']) AND isSet($_POST['Anno'])
    ) {

        if (isSet($_POST['Azienda'])) {
            list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
            $_SESSION['id_azienda'] = $IdAzienda;
        }
        if (isSet($_POST['Cliente'])) {
            list($IdCliente, $Nominativo) = explode(';', $_POST['Cliente']);
            $_SESSION['id_cliente'] = $IdCliente;
        }
        if (isSet($_POST['Anno']))
            $_SESSION['Anno'] = $_POST['Anno'];
    }
//    echo "<br/>SESSION Anno : " . $_SESSION['Anno'];
//    echo "<br/>SESSION Nominativo : " . $_SESSION['Nominativo'];
//    echo "<br/>SESSION id_azienda : " . $_SESSION['id_azienda'];
//    echo "<br/>SESSION id_cliente : " . $_SESSION['id_cliente'];

    //##########################################################################
    //Se il cliente aveva già impostato i dati di input in una precedente simulazione 
    //allora gli vengono mostrati questi ultimi 
    //Altrimenti vengono visualizzati i dati di default
    $sqlDati = findValoriDatiByCliente($_SESSION['id_cliente'], "ordine", $_SESSION['lingua']);

    if (mysql_num_rows($sqlDati) == 0) {
        $_SESSION['NumSimulazione'] = 1; //si tratta della prima simulazione
//            echo "<br/>Prima simulazione --- recupero dati default<br/>";
        $sqlDati = "";
        $sqlDati = findDatiDefaultBs("ordine", $strUtentiAziendeDatiBs, "inserito");
    }


    $sqlComponente = findCompClienteUnionNewComp("descri_componente", $_SESSION['id_cliente'], $strUtentiAziendeComp, $_SESSION['lingua'], $valAbilitato);
    //TO DO :se sono stati aggiunti prodotti di conseguenza potrebbere essere stati 
    //aggiunti nuovi componenti non presenti nella tabella bs_comp_cliente
    //bisogna visualizzarli
    if (mysql_num_rows($sqlComponente) == 0) {
        //Vuol dire che si tratta della prima simulazione
        //quindi vengono caricati i prezzi di default
        $_SESSION['NumSimulazione'] = 1;
        $sqlComponente = 0;
        $sqlComponente = findComponentiEPrezzo("descri_componente", $strUtentiAziendeComp);
    }

    $_SESSION['nome_cliente_bs'] = "";
    //Recupero il nominativo del cliente da visualizzare
    $sqlNomeCliente = findClienteBsById($_SESSION['id_cliente']);
    while ($rowNome = mysql_fetch_array($sqlNomeCliente)) {

        $_SESSION['nome_cliente_bs'] = $rowNome['nominativo'];
    }

//##################################################################
//################### GESTIONE VALUTA ##############################
//##################################################################
    $_SESSION['aggPagDatiInput'] ++;
//Mi conservo in una variabile la valuta e il cambio iniziale al primo caricamento della pagina
    if ($_SESSION['aggPagDatiInput'] == 1) {

        $_SESSION['valutaIniziale'] = $_SESSION['valutaBs'];
        $_SESSION['cambioIniziale'] = $_SESSION['cambio'];
        $_SESSION['aggCambio'] = 0;
    }
    //Conta il numero di volte che si cambia la valuta
    $cambioValuta = 0;
    if (isset($_POST['valutaBs'])) {

        foreach ($_POST['valutaBs'] as $key => $value) {

            $valutaBsPost = $key;
        }

        if ($valutaBsPost != $_SESSION['valutaBs']) {
            $cambioValuta = 1;
            $_SESSION['aggCambio'] ++;
        }

        $_SESSION['valutaBs'] = $valutaBsPost;
    }
    if (isSet($_SESSION['valutaBs'])) {
        switch ($_SESSION['valutaBs']) {
            case 1:
                $_SESSION['filtro'] = "filtroEuro";
                break;
            case 2:
                $_SESSION['filtro'] = "filtroDollaro";
                break;
        }
    }
    $filtroValuta = "{${$_SESSION['filtro']}}";

    //Stabilisce se le valute vanno moltiplicate o divise per il cambio 
    //a seconda della valuta iniziale e del numero di volte che si aggiorna la pagina    
    if ($_SESSION['valutaIniziale'] == 1) {
        //se agg pagina è dispari moltiplico e se è pari divido per il cambio
        ( $_SESSION['aggCambio'] & 1 ) ? $oper = "*" : $oper = "/";
        if ($_SESSION['aggCambio'] == 0)
            $oper = "*";
    } else {
        //se agg pagina è dispari divido e se è pari moltiplico per il cambio
        ( $_SESSION['aggCambio'] & 1 ) ? $oper = "/" : $oper = "*";
        if ($_SESSION['aggCambio'] == 0)
            $oper = "*";
    }

//    echo "<br/>cambioValuta: " . $cambioValuta;
//    echo "<br/>aggCambio: " . $_SESSION['aggCambio'];
//    echo "<br/>aggPagDatiInput: " . $_SESSION['aggPagDatiInput'];
//    echo "<br/>valutaIniziale: " . $_SESSION['valutaIniziale'];
//    echo "<br/>valutaAttuale: " . $_SESSION['valutaBs'];
//    echo "<br/>cambio: " . $_SESSION['cambio'];
//    echo "<br/>filtro: " . $_SESSION['filtro'];


//#########################################################################
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>;">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:60%; margin:15px auto;" > 
                <form id="CaricaCrm" name="CaricaCrm" method="POST">
                    <?php
                    //Scelta valuta
                    include('../include/scelta_valuta.php');
                    ?><br/><br/><br/>
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2" ><?php echo $titoloPaginaDatiInput ?></td>
                        </tr> 
                        <tr>
                            <td class="cella2" colspan="2" ><?php echo $filtroAnnoRif . ": <span style='font-size: 20px'>" . $_SESSION['Anno'] . "</span> &nbsp;&nbsp;&nbsp;&nbsp;" . $filtroCliente . ": <span style='font-size: 20px'>" . $_SESSION['nome_cliente_bs'] . "</span>" ?></td>
                        </tr> 

                        <?php
                        while ($rowDati = mysql_fetch_array($sqlDati)) {
                            $valoreDato = $rowDati['valore'];
                            if (isSet($_POST[$rowDati["nome_dato"]]))
                                $valoreDato = $_POST[$rowDati["nome_dato"]];
                            ?>
                            <tr>
                                <td class="cella1" width="60%" ><?php echo $rowDati['nome_visibile_' . $_SESSION['lingua']] ?>

                                    <?php if ($rowDati['nome_dato'] == 'CostoTrasporto') { ?>
                                        &nbsp;&nbsp;
                                        <a class="thumbnail" href="#" >
                                            <img  src="/CloudFab/images/icone/lente_piccola.png" />
                                            <div style="width:350px;text-align:left"><?php echo $filtroNoteCostoTrasporto ?></div></a></td> 

                                    <?php
                                } if ($rowDati['tipo1'] == "valuta") {

                                    if ($cambioValuta || $_SESSION['aggPagDatiInput'] == 1) {
                                        $valoreDato = $valoreDato . $oper . $_SESSION['cambio'];
                                        eval("\$valoreDato = $valoreDato;");
                                    }
                                    ?>

                                    <td class="cella1" width="40%"><input  type="text" onkeypress="BloccaTastoInvio(event)" style="text-align:right;width:50%" name="<?php echo $rowDati['nome_dato'] ?>"  value="<?php echo number_format($valoreDato, '2', '.', '') ?>"/>&nbsp;<?php echo $filtroValuta ?></td>
                                </tr>                                 
                            <?php } else { ?>

                                <td class="cella1" width="40%"><input type="text" onkeypress="BloccaTastoInvio(event)" style="text-align:right;width:50%" name="<?php echo $rowDati['nome_dato'] ?>"  value="<?php echo $valoreDato ?>"/>&nbsp;<?php echo $rowDati['uni_mis'] ?></td>
                                </tr>  
                                <?php
                            }
                        }
                        ?>                                                    


                    </table>
                    <table width="100%"> 
                        <tr>
                            <td class="cella3" width="60%"><?php echo $filtroMaterieDrymix ?></td>
                            <td class="cella3" width="40%"><?php echo $filtroCosto . " " . $filtroKgBreve ?></td>
                        </tr> 
                        <?php
//TODO : creare un array di oggetti materia prima e poi leggerli dall'oggetto 
//Visualizzo i campi di input relativi alle materie prime presenti nella tabella materia_prima
                        $N = 1;
                        while ($rowMatPrime = mysql_fetch_array($sqlComponente)) {
                            //Inizio prezzo
                            //Visualizzo il costo unitario delle materie prime
                            $CostoUnitarioKg = $rowMatPrime['pre_acq'];

                            if (isSet($_POST['CostoComp' . $rowMatPrime['id_comp']]))
                                $CostoUnitarioKg = $_POST['CostoComp' . $rowMatPrime['id_comp']];

                            if ($cambioValuta || $_SESSION['aggPagDatiInput'] == 1) {
                                $CostoUnitarioKg = $CostoUnitarioKg . $oper . $_SESSION['cambio'];
                                eval("\$CostoUnitarioKg = $CostoUnitarioKg;");
                            }
                            $CostoUnitarioKg = number_format($CostoUnitarioKg, 4, '.', '');
                            ?> <tr>
                                <td class="cella2" width="60%"><?php echo($rowMatPrime['descri_componente']) ?></td>
                                <td class="cella2" width="40%"><input  onkeypress="BloccaTastoInvio(event)" type="text" style="text-align:right;width:50%" name="CostoComp<?php echo ($rowMatPrime['id_comp']); ?>" id="CostoComp<?php echo ($rowMatPrime['id_comp']); ?>" value="<?php echo $CostoUnitarioKg ?>"/> <?php echo $filtroValuta ?>
                                </td>
                                </td>
                            </tr>
                            <?php
                            $N++;
                        }//End While materie prime 
                        ?>

                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="location.href='carica_bs.php'"/>
                                <input type="button" name='129' value="<?php echo $valueButtonConferma ?>" onclick="Salva()"/></td></tr>
                    </table>
                </form>
            </div>

            <div id="msgLog">

            </div>
        </div><!--mainContainer-->

    </body>


</html>

