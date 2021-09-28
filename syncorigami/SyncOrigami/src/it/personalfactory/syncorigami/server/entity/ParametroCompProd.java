/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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
@Table(name = "parametro_comp_prod")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroCompProd.findAll", query = "SELECT p FROM ParametroCompProd p"),
//  @NamedQuery(name = "ParametroCompProd.findByIdParComp", query = "SELECT p FROM ParametroCompProd p WHERE p.idParComp = :idParComp"),
//  @NamedQuery(name = "ParametroCompProd.findByNomeVariabile", query = "SELECT p FROM ParametroCompProd p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroCompProd.findByDescriVariabile", query = "SELECT p FROM ParametroCompProd p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroCompProd.findByValoreBase", query = "SELECT p FROM ParametroCompProd p WHERE p.valoreBase = :valoreBase"),
//  @NamedQuery(name = "ParametroCompProd.findByAbilitato", query = "SELECT p FROM ParametroCompProd p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroCompProd.findByDtAbilitato", query = "SELECT p FROM ParametroCompProd p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroCompProd.findDatiNuovi", query = "SELECT p FROM ParametroCompProd p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroCompProd implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
//  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_comp")
  private Integer idParComp;
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

  public ParametroCompProd() {
  }

  public ParametroCompProd(Integer idParComp) {
    this.idParComp = idParComp;
  }

  public ParametroCompProd(Integer idParComp, Date dtAbilitato) {
    this.idParComp = idParComp;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParComp() {
    return idParComp;
  }

  public void setIdParComp(Integer idParComp) {
    this.idParComp = idParComp;
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

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idParComp != null ? idParComp.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroCompProd)) {
      return false;
    }
    ParametroCompProd other = (ParametroCompProd) object;
    if ((this.idParComp == null && other.idParComp != null) || (this.idParComp != null && !this.idParComp.equals(other.idParComp))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.ParametroCompProd[ idParComp=" + idParComp + " ]";
  }
  
}
