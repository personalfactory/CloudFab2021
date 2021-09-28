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
@Table(name = "valore_par_prod_mac")
@XmlRootElement
@NamedQueries({
@NamedQuery(name = "ValoreParProdMac.findDatiNuovi", query = "SELECT v FROM ValoreParProdMac v, Macchina m, AnagrafeProdotto a WHERE "
                                                                + "v.idMacchina = m.idMacchina "
                                                                + "AND v.idProdotto = a.idProdotto "
                                                                + "AND m.idMacchina = :idMacchina "
                                                                + "AND (v.dtAbilitato > :dtAbilitato OR a.dtAbilitato > :dtAbilitato) GROUP BY v.idValPm")})
public class ValoreParProdMac implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_pm")
  private Integer idValPm;
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
 
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;
  @JoinColumn(name = "id_prodotto", referencedColumnName = "id_prodotto")
  @ManyToOne(optional = false)
  private Prodotto idProdotto;
  @JoinColumn(name = "id_par_pm", referencedColumnName = "id_par_pm")
  @ManyToOne(optional = false)
  private ParametroProdMac idParPm;

  public ValoreParProdMac() {
  }

  public ValoreParProdMac(Integer idValPm) {
    this.idValPm = idValPm;
  }

  public ValoreParProdMac(Integer idValPm, Date dtAbilitato) {
    this.idValPm = idValPm;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdValPm() {
    return idValPm;
  }

  public void setIdValPm(Integer idValPm) {
    this.idValPm = idValPm;
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

  

  public Macchina getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(Macchina idMacchina) {
    this.idMacchina = idMacchina;
  }

  public Prodotto getIdProdotto() {
    return idProdotto;
  }

  public void setIdProdotto(Prodotto idProdotto) {
    this.idProdotto = idProdotto;
  }

  public ParametroProdMac getIdParPm() {
    return idParPm;
  }

  public void setIdParPm(ParametroProdMac idParPm) {
    this.idParPm = idParPm;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValPm != null ? idValPm.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParProdMac)) {
      return false;
    }
    ValoreParProdMac other = (ValoreParProdMac) object;
    if ((this.idValPm == null && other.idValPm != null) || (this.idValPm != null && !this.idValPm.equals(other.idValPm))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.ValoreParProdMac[ idValPm=" + idValPm + " ]";
  }
  
}
