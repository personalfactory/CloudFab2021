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
@Table(name = "presa")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Presa.findAll", query = "SELECT p FROM Presa p"),
//  @NamedQuery(name = "Presa.findByIdPresa", query = "SELECT p FROM Presa p WHERE p.idPresa = :idPresa"),
//  @NamedQuery(name = "Presa.findByPresa", query = "SELECT p FROM Presa p WHERE p.presa = :presa"),
//  @NamedQuery(name = "Presa.findByAbilitato", query = "SELECT p FROM Presa p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "Presa.findByDtAbilitato", query = "SELECT p FROM Presa p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Presa.findDatiNuovi", query = "SELECT p FROM Presa p WHERE p.dtAbilitato > :dtAbilitato")})
public class Presa implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_presa")
  private Integer idPresa;
  @Size(max = 255)
  @Column(name = "presa")
  private String presa;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public Presa() {
  }

  public Presa(Integer idPresa) {
    this.idPresa = idPresa;
  }

  public Presa(Integer idPresa, Date dtAbilitato) {
    this.idPresa = idPresa;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdPresa() {
    return idPresa;
  }

  public void setIdPresa(Integer idPresa) {
    this.idPresa = idPresa;
  }

  public String getPresa() {
    return presa;
  }

  public void setPresa(String presa) {
    this.presa = presa;
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
    hash += (idPresa != null ? idPresa.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Presa)) {
      return false;
    }
    Presa other = (Presa) object;
    if ((this.idPresa == null && other.idPresa != null) || (this.idPresa != null && !this.idPresa.equals(other.idPresa))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
