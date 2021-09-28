/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

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
@Table(name = "mazzetta_ori")
@XmlRootElement
public class MazzettaOri implements Serializable {
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  
  private static final long serialVersionUID = 1L;
  @Id
  //@GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_mazzetta")
  private Integer idMazzetta;
  @Size(max = 50)
  @Column(name = "cod_mazzetta")
  private String codMazzetta;
  @Size(max = 255)
  @Column(name = "nome_mazzetta")
  private String nomeMazzetta;
  
  @Column(name = "abilitato")
  private Boolean abilitato;
  
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMazzetta")
  private Collection<ProdottoOri> prodottoOriCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMazzetta")
  private Collection<MazzettaColorataOri> mazzettaColorataOriCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMazzetta")
  private Collection<MazzettaColSingMacOri> mazzettaColSingMacOriCollection;

  public MazzettaOri() {
  }

  public MazzettaOri(Integer idMazzetta) {
    this.idMazzetta = idMazzetta;
  }

  public MazzettaOri(Integer idMazzetta, Date dtAbilitato) {
    this.idMazzetta = idMazzetta;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdMazzetta() {
    return idMazzetta;
  }

  public void setIdMazzetta(Integer idMazzetta) {
    this.idMazzetta = idMazzetta;
  }

  public String getCodMazzetta() {
    return codMazzetta;
  }

  public void setCodMazzetta(String codMazzetta) {
    this.codMazzetta = codMazzetta;
  }

  public String getNomeMazzetta() {
    return nomeMazzetta;
  }

  public void setNomeMazzetta(String nomeMazzetta) {
    this.nomeMazzetta = nomeMazzetta;
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
  public Collection<ProdottoOri> getProdottoOriCollection() {
    return prodottoOriCollection;
  }

  public void setProdottoOriCollection(Collection<ProdottoOri> prodottoOriCollection) {
    this.prodottoOriCollection = prodottoOriCollection;
  }

  @XmlTransient
  public Collection<MazzettaColorataOri> getMazzettaColorataOriCollection() {
    return mazzettaColorataOriCollection;
  }

  public void setMazzettaColorataOriCollection(Collection<MazzettaColorataOri> mazzettaColorataOriCollection) {
    this.mazzettaColorataOriCollection = mazzettaColorataOriCollection;
  }

  @XmlTransient
  public Collection<MazzettaColSingMacOri> getMazzettaColSingMacOriCollection() {
    return mazzettaColSingMacOriCollection;
  }

  public void setMazzettaColSingMacOriCollection(Collection<MazzettaColSingMacOri> mazzettaColSingMacOriCollection) {
    this.mazzettaColSingMacOriCollection = mazzettaColSingMacOriCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idMazzetta != null ? idMazzetta.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof MazzettaOri)) {
      return false;
    }
    MazzettaOri other = (MazzettaOri) object;
    if ((this.idMazzetta == null && other.idMazzetta != null) || (this.idMazzetta != null && !this.idMazzetta.equals(other.idMazzetta))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

 

  
}
