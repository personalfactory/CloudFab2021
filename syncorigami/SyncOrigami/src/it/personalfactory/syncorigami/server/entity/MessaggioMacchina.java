/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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
@Table(name = "messaggio_macchina")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "MessaggioMacchina.findAll", query = "SELECT m FROM MessaggioMacchina m"),
//  @NamedQuery(name = "MessaggioMacchina.findByIdMessaggio", query = "SELECT m FROM MessaggioMacchina m WHERE m.idMessaggio = :idMessaggio"),
//  @NamedQuery(name = "MessaggioMacchina.findByMessaggio", query = "SELECT m FROM MessaggioMacchina m WHERE m.messaggio = :messaggio"),
//  @NamedQuery(name = "MessaggioMacchina.findByAbilitato", query = "SELECT m FROM MessaggioMacchina m WHERE m.abilitato = :abilitato"),
//  @NamedQuery(name = "MessaggioMacchina.findByDtAbilitato", query = "SELECT m FROM MessaggioMacchina m WHERE m.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "MessaggioMacchina.findDatiNuovi", query = "SELECT m FROM MessaggioMacchina m WHERE m.dtAbilitato > :dtAbilitato")})
public class MessaggioMacchina implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_messaggio")
  private Integer idMessaggio;
  @Column(name = "messaggio")
  private String messaggio;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public MessaggioMacchina() {
  }

  public MessaggioMacchina(Integer idMessaggio) {
    this.idMessaggio = idMessaggio;
  }

  public MessaggioMacchina(Integer idMessaggio, Date dtAbilitato) {
    this.idMessaggio = idMessaggio;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdMessaggio() {
    return idMessaggio;
  }

  public void setIdMessaggio(Integer idMessaggio) {
    this.idMessaggio = idMessaggio;
  }

  public String getMessaggio() {
    return messaggio;
  }

  public void setMessaggio(String messaggio) {
    this.messaggio = messaggio;
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
    hash += (idMessaggio != null ? idMessaggio.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof MessaggioMacchina)) {
      return false;
    }
    MessaggioMacchina other = (MessaggioMacchina) object;
    if ((this.idMessaggio == null && other.idMessaggio != null) || (this.idMessaggio != null && !this.idMessaggio.equals(other.idMessaggio))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
