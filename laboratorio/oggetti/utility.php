<?php

include('Risultato.php');

/**
 * La funzione prende come argomento due oggetti risultato 
 * di due esperimenti diversi con stessa caratteristica
 * e restituisce l'oggetto contenente la media dei risultato
 * da usare solo quando si è sicuri di poter fare la media fra i due oggetti
 * ovvero qunado hanno la stessa dimensione
 */
function mergeRisultati($risultato1, $risultato2) {
    $risultato3 = new Risultato();
    $risultato3->setIdEsperimento(0);
    $risultato3->setIdCaratteristica($risultato1->getIdCaratteristica);
    $risultato3->setValoreCar(($risultato1->getValCar + $risultato2) / 2);
    $risultato3->setValoreDim($risultato1->getValDim);

    return $risultato3;
}

?>
