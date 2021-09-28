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
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
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
@Table(name = "bolla")
@XmlRootElement
//@NamedQueries({
//  @NamedQuery(name = "Bolla.findAll", query = "SELECT b FROM Bolla b"),
//  @NamedQuery(name = "Bolla.findByIdBolla", query = "SELECT b FROM Bolla b WHERE b.idBolla = :idBolla"),
//  @NamedQuery(name = "Bolla.findByNumBolla", query = "SELECT b FROM Bolla b WHERE b.numBolla = :numBolla"),
//  @NamedQuery(name = "Bolla.findByDtBolla", query = "SELECT b FROM Bolla b WHERE b.dtBolla = :dtBolla"),
//  @NamedQuery(name = "Bolla.findByCodStab", query = "SELECT b FROM Bolla b WHERE b.codStab = :codStab")})
public class Bolla implements Serializable {
  @Column(name =   "dt_bolla")
  @Temporal(TemporalType.DATE)
  private Date dtBolla;
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_bolla")
  private Integer idBolla;
  @Column(name = "num_bolla")
  private Integer numBolla;
  @Size(max = 255)
  @Column(name = "cod_stab")
  private String codStab;
  @OneToMany(mappedBy = "idBolla")
  private Collection<Lotto> lottoCollection;
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public Bolla() {
  }

  public Bolla(Integer idBolla) {
    this.idBolla = idBolla;
  }

  public Integer getIdBolla() {
    return idBolla;
  }

  public void setIdBolla(Integer idBolla) {
    this.idBolla = idBolla;
  }

  public Integer getNumBolla() {
    return numBolla;
  }

  public void setNumBolla(Integer numBolla) {
    this.numBolla = numBolla;
  }

  public Date getDtBolla() {
    return dtBolla;
  }

  public void setDtBolla(Date dtBolla) {
    this.dtBolla = dtBolla;
  }

  public String getCodStab() {
    return codStab;
  }

  public void setCodStab(String codStab) {
    this.codStab = codStab;
  }

  public Date getDtAbilitato() {
    return dtAbilitato;
  }

  public void setDtAbilitato(Date dtAbilitato) {
    this.dtAbilitato = dtAbilitato;
  }
  

  @XmlTransient
  public Collection<Lotto> getLottoCollection() {
    return lottoCollection;
  }

  public void setLottoCollection(Collection<Lotto> lottoCollection) {
    this.lottoCollection = lottoCollection;
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
    hash += (idBolla != null ? idBolla.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Bolla)) {
      return false;
    }
    Bolla other = (Bolla) object;
    if ((this.idBolla == null && other.idBolla != null) || (this.idBolla != null && !this.idBolla.equals(other.idBolla))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

    
}
