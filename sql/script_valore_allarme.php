<?php

function selectValoreAllarmeByFiltri($idMacchina,$idAllarme,$nome,$descri,$valore,$idCiclo,$abilitato,$dtAbilitato,$filtro){
  
  $stringSql="SELECT a.id_allarme,a.nome,a.descrizione,v.valore,v.id_tabella_rif,v.abilitato,v.dt_abilitato,v.id_macchina FROM serverdb.valore_allarme v 
                JOIN serverdb.allarme a ON v.id_allarme=a.id_allarme
              WHERE
                  id_macchina=".$idMacchina."
                AND
                  v.id_allarme LIKE '%".$idAllarme."%' 
                AND 
                  nome LIKE '%".$nome."%'
                AND
                  descrizione LIKE '%".$descri."%'
                AND
                  valore LIKE '%".$valore."%'
                AND
                  id_tabella_rif LIKE '%".$idCiclo."%'
                AND
                  a.abilitato LIKE '%".$abilitato."%'
                AND
                  v.dt_abilitato LIKE '%".$dtAbilitato."%'
        
                ORDER BY ".$filtro;
  
    
   $sql = mysql_query($stringSql)  or die("ERROR IN script_valore_allarme - FUNCTION selectValoreAllarmeByFiltri  : " .$stringSql." - ". mysql_error());
  return $sql;
}
