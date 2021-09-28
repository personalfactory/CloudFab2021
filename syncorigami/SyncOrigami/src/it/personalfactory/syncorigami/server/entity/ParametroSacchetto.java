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
@Table(name = "parametro_sacchetto")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroSacchetto.findAll", query = "SELECT p FROM ParametroSacchetto p"),
//  @NamedQuery(name = "ParametroSacchetto.findByIdParSac", query = "SELECT p FROM ParametroSacchetto p WHERE p.idParSac = :idParSac"),
//  @NamedQuery(name = "ParametroSacchetto.findByNomeVariabile", query = "SELECT p FROM ParametroSacchetto p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroSacchetto.findByDescriVariabile", query = "SELECT p FROM ParametroSacchetto p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroSacchetto.findByValoreBase", query = "SELECT p FROM ParametroSacchetto p WHERE p.valoreBase = :valoreBase"),
//  @NamedQuery(name = "ParametroSacchetto.findByAbilitato", query = "SELECT p FROM ParametroSacchetto p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroSacchetto.findByDtAbilitato", query = "SELECT p FROM ParametroSacchetto p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroSacchetto.findDatiNuovi", query = "SELECT p FROM ParametroSacchetto p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroSacchetto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
//  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_sac")
  private Integer idParSac;
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
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idParSac")
  private Collection<ValoreParSacchetto> valoreParSacchettoCollection;

  public ParametroSacchetto() {
  }

  public ParametroSacchetto(Integer idParSac) {
    this.idParSac = idParSac;
  }

  public ParametroSacchetto(Integer idParSac, Date dtAbilitato) {
    this.idParSac = idParSac;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParSac() {
    return idParSac;
  }

  public void setIdParSac(Integer idParSac) {
    this.idParSac = idParSac;
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
  public Collection<ValoreParSacchetto> getValoreParSacchettoCollection() {
    return valoreParSacchettoCollection;
  }

  public void setValoreParSacchettoCollection(Collection<ValoreParSacchetto> valoreParSacchettoCollection) {
    this.valoreParSacchettoCollection = valoreParSacchettoCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idParSac != null ? idParSac.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroSacchetto)) {
      return false;
    }
    ParametroSacchetto other = (ParametroSacchetto) object;
    if ((this.idParSac == null && other.idParSac != null) || (this.idParSac != null && !this.idParSac.equals(other.idParSac))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
