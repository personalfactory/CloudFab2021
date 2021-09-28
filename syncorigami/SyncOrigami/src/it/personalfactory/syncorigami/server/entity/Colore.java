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
import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.OneToMany;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "colore")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Colore.findAll", query = "SELECT c FROM Colore c"),
//  @NamedQuery(name = "Colore.findByIdColore", query = "SELECT c FROM Colore c WHERE c.idColore = :idColore"),
//  @NamedQuery(name = "Colore.findByCodColore", query = "SELECT c FROM Colore c WHERE c.codColore = :codColore"),
//  @NamedQuery(name = "Colore.findByNomeColore", query = "SELECT c FROM Colore c WHERE c.nomeColore = :nomeColore"),
//  @NamedQuery(name = "Colore.findByAbilitato", query = "SELECT c FROM Colore c WHERE c.abilitato = :abilitato"),
//  @NamedQuery(name = "Colore.findByDtAbilitato", query = "SELECT c FROM Colore c WHERE c.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Colore.findDatiNuovi", query = "SELECT c FROM Colore c WHERE  c.dtAbilitato > :dtAbilitato")})
public class Colore implements Serializable {
  @Basic(optional =   false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_colore")
  private Integer idColore;
  @Size(max = 50)
  @Column(name = "cod_colore")
  private String codColore;
  @Size(max = 100)
  @Column(name = "nome_colore")
  private String nomeColore;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idColore")
  private Collection<MazzettaColorata> mazzettaColorataCollection;
//  @OneToMany(mappedBy = "idColore")
//  private Collection<MazzettaColSingMac> mazzettaColSingMacCollection;

  public Colore() {
  }

  public Colore(Integer idColore) {
    this.idColore = idColore;
  }

  public Colore(Integer idColore, Date dtAbilitato) {
    this.idColore = idColore;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdColore() {
    return idColore;
  }

  public void setIdColore(Integer idColore) {
    this.idColore = idColore;
  }

  public String getCodColore() {
    return codColore;
  }

  public void setCodColore(String codColore) {
    this.codColore = codColore;
  }

  public String getNomeColore() {
    return nomeColore;
  }

  public void setNomeColore(String nomeColore) {
    this.nomeColore = nomeColore;
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
  public Collection<MazzettaColorata> getMazzettaColorataCollection() {
    return mazzettaColorataCollection;
  }

  public void setMazzettaColorataCollection(Collection<MazzettaColorata> mazzettaColorataCollection) {
    this.mazzettaColorataCollection = mazzettaColorataCollection;
  }

//  @XmlTransient
//  public Collection<MazzettaColSingMac> getMazzettaColSingMacCollection() {
//    return mazzettaColSingMacCollection;
//  }
//
//  public void setMazzettaColSingMacCollection(Collection<MazzettaColSingMac> mazzettaColSingMacCollection) {
//    this.mazzettaColSingMacCollection = mazzettaColSingMacCollection;
//  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idColore != null ? idColore.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Colore)) {
      return false;
    }
    Colore other = (Colore) object;
    if ((this.idColore == null && other.idColore != null) || (this.idColore != null && !this.idColore.equals(other.idColore))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

 

 
}
