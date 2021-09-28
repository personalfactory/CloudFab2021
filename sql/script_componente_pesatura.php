<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function insertNuovoComponentePesatura($idProdotto,$idComp,$metodoPesa,$stepDosaggio,$ordineDosaggio,$tollEccesso,$tollDifetto,
        $fluidificazione,$valResiduoFluid,$quantita,$note,$abilitato,$dtAbilitato){
     $stringSql = "INSERT INTO serverdb.componente_pesatura (
                                            id_prodotto,
                                            id_comp,
                                            metodo_pesa,
                                            step_dosaggio,
                                            ordine_dosaggio,
                                            toll_eccesso,
                                            toll_difetto,
                                            fluidificazione,
                                            valore_residuo_fluidificazione,
                                            quantita,
                                            note,
                                            abilitato,
                                            dt_abilitato)
                                        VALUES(
                                            " . $idProdotto . ",
                                            " . $idComp . ",
                                            '".$metodoPesa."',
                                            '".$stepDosaggio."',
                                            " . $ordineDosaggio . ",
                                            " . $tollEccesso . ",
                                            " . $tollDifetto . ",
                                            '".$fluidificazione."',
                                            " . $valResiduoFluid . ",
                                            " . $quantita . ",
                                                '".$note."',
                                            " . $abilitato . ",
                                            '".$dtAbilitato."')";
    
     $sql = mysql_query($stringSql);
       //or die("ERROR IN componente_pesatura - FUNCTION insertNuovoComponentePesatura " .$stringSql ." - ".mysql_error());
     return $sql;
}

function selectCompPesaturaByIdProdotto($idProdotto){
$sql = mysql_query("SELECT *,cp.abilitato AS comp_abilitato	
                                FROM 
                                    serverdb.componente_pesatura cp
                                JOIN  serverdb.componente c
                                ON
                                    cp.id_comp=c.id_comp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . "
                                ORDER BY 
                                    c.descri_componente") ;
//        or die("ERROR IN script_componente_pesatura - FUNCTION selectCompPesaturaByIdProdotto " . mysql_error());

return $sql;
}


function modificaComponentePesatura($idComp,$idProdotto,$metodoPesa,$stepDosaggio,$ordineDosaggio,$tollEccesso,$tollDifetto,
        $fluidificazione,$valResiduoFluid,$quantita,$compAbilitato){
 
    $stringSql = "UPDATE serverdb.componente_pesatura
                    SET 
                                                     
                       metodo_pesa=if(metodo_pesa!='" . $metodoPesa . "','" . $metodoPesa . "',metodo_pesa),
                       step_dosaggio=if(step_dosaggio!='" . $stepDosaggio . "','" . $stepDosaggio . "',step_dosaggio),
                       ordine_dosaggio=if(ordine_dosaggio!=" . $ordineDosaggio . "," . $ordineDosaggio . ",ordine_dosaggio),
                       toll_eccesso=if(toll_eccesso!=" . $tollEccesso . "," . $tollEccesso . ",toll_eccesso),
                       toll_difetto=if(toll_difetto!=" . $tollDifetto . "," . $tollDifetto . ",toll_difetto),
                       fluidificazione=if(fluidificazione!='" . $fluidificazione . "','" . $fluidificazione . "',fluidificazione),
                       valore_residuo_fluidificazione=if(valore_residuo_fluidificazione!='" . $valResiduoFluid . "','" . $valResiduoFluid . "',valore_residuo_fluidificazione),
                       quantita=if(quantita!=" . $quantita . "," . $quantita . ",quantita),
                       abilitato=if(abilitato!=" . $compAbilitato . "," . $compAbilitato . ",abilitato),
                       dt_abilitato=NOW()    
                    WHERE
                       id_prodotto=" . $idProdotto . "
                    AND
                       id_comp=" . $idComp;
    
    $sql = mysql_query($stringSql) 
  or die("ERROR IN script_componente_pesatura - FUNCTION modificaComponentePesatura " .$stringSql ." - ".mysql_error());
    return $sql;
}




function insertNuovoCompPesatura($idProdotto,$idComp,$quantita,$abilitato,$dtAbilitato){
    
     $stringSql = "INSERT INTO serverdb.componente_pesatura (
                                            id_prodotto,
                                            id_comp,
                                            quantita,
                                            abilitato,
                                            dt_abilitato)
                                        VALUES(
                                            " . $idProdotto . ",
                                            " . $idComp . ",
                                            " . $quantita . ",
                                            " . $abilitato . ",
                                            '".$dtAbilitato."')";
    
     $sql = mysql_query($stringSql); 
//        or die("ERROR IN script_componente_pesatura - FUNCTION insertNuovoComponentePesatura " .$stringSql ." - ".mysql_error());
     return $sql;
}

