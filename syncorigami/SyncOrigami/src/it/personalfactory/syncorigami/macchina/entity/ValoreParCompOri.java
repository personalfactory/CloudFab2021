/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

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
@Table(name = "valore_par_comp_ori")
@XmlRootElement
public class ValoreParCompOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
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
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_valore_iniziale")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtValoreIniziale;
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_modifica_mac")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtModificaMac;
  @Column(name = "abilitato")
  private Boolean abilitato;
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_comp")
  private int idComp;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_comp")
  private int idParComp;
  
//  @JoinColumn(name = "id_comp", referencedColumnName = "id_comp")
//  @ManyToOne(optional = false)
//  private ComponenteOri idComp;
//  @JoinColumn(name = "id_par_comp", referencedColumnName = "id_par_comp")
//  @ManyToOne(optional = false)
//  private ParametroCompProdOri idParComp;

  public ValoreParCompOri() {
  }

  public int getIdComp() {
    return idComp;
  }

  public void setIdComp(int idComp) {
    this.idComp = idComp;
  }

  public int getIdParComp() {
    return idParComp;
  }

  public void setIdParComp(int idParComp) {
    this.idParComp = idParComp;
  }

//  public ComponenteOri getIdComp() {
//    return idComp;
//  }
//
//  public void setIdComp(ComponenteOri idComp) {
//    this.idComp = idComp;
//  }
//
//  public ParametroCompProdOri getIdParComp() {
//    return idParComp;
//  }
//
//  public void setIdParComp(ParametroCompProdOri idParComp) {
//    this.idParComp = idParComp;
//  }
  

  public ValoreParCompOri(Integer idValComp) {
    this.idValComp = idValComp;
  }

  public ValoreParCompOri(Integer idValComp, Date dtValoreIniziale, Date dtModificaMac, Date dtAbilitato) {
    this.idValComp = idValComp;
    this.dtValoreIniziale = dtValoreIniziale;
    this.dtModificaMac = dtModificaMac;
    this.dtAbilitato = dtAbilitato;
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

  public Date getDtModificaMac() {
    return dtModificaMac;
  }

  public void setDtModificaMac(Date dtModificaMac) {
    this.dtModificaMac = dtModificaMac;
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

//  public ComponenteOri getIdComp() {
//    return idComp;
//  }
//
//  public void setIdComp(ComponenteOri idComp) {
//    this.idComp = idComp;
//  }
//
//  public ParametroCompProdOri getIdParComp() {
//    return idParComp;
//  }
//
//  public void setIdParComp(ParametroCompProdOri idParComp) {
//    this.idParComp = idParComp;
//  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idValComp != null ? idValComp.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ValoreParCompOri)) {
      return false;
    }
    ValoreParCompOri other = (ValoreParCompOri) object;
    if ((this.idValComp == null && other.idValComp != null) || (this.idValComp != null && !this.idValComp.equals(other.idValComp))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.macchina.entity.ValoreParCompOri[ idValComp=" + idValComp + " ]";
  }
  
}
