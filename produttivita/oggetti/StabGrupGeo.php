<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StabGrupGeo
 *
 * @author marilisa
 */
class StabGrupGeo {

  //put your code here
  private $id_macchina; //	int(11) 
  private $descri_stab; //	varchar(50) 
  private $gruppo; //	varchar(100) 
  private $geografico; //	varchar(100) 
  private $id_utente; //	int(11) 
  private $dt_ultima_modifica; //	timestamp 

  
  function __construct($id_macchina, $descri_stab, $gruppo, $geografico) {
    $this->id_macchina = $id_macchina;
    $this->descri_stab = $descri_stab;
    $this->gruppo = $gruppo;
    $this->geografico = $geografico;
   
  }

  
  public function getId_macchina() {
    return $this->id_macchina;
  }

  public function setId_macchina($id_macchina) {
    $this->id_macchina = $id_macchina;
  }

  public function getDescri_stab() {
    return $this->descri_stab;
  }

  public function setDescri_stab($descri_stab) {
    $this->descri_stab = $descri_stab;
  }

  public function getGruppo() {
    return $this->gruppo;
  }

  public function setGruppo($gruppo) {
    $this->gruppo = $gruppo;
  }

  public function getGeografico() {
    return $this->geografico;
  }

  public function setGeografico($geografico) {
    $this->geografico = $geografico;
  }

  public function getId_utente() {
    return $this->id_utente;
  }

  public function setId_utente($id_utente) {
    $this->id_utente = $id_utente;
  }

  public function getDt_ultima_modifica() {
    return $this->dt_ultima_modifica;
  }

  public function setDt_ultima_modifica($dt_ultima_modifica) {
    $this->dt_ultima_modifica = $dt_ultima_modifica;
  }

}

?>
