<?php

function findDatiRiepilogo($campoOrdine,$campoGroupBy,$nominativo,$venduto,$costiVariabili,$ricavi,$primoMargine,$altreSpese,
        $secondoMargine,$costiAmmImpianto,$costiAmmInv,$ebita,$saturazioneImp,$anno,$strUtentiAziende){
         
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_riepilogo r
                        JOIN serverdb.bs_cliente c ON r.id_cliente=c.id_cliente
                        JOIN serverdb.utente u ON u.id_utente=c.id_utente
                        WHERE 
                            (r.id_utente,r.id_azienda) IN ".$strUtentiAziende."                            
                        AND 
                            nominativo LIKE '%".$nominativo."%'
                        AND 
                            venduto LIKE '%".$venduto."%'
                        AND 
                            costi_variabili LIKE '%".$costiVariabili."%'
                        AND 
                            ricavi LIKE '%".$ricavi."%'        
                        AND 
                            primo_margine LIKE '%" . $primoMargine . "%'
                        AND        
                            altre_spese LIKE '%".$altreSpese."%'        
                        AND 
                            secondo_margine LIKE '%" . $secondoMargine . "%'
                        AND        
                            costi_amm_impianto LIKE '%".$costiAmmImpianto."%'        
                        AND 
                            costi_amm_inv LIKE '%" . $costiAmmInv . "%' 
                        AND
                            ebita LIKE '%".$ebita."%'        
                        AND 
                            saturazione_impianto LIKE '%" . $saturazioneImp . "%'  
                        AND
                            anno LIKE '%".$anno."%'
                        GROUP BY ".$campoGroupBy."                            
                        ORDER BY ".$campoOrdine;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_riepilogo - FUNCTION findDatiRiepilogo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}



function inserisciDatiRiepilogo($venduto,$costiVariabili,$ricavi,$primoMargine,
       $costiAmmImpianto,$costiAmmInv,$secondoMargine,$altreSpese,$ebita,$anno,
        $idCliente,$idUtente,$idAzienda,$dtAbilitato,$saturazioneImpianto,$note,$cambio,$valuta){
    
//    $venduto=number_format($venduto, '0', ',', '.');
//    $costiVariabili=number_format($costiVariabili, '0', ',', '.');
//    $ricavi=number_format($ricavi, '0', ',', '.');
//    $primoMargine=number_format($primoMargine, '0', ',', '.');
//    $costiAmmImpianto=number_format($costiAmmImpianto, '0', ',', '.');
//    $costiAmmInv=number_format($costiAmmInv, '0', ',', '.');
//    $secondoMargine=number_format($secondoMargine, '0', ',', '.');
//    $altreSpese=number_format($altreSpese, '0', ',', '.');
//    $ebita=number_format($ebita, '0', ',', '.');
//    $saturazioneImpianto=number_format($saturazioneImpianto, '2', ',', '.');
       
        
   $stringSql = "INSERT INTO serverdb.bs_riepilogo (venduto,costi_variabili,ricavi,primo_margine,
       costi_amm_impianto,costi_amm_inv,secondo_margine,altre_spese,ebita,anno,id_cliente,id_utente,id_azienda,dt_abilitato,saturazione_impianto,note_simulazione,cambio,valuta)
                       VALUES (".$venduto.",".$costiVariabili.",".$ricavi.",".$primoMargine.",".$costiAmmImpianto.",".$costiAmmInv.",".$secondoMargine.",".$altreSpese.",
                           ".$ebita.",".$anno.",".$idCliente.",".$idUtente.",".$idAzienda.",'".$dtAbilitato."',".$saturazioneImpianto.",'".$note."',".$cambio.",'".$valuta."')";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_riepilogo - FUNCTION inserisciDatiRiepilogo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}


function eliminaDatiRiepilogo($idCliente,$anno){
    
        
 $stringSql = "DELETE FROM serverdb.bs_riepilogo WHERE anno=".$anno." AND id_cliente=".$idCliente;
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_riepilogo - FUNCTION eliminaDatiRiepilogo - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}

function findSimulazioneByClienteAnno($idCliente,$anno){
         
   $stringSql = "SELECT * 
                        FROM 
                            serverdb.bs_riepilogo r
                        WHERE 
                            id_cliente=".$idCliente." 
                        AND
                            anno = '".$anno."'";
                        
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_riepilogo - FUNCTION findSimulazioneByClienteAnno - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}
?>
