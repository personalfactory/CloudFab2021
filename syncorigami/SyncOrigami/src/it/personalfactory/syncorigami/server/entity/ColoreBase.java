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
@Table(name = "colore_base")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ColoreBase.findAll", query = "SELECT c FROM ColoreBase c"),
//  @NamedQuery(name = "ColoreBase.findByIdColoreBase", query = "SELECT c FROM ColoreBase c WHERE c.idColoreBase = :idColoreBase"),
//  @NamedQuery(name = "ColoreBase.findByNomeColoreBase", query = "SELECT c FROM ColoreBase c WHERE c.nomeColoreBase = :nomeColoreBase"),
//  @NamedQuery(name = "ColoreBase.findByCodColoreBase", query = "SELECT c FROM ColoreBase c WHERE c.codColoreBase = :codColoreBase"),
//  @NamedQuery(name = "ColoreBase.findByAbilitato", query = "SELECT c FROM ColoreBase c WHERE c.abilitato = :abilitato"),
//  @NamedQuery(name = "ColoreBase.findByDtAbilitato", query = "SELECT c FROM ColoreBase c WHERE c.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "ColoreBase.findByCostoColoreBase", query = "SELECT c FROM ColoreBase c WHERE c.costoColoreBase = :costoColoreBase"),
//  @NamedQuery(name = "ColoreBase.findByTollPerc", query = "SELECT c FROM ColoreBase c WHERE c.tollPerc = :tollPerc"),
  @NamedQuery(name = "ColoreBase.findDatiNuovi", query = "SELECT c FROM ColoreBase c WHERE  c.dtAbilitato > :dtAbilitato")})
public class ColoreBase implements Serializable {
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
  @Column(name = "id_colore_base")
  private Integer idColoreBase;
  @Size(max = 50)
  @Column(name = "nome_colore_base")
  private String nomeColoreBase;
  @Size(max = 50)
  @Column(name = "cod_colore_base")
  private String codColoreBase;
  
  @Column(name = "abilitato")
  private Boolean abilitato;
  // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
  @Column(name = "costo_colore_base")
  private Double costoColoreBase;
  @Column(name = "toll_perc")
  private Double tollPerc;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idColoreBase")
  private Collection<MazzettaColorata> mazzettaColorataCollection;
  @OneToMany(mappedBy = "idColoreBase")
  private Collection<MazzettaColSingMac> mazzettaColSingMacCollection;

  public ColoreBase() {
  }

  public ColoreBase(Integer idColoreBase) {
    this.idColoreBase = idColoreBase;
  }

  public ColoreBase(Integer idColoreBase, Date dtAbilitato) {
    this.idColoreBase = idColoreBase;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdColoreBase() {
    return idColoreBase;
  }

  public void setIdColoreBase(Integer idColoreBase) {
    this.idColoreBase = idColoreBase;
  }

  public String getNomeColoreBase() {
    return nomeColoreBase;
  }

  public void setNomeColoreBase(String nomeColoreBase) {
    this.nomeColoreBase = nomeColoreBase;
  }

  public String getCodColoreBase() {
    return codColoreBase;
  }

  public void setCodColoreBase(String codColoreBase) {
    this.codColoreBase = codColoreBase;
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

  public Double getCostoColoreBase() {
    return costoColoreBase;
  }

  public void setCostoColoreBase(Double costoColoreBase) {
    this.costoColoreBase = costoColoreBase;
  }

  public Double getTollPerc() {
    return tollPerc;
  }

  public void setTollPerc(Double tollPerc) {
    this.tollPerc = tollPerc;
  }

  @XmlTransient
  public Collection<MazzettaColorata> getMazzettaColorataCollection() {
    return mazzettaColorataCollection;
  }

  public void setMazzettaColorataCollection(Collection<MazzettaColorata> mazzettaColorataCollection) {
    this.mazzettaColorataCollection = mazzettaColorataCollection;
  }

  @XmlTransient
  public Collection<MazzettaColSingMac> getMazzettaColSingMacCollection() {
    return mazzettaColSingMacCollection;
  }

  public void setMazzettaColSingMacCollection(Collection<MazzettaColSingMac> mazzettaColSingMacCollection) {
    this.mazzettaColSingMacCollection = mazzettaColSingMacCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idColoreBase != null ? idColoreBase.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ColoreBase)) {
      return false;
    }
    ColoreBase other = (ColoreBase) object;
    if ((this.idColoreBase == null && other.idColoreBase != null) || (this.idColoreBase != null && !this.idColoreBase.equals(other.idColoreBase))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

 

  
  
}
