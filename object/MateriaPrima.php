<?php
/**
 * 
 */
class MateriaPrima {

  //put your code here
  private $codice; 
  private $descri; 
  private $prezzo;  
  private $quantia; 

  function __construct($codice, $descri, $prezzo, $quantia) {
      $this->codice = $codice;
      $this->descri = $descri;
      $this->prezzo = $prezzo;
      $this->quantia = $quantia;
  }

  public function getCodice() {
      return $this->codice;
  }

  public function getDescri() {
      return $this->descri;
  }

  public function getPrezzo() {
      return $this->prezzo;
  }

  public function getQuantia() {
      return $this->quantia;
  }


}
 
?>
