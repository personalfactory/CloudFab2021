<?php
//##############################################################################
//####################### SERVERDB #############################################
//##############################################################################

function findValoreRipristinoByIdMacchina($idMacchina,
                                          $filtro,
                                          $idValRip,
                                          $idParRip,
                                          $nomeVariabile,
                                          $valoreVariabile,
                                          $dtAbilitato,
                                          $idProcesso,
                                          $dtRegistrato,
                                          $dtAggMac){
  
   $sql=mysql_query("SELECT 
                          valore_ripristino.id_valore_ripristino,
                          valore_ripristino.id_par_ripristino,
                          valore_ripristino.valore_variabile,
                          valore_ripristino.abilitato,
                          valore_ripristino.dt_abilitato,
                          parametro_ripristino.nome_variabile,
                          parametro_ripristino.descri_variabile,
                          valore_ripristino.id_pro_corso, 
                          valore_ripristino.dt_registrato,
                          valore_ripristino.dt_agg_mac
                        FROM
                            serverdb.valore_ripristino
                        INNER JOIN serverdb.parametro_ripristino 
                        ON 
                            valore_ripristino.id_par_ripristino = parametro_ripristino.id_par_ripristino
                        WHERE 
                            valore_ripristino.id_macchina=" .$idMacchina . "
                        AND
                          id_valore_ripristino LIKE '%".$idValRip."%'
                        AND
                          valore_ripristino.id_par_ripristino LIKE '%".$idParRip."%'
                        AND
                          nome_variabile LIKE '%".$nomeVariabile."%'
                        AND
                          valore_variabile LIKE '%".$valoreVariabile."%'
                        AND
                         valore_ripristino.dt_abilitato LIKE '%".$dtAbilitato."%'
                        AND
                          id_pro_corso LIKE '%".$idProcesso."%'
                        AND
                          dt_registrato LIKE '%".$dtRegistrato."%'  
                        AND
                          dt_agg_mac LIKE '%".$dtAggMac."%'  
                        ORDER BY ".$filtro) ;
   //or die("ERRORE IN script_valore_ripristino - FUNCTION findValoreRipristinoByIdMacchina : SELECT FROM serverdb.valore_ripristino : " . mysql_error());
          
          return $sql;
  
  
}

function updateValoreRipristino($valore,$dataCorrente,$idParRip,$idMacchina){

 $sql= mysql_query("UPDATE serverdb.valore_ripristino 
			SET 
				dt_abilitato=if(valore_variabile != '" . $valore . "','" . $dataCorrente . "',dt_abilitato),
        valore_variabile=if(valore_variabile != '" . $valore . "','" . $valore . "',valore_variabile)
			WHERE
				id_par_ripristino=" . $idParRip . "
			AND
				id_macchina=" . $idMacchina);
                    //or die("ERRORE IN script_valore_ripristino- FUNCTION updateValoreRipristino - UPDATE serverdb.valore_ripristino : " . mysql_error());
 return $sql;

}



//##############################################################################
//####################### STORICO ##############################################
//##############################################################################
function insertIntoStoricoValRipristino($idValRip,$idParRip,$idMacchina,$valoreVariabile,$abilitato,$dtAbilitato,$dtRegistrato,$idProCorso){
 $sql = mysql_query("INSERT INTO storico.valore_ripristino	
                                    (id_valore_ripristino,
                                    id_par_ripristino,
                                    id_macchina,
                                    valore_variabile,
                                    abilitato,
                                    dt_abilitato,
                                    dt_registrato,
                                    id_pro_corso)
                        VALUES(
                                        " . $idValRip . ",
                                        " . $idParRip . ",
                                        '" .  $idMacchina . "',
                                        '" . $valoreVariabile . "',
                                        " . $abilitato . ",
                                        '" . $dtAbilitato . "',
                                        '" . $dtRegistrato . "',    
                                        " . $idProCorso . ")");
//		or die("ERRORE IN script_valore_ripristino - FUNCTION insertIntoStoricoValRipristino : INSERT INTO storico.valore_ripristino : " . mysql_error());
 return $sql;
}









/**
 * Aggiorna il campo id_par_ripristino del record di serverdb.valore_ripristino selezionato per id
 * @param unknown $idParametro
 * @param unknown $idParametroOld
 * @return resource
 */
function updateIdParRipristino($idParametro, $idParametroOld){
	$sqlString= "UPDATE serverdb.valore_ripristino 
						SET 
              id_par_ripristino = " . $idParametro . "
						WHERE 
							id_par_ripristino='" . $idParametroOld . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_ripristino - FUNCTION updateIdParRipristino - ".$sqlString ." ". mysql_error());
	return $sql;
}










/**
 * Inserisce un nuovo record
 * @param unknown $nomeParametro
 * @param unknown $dataCorrente
 * @return resource
 */
function insertValRipristino($nomeParametro, $dataCorrente){
	$sqlString= "INSERT INTO serverdb.valore_ripristino (id_par_ripristino,id_macchina,abilitato,dt_abilitato) 
						SELECT  
							parametro_ripristino.id_par_ripristino,
							macchina.id_macchina,
							1,
							'" . $dataCorrente . "'
						FROM 
							parametro_ripristino,macchina
						WHERE 
							parametro_ripristino.nome_variabile='" . $nomeParametro . "'";

	$sql = mysql_query($sqlString)
	or die("ERROR IN script_valore_ripristino - FUNCTION insertValRipristino - ".$sqlString ." ". mysql_error());
	return $sql;
}
?>
