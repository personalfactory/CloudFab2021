/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.EmbeddedId;
import javax.persistence.Entity;
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
@Table(name = "mazzetta_col_sing_mac")
@XmlRootElement
//@NamedQueries({
//  @NamedQuery(name = "MazzettaColSingMac.findAll", query = "SELECT m FROM MazzettaColSingMac m"),
//  @NamedQuery(name = "MazzettaColSingMac.findByIdMazSingMac", query = "SELECT m FROM MazzettaColSingMac m WHERE m.mazzettaColSingMacPK.idMazSingMac = :idMazSingMac"),
//  @NamedQuery(name = "MazzettaColSingMac.findByIdMacchina", query = "SELECT m FROM MazzettaColSingMac m WHERE m.mazzettaColSingMacPK.idMacchina = :idMacchina"),
//  @NamedQuery(name = "MazzettaColSingMac.findByQuantita", query = "SELECT m FROM MazzettaColSingMac m WHERE m.quantita = :quantita"),
//  @NamedQuery(name = "MazzettaColSingMac.findByDtCreazioneMac", query = "SELECT m FROM MazzettaColSingMac m WHERE m.dtCreazioneMac = :dtCreazioneMac"),
//  @NamedQuery(name = "MazzettaColSingMac.findByAbilitato", query = "SELECT m FROM MazzettaColSingMac m WHERE m.abilitato = :abilitato"),
//  @NamedQuery(name = "MazzettaColSingMac.findByDtAbilitato", query = "SELECT m FROM MazzettaColSingMac m WHERE m.dtAbilitato = :dtAbilitato")})
public class MazzettaColSingMac implements Serializable {
  private static final long serialVersionUID = 1L;
  @EmbeddedId
  protected MazzettaColSingMacPK mazzettaColSingMacPK;
  // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
  @Column(name = "quantita")
  private Integer quantita;
 // @Basic(optional = false)
  @NotNull
  @Column(name = "dt_creazione_mac")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtCreazioneMac;
  @Column(name = "abilitato")
  private Boolean abilitato;
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @JoinColumn(name = "id_mazzetta", referencedColumnName = "id_mazzetta")
  @ManyToOne
  private Mazzetta idMazzetta;
  @JoinColumn(name = "id_colore_base", referencedColumnName = "id_colore_base")
  @ManyToOne
  private ColoreBase idColoreBase;
//  @JoinColumn(name = "id_colore", referencedColumnName = "id_colore")
//  @ManyToOne
//  private Colore idColore;
  @Size(max = 255)
  @Column(name = "cod_colore")
  private String codColore;  
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina", insertable = false, updatable = false)
  @ManyToOne(optional = false)
  private Macchina idMacchina;

  public MazzettaColSingMac() {
  }

  public MazzettaColSingMac(MazzettaColSingMacPK mazzettaColSingMacPK) {
    this.mazzettaColSingMacPK = mazzettaColSingMacPK;
  }

  public MazzettaColSingMac(MazzettaColSingMacPK mazzettaColSingMacPK, Date dtCreazioneMac, Date dtAbilitato) {
    this.mazzettaColSingMacPK = mazzettaColSingMacPK;
    this.dtCreazioneMac = dtCreazioneMac;
    this.dtAbilitato = dtAbilitato;
  }

  public MazzettaColSingMac(int idMazSingMac, int idMacchina) {
    this.mazzettaColSingMacPK = new MazzettaColSingMacPK(idMazSingMac, idMacchina);
  }

  public MazzettaColSingMacPK getMazzettaColSingMacPK() {
    return mazzettaColSingMacPK;
  }

  public void setMazzettaColSingMacPK(MazzettaColSingMacPK mazzettaColSingMacPK) {
    this.mazzettaColSingMacPK = mazzettaColSingMacPK;
  }

  public Integer getQuantita() {
    return quantita;
  }

  public void setQuantita(Integer quantita) {
    this.quantita = quantita;
  }

  public Date getDtCreazioneMac() {
    return dtCreazioneMac;
  }

  public void setDtCreazioneMac(Date dtCreazioneMac) {
    this.dtCreazioneMac = dtCreazioneMac;
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

  public Mazzetta getIdMazzetta() {
    return idMazzetta;
  }

  public void setIdMazzetta(Mazzetta idMazzetta) {
    this.idMazzetta = idMazzetta;
  }

  public ColoreBase getIdColoreBase() {
    return idColoreBase;
  }

  public void setIdColoreBase(ColoreBase idColoreBase) {
    this.idColoreBase = idColoreBase;
  }

//  public Colore getIdColore() {
//    return idColore;
//  }
//
//  public void setIdColore(Colore idColore) {
//    this.idColore = idColore;
//  }

  public String getCodColore() {
    return codColore;
  }

  public void setCodColore(String codColore) {
    this.codColore = codColore;
  }

  

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (mazzettaColSingMacPK != null ? mazzettaColSingMacPK.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof MazzettaColSingMac)) {
      return false;
    }
    MazzettaColSingMac other = (MazzettaColSingMac) object;
    if ((this.mazzettaColSingMacPK == null && other.mazzettaColSingMacPK != null) || (this.mazzettaColSingMacPK != null && !this.mazzettaColSingMacPK.equals(other.mazzettaColSingMacPK))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.MazzettaColSingMac[ mazzettaColSingMacPK=" + mazzettaColSingMacPK + " ]";
  }
  
}
