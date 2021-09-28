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
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_aggiornamento.php');

            //Calcolo l'anno ed il mese corrente
            $now = getdate();
            $annoCorrente = $now["year"];
            $meseCorrente = $now["mon"];
            if ($meseCorrente < 10) {
                $meseCorrente = "0" . $meseCorrente;
            }

            $_SESSION['IdMacchina'] = "";
            $_SESSION['DescriStab'] = "";
            $_SESSION['Tipo'] = "";
            $_SESSION['NomeFile'] = "";
            $_SESSION['Versione'] = "";
            $_SESSION['DtAggiornamento'] = $annoCorrente . "-" . $meseCorrente;

            $_SESSION['IdMacchinaList'] = "";
            $_SESSION['DescriStabList'] = "";
            $_SESSION['TipoList'] = "";
            $_SESSION['NomeFileList'] = "";
            $_SESSION['VersioneList'] = "";
            $_SESSION['DtAggiornamentoList'] = "";


            if (isset($_POST['IdMacchina'])) {
                $_SESSION['IdMacchina'] = trim($_POST['IdMacchina']);
            }
            if (isset($_POST['IdMacchinaList']) AND $_POST['IdMacchinaList'] != "") {
                $_SESSION['IdMacchina'] = trim($_POST['IdMacchinaList']);
            }
            if (isset($_POST['DescriStab'])) {
                $_SESSION['DescriStab'] = trim($_POST['DescriStab']);
            }
            if (isset($_POST['DescriStabList']) AND $_POST['DescriStabList'] != "") {
                $_SESSION['DescriStab'] = trim($_POST['DescriStabList']);
            }
            if (isset($_POST['Tipo'])) {
                $_SESSION['Tipo'] = trim($_POST['Tipo']);
            }
            if (isset($_POST['TipoList']) AND $_POST['TipoList'] != "") {
                $_SESSION['Tipo'] = trim($_POST['TipoList']);
            }
            if (isset($_POST['NomeFile'])) {
                $_SESSION['NomeFile'] = trim($_POST['NomeFile']);
            }
            if (isset($_POST['NomeFileList']) AND $_POST['NomeFileList'] != "") {
                $_SESSION['NomeFile'] = trim($_POST['NomeFileList']);
            }
            if (isset($_POST['Versione'])) {
                $_SESSION['Versione'] = trim($_POST['Versione']);
            }
            if (isset($_POST['VersioneList']) AND $_POST['VersioneList'] != "") {
                $_SESSION['Versione'] = trim($_POST['VersioneList']);
            }
            if (isset($_POST['DtAggiornamento'])) {
                $_SESSION['DtAggiornamento'] = trim($_POST['DtAggiornamento']);
            }
            if (isset($_POST['DtAggiornamentoList']) AND $_POST['DtAggiornamentoList'] != "") {
                $_SESSION['DtAggiornamento'] = trim($_POST['DtAggiornamentoList']);
            }

            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "dt_aggiornamento";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }

            begin();
            $sql = findAllFileByFiltri($_SESSION['Filtro'], "id", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlIdMac = findAllFileByFiltri("a.id_macchina", "a.id_macchina", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlDescriStab = findAllFileByFiltri("descri_stab", "descri_stab", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlTipo = findAllFileByFiltri("tipo", "tipo", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlNomeFile = findAllFileByFiltri("nome_file", "nome_file", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlVersione = findAllFileByFiltri("versione", "versione", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlAbilitato = findAllFileByFiltri("abilitato", "abilitato", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            $sqlDtAgg = findAllFileByFiltri("dt_abilitato", "dt_abilitato", $_SESSION['IdMacchina'], $_SESSION['DescriStab'], $_SESSION['Tipo'], $_SESSION['NomeFile'], $_SESSION['Versione'], $_SESSION['DtAggiornamento']);
            commit();
            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_lista_file.php');
            ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab formula : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziende;
                }
                ?>
            </div>
        </div>
    </body>
</html>
