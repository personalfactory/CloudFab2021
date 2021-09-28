/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import it.divinotaras.jpa.entitysupport.DTEntityExtStatic;
import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.OneToMany;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.validation.constraints.NotNull;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "num_sacchetto")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "NumSacchetto.findAll", query = "SELECT n FROM NumSacchetto n"),
//  @NamedQuery(name = "NumSacchetto.findByIdNumSac", query = "SELECT n FROM NumSacchetto n WHERE n.idNumSac = :idNumSac"),
//  @NamedQuery(name = "NumSacchetto.findByNumSacchetti", query = "SELECT n FROM NumSacchetto n WHERE n.numSacchetti = :numSacchetti"),
//  @NamedQuery(name = "NumSacchetto.findByAbilitato", query = "SELECT n FROM NumSacchetto n WHERE n.abilitato = :abilitato"),
//  @NamedQuery(name = "NumSacchetto.findByDtAbilitato", query = "SELECT n FROM NumSacchetto n WHERE n.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "NumSacchetto.findDatiNuovi", query = "SELECT n FROM NumSacchetto n WHERE n.dtAbilitato > :dtAbilitato")})
public class NumSacchetto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_num_sac")
  private Integer idNumSac;
  @Basic(optional = false)
  @NotNull
  @Column(name = "num_sacchetti")
  private int numSacchetti;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(mappedBy = "idNumSac")
  private Collection<ValoreParSacchetto> valoreParSacchettoCollection;
  @JoinColumn(name = "id_cat", referencedColumnName = "id_cat")
  @ManyToOne(optional = false)
  private Categoria idCat;

  public NumSacchetto() {
  }

  public NumSacchetto(Integer idNumSac) {
    this.idNumSac = idNumSac;
  }

  public NumSacchetto(Integer idNumSac, int numSacchetti, Date dtAbilitato) {
    this.idNumSac = idNumSac;
    this.numSacchetti = numSacchetti;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdNumSac() {
    return idNumSac;
  }

  public void setIdNumSac(Integer idNumSac) {
    this.idNumSac = idNumSac;
  }

  public int getNumSacchetti() {
    return numSacchetti;
  }

  public void setNumSacchetti(int numSacchetti) {
    this.numSacchetti = numSacchetti;
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

  @XmlTransient
  public Collection<ValoreParSacchetto> getValoreParSacchettoCollection() {
    return valoreParSacchettoCollection;
  }

  public void setValoreParSacchettoCollection(Collection<ValoreParSacchetto> valoreParSacchettoCollection) {
    this.valoreParSacchettoCollection = valoreParSacchettoCollection;
  }

  public Categoria getIdCat() {
    return idCat;
  }

  public void setIdCat(Categoria idCat) {
    this.idCat = idCat;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idNumSac != null ? idNumSac.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof NumSacchetto)) {
      return false;
    }
    NumSacchetto other = (NumSacchetto) object;
    if ((this.idNumSac == null && other.idNumSac != null) || (this.idNumSac != null && !this.idNumSac.equals(other.idNumSac))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
