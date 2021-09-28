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
@Table(name = "parametro_glob_mac")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroGlobMac.findAll", query = "SELECT p FROM ParametroGlobMac p"),
//  @NamedQuery(name = "ParametroGlobMac.findByIdParGm", query = "SELECT p FROM ParametroGlobMac p WHERE p.idParGm = :idParGm"),
//  @NamedQuery(name = "ParametroGlobMac.findByNomeVariabile", query = "SELECT p FROM ParametroGlobMac p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroGlobMac.findByDescriVariabile", query = "SELECT p FROM ParametroGlobMac p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroGlobMac.findByValoreVariabile", query = "SELECT p FROM ParametroGlobMac p WHERE p.valoreVariabile = :valoreVariabile"),
//  @NamedQuery(name = "ParametroGlobMac.findByAbilitato", query = "SELECT p FROM ParametroGlobMac p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroGlobMac.findByDtAbilitato", query = "SELECT p FROM ParametroGlobMac p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroGlobMac.findDatiNuovi", query = "SELECT p FROM ParametroGlobMac p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroGlobMac implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
//  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_gm")
  private Integer idParGm;
  @Size(max = 255)
  @Column(name = "nome_variabile")
  private String nomeVariabile;
  @Size(max = 255)
  @Column(name = "descri_variabile")
  private String descriVariabile;
  @Size(max = 255)
  @Column(name = "valore_variabile")
  private String valoreVariabile;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public ParametroGlobMac() {
  }

  public ParametroGlobMac(Integer idParGm) {
    this.idParGm = idParGm;
  }

  public ParametroGlobMac(Integer idParGm, Date dtAbilitato) {
    this.idParGm = idParGm;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParGm() {
    return idParGm;
  }

  public void setIdParGm(Integer idParGm) {
    this.idParGm = idParGm;
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

  public String getValoreVariabile() {
    return valoreVariabile;
  }

  public void setValoreVariabile(String valoreVariabile) {
    this.valoreVariabile = valoreVariabile;
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
    hash += (idParGm != null ? idParGm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroGlobMac)) {
      return false;
    }
    ParametroGlobMac other = (ParametroGlobMac) object;
    if ((this.idParGm == null && other.idParGm != null) || (this.idParGm != null && !this.idParGm.equals(other.idParGm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
