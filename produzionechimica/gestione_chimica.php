<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            //Nota sulla gestione utenti: Ancora non viene fatto alcun filtro sulle funzioni 
            //di questa pagine ma solo sulla voce di menù
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_chimica.php');
            include('../sql/script_lotto.php');

            if ($DEBUG) ini_set("display_errors", "1");

            $_SESSION['ToDo'] = 1;
            if (isset($_GET['ToDo'])) {
                $_SESSION['ToDo'] = $_GET['ToDo'];
            }
             //Calcolo l'anno ed il mese corrente
             $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }

            $_SESSION['CodProdotto'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['CodLotto'] = "";
            $_SESSION['CodChimica'] = "";
            $_SESSION['Data'] = "";
            $_SESSION['DtAbilitato'] = $annoCorrente;


            $_SESSION['CodProdottoList'] = "";
            $_SESSION['DescrizioneList'] = "";
            $_SESSION['CodLottoList'] = "";
            $_SESSION['CodChimicaList'] = "";
            $_SESSION['DataList'] = "";
            $_SESSION['DtAbilitatoList'] = "";


            // Impostiamo di default di mostrare x prima la pagina 1
            //e ordinare i risultati in base al cod_prodotto
            if (isset($_POST['page'])) {
                $_SESSION['pageNum'] = $_POST['page'];
            } else if (!isset($_POST['page']) AND !isset($_POST['Filtro'])) {
                $_SESSION['pageNum'] = 1;
                $_SESSION['Filtro'] = "cod_prodotto";
            }

            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
                //Se si modifica qualche filtro si riazzara la pagina 
            }
            if (isset($_POST['CodProdottoList']) AND $_POST['CodProdottoList'] != "") {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdottoList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['CodLotto'])) {
                $_SESSION['CodLotto'] = trim($_POST['CodLotto']);
            }
            if (isset($_POST['CodLottoList']) AND $_POST['CodLottoList'] != "") {
                $_SESSION['CodLotto'] = trim($_POST['CodLottoList']);
            }
            if (isset($_POST['CodChimica'])) {
                $_SESSION['CodChimica'] = trim($_POST['CodChimica']);
            }
            if (isset($_POST['CodChimicaList']) AND $_POST['CodChimicaList'] != "") {
                $_SESSION['CodChimica'] = trim($_POST['CodChimicaList']);
            }
            if (isset($_POST['Data'])) {
                $_SESSION['Data'] = trim($_POST['Data']);
            }
            if (isset($_POST['DataList']) AND $_POST['DataList'] != "") {
                $_SESSION['Data'] = trim($_POST['DataList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
           
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
           

            $rowsPerPage = 100;

            //Calcolo l' offset
            $offset = ($_SESSION['pageNum'] - 1) * $rowsPerPage;

            begin();
            $sql = "";
            switch (($_SESSION['ToDo'])) {
                case 1:
                    $titoloPagina=$titoloPaginaGestioneChimica;
                    $hrefToDo="gestione_chimica.php?ToDo=2";
                    $filtroLegendaLotti=$filtroLegendaLottiTutti;
                    $nomeClasse = "dataRigGray";
                    $nomeTitle = $msgInfoLottoNonAssociato;

                    $sql = findChimicaDisponibileByFiltri($offset, $rowsPerPage, $_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);

                    $sqlTot = findChimicaDisponibileByFiltriTot($_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);

                    $sqlProd = findChimicaDisponibileByFiltri("0", "1000000", "cod_prodotto", "cod_prodotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlDescri = findChimicaDisponibileByFiltri("0", "1000000", "descri_formula", "descri_formula", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlCodLot = findChimicaDisponibileByFiltri("0", "1000000", "cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlCodChim = findChimicaDisponibileByFiltri("0", "1000000", "cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlData = findChimicaDisponibileByFiltri("0", "1000000", "data", "data", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlDtAbil = findChimicaDisponibileByFiltri("0", "1000000", "dt_abilitato", "dt_abilitato", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
$totKitStandard='';
$totKitSfusa='';
                    break;

                case 2:
                    $titoloPagina=$titoloPaginaGestioneChimica2; 
                    
                    $filtroLegendaLotti=$filtroLegendaLottiDisponibili;
                    $hrefToDo="gestione_chimica.php?ToDo=1";
                    $nomeClasse = "dataRigWhite";
                    $nomeTitle = $msgInfoLottoAssociato;

                    
                    $sql = findChimicaByFiltriTot($_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    
                    $sqlTot = findChimicaByFiltriTot($_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    
                    $sqlProd = findChimicaByFiltriTot("cod_prodotto", "cod_prodotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlDescri = findChimicaByFiltriTot("descri_formula", "descri_formula", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlCodLot = findChimicaByFiltriTot("cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlCodChim = findChimicaByFiltriTot("cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlData = findChimicaByFiltriTot("data", "data", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    $sqlDtAbil = findChimicaByFiltriTot("dt_abilitato", "dt_abilitato", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    
                    
//                    $sql = findChimicaByFiltri($offset, $rowsPerPage,$_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    
//                    $sqlTot = findChimicaByFiltriTot($_SESSION['Filtro'], "cod_chimica", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    
//                    $sqlProd = findChimicaByFiltri("0", "1000000","cod_prodotto", "cod_prodotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    $sqlDescri = findChimicaByFiltri("0", "1000000","descri_formula", "descri_formula", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    $sqlCodLot = findChimicaByFiltri("0", "1000000","cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    $sqlCodChim = findChimicaByFiltri("0", "1000000","cod_lotto", "cod_lotto", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    $sqlData = findChimicaByFiltri("0", "1000000","data", "data", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
//                    $sqlDtAbil = findChimicaByFiltri("0", "1000000","dt_abilitato", "dt_abilitato", $_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                    
                    //Calcolo del totale dei codici chimica standard
                    $totKitStandard=0;
                    $sqlTotKit=countTotKitByFiltri($_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                      while ($rowNumKit = mysql_fetch_array($sqlTotKit)) {
                          $totKitStandard=$rowNumKit['num_kit'];
                      }
                    //Calcolo del totale codici kit chimica sfusa
                    $totKitSfusa=0;
                    $sqlTotKitSfusa=countTotKitInSfusaByFiltri($_SESSION['CodChimica'], $_SESSION['CodProdotto'], $_SESSION['CodLotto'], $_SESSION['Descrizione'], $_SESSION['Data'], $_SESSION['DtAbilitato']);
                      while ($rowNumKitSf = mysql_fetch_array($sqlTotKitSfusa)) {
                          $totKitSfusa=$rowNumKitSf['num_kit_sfusa'];
                      }
                    
                    
                    
                    break;

                default:
                    break;
            }
            
            commit();

            $trovati = mysql_num_rows($sql);
          
            $numrows = mysql_num_rows($sqlTot);
            include('./moduli/visualizza_chimica.php');
            ?>

        </div>
    </body>
</html>
