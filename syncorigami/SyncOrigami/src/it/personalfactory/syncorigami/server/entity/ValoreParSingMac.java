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
@Table(name = "valore_par_sing_mac")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ValoreParSingMac.findAll", query = "SELECT v FROM ValoreParSingMac v"),
//  @NamedQuery(name = "ValoreParSingMac.findByIdValParSm", query = "SELECT v FROM ValoreParSingMac v WHERE v.idValParSm = :idValParSm"),
//  @NamedQuery(name = "ValoreParSingMac.findByValoreVariabile", query = "SELECT v FROM ValoreParSingMac v WHERE v.valoreVariabile = :valoreVariabile"),
//  @NamedQuery(name = "ValoreParSingMac.findByValoreIniziale", query = "SELECT v FROM ValoreParSingMac v WHERE v.valoreIniziale = :valoreIniziale"),
//  @NamedQuery(name = "ValoreParSingMac.findByDtValoreIniziale", query = "SELECT v FROM ValoreParSingMac v WHERE v.dtValoreIniziale = :dtValoreIniziale"),
//  @NamedQuery(name = "ValoreParSingMac.findByAbilitato", query = "SELECT v FROM ValoreParSingMac v WHERE v.abilitato = :abilitato"),
//  @NamedQuery(name = "ValoreParSingMac.findByDtAbilitato", query = "SELECT v FROM ValoreParSingMac v WHERE v.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "ValoreParSingMac.findByDtModificaMac", query = "SELECT v FROM ValoreParSingMac v WHERE v.dtModificaMac = :dtModificaMac"),
//  @NamedQuery(name = "ValoreParSingMac.findByDtAggMac", query = "SELECT v FROM ValoreParSingMac v WHERE v.dtAggMac = :dtAggMac"),
//  @NamedQuery(name = "ValoreParSingMac.findByValoreMac", query = "SELECT v FROM ValoreParSingMac v WHERE v.valoreMac = :valoreMac"),
    
  @NamedQuery(name = "ValoreParSingMac.findValoreByIdParMac", query = "SELECT v FROM ValoreParSingMac v, Macchina m WHERE v.idMacchina = m.idMacchina "
                                                                + "AND m.idMacchina =:idMacchina AND v.idParSm=:idParSm"),
  @NamedQuery(name = "ValoreParSingMac.findDatiNuovi", query = "SELECT v FROM ValoreParSingMac v, Macchina m WHERE v.idMacchina =m.idMacchina "
                                                                + "AND m.idMacchina = :idMacchina "
                                                                + "AND v.dtAbilitato > :dtAbilitato")})


public class ValoreParSingMac implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_par_sm")
  private Integer idValParSm;
  @Size(max = 255)
  @Column(name = "valore_variabile")
  private String valoreVariabile;
  @Size(max = 255)
  @Column(name = "valore_iniziale")
  private String valoreIniziale;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_valore_iniziale")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtValoreIniziale;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_modifica_mac")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtModificaMac;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_agg_mac")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAggMac;
  @Size(max = 255)
  @Column(name = "valore_mac")
  private String valoreMac;
  @JoinColumn(name = "id_par_sm", referencedColumnName = "id_par_sm")
  @ManyToOne(optional = false)
  private ParametroSingMac idParSm;
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;

  public ValoreParSingMac() {
  }

  public ValoreParSingMac(Integer idValParSm) {
    this.idValParSm = idValParSm;
  }

  public ValoreParSingMac(Integer idValParSm, Date dtValoreIniziale, Date dtAbilitato, Date dtModificaMac, Date dtAggMac) {
    this.idValParSm = idValParSm;
    this.dtValoreIniziale = dtValoreIniziale;
    this.dtAbilitato = dtAbilitato;
    this.dtModificaMac = dtModificaMac;
    this.dtAggMac = dtAggMac;
  }

  public Integer getIdValParSm() {
    return idValParSm;
  }

  public void setIdValParSm(Integer idValParSm) {
    this.idValParSm = idValParSm;
  }

  public String getValoreVariabile() {
    return valoreVariabile;
  }

  public void setValoreVariabile(String valoreVariabile) {
    this.valoreVariabile = valoreVariabile;
  }

  public String getValoreIniziale() {
    return valoreIniziale;
  }

  public void setValoreIniziale(String valoreIniziale) {
    this.valoreIniziale = valoreIniziale;
  }

  public Date getDtValoreIniziale() {
    return dtValoreIniziale;
  }

  public void setDtValoreIniziale(Date dtValoreIniziale) {
    this.dtValoreIniziale = dtValoreIniziale;
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

  public Date getDtModificaMac() {
    return dtModificaMac;
  }

  public void setDtModificaMac(Date dtModificaMac) {
    this.dtModificaMac = dtModificaMac;
  }

  public Date getDtAggMac() {
    return dtAggMac;
  }

  public void setDtAggMac(Date dtAggMac) {
    this.dtAggMac = dtAggMac;
  }

  public String getValoreMac() {
    return valoreMac;
  }

  public void setValoreMac(String valoreMac) {
    this.valoreMac = valoreMac;
  }

  public ParametroSingMac getIdParSm() {
    return idParSm;
  }

  public void setIdParSm(ParametroSingMac idParSm) {
    this.idParSm = idParSm;
  }

  public Macchina getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(Macchina idMacchina) {
    this.idMacchina = idMacchina;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValParSm != null ? idValParSm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParSingMac)) {
      return false;
    }
    ValoreParSingMac other = (ValoreParSingMac) object;
    if ((this.idValParSm == null && other.idValParSm != null) || (this.idValParSm != null && !this.idValParSm.equals(other.idValParSm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
}
