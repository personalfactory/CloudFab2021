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
@Table(name = "dizionario_tipo")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "DizionarioTipo.findAll", query = "SELECT d FROM DizionarioTipo d"),
//  @NamedQuery(name = "DizionarioTipo.findByIdDizTipo", query = "SELECT d FROM DizionarioTipo d WHERE d.idDizTipo = :idDizTipo"),
//  @NamedQuery(name = "DizionarioTipo.findByDizionarioTipo", query = "SELECT d FROM DizionarioTipo d WHERE d.dizionarioTipo = :dizionarioTipo"),
//  @NamedQuery(name = "DizionarioTipo.findByTabella", query = "SELECT d FROM DizionarioTipo d WHERE d.tabella = :tabella"),
//  @NamedQuery(name = "DizionarioTipo.findByAbilitato", query = "SELECT d FROM DizionarioTipo d WHERE d.abilitato = :abilitato"),
//  @NamedQuery(name = "DizionarioTipo.findByDtAbilitato", query = "SELECT d FROM DizionarioTipo d WHERE d.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "DizionarioTipo.findDatiNuovi", query = "SELECT d FROM DizionarioTipo d WHERE d.dtAbilitato > :dtAbilitato")})
public class DizionarioTipo implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_diz_tipo")
  private Integer idDizTipo;
  @Size(max = 255)
  @Column(name = "dizionario_tipo")
  private String dizionarioTipo;
  @Size(max = 100)
  @Column(name = "tabella")
  private String tabella;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idDizTipo")
  private Collection<Dizionario> dizionarioCollection;

  public DizionarioTipo() {
  }

  public DizionarioTipo(Integer idDizTipo) {
    this.idDizTipo = idDizTipo;
  }

  public DizionarioTipo(Integer idDizTipo, Date dtAbilitato) {
    this.idDizTipo = idDizTipo;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdDizTipo() {
    return idDizTipo;
  }

  public void setIdDizTipo(Integer idDizTipo) {
    this.idDizTipo = idDizTipo;
  }

  public String getDizionarioTipo() {
    return dizionarioTipo;
  }

  public void setDizionarioTipo(String dizionarioTipo) {
    this.dizionarioTipo = dizionarioTipo;
  }

  public String getTabella() {
    return tabella;
  }

  public void setTabella(String tabella) {
    this.tabella = tabella;
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
  public Collection<Dizionario> getDizionarioCollection() {
    return dizionarioCollection;
  }

  public void setDizionarioCollection(Collection<Dizionario> dizionarioCollection) {
    this.dizionarioCollection = dizionarioCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idDizTipo != null ? idDizTipo.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof DizionarioTipo)) {
      return false;
    }
    DizionarioTipo other = (DizionarioTipo) object;
    if ((this.idDizTipo == null && other.idDizTipo != null) || (this.idDizTipo != null && !this.idDizTipo.equals(other.idDizTipo))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
