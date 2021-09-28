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
@Table(name = "parametro_prodotto")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroProdotto.findAll", query = "SELECT p FROM ParametroProdotto p"),
//  @NamedQuery(name = "ParametroProdotto.findByIdParProd", query = "SELECT p FROM ParametroProdotto p WHERE p.idParProd = :idParProd"),
//  @NamedQuery(name = "ParametroProdotto.findByNomeVariabile", query = "SELECT p FROM ParametroProdotto p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroProdotto.findByDescriVariabile", query = "SELECT p FROM ParametroProdotto p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroProdotto.findByValoreBase", query = "SELECT p FROM ParametroProdotto p WHERE p.valoreBase = :valoreBase"),
//  @NamedQuery(name = "ParametroProdotto.findByAbilitato", query = "SELECT p FROM ParametroProdotto p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroProdotto.findByDtAbilitato", query = "SELECT p FROM ParametroProdotto p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroProdotto.findDatiNuovi", query = "SELECT p FROM ParametroProdotto p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroProdotto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
//  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_prod")
  private Integer idParProd;
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
  private Integer abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idParProd")
  private Collection<ValoreParProd> valoreParProdCollection;

  public ParametroProdotto() {
  }

  public ParametroProdotto(Integer idParProd) {
    this.idParProd = idParProd;
  }

  public ParametroProdotto(Integer idParProd, Date dtAbilitato) {
    this.idParProd = idParProd;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParProd() {
    return idParProd;
  }

  public void setIdParProd(Integer idParProd) {
    this.idParProd = idParProd;
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

  public Integer getAbilitato() {
    return abilitato;
  }

  public void setAbilitato(Integer abilitato) {
    this.abilitato = abilitato;
  }

  public Date getDtAbilitato() {
    return dtAbilitato;
  }

  public void setDtAbilitato(Date dtAbilitato) {
    this.dtAbilitato = dtAbilitato;
  }

  @XmlTransient
  public Collection<ValoreParProd> getValoreParProdCollection() {
    return valoreParProdCollection;
  }

  public void setValoreParProdCollection(Collection<ValoreParProd> valoreParProdCollection) {
    this.valoreParProdCollection = valoreParProdCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idParProd != null ? idParProd.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroProdotto)) {
      return false;
    }
    ParametroProdotto other = (ParametroProdotto) object;
    if ((this.idParProd == null && other.idParProd != null) || (this.idParProd != null && !this.idParProd.equals(other.idParProd))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
