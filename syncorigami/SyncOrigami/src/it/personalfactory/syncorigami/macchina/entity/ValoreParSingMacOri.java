/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

import it.divinotaras.jpa.entitysupport.DTEntityExtStatic;
import java.io.Serializable;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "valore_par_sing_mac_ori")
@XmlRootElement
public class ValoreParSingMacOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_par_sm")
  private Integer idValParSm;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_sm")
  private int idParSm;
 
  @Size(max = 255)
  @Column(name = "valore_variabile")
  private String valoreVariabile;
  @Size(max = 255)
  @Column(name = "valore_iniziale")
  private String valoreIniziale;
 
  //Non viene aggiornata automaticamente durante insert e update
  @Column(name = "dt_valore_iniziale", insertable = false, updatable=false)
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtValoreIniziale;
  
  //Non viene aggiornata automaticamente durante insert e update
  @Column(name = "dt_modifica_mac", insertable = false, updatable=false)
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtModificaMac;
  
  @Column(name = "abilitato")
  private Boolean abilitato;
  
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public ValoreParSingMacOri() {
  }

  public ValoreParSingMacOri(Integer idValParSm) {
    this.idValParSm = idValParSm;
  }

  public ValoreParSingMacOri(Integer idValParSm, int idParSm, Date dtAbilitato) {
    this.idValParSm = idValParSm;
    this.idParSm = idParSm;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdValParSm() {
    return idValParSm;
  }

  public void setIdValParSm(Integer idValParSm) {
    this.idValParSm = idValParSm;
  }

  public int getIdParSm() {
    return idParSm;
  }

  public void setIdParSm(int idParSm) {
    this.idParSm = idParSm;
  }

  public String getValoreVariabile() {
    return valoreVariabile;
  }

  public void setValoreVariabile(String valoreVariabile) {
    this.valoreVariabile = valoreVariabile;
  }

  public String getValoreIniziale() {
    return valoreIniziale;
  }

  public void setValoreIniziale(String valoreIniziale) {
    this.valoreIniziale = valoreIniziale;
  }

  public Date getDtValoreIniziale() {
    return dtValoreIniziale;
  }

  public void setDtValoreIniziale(Date dtValoreIniziale) {
    this.dtValoreIniziale = dtValoreIniziale;
  }

  public Date getDtModificaMac() {
    return dtModificaMac;
  }

  public void setDtModificaMac(Date dtModificaMac) {
    this.dtModificaMac = dtModificaMac;
  }

  public Boolean getAbilitato() {
    return abilitato;
  }

  public void setAbilitato(Boolean abilitato) {
    this.abilitato = abilitato;
  }

  
  public Date getDtAbilitato() {
    return dtAbilitato;
  }

  public void setDtAbilitato(Date dtAbilitato) {
    this.dtAbilitato = dtAbilitato;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValParSm != null ? idValParSm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParSingMacOri)) {
      return false;
    }
    ValoreParSingMacOri other = (ValoreParSingMacOri) object;
    if ((this.idValParSm == null && other.idValParSm != null) || (this.idValParSm != null && !this.idValParSm.equals(other.idValParSm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
