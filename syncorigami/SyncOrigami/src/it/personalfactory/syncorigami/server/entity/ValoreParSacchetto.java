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
@Table(name = "valore_par_sacchetto")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ValoreParSacchetto.findAll", query = "SELECT v FROM ValoreParSacchetto v"),
//  @NamedQuery(name = "ValoreParSacchetto.findByIdValParSac", query = "SELECT v FROM ValoreParSacchetto v WHERE v.idValParSac = :idValParSac"),
//  @NamedQuery(name = "ValoreParSacchetto.findBySacchetto", query = "SELECT v FROM ValoreParSacchetto v WHERE v.sacchetto = :sacchetto"),
//  @NamedQuery(name = "ValoreParSacchetto.findByValoreVariabile", query = "SELECT v FROM ValoreParSacchetto v WHERE v.valoreVariabile = :valoreVariabile"),
//  @NamedQuery(name = "ValoreParSacchetto.findByAbilitato", query = "SELECT v FROM ValoreParSacchetto v WHERE v.abilitato = :abilitato"),
//  @NamedQuery(name = "ValoreParSacchetto.findByDtAbilitato", query = "SELECT v FROM ValoreParSacchetto v WHERE v.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ValoreParSacchetto.findDatiNuovi", query = "SELECT v FROM ValoreParSacchetto v WHERE v.dtAbilitato > :dtAbilitato")})
public class ValoreParSacchetto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_par_sac")
  private Integer idValParSac;
  @Column(name = "sacchetto")
  private Integer sacchetto;
  @Size(max = 255)
  @Column(name = "valore_variabile")
  private String valoreVariabile;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @JoinColumn(name = "id_cat", referencedColumnName = "id_cat")
  @ManyToOne(optional = false)
  private Categoria idCat;
  @JoinColumn(name = "id_num_sac", referencedColumnName = "id_num_sac")
  @ManyToOne
  private NumSacchetto idNumSac;
  @JoinColumn(name = "id_par_sac", referencedColumnName = "id_par_sac")
  @ManyToOne(optional = false)
  private ParametroSacchetto idParSac;

  public ValoreParSacchetto() {
  }

  public ValoreParSacchetto(Integer idValParSac) {
    this.idValParSac = idValParSac;
  }

  public Integer getIdValParSac() {
    return idValParSac;
  }

  public void setIdValParSac(Integer idValParSac) {
    this.idValParSac = idValParSac;
  }

  public Integer getSacchetto() {
    return sacchetto;
  }

  public void setSacchetto(Integer sacchetto) {
    this.sacchetto = sacchetto;
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

  public NumSacchetto getIdNumSac() {
    return idNumSac;
  }

  public void setIdNumSac(NumSacchetto idNumSac) {
    this.idNumSac = idNumSac;
  }

  public ParametroSacchetto getIdParSac() {
    return idParSac;
  }

  public void setIdParSac(ParametroSacchetto idParSac) {
    this.idParSac = idParSac;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValParSac != null ? idValParSac.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParSacchetto)) {
      return false;
    }
    ValoreParSacchetto other = (ValoreParSacchetto) object;
    if ((this.idValParSac == null && other.idValParSac != null) || (this.idValParSac != null && !this.idValParSac.equals(other.idValParSac))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