function findCompPesaturaByIdProdIdComp($idComponente,$idProdotto){ 
                    
              $stringSql="SELECT * FROM serverdb.componente_pesatura 
				WHERE 
                                    id_comp = " . $idComponente . "
				AND
                                    id_prodotto= " . $idProdotto;

            $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION findCompProdByIdProdIdComp " .$stringSql ." - ".mysql_error());
     return $sql;
}


function modificaComponentiAlternativi($idComp,$idProdotto,$stringaCompAlternativi){
 
    $stringSql = "UPDATE serverdb.componente_pesatura
                    SET 
                       info1='".$stringaCompAlternativi."',                              
                       
                       dt_abilitato=NOW()    
                    WHERE
                       id_prodotto=" . $idProdotto . "
                    AND
                       id_comp=" . $idComp;
    
    $sql = mysql_query($stringSql) 
  or die("ERROR IN script_componente_pesatura - FUNCTION modificaComponentiAlternativi " .$stringSql ." - ".mysql_error());
    return $sql;
}


function selectComponentiAlternativiTotByIdProdotto($idProdotto){
$sql = mysql_query("SELECT * FROM 
                                    serverdb.componente_pesatura cp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . " AND info1<>'' AND abilitato=1") ;
//  or die("ERROR IN script_componente_pesatura - FUNCTION selectComponentiAlternativiTotByIdProdotto " . mysql_error());

return $sql;
}




function sostituisciComponenteInCompPesatura($idCompOld,$idCompNew,$quantita,$idProdotto,$data){
  
                $stringSql="UPDATE serverdb.componente_pesatura  SET id_comp= " . $idCompNew . ",
							 quantita=" . $quantita . ",
							 abilitato=1,
							 dt_abilitato='" . $data . "'
                            WHERE 
                                id_comp=" . $idCompOld . "
                            AND 
                                id_prodotto=" . $idProdotto;
 $sql = mysql_query($stringSql) ;
        //or die("ERROR IN script_componente_pesatura - FUNCTION sostituisciComponenteInCompPesatura " .$stringSql ." - ".mysql_error());
     return $sql;
                
}


function disabilitaCompPesatura($idProdotto,$idComponente){
    $stringSql = "UPDATE serverdb.componente_pesatura SET abilitato=0 WHERE id_prodotto=" . $idProdotto." AND id_comp=".$idComponente;
    $sql = mysql_query($stringSql)
	or die("ERROR IN script_componente_pesatura.php - FUNCTION disabilitaCompPesatura - ".$stringSql ." ". mysql_error());
return $sql;
}

function abilitaCompPesatura($idProdotto,$idComponente){
    $stringSql = "UPDATE serverdb.componente_pesatura SET abilitato=1 WHERE id_prodotto=" . $idProdotto." AND id_comp=".$idComponente;
    $sql = mysql_query($stringSql)
	or die("ERROR IN script_componente_pesatura.php - FUNCTION abilitaCompPesatura - ".$stringSql ." ". mysql_error());
return $sql;
}



/**function selectComponentiAlternativiByIdProdIdCompAbil($idProdotto,$idComp,$abilitato){
$stringSql="SELECT *,cp.abilitato AS comp_abilitato	
                                FROM 
                                    serverdb.componente_prodotto cp
                                INNER JOIN  serverdb.componente c
                                ON
                                    cp.id_comp=c.id_comp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . "
                                    AND
                                    cp.id_comp=".$idComp."    
                                    AND    
                                    cp.abilitato=" . $abilitato . "
                                ORDER BY 
                                    c.descri_componente";
    $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION selectComponentiByIdProdAbil " .$stringSql ." - ".mysql_error());

return $sql;
}*/

function selectComponentiPesByIdProdAbil($idProdotto,$abilitato){
$stringSql="SELECT *,cp.abilitato AS comp_abilitato	
                                FROM 
                                    serverdb.componente_pesatura cp
                                INNER JOIN  serverdb.componente c
                                ON
                                    cp.id_comp=c.id_comp
                                WHERE
                                    cp.id_prodotto=" . $idProdotto . "
                                    AND
                                    cp.abilitato=" . $abilitato . "
                                ORDER BY 
                                    c.descri_componente";
    $sql = mysql_query($stringSql) 
        or die("ERROR IN script_componente_prodotto - FUNCTION selectComponentiPesByIdProdAbil " .$stringSql ." - ".mysql_error());

return $sql;
}
