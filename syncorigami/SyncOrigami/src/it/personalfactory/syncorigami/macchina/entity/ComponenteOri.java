/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
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
@Table(name = "componente_ori")
@XmlRootElement
public class ComponenteOri implements Serializable {
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idComp")
  private Collection<ComponenteProdottoOri> componenteProdottoOriCollection;
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_comp")
  private Integer idComp;
  @Size(max = 50)
  @Column(name = "cod_componente")
  private String codComponente;
  @Size(max = 255)
  @Column(name = "descri_componente")
  private String descriComponente;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idComp")
  private Collection<ValoreParCompOri> valoreParCompOriCollection;

  public ComponenteOri() {
  }

  public ComponenteOri(Integer idComp) {
    this.idComp = idComp;
  }

  public ComponenteOri(Integer idComp, Date dtAbilitato) {
    this.idComp = idComp;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdComp() {
    return idComp;
  }

  public void setIdComp(Integer idComp) {
    this.idComp = idComp;
  }

  public String getCodComponente() {
    return codComponente;
  }

  public void setCodComponente(String codComponente) {
    this.codComponente = codComponente;
  }

  public String getDescriComponente() {
    return descriComponente;
  }

  public void setDescriComponente(String descriComponente) {
    this.descriComponente = descriComponente;
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
  public Collection<ValoreParCompOri> getValoreParCompOriCollection() {
    return valoreParCompOriCollection;
  }

  public void setValoreParCompOriCollection(Collection<ValoreParCompOri> valoreParCompOriCollection) {
    this.valoreParCompOriCollection = valoreParCompOriCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idComp != null ? idComp.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ComponenteOri)) {
      return false;
    }
    ComponenteOri other = (ComponenteOri) object;
    if ((this.idComp == null && other.idComp != null) || (this.idComp != null && !this.idComp.equals(other.idComp))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.macchina.entity.ComponenteOri[ idComp=" + idComp + " ]";
  }

 

  @XmlTransient
  public Collection<ComponenteProdottoOri> getComponenteProdottoOriCollection() {
    return componenteProdottoOriCollection;
  }

  public void setComponenteProdottoOriCollection(Collection<ComponenteProdottoOri> componenteProdottoOriCollection) {
    this.componenteProdottoOriCollection = componenteProdottoOriCollection;
  }
  
}
