/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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
@Table(name = "valore_par_comp")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ValoreParComp.findAll", query = "SELECT v FROM ValoreParComp v"),
//  @NamedQuery(name = "ValoreParComp.findByIdValComp", query = "SELECT v FROM ValoreParComp v WHERE v.idValComp = :idValComp"),
//  @NamedQuery(name = "ValoreParComp.findByValoreVariabile", query = "SELECT v FROM ValoreParComp v WHERE v.valoreVariabile = :valoreVariabile"),
//  @NamedQuery(name = "ValoreParComp.findByValoreIniziale", query = "SELECT v FROM ValoreParComp v WHERE v.valoreIniziale = :valoreIniziale"),
//  @NamedQuery(name = "ValoreParComp.findByDtValoreIniziale", query = "SELECT v FROM ValoreParComp v WHERE v.dtValoreIniziale = :dtValoreIniziale"),
//  @NamedQuery(name = "ValoreParComp.findByAbilitato", query = "SELECT v FROM ValoreParComp v WHERE v.abilitato = :abilitato"),
//  @NamedQuery(name = "ValoreParComp.findByDtAbilitato", query = "SELECT v FROM ValoreParComp v WHERE v.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "ValoreParComp.findByDtModificaMac", query = "SELECT v FROM ValoreParComp v WHERE v.dtModificaMac = :dtModificaMac"),
//  @NamedQuery(name = "ValoreParComp.findByDtAggMac", query = "SELECT v FROM ValoreParComp v WHERE v.dtAggMac = :dtAggMac"),
//  @NamedQuery(name = "ValoreParComp.findByValoreMac", query = "SELECT v FROM ValoreParComp v WHERE v.valoreMac = :valoreMac"),
  //@NamedQuery(name = "ValoreParComp.findDatiNuovi", query = "SELECT v FROM ValoreParComp v, Macchina m, ComponenteProdotto cp, AnagrafeProdotto p "
  //        + "WHERE v.idMacchina =m.idMacchina "
  //        +"AND v.idComp=cp.idComp "
  //        +"AND p.idProdotto = cp.idProdotto "
  //        +"AND m.idMacchina = :idMacchina "
   //       +"AND (v.dtAbilitato > :dtAbilitato OR p.dtAbilitato>:dtAbilitato OR cp.dtAbilitato>:dtAbilitato) GROUP BY  v.idValComp")
@NamedQuery(name = "ValoreParComp.findDatiNuovi", query = "SELECT v FROM ValoreParComp v, Macchina m, ComponenteProdotto cp, AnagrafeProdotto p "
          + "WHERE v.idMacchina =m.idMacchina "
          +"AND v.idComp=cp.idComp "
          +"AND p.idProdotto = cp.idProdotto "
          +"AND m.idMacchina = :idMacchina "
          +"AND (v.dtAbilitato > :dtAbilitato OR cp.dtAbilitato>:dtAbilitato) GROUP BY  v.idValComp")})
public class ValoreParComp implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_comp")
  private Integer idValComp;
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
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;
  @JoinColumn(name = "id_comp", referencedColumnName = "id_comp")
  @ManyToOne(optional = false)
  private Componente idComp;
  @JoinColumn(name = "id_par_comp", referencedColumnName = "id_par_comp")
  @ManyToOne(optional = false)
  private ParametroCompProd idParComp;

  public ValoreParComp() {
  }

  public ValoreParComp(Integer idValComp) {
    this.idValComp = idValComp;
  }

  public ValoreParComp(Integer idValComp, Date dtValoreIniziale, Date dtAbilitato, Date dtModificaMac, Date dtAggMac) {
    this.idValComp = idValComp;
    this.dtValoreIniziale = dtValoreIniziale;
    this.dtAbilitato = dtAbilitato;
    this.dtModificaMac = dtModificaMac;
    this.dtAggMac = dtAggMac;
  }

  public Integer getIdValComp() {
    return idValComp;
  }

  public void setIdValComp(Integer idValComp) {
    this.idValComp = idValComp;
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

  public Macchina getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(Macchina idMacchina) {
    this.idMacchina = idMacchina;
  }

  public Componente getIdComp() {
    return idComp;
  }

  public void setIdComp(Componente idComp) {
    this.idComp = idComp;
  }

  public ParametroCompProd getIdParComp() {
    return idParComp;
  }

  public void setIdParComp(ParametroCompProd idParComp) {
    this.idParComp = idParComp;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValComp != null ? idValComp.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParComp)) {
      return false;
    }
    ValoreParComp other = (ValoreParComp) object;
    if ((this.idValComp == null && other.idValComp != null) || (this.idValComp != null && !this.idValComp.equals(other.idValComp))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.ValoreParComp[ idValComp=" + idValComp + " ]";
  }
  
}
