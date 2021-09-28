<?php
function findBSProdClienti($anno,$strUtentiAziende) {
        $stringSql = "SELECT * FROM 
                            serverdb.bs_prodotto_cliente b JOIN serverdb.prodotto p  
                            ON b.id_prodotto=p.id_prodotto
                            JOIN serverdb.bs_prodotto r ON r.id_prodotto=b.id_prodotto
                        WHERE
                            b.anno=".$anno." 
                            AND
                            (b.id_utente,b.id_azienda) IN ".$strUtentiAziende."
                        ORDER BY 
                            rating";
        $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

        return $sql;
    }
    
    
    function findBSProdottiByCliente($anno,$idCliente) {
        $stringSql = "SELECT * FROM 
                            serverdb.bs_prodotto_cliente b JOIN serverdb.prodotto p  
                            ON b.id_prodotto=p.id_prodotto
                            JOIN serverdb.bs_prodotto r ON r.id_prodotto=b.id_prodotto
                        WHERE
                            b.anno=".$anno." 
                            AND
                            b.id_cliente= ".$idCliente."
                        ORDER BY 
                            rating";
        $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

        return $sql;
    }
    
    function findBSProdottiByClienteUnion($anno,$idCliente) {
        $stringSql = "SELECT * FROM 
                        (SELECT b.id_prodotto AS id_prodotto,p.cod_prodotto AS cod_prodotto, p.nome_prodotto AS nome_prodotto, 
                            venduto_privato, venduto_impresa, venduto_rivenditore, generatore_listino, 0 AS costo,r.tipo AS tipo,
                            link_presentazione_prod,link_scheda_tecnica,
                            features, corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,
                            corrispettivo_3,prezzo_3,note_3,r.dt_abilitato AS dt_abilitato,r.rating AS rating
                        FROM 
                            serverdb.bs_prodotto_cliente b 
                            JOIN serverdb.prodotto p ON b.id_prodotto=p.id_prodotto
                            JOIN serverdb.bs_prodotto r ON r.id_prodotto=b.id_prodotto
                        WHERE
                            b.anno=".$anno." 
                        AND
                            b.id_cliente= ".$idCliente."
                    UNION ALL
                        SELECT c.id_prodotto AS id_prodotto, a.cod_prodotto AS cod_prodotto, a.nome_prodotto AS nome_prodotto,
                            venduto_privato, venduto_impresa, venduto_rivenditore, generatore_listino,costo,a.tipo AS tipo,
                            link_presentazione_prod,'' AS link_scheda_tecnica,features, 
                            corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,corrispettivo_3,prezzo_3,note_3,
                            c.dt_abilitato AS dt_abilitato, a.rating AS rating                            
                        FROM 
                            serverdb.bs_altri_prodotti_cliente c 
                            JOIN serverdb.bs_altri_prodotti a ON c.id_prodotto=a.id_prodotto
                        WHERE
                            c.anno=".$anno." 
                        AND
                            c.id_cliente= ".$idCliente."
                        ) derivedTable
                    ORDER BY rating";
        $sql = mysql_query($stringSql) or die("ERROR IN riepilogo_info_bs - findBSProdottiByClienteUnion" . $stringSql . " : " . mysql_error());

        return $sql;
    }
    
    
    
    function inserisciProdottiCliente($idProdotto,$idCliente,$anno,$vendutoPrivato,$vendutoImpresa,$vendutoRivenditore,$generatoreListino,$dtAbilitato){
    $stringSql = "INSERT INTO serverdb.bs_prodotto_cliente
       (id_prodotto,id_cliente,anno,venduto_privato,venduto_impresa,venduto_rivenditore,generatore_listino,dt_abilitato)
                        VALUES (".$idProdotto.",
                            ".$idCliente.",
                                ".$anno.",
                                    ".$vendutoPrivato.",
                                        ".$vendutoImpresa.",
                                            ".$vendutoRivenditore.",
                                                ".$generatoreListino.",
                                                '".$dtAbilitato."')";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto_cliente - FUNCTION inserisciProdottiCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}


function eliminaBsProdottiCliente($idCliente,$anno){
    $stringSql = "DELETE FROM serverdb.bs_prodotto_cliente WHERE anno=".$anno." AND id_cliente=".$idCliente;
       
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto_cliente - FUNCTION eliminaProdottiCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}
?>
