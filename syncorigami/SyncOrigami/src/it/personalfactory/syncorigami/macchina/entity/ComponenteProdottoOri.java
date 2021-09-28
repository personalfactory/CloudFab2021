/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

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
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "componente_prodotto_ori")
@XmlRootElement
public class ComponenteProdottoOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  //@GeneratedValue(strategy = GenerationType.IDENTITY)
  //@Basic(optional = false)
  @NotNull
  @Column(name = "id_comp_prod")
  private Integer idCompProd;
  // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
  @Column(name = "quantita")
  private Double quantita;
    
  @Column(name = "abilitato")
  private Boolean abilitato;
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  
  @JoinColumn(name = "id_comp", referencedColumnName = "id_comp")
  @ManyToOne(optional = false)
  private ComponenteOri idComp;
  
  @JoinColumn(name = "id_prodotto", referencedColumnName = "id_prodotto")
  @ManyToOne(optional = false)
  private ProdottoOri idProdotto;
  

  public ComponenteProdottoOri() {
  }

  public ComponenteProdottoOri(Integer idCompProd) {
    this.idCompProd = idCompProd;
  }

  public ComponenteProdottoOri(Integer idCompProd, Date dtAbilitato) {
    this.idCompProd = idCompProd;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdCompProd() {
    return idCompProd;
  }

  public void setIdCompProd(Integer idCompProd) {
    this.idCompProd = idCompProd;
  }

  public Double getQuantita() {
    return quantita;
  }

  public void setQuantita(Double quantita) {
    this.quantita = quantita;
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

  public ProdottoOri getIdProdotto() {
    return idProdotto;
  }

  public void setIdProdotto(ProdottoOri idProdotto) {
    this.idProdotto = idProdotto;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idCompProd != null ? idCompProd.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ComponenteProdottoOri)) {
      return false;
    }
    ComponenteProdottoOri other = (ComponenteProdottoOri) object;
    if ((this.idCompProd == null && other.idCompProd != null) || (this.idCompProd != null && !this.idCompProd.equals(other.idCompProd))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

  
  public ComponenteOri getIdComp() {
    return idComp;
  }

  public void setIdComp(ComponenteOri idComp) {
    this.idComp = idComp;
  }
  
}
