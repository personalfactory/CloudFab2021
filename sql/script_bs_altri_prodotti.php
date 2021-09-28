<?php

function findBSAltroProdottoById($idProdotto) {
    $stringSql = "SELECT * FROM serverdb.bs_altri_prodotti
                        WHERE
                           id_prodotto=" . $idProdotto;

    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}


function insertNewAltroProdottoBs($codProdotto,$nomeProdotto,$classificazione,$costo,$rating, $linkSchedaTecnica, $features, $corrispettivo1, $prezzo1, $note1, $corrispettivo2, $prezzo2, $note2, $corrispettivo3, $prezzo3, $note3,$tipo, $idUtente, $idAzienda) {

    $stringSql = "INSERT INTO serverdb.bs_altri_prodotti (cod_prodotto,nome_prodotto,classificazione,costo,rating,link_presentazione_prod,features,
        corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,
            corrispettivo_3,prezzo_3,note_3,tipo,id_utente,id_azienda)
                            VALUES
                            ('" . $codProdotto . "',
                              '" . $nomeProdotto . "',
                               '" . $classificazione . "',
                                 " . $costo . ",
                                    '" . $rating . "',
                                      '" . $linkSchedaTecnica . "',
                                            '" . $features . "',
                                                '" . $corrispettivo1 . "',
                                                    " . $prezzo1 . ",
                                                        '" . $note1 . "',
                                                            '" . $corrispettivo2 . "',
                                                                " . $prezzo2 . ",
                                                                    '" . $note2 . "',
                                                                        '" . $corrispettivo3 . "',
                                                                            " . $prezzo3 . ",
                                                                                '" . $note3 . "',
                                                                                   '" . $tipo . "',
                                                                                    " . $idUtente . ",
                                                                                        " . $idAzienda . ")";
    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}

function updateBSAltroProdottoById($idProdotto,$codProdotto,$nomeProdotto, $classificazione, $costo,$rating, $linkPresentazioneProd, $features, $corrispettivo1, $prezzo1, $note1, $corrispettivo2, $prezzo2, $note2, $corrispettivo3, $prezzo3, $note3, $idAzienda) {
    $stringSql = "UPDATE serverdb.bs_altri_prodotti b SET cod_prodotto='".$codProdotto."', nome_prodotto='".$nomeProdotto."', classificazione='" . $classificazione . "',
                    rating='" . $rating . "',
                    costo=" . $costo . ",
                    link_presentazione_prod='" . $linkPresentazioneProd . "',
                    features='" . $features . "',
                    corrispettivo_1='" . $corrispettivo1 . "',
                    prezzo_1=" . $prezzo1 . ",
                    note_1='" . $note1 . "',
                    corrispettivo_2='" . $corrispettivo2 . "',
                    prezzo_2=" . $prezzo2 . ",
                    note_2='" . $note2 . "',
                    corrispettivo_3='" . $corrispettivo3 . "',
                    prezzo_3=" . $prezzo3 . ",
                    note_3='" . $note3 . "',
                    id_azienda='" . $idAzienda . "'    
              WHERE
                    b.id_prodotto=" . $idProdotto;

    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}


function findBSAltroProdottoByCodice($codProdotto) {
    $stringSql = "SELECT * FROM serverdb.bs_altri_prodotti
                        WHERE
                           cod_prodotto='" . $codProdotto."'";

    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}

function findBSAltroProdCodiceUpdate($idProdotto,$codProdotto) {
    $stringSql = "SELECT * FROM serverdb.bs_altri_prodotti
                        WHERE
                           cod_prodotto='".$codProdotto."' AND id_prodotto<>".$idProdotto;

    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}