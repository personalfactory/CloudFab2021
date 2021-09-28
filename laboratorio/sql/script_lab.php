<?php



//##############################################################################
//############## Tabella lab_esperimento #######################################
//##############################################################################

/**
 * Select di tutti gli esperimenti, gruppo e utente
 * @return result set $sql
 */
function selectEsperimentiAll() {

  $sql = mysql_query("SELECT
                            lab_esperimento.id_esperimento,
                            lab_esperimento.cod_lab_formula,
                            lab_formula.tipologia,
                            lab_esperimento.num_prova,
                            lab_esperimento.dt_prova,
                            lab_esperimento.ora_prova,
                            lab_formula.utente,
                            lab_formula.gruppo_lavoro
                        FROM
                            lab_esperimento
                        INNER JOIN 
                            lab_formula 
                        ON 
                            lab_esperimento.cod_lab_formula = lab_formula.cod_lab_formula
					              ORDER BY
                            lab_esperimento.cod_lab_formula,
                            lab_esperimento.num_prova")
          or die("ERRORE selectEsperimentiAll() : " . mysql_error());
  return $sql;
}

/**
 * Select degli esperimenti appartenenti ad un gruppo
 * @return result set $sql
 */
function selectEsperimentiGruppoUtente() {
  $sql = mysql_query("SELECT
                          lab_esperimento.id_esperimento,
                          lab_esperimento.cod_lab_formula,
                          lab_esperimento.num_prova,
                          lab_esperimento.dt_prova,
                          lab_esperimento.ora_prova,
                          lab_formula.utente,
                          lab_formula.gruppo_lavoro
                        FROM
                          lab_esperimento
                        INNER JOIN 
                          lab_formula 
                          ON 
                            lab_esperimento.cod_lab_formula = lab_formula.cod_lab_formula
                        WHERE 
                          lab_formula.utente='" . $_SESSION['username'] . "' OR  gruppo_lavoro='" . $_SESSION['nome_gruppo_utente'] . "'
                        ORDER BY
                          lab_esperimento.cod_lab_formula,
                          lab_esperimento.num_prova")
          or die("selectEsperimentiGruppoUtente() : " . mysql_error());
  return $sql;
}

//##############################################################################
//############## Tabella lab_peso ##############################################
//##############################################################################

/**
 * Elimina dalla tabella lab_peso tutti i record relativi alla macchina in uso
 */
//function deleteLabPeso() {
//  mysql_query("DELETE FROM lab_peso WHERE id_lab_macchina= " . $_SESSION['lab_macchina'])
//          or die("ERRORE deleteLabPeso() :" . mysql_error());
//}

/**
 * Inizializza la tabella lab_peso con i codici delle materie prime 
 * da eseguire nel primo esperimento 
 * @param type $CodiceBarre
 * @param type $CodiceFormula 
 */
//function inizializzaLabPesoCodMat($CodiceBarre, $CodiceFormula ){
//
//  mysql_query("INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina) 
//					SELECT
//							lab_matpri_teoria.id_mat,
//							lab_materie_prime.cod_mat,
//							0,
//              '" . $CodiceBarre . "',
//              ".$_SESSION['lab_macchina']."
//					FROM
//							lab_matpri_teoria
//					INNER JOIN 
//							lab_materie_prime ON lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
//					WHERE 
//							lab_matpri_teoria.cod_lab_formula='" . $CodiceFormula . "'")
//          or die("Errore 109.1: " . mysql_error());
//
//}

/**
 * Inizializzazione della tabella lab_peso relativa all'acqua da eseguire nel primo esperimento
 * @param type $CodiceBarre
 * @param type $CodiceFormula 
 */
 
//function inizializzaLabPesoAcqua($CodiceBarre,$CodiceFormula,$PercentualeSI){
//  mysql_query("INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina) 
//					SELECT
//							lab_parametro_teoria.id_par,
//							lab_parametro.nome_parametro,
//							0,
//              '" . $CodiceBarre . "',
//              ".$_SESSION['lab_macchina']."  
//					FROM
//							lab_parametro_teoria
//					INNER JOIN 
//							lab_parametro ON lab_parametro.id_par = lab_parametro_teoria.id_par
//					WHERE 
//							lab_parametro_teoria.cod_lab_formula='" . $CodiceFormula . "'
//						AND 
//						(lab_parametro.tipo LIKE '%" . $PercentualeSI . "%' )")
//          or die("Errore 109.2: " . mysql_error());
//
//}

/**
 * Inizializza la tabella lab_peso con i codici delle materie prime oggetto di sperimentazione, 
 * questa tabella viene aggiornata con le quantita pesate durante la procedura di pesa 
 * eseguita nella pagina carica_lab_peso
 * La tabella viene inizializzata con le quantita registrate nella prova di origine 
 * calcolate in base alla nuova quantita totale di miscela
 * @param type $CodiceBarre
 * @param type $QtaTotMiscela 
 * @param type $IdEsperimento 
 */
//function inizializzaLabPesoMatPriKeVaria( $QtaTotMiscela, $CodiceBarre, $IdEsperimento ){
//
//mysql_query("INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina) 
//					SELECT
//							lab_risultato_matpri.id_mat,
//							lab_materie_prime.cod_mat,
//							TRUNCATE((lab_risultato_matpri.qta_reale*" . $_SESSION['$PesoMiscela'] . ")/" . $QtaTotMiscela . ",4),
//              '" . $CodiceBarre . "',
//              ".$_SESSION['lab_macchina']."
//					FROM
//							lab_risultato_matpri
//					INNER JOIN 
//							lab_materie_prime ON lab_materie_prime.id_mat = lab_risultato_matpri.id_mat
//					WHERE 
//							lab_risultato_matpri.id_esperimento=" . $IdEsperimento )
//          or die("ERRORE inizializzaLabPesoMatPriKeVaria() : " . mysql_error());
//}


/**
 * Inizializzazione pesa dell'acqua da eseguire negli esperimenti successivi al primo
 * @param type $QtaTotMiscela
 * @param type $CodiceBarre
 * @param type $IdEsperimento 
 */
function inizializzaLabPesoAcquaSec( $QtaTotMiscela, $CodiceBarre, $IdEsperimento,$PercentualeSI ){
  
  mysql_query("INSERT INTO lab_peso (id,codice,peso,cod_barre,id_lab_macchina) 
					SELECT
							lab_risultato_par.id_par,
							lab_parametro.nome_parametro,
							TRUNCATE((lab_risultato_par.valore_reale*" . $_SESSION['$PesoMiscela'] . ")/" . $QtaTotMiscela . ",4),
              '" . $CodiceBarre . "',
              ".$_SESSION['lab_macchina']."
					FROM
							lab_risultato_par
					INNER JOIN 
							lab_parametro ON lab_parametro.id_par = lab_risultato_par.id_par
					WHERE 
							lab_risultato_par.id_esperimento=" . $IdEsperimento . "
						AND 
						(lab_parametro.tipo LIKE '%" . $PercentualeSI . "%' )")
          or die("ERRORE inizializzaPesoAcqua() : " . mysql_error());

}


//##############################################################################
//############## Tabella lab_risultato_matpri ##################################
//##############################################################################

//function calcolaQtaTotMiscela($IdEsperimento){
//  $QtaTotMiscela=
// $sqlQtaTotMiscela = mysql_query("SELECT lab_risultato_matpri.qta_reale
//                                  FROM
//                                    lab_risultato_matpri
//                                  WHERE 
//                                     lab_risultato_matpri.id_esperimento=" . $IdEsperimento )
//          or die("ERRORE calcolaQtaTotMiscela: " . mysql_error());
//
//  while ($rowQtaTotMiscela = mysql_fetch_array($sqlQtaTotMiscela)) {
//
//    $QtaTotMiscela = $QtaTotMiscela + $rowQtaTotMiscela['qta_reale'];
//  }
//  return $QtaTotMiscela;
//}








?>

