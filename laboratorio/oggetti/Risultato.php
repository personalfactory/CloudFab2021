<?php
/**
 * Description of Risultato
 *
 * @author marilisa
 */
class Risultato {

  //put your code here
  private $idEsperimento; //int
  private $idCaratteristica; //int
  private $valoreCar; //varchar(255) 
  private $valoreDim; //double
  private $note; //text

  function __construct($idEsperimento, $idCaratteristica, $valoreCar, $valoreDim,$note){
    $this->idEsperimento = $idEsperimento;
    $this->idCaratteristica = $idCaratteristica;
    $this->valoreCar = $valoreCar;
    $this->valoreDim = $valoreDim;
    $this->note = $note;
 }
// public function __destruct() {
//    $this->idEsperimento-> 
//    $this->idCaratteristica  ;
//    $this->valoreCar = ;
//    $this->valoreDim ;
// }

  
 function toString(){
        
    $output= "</br>objEsperimento [IdEsper:".$this->idEsperimento.
        "; IdCar:".$this->idCaratteristica.
        "; ValCar:".$this->valoreCar.
        "; ValDim:".$this->valoreDim."]</br>";

  return $output;    
    
}
public function getNote() {
    return $this->note;
}

public function setNote($note) {
    $this->note = $note;
}

public function getIdEsperimento() {
    return $this->idEsperimento;
}

public function setIdEsperimento($idEsperimento) {
    $this->idEsperimento = $idEsperimento;
}

public function getIdCaratteristica() {
    return $this->idCaratteristica;
}

public function setIdCaratteristica($idCaratteristica) {
    $this->idCaratteristica = $idCaratteristica;
}

public function getValoreCar() {
    return $this->valoreCar;
}

public function setValoreCar($valoreCar) {
    $this->valoreCar = $valoreCar;
}

public function getValoreDim() {
    return $this->valoreDim;
}

public function setValoreDim($valoreDim) {
    $this->valoreDim = $valoreDim;
}



 
  
 

}

?>
