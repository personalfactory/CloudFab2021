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
@Table(name = "parametro_sing_mac")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroSingMac.findAll", query = "SELECT p FROM ParametroSingMac p"),
//  @NamedQuery(name = "ParametroSingMac.findByIdParSm", query = "SELECT p FROM ParametroSingMac p WHERE p.idParSm = :idParSm"),
//  @NamedQuery(name = "ParametroSingMac.findByNomeVariabile", query = "SELECT p FROM ParametroSingMac p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroSingMac.findByDescriVariabile", query = "SELECT p FROM ParametroSingMac p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroSingMac.findByValoreBase", query = "SELECT p FROM ParametroSingMac p WHERE p.valoreBase = :valoreBase"),
//  @NamedQuery(name = "ParametroSingMac.findByAbilitato", query = "SELECT p FROM ParametroSingMac p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroSingMac.findByDtAbilitato", query = "SELECT p FROM ParametroSingMac p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroSingMac.findDatiNuovi", query = "SELECT p FROM ParametroSingMac p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroSingMac implements Serializable {
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  private static final long serialVersionUID = 1L;
  @Id
//  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_sm")
  private Integer idParSm;
  @Size(max = 255)
  @Column(name = "nome_variabile")
  private String nomeVariabile;
  @Size(max = 255)
  @Column(name = "descri_variabile")
  private String descriVariabile;
  @Size(max = 255)
  @Column(name = "valore_base")
  private String valoreBase;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idParSm")
  private Collection<ValoreParSingMac> valoreParSingMacCollection;

  public ParametroSingMac() {
  }

  public ParametroSingMac(Integer idParSm) {
    this.idParSm = idParSm;
  }

  public ParametroSingMac(Integer idParSm, Date dtAbilitato) {
    this.idParSm = idParSm;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParSm() {
    return idParSm;
  }

  public void setIdParSm(Integer idParSm) {
    this.idParSm = idParSm;
  }

  public String getNomeVariabile() {
    return nomeVariabile;
  }

  public void setNomeVariabile(String nomeVariabile) {
    this.nomeVariabile = nomeVariabile;
  }

  public String getDescriVariabile() {
    return descriVariabile;
  }

  public void setDescriVariabile(String descriVariabile) {
    this.descriVariabile = descriVariabile;
  }

  public String getValoreBase() {
    return valoreBase;
  }

  public void setValoreBase(String valoreBase) {
    this.valoreBase = valoreBase;
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
  public Collection<ValoreParSingMac> getValoreParSingMacCollection() {
    return valoreParSingMacCollection;
  }

  public void setValoreParSingMacCollection(Collection<ValoreParSingMac> valoreParSingMacCollection) {
    this.valoreParSingMacCollection = valoreParSingMacCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idParSm != null ? idParSm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroSingMac)) {
      return false;
    }
    ParametroSingMac other = (ParametroSingMac) object;
    if ((this.idParSm == null && other.idParSm != null) || (this.idParSm != null && !this.idParSm.equals(other.idParSm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

  
  
}
