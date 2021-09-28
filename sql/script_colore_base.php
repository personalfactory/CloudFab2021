<?php
//Tabelle coinvolte 
//colore_base


//############# VERIFICA PERMESSO VISUALIZZAZIONE ##############################
//verificaPermessoVisualizzazione($_SESSION['objPermessiVis'], 'colore_base');
/*
//Stringa contenente l'elenco degli id degli utenti prop visibili dall'utente loggato
echo "</br>Utenti proprietari  visibili : ".
        $_SESSION['strUtentiVis']=getUtentiPropVisib($_SESSION['objPermessiVis'], 'colore_base');
        
//Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
echo "</br>Aziende visibili  : ". 
        $_SESSION['strAziendeVis']=getAziendeVisib($_SESSION['objPermessiVis'], 'colore_base');
//##############################################################################
*/

/**
 * Seleziona un record dalla tabella colore_base con id_colore_base=$IdColoreBase
 * @param unknown $IdColoreBase
 * @return resource
 */
function findColorBaseById($idColoreBase){
	$sqlString="SELECT * FROM serverdb.colore_base WHERE id_colore_base=" . $idColoreBase;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION findColorBaseById - ".$sqlString ." ". mysql_error());
	return $sql;
}


/**
 * Seleziona tutti i colori base visibili all'utente
 * @param type $strUtentiVis
 * @param type $strAziendeVis
 * @param type $campoOrdine
 * @return type
 */

function findAllColoreBaseVis($strUtentiAziende,$campoOrdine){
	$sqlString="SELECT * FROM serverdb.colore_base
                    WHERE (id_utente,id_azienda) IN ".$strUtentiAziende."
                       
                ORDER BY ".$campoOrdine;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION findAllFromColore - ".$sqlString ." ". mysql_error());
	return $sql;
}






/**
 * Seleziona tutti i record della tabella colore_base con cod_colore_base = $codiceColoreBase e nome_colore_base = $nomeColoreBase
 * @param unknown $idColoreBase
 * @param unknown $nomeColoreBase
 * @param unknown $codiceColoreBase
 * @param unknown $connessione
 * @return resource
 * @author FR
 */
function findAllColoreByCodName($idColoreBase, $nomeColoreBase, $codiceColoreBase){
	$sqlString="SELECT * FROM serverdb.colore_base 
				WHERE 
					cod_colore_base = '".$codiceColoreBase."' 
				AND 
					nome_colore_base = '".$nomeColoreBase."'
				AND 
					id_colore_base<>".$idColoreBase;

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION findAllColoreByCodName - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Seleziona il record della tabella colore_base con cod_colore_base = $codiceColoreBase o nome_colore_base = $nomeColoreBase
 * @param unknown $nomeColoreBase
 * @param unknown $codiceColoreBase
 * @param unknown $connessione
 * @return resource
 */
function findColoreBaseByNameOrCod($nomeColoreBase, $codiceColoreBase, $connessione){
	$sqlString="SELECT * FROM serverdb.colore_base 
                WHERE 
                    nome_colore_base = '" . $nomeColoreBase . "'
                   OR 
                    cod_colore_base = '" . $codiceColoreBase . "'";

	$sql = mysql_query($sqlString, $connessione)
	or die("ERROR IN script_colore_base.php - FUNCTION findColoreBaseByNameOrCod - ".$sqlString ." ". mysql_error());
	return $sql;
}












/**
 * Seleziona tutti i record della tabella colore_base ordinati per nome
 * @return resource
 * @author FR
 */
function findAllColoreBase(){
	$sqlString="SELECT * FROM serverdb.colore_base ORDER BY nome_colore_base";

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_colore_base.php - FUNCTION findAllColoreBase - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Inserisce un nuovo record nella tabella colore_base
 * @param unknown $CodiceColoreBase
 * @param unknown $NomeColoreBase
 * @param unknown $CostoColoreBase
 * @param unknown $Tolleranza
 * @param unknown $dataCorrente
 * @return resource
 */
function insertColoreBase($CodiceColoreBase, $NomeColoreBase, $CostoColoreBase,
        $Tolleranza, $dataCorrente,$idUtenti,$idAzienda ){
	$sqlString="INSERT INTO serverdb.colore_base (
                                        cod_colore_base, 
                                        nome_colore_base,
                                        costo_colore_base,
                                        toll_perc,
                                        abilitato,
                                        dt_abilitato,id_utente,id_azienda) 
				VALUES ( '" . $CodiceColoreBase . "',
                                        '" . $NomeColoreBase . "',
                                        '" . $CostoColoreBase . "',
                                        '" . $Tolleranza . "',
                                        1,
                                        '" . $dataCorrente . "',
                                        ".$idUtenti.", 
                                        ".$idAzienda.")";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION insertColoreBase - ".$sqlString ." ". mysql_error());
	return $sql;
}








/**
 * Seleziona i campi id_colore_base, nome_colore_base dalla tabella colore_base
 * @return resource
 */
function findIdNomeColoreBase(){
	$sqlString="SELECT 
                                                id_colore_base,
                                                nome_colore_base
                                        FROM 
                                                serverdb.colore_base";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION findIdNomeColoreBase - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Inserisce un record nello storico
 * @param unknown $IdColoreBase
 * @return resource
 * @author FR
 */
function insertStoricoColoreBase($idColoreBase){
	$sqlString= "INSERT INTO storico.colore_base 						 										
				(id_colore_base,cod_colore_base,nome_colore_base,costo_colore_base,toll_perc,abilitato,dt_abilitato) 
					SELECT 
						id_colore_base,
						cod_colore_base,
						nome_colore_base,
						costo_colore_base,
                                                toll_perc,
						abilitato,
						dt_abilitato
					FROM 
						serverdb.colore_base
					WHERE
						id_colore_base=".$idColoreBase;

	$sql = mysql_query($sqlString);
//	or die("ERROR IN script_colore_base.php - FUNCTION insertStoricoColoreBase - ".$sqlString ." ". mysql_error());
	return $sql;
}





/**
 * Aggiorna tutti i campi del record selezionato per id dalla tabella 
 * colore_base del db server
 * @param type $codiceColoreBase
 * @param type $nomeColoreBase
 * @param type $costoColoreBase
 * @param type $tolleranza
 * @param type $idColoreBase
 * @param type $idAzienda
 * @return type
 */
function updateServerDBColoreBase($codiceColoreBase, $nomeColoreBase, $costoColoreBase, $tolleranza, $idColoreBase,$idAzienda ){
	$sqlString="UPDATE serverdb.colore_base 
            SET 
                    cod_colore_base=if(cod_colore_base!='".$codiceColoreBase."','".$codiceColoreBase."',cod_colore_base),
                    nome_colore_base=if(cod_colore_base!='".$nomeColoreBase."','".$nomeColoreBase."',cod_colore_base),
                    costo_colore_base=if(cod_colore_base!='".$costoColoreBase."','".$costoColoreBase."',cod_colore_base),
                    toll_perc=if(toll_perc!='".$tolleranza."','".$tolleranza."',toll_perc),
                    id_azienda=if(id_azienda!='".$idAzienda."','".$idAzienda."',id_azienda)
            WHERE 
                    id_colore_base=".$idColoreBase."";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_colore_base.php - FUNCTION insertColoreBase - ".$sqlString ." ". mysql_error());
	return $sql;
}
?>