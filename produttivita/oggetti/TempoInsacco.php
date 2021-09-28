<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempoInsacco
 *
 * @author marilisa
 */
class TempoInsacco {
private $id_macchina;	// int(11) 
private $dt_produzione_mac; // timestamp 
private $cod_operatore; // varchar(255) 
private $cod_prodotto;	// varchar(255) 
private $cod_chimica; // varchar(255) 
private $somma_tempo_sec; //	decimal(41,0) //tempo di insacco per ciascun codice chimica
private $num_sac; //	bigint(21) Numero di sacchi per ciascun codice chimica
private $media_per_cod_chimica;	//decimal(45,4) 
private $media_per_cod_chimica_pesata; //	varchar(45) 
private $dt_ultima_modifica; //	timestamp 


function __construct($id_macchina, $dt_produzione_mac,$cod_operatore, $cod_prodotto, $cod_chimica
        //, $somma_tempo_sec, $num_sac, $media_per_cod_chimica, $media_per_cod_chimica_pesata
        ) {
    $this->id_macchina = $id_macchina;
    $this->dt_produzione_mac = $dt_produzione_mac;
    $this->cod_operatore = $cod_operatore;
    $this->cod_prodotto = $cod_prodotto;
    $this->cod_chimica = $cod_chimica;
 //   $this->somma_tempo_sec = $somma_tempo_sec;
//    $this->num_sac = $num_sac;
//    $this->media_per_cod_chimica = $media_per_cod_chimica;
//    $this->media_per_cod_chimica_pesata = $media_per_cod_chimica_pesata;
   
}

function toString(){
        
$output= "</br>objTempoInsacco [IdMac:".$this->id_macchina.
        "; DtProd:".$this->dt_produzione_mac.
        "; CodChim:".$this->cod_chimica.
        "; CodProd:".$this->cod_prodotto.
        "; NumSac:".$this->somma_tempo_sec.
        "; NumSac:".$this->num_sac."]</br>";

  return $output;    
    
}

public function medieAritPerCodChim(){
 if($this->num_sac!=0){
    $this->media_per_cod_chimica= $this->somma_tempo_sec/$this->num_sac;
 } 
}

/**
 * @return type
 */
public function mediePesate(){
  if($this->num_sac!=0){

    return $this->media_per_cod_chimica*$this->num_sac;
  }
}
//public function mediaPesate($arrayMediePes,$numSacTot){
// 
//   
//    $mediePes=$medieArit*$numSac;
//    
//    return $mediePes;
//    
//}


public function getId_macchina() {
    return $this->id_macchina;
}

public function setId_macchina($id_macchina) {
    $this->id_macchina = $id_macchina;
}

public function getDt_produzione_mac() {
    return $this->dt_produzione_mac;
}

public function setDt_produzione_mac($dt_produzione_mac) {
    $this->dt_produzione_mac = $dt_produzione_mac;
}

public function getCod_operatore() {
    return $this->cod_operatore;
}

public function setCod_operatore($cod_operatore) {
    $this->cod_operatore = $cod_operatore;
}

public function getCod_prodotto() {
    return $this->cod_prodotto;
}

public function setCod_prodotto($cod_prodotto) {
    $this->cod_prodotto = $cod_prodotto;
}

public function getCod_chimica() {
    return $this->cod_chimica;
}

public function setCod_chimica($cod_chimica) {
    $this->cod_chimica = $cod_chimica;
}

public function getSomma_tempo_sec() {
    return $this->somma_tempo_sec;
}

public function setSomma_tempo_sec($somma_tempo_sec) {
    $this->somma_tempo_sec = $somma_tempo_sec;
}

public function getNum_sac() {
    return $this->num_sac;
}

public function setNum_sac($num_sac) {
    $this->num_sac = $num_sac;
}

public function getMedia_per_cod_chimica() {
    return $this->media_per_cod_chimica;
}

public function setMedia_per_cod_chimica($media_per_cod_chimica) {
    $this->media_per_cod_chimica = $media_per_cod_chimica;
}

public function getMedia_per_cod_chimica_pesata() {
    return $this->media_per_cod_chimica_pesata;
}

public function setMedia_per_cod_chimica_pesata($media_per_cod_chimica_pesata) {
    $this->media_per_cod_chimica_pesata = $media_per_cod_chimica_pesata;
}

public function getDt_ultima_modifica() {
    return $this->dt_ultima_modifica;
}

public function setDt_ultima_modifica($dt_ultima_modifica) {
    $this->dt_ultima_modifica = $dt_ultima_modifica;
}




}

?>
