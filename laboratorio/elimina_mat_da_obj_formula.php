<?php
function eliminaMatDaObjFormula($codMat,$k){


for ($j = 0; $j < $k; $j++) {

    if ($_SESSION['LabMatpriTeoria'][$j]->getCodMat() == $codMat) {
        echo "</br>############## ELIMINAZIONE ####################</br>";
        unset($_SESSION['LabMatpriTeoria'][$j]);
        $k = $k - 1;
        echo "k : " . $k;
    }
}
}
?>