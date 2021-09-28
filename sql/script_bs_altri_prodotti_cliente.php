<?php

function inserisciAltriProdottiCliente($idProdotto,$idCliente,$anno,$vendutoPrivato,$vendutoImpresa,$vendutoRivenditore,$generatoreListino,$dtAbilitato){
    $stringSql = "INSERT INTO serverdb.bs_altri_prodotti_cliente
       (id_prodotto,id_cliente,anno,venduto_privato,venduto_impresa,venduto_rivenditore,generatore_listino,dt_abilitato)
                        VALUES (".$idProdotto.",
                            ".$idCliente.",
                                ".$anno.",
                                    ".$vendutoPrivato.",
                                        ".$vendutoImpresa.",
                                            ".$vendutoRivenditore.",
                                                ".$generatoreListino.",
                                                '".$dtAbilitato."')";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_altri_prodotti_cliente - FUNCTION inserisciAltriProdottiCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}



function eliminaBsAltriProdottiCliente($idCliente,$anno){
    $stringSql = "DELETE FROM serverdb.bs_altri_prodotti_cliente WHERE anno=".$anno." AND id_cliente=".$idCliente;
       
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_altri_prodotti_cliente - FUNCTION eliminaBsAltriProdottiCliente - " . $stringSql . " : " . mysql_error());
    

    return $sql;
}