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
@Table(name = "valore_prodotto")
@XmlRootElement
@NamedQueries({
@NamedQuery(name = "ValoreProdotto.findDatiNuovi", query = "SELECT v FROM ValoreProdotto v, AnagrafeProdotto p WHERE "
        + "v.idProdotto=p.idProdotto "
        + "AND (v.dtAbilitato > :dtAbilitato OR p.dtAbilitato > :dtAbilitato) GROUP BY v.idValPr")})
public class ValoreProdotto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_val_pr")
  private Integer idValPr;
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
  
  @JoinColumn(name = "id_prodotto", referencedColumnName = "id_prodotto")
  @ManyToOne(optional = false)
  private Prodotto idProdotto;
  
  @JoinColumn(name = "id_par_prod", referencedColumnName = "id_par_prod")
  @ManyToOne(optional = false)
  private ParametroProd idParProd;

  public ValoreProdotto() {
  }

  public ValoreProdotto(Integer idValParPr) {
    this.idValPr = idValParPr;
  }

  public ValoreProdotto(Integer idValParPr, Date dtAbilitato) {
    this.idValPr = idValParPr;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdValPr() {
    return idValPr;
  }

  public void setIdValPr(Integer idValParPr) {
    this.idValPr = idValParPr;
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

  public Prodotto getIdProdotto() {
    return idProdotto;
  }

  public void setIdProdotto(Prodotto idProdotto) {
    this.idProdotto = idProdotto;
  }

  public ParametroProd getIdParProd() {
    return idParProd;
  }

  public void setIdParProd(ParametroProd idParProd) {
    this.idParProd = idParProd;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValPr != null ? idValPr.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreProdotto)) {
      return false;
    }
    ValoreProdotto other = (ValoreProdotto) object;
    if ((this.idValPr == null && other.idValPr != null) || (this.idValPr != null && !this.idValPr.equals(other.idValPr))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
