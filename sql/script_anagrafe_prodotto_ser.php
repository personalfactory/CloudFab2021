<?php
/**
 * Seleziona il prodotto padre di un dato prodotto dalla tabella anagrafe_prodotto
 * tramite l' id_prodotto del figlio.
 * Il campo colorato della tabella contiene l'informazione  prodotto padre, 
 * se ha valore 0 vuol dire che si tratta di un prodotto padre, 
 * se ha valore > 0 allora contiene l'id del suo prodotto padre
 * @param type $idProdotto
 * @return type
 */
function findProdottoPadreById($idProdotto){
    
    $strinSql="SELECT colorato FROM serverdb.prodotto WHERE id_prodotto=" . $idProdotto;
    $sql=mysql_query($strinSql) 
            or die("ERROR IN script_prodotto.php - FUNCTION findProdottoById - " .$strinSql." - " . mysql_error());
    return $sql;
}
?>
