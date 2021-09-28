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
@Table(name = "componente")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Componente.findAll", query = "SELECT c FROM Componente c"),
//  @NamedQuery(name = "Componente.findByIdComp", query = "SELECT c FROM Componente c WHERE c.idComp = :idComp"),
//  @NamedQuery(name = "Componente.findByCodComponente", query = "SELECT c FROM Componente c WHERE c.codComponente = :codComponente"),
//  @NamedQuery(name = "Componente.findByDescriComponente", query = "SELECT c FROM Componente c WHERE c.descriComponente = :descriComponente"),
//  @NamedQuery(name = "Componente.findByAbilitato", query = "SELECT c FROM Componente c WHERE c.abilitato = :abilitato"),
//  @NamedQuery(name = "Componente.findByDtAbilitato", query = "SELECT c FROM Componente c WHERE c.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Componente.findDatiNuovi", query = "SELECT c FROM Componente c, ComponenteProdotto cp, AnagrafeProdotto a "
          + "WHERE c.idComp=cp.idComp AND cp.idProdotto=a.idProdotto "
          + "AND (c.dtAbilitato > :dtAbilitato OR cp.dtAbilitato > :dtAbilitato OR a.dtAbilitato > :dtAbilitato) "
          + "GROUP BY c.idComp")})
public class Componente implements Serializable {
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
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
   @Basic(optional =   false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idComp")
  private Collection<ComponenteProdotto> componenteProdottoCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idComp")
  private Collection<ValoreParComp> valoreParCompCollection;
  private static final long serialVersionUID = 1L;

  public Componente() {
  }

  public Componente(Integer idComp) {
    this.idComp = idComp;
  }

  public Componente(Integer idComp, Date dtAbilitato) {
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

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idComp != null ? idComp.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Componente)) {
      return false;
    }
    Componente other = (Componente) object;
    if ((this.idComp == null && other.idComp != null) || (this.idComp != null && !this.idComp.equals(other.idComp))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

  
  @XmlTransient
  public Collection<ValoreParComp> getValoreParCompCollection() {
    return valoreParCompCollection;
  }

  public void setValoreParCompCollection(Collection<ValoreParComp> valoreParCompCollection) {
    this.valoreParCompCollection = valoreParCompCollection;
  }

  
  @XmlTransient
  public Collection<ComponenteProdotto> getComponenteProdottoCollection() {
    return componenteProdottoCollection;
  }

  public void setComponenteProdottoCollection(Collection<ComponenteProdotto> componenteProdottoCollection) {
    this.componenteProdottoCollection = componenteProdottoCollection;
  }

  
    
}
