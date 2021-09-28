/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "parametro_prod_mac")
@XmlRootElement
@NamedQueries({
  @NamedQuery(name = "ParametroProdMac.findDatiNuovi", query = "SELECT p FROM ParametroProdMac p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroProdMac implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_pm")
  private Integer idParPm;
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

  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idParPm")
  private Collection<ValoreParProdMac> valoreParProdMacCollection;
  
  public ParametroProdMac() {
  }

  public ParametroProdMac(Integer idParPm) {
    this.idParPm = idParPm;
  }

  public ParametroProdMac(Integer idParPm, Date dtAbilitato) {
    this.idParPm = idParPm;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParPm() {
    return idParPm;
  }

  public void setIdParPm(Integer idParPm) {
    this.idParPm = idParPm;
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
    hash += (idParPm != null ? idParPm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroProdMac)) {
      return false;
    }
    ParametroProdMac other = (ParametroProdMac) object;
    if ((this.idParPm == null && other.idParPm != null) || (this.idParPm != null && !this.idParPm.equals(other.idParPm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.ParametroProdMac[ idParPm=" + idParPm + " ]";
  }
  
}
