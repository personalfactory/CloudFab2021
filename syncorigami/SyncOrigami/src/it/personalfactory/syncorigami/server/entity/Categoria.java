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
@Table(name = "categoria")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Categoria.findAll", query = "SELECT c FROM Categoria c"),
//  @NamedQuery(name = "Categoria.findByIdCat", query = "SELECT c FROM Categoria c WHERE c.idCat = :idCat"),
//  @NamedQuery(name = "Categoria.findByNomeCategoria", query = "SELECT c FROM Categoria c WHERE c.nomeCategoria = :nomeCategoria"),
//  @NamedQuery(name = "Categoria.findByDescriCategoria", query = "SELECT c FROM Categoria c WHERE c.descriCategoria = :descriCategoria"),
//  @NamedQuery(name = "Categoria.findByAbilitato", query = "SELECT c FROM Categoria c WHERE c.abilitato = :abilitato"),
//  @NamedQuery(name = "Categoria.findByDtAbilitato", query = "SELECT c FROM Categoria c WHERE c.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Categoria.findDatiNuovi", query = "SELECT c FROM Categoria c WHERE  c.dtAbilitato > :dtAbilitato")})
public class Categoria implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_cat")
  private Integer idCat;
  @Size(max = 100)
  @Column(name = "nome_categoria")
  private String nomeCategoria;
  @Size(max = 255)
  @Column(name = "descri_categoria")
  private String descriCategoria;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idCat")
  private Collection<ValoreParSacchetto> valoreParSacchettoCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idCat")
  private Collection<NumSacchetto> numSacchettoCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idCat")
  private Collection<ValoreParProd> valoreParProdCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idCat")
  private Collection<AnagrafeProdotto> anagrafeProdottoCollection;

  public Categoria() {
  }

  public Categoria(Integer idCat) {
    this.idCat = idCat;
  }

  public Categoria(Integer idCat, Date dtAbilitato) {
    this.idCat = idCat;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdCat() {
    return idCat;
  }

  public void setIdCat(Integer idCat) {
    this.idCat = idCat;
  }

  public String getNomeCategoria() {
    return nomeCategoria;
  }

  public void setNomeCategoria(String nomeCategoria) {
    this.nomeCategoria = nomeCategoria;
  }

  public String getDescriCategoria() {
    return descriCategoria;
  }

  public void setDescriCategoria(String descriCategoria) {
    this.descriCategoria = descriCategoria;
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

  @XmlTransient
  public Collection<NumSacchetto> getNumSacchettoCollection() {
    return numSacchettoCollection;
  }

  public void setNumSacchettoCollection(Collection<NumSacchetto> numSacchettoCollection) {
    this.numSacchettoCollection = numSacchettoCollection;
  }

  @XmlTransient
  public Collection<ValoreParProd> getValoreParProdCollection() {
    return valoreParProdCollection;
  }

  public void setValoreParProdCollection(Collection<ValoreParProd> valoreParProdCollection) {
    this.valoreParProdCollection = valoreParProdCollection;
  }

  @XmlTransient
  public Collection<AnagrafeProdotto> getAnagrafeProdottoCollection() {
    return anagrafeProdottoCollection;
  }

  public void setAnagrafeProdottoCollection(Collection<AnagrafeProdotto> anagrafeProdottoCollection) {
    this.anagrafeProdottoCollection = anagrafeProdottoCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idCat != null ? idCat.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Categoria)) {
      return false;
    }
    Categoria other = (Categoria) object;
    if ((this.idCat == null && other.idCat != null) || (this.idCat != null && !this.idCat.equals(other.idCat))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
