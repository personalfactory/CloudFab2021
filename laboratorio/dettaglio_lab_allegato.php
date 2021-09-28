<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function disabilitaOperazioni() {
            //CASO: NESSUN PERMESSO DI SCRITTURA            
            for (i = 0; i < document.getElementsByName('EliminaAllegato').length; i++) {
                document.getElementsByName('EliminaAllegato')[i].removeAttribute('href');
            }
        }
    </script>

    <?php
    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('./sql/script.php');
    include('sql/script_lab_allegato.php');

    if ($DEBUG) ini_set(display_errors, "1");


    $IdRif = $_GET['IdRif'];
    $IdCaratteristica = $_GET['IdCarat'];
    $NomeCar = $_GET['NomeCar'];
    $TipoRif = $_GET['TipoRif'];
    $nomeTabCar = "";
    //Salvo il percorso per il redirect dopo l'eliminazione 
    //dell'associazione fra caratteristica e allegato
    $RefBack = $_GET['RefBack'];


    $actionOnLoad = "";
    $permessoModifica = 0;

    $sql = "";
    if ($TipoRif == $valRifMateriaPrima) {

        $nomeTabCar = "lab_caratteristica_mt";

        include('sql/script_lab_materie_prime.php');
        //Cerco l'utente proprietario della materia prima con allegato
        $sql = findMatPrimaById($IdRif);

        //#############################################################
    } else if ($TipoRif == $valRifEsperimento) {
        $nomeTabCar = "lab_caratteristica";
        include('sql/script_lab_esperimento.php');
        //Cerco l'utente proprietario dell'esperimento con allegato
        $sql = findEsperimentoById($IdRif);
    }

    
    //####################### QUERY AL DB ##############################
    begin();
    $sqlFile = findAllegatiByIdRifCar($IdRif, $IdCaratteristica, $TipoRif, $nomeTabCar);
    commit();

    while ($row = mysql_fetch_array($sql)) {

        $IdUtenteProp = $row['id_utente'];
        $IdAzienda = $row['id_azienda'];
    }
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad="";
    //Il permesso di editare/cancellare l'allegato si verifica sulla tabella 
    //lab_caratteristica se si tratta di un allegato ad una caratteristica 
    //di un esperimento altrimenti sulla tabella lab_caratteristica_mt 
    //se si tratta di un allegato ad una caratteristica di una materia prima
    $arrayTabelleCoinvolte = array($nomeTabCar);
    if ($IdUtenteProp != $_SESSION['id_utente']) {

        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        if ($DEBUG)
            echo "</br>Eseguita verifica permesso di tipo 3";
        $actionOnLoad = verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
    }

 
    //######################################################################
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
<?php include('../include/menu.php'); ?>
            <div id="container" style="width:90%; margin:15px auto;">
                <form id="DettaglioLabAllegato" name="DettaglioLabAllegato">
                    <!--############################################################################
                    ########################### FILE ALLEGATI ALLA CARATTERISTICA  #################
                    ##############################################################################-->
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="5"><?php echo $titoloPaginaAllegatiCar . " : " . $NomeCar ?></td>
                        </tr>
                        <tr>
                            <th  class="cella4" width="360px"><?php echo $filtroLabAllegato ?></th>
                            <th  class="cella4" width="200px"><?php echo $filtroDescriFile ?></th>
                            <th  class="cella4" width="300px"><?php echo $filtroNote ?></th>
                            <th  class="cella4" width="150px"><?php echo $filtroLabDataCaricamento ?></th>
                            <th  class="cella4" width="60px"></th>
                        </tr>
                        <?php
                        $NFile = 1;
                        while ($rowFile = mysql_fetch_array($sqlFile)) {
                            ?>		
                            <tr>
                                <td class="cella1" width="360px"><?php echo $rowFile['link'] ?></a></td>
                                <td class="cella1" width="200px"><?php echo $rowFile['descri'] ?></td>
                                <td class="cella1" width="300px"><?php echo $rowFile['note'] ?></td>
                                <td class="cella1" width="150px"><?php echo $rowFile['data_caricato'] ?></td>
                                <td class="cella1" width="80px" >                                   
                                    <a target="_blank" href="<?php echo $sourceLabDownloadDir . $rowFile['link'] ?>">
                                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleVediAllegato ?>"/></a>
    <!--                                       <a href="elimina_lab_dato.php?Tabella=lab_allegato&IdRecord=<?php echo $rowFile['id'] ?>&NomeId=id&RefBack=<?php echo $RefBack ?>">
                                            <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/>-->

                                    <a name="EliminaAllegato" href="cancella_lab_allegato.php?nome_file=<?php echo $rowFile['link'] ?>&idRif=<?php echo $IdRif ?>&idCar=<?php echo $IdCaratteristica ?>&tipoRif=<?php echo $TipoRif ?>&RefBack=<?php echo $RefBack ?>">
                                        <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $NFile++;
                        }
                        ?>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="5">
                                <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="javascript:history.back();"/>
                            </td>
                        </tr>
                    </table>    
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
