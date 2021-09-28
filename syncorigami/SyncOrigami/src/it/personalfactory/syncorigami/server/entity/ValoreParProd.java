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
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
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
@Table(name = "valore_par_prod")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ValoreParProd.findAll", query = "SELECT v FROM ValoreParProd v"),
//  @NamedQuery(name = "ValoreParProd.findByIdValParPr", query = "SELECT v FROM ValoreParProd v WHERE v.idValParPr = :idValParPr"),
//  @NamedQuery(name = "ValoreParProd.findByValoreVariabile", query = "SELECT v FROM ValoreParProd v WHERE v.valoreVariabile = :valoreVariabile"),
//  @NamedQuery(name = "ValoreParProd.findByAbilitato", query = "SELECT v FROM ValoreParProd v WHERE v.abilitato = :abilitato"),
//  @NamedQuery(name = "ValoreParProd.findByDtAbilitato", query = "SELECT v FROM ValoreParProd v WHERE v.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ValoreParProd.findDatiNuovi", query = "SELECT v FROM ValoreParProd v WHERE v.dtAbilitato > :dtAbilitato")})
public class ValoreParProd implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_par_pr")
  private Integer idValParPr;
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
  
  @JoinColumn(name = "id_cat", referencedColumnName = "id_cat")
  @ManyToOne(optional = false)
  private Categoria idCat;
  
  @JoinColumn(name = "id_par_prod", referencedColumnName = "id_par_prod")
  @ManyToOne(optional = false)
  private ParametroProdotto idParProd;

  public ValoreParProd() {
  }

  public ValoreParProd(Integer idValParPr) {
    this.idValParPr = idValParPr;
  }

  public ValoreParProd(Integer idValParPr, Date dtAbilitato) {
    this.idValParPr = idValParPr;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdValParPr() {
    return idValParPr;
  }

  public void setIdValParPr(Integer idValParPr) {
    this.idValParPr = idValParPr;
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

  public Categoria getIdCat() {
    return idCat;
  }

  public void setIdCat(Categoria idCat) {
    this.idCat = idCat;
  }

  public ParametroProdotto getIdParProd() {
    return idParProd;
  }

  public void setIdParProd(ParametroProdotto idParProd) {
    this.idParProd = idParProd;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValParPr != null ? idValParPr.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParProd)) {
      return false;
    }
    ValoreParProd other = (ValoreParProd) object;
    if ((this.idValParPr == null && other.idValParPr != null) || (this.idValParPr != null && !this.idValParPr.equals(other.idValParPr))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
