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
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
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
@Table(name = "valore_ripristino_ori")
@XmlRootElement
public class ValoreRipristinoOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  //@GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_valore_ripristino")
  private Integer idValoreRipristino;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_ripristino")
  private int idParRipristino;
  
  @Size(max = 255)
  @Column(name = "valore_variabile")
  private String valoreVariabile;
  @Column(name = "id_pro_corso")
  private Integer idProCorso;
  
  //Non viene aggiornata automaticamente durante insert e update
  @Column(name = "dt_registrato", insertable = false, updatable=false)
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtRegistrato;
  
  @Column(name = "abilitato")
  private Boolean abilitato;
  
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public ValoreRipristinoOri() {
  }

  public ValoreRipristinoOri(Integer idValoreRipristino) {
    this.idValoreRipristino = idValoreRipristino;
  }

  public ValoreRipristinoOri(Integer idValoreRipristino, int idParRipristino, Date dtAbilitato) {
    this.idValoreRipristino = idValoreRipristino;
    this.idParRipristino = idParRipristino;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdValoreRipristino() {
    return idValoreRipristino;
  }

  public void setIdValoreRipristino(Integer idValoreRipristino) {
    this.idValoreRipristino = idValoreRipristino;
  }

  public int getIdParRipristino() {
    return idParRipristino;
  }

  public void setIdParRipristino(int idParRipristino) {
    this.idParRipristino = idParRipristino;
  }

  public String getValoreVariabile() {
    return valoreVariabile;
  }

  public void setValoreVariabile(String valoreVariabile) {
    this.valoreVariabile = valoreVariabile;
  }

  public Integer getIdProCorso() {
    return idProCorso;
  }

  public void setIdProCorso(Integer idProCorso) {
    this.idProCorso = idProCorso;
  }

  public Date getDtRegistrato() {
    return dtRegistrato;
  }

  public void setDtRegistrato(Date dtRegistrato) {
    this.dtRegistrato = dtRegistrato;
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
    hash += (idValoreRipristino != null ? idValoreRipristino.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreRipristinoOri)) {
      return false;
    }
    ValoreRipristinoOri other = (ValoreRipristinoOri) object;
    if ((this.idValoreRipristino == null && other.idValoreRipristino != null) || (this.idValoreRipristino != null && !this.idValoreRipristino.equals(other.idValoreRipristino))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
