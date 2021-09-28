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
import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
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
@Table(name = "lotto")
@XmlRootElement
//@NamedQueries({
//  @NamedQuery(name = "Lotto.findAll", query = "SELECT l FROM Lotto l"),
//  @NamedQuery(name = "Lotto.findByCodLotto", query = "SELECT l FROM Lotto l WHERE l.codLotto = :codLotto"),
//  @NamedQuery(name = "Lotto.findByDescriLotto", query = "SELECT l FROM Lotto l WHERE l.descriLotto = :descriLotto"),
//  @NamedQuery(name = "Lotto.findByDtLotto", query = "SELECT l FROM Lotto l WHERE l.dtLotto = :dtLotto"),
//  @NamedQuery(name = "Lotto.findByParent", query = "SELECT l FROM Lotto l WHERE l.parent = :parent"),
//  @NamedQuery(name = "Lotto.findByNumBolla", query = "SELECT l FROM Lotto l WHERE l.numBolla = :numBolla"),
//  @NamedQuery(name = "Lotto.findByDtBolla", query = "SELECT l FROM Lotto l WHERE l.dtBolla = :dtBolla")})
public class Lotto implements Serializable {
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_lotto")
  @Temporal(TemporalType.DATE)
  private Date dtLotto;
  @Column(name = "dt_bolla")
  @Temporal(TemporalType.DATE)
  private Date dtBolla;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "codLotto")
  private Collection<Chimica> chimicaCollection;
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 50)
  @Column(name = "cod_lotto")
  private String codLotto;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "descri_lotto")
  private String descriLotto;
  @Size(max = 50)
  @Column(name = "parent")
  private String parent;
  @Size(max = 255)
  @Column(name = "num_bolla")
  private String numBolla;
  @JoinColumn(name = "id_bolla", referencedColumnName = "id_bolla")
  @ManyToOne
  private Bolla idBolla;

  public Lotto() {
  }

  public Lotto(String codLotto) {
    this.codLotto = codLotto;
  }

  public Lotto(String codLotto, String descriLotto, Date dtLotto) {
    this.codLotto = codLotto;
    this.descriLotto = descriLotto;
    this.dtLotto = dtLotto;
  }

  public String getCodLotto() {
    return codLotto;
  }

  public void setCodLotto(String codLotto) {
    this.codLotto = codLotto;
  }

  public String getDescriLotto() {
    return descriLotto;
  }

  public void setDescriLotto(String descriLotto) {
    this.descriLotto = descriLotto;
  }

  public Date getDtLotto() {
    return dtLotto;
  }

  public void setDtLotto(Date dtLotto) {
    this.dtLotto = dtLotto;
  }

  public String getParent() {
    return parent;
  }

  public void setParent(String parent) {
    this.parent = parent;
  }

  public String getNumBolla() {
    return numBolla;
  }

  public void setNumBolla(String numBolla) {
    this.numBolla = numBolla;
  }

  public Date getDtBolla() {
    return dtBolla;
  }

  public void setDtBolla(Date dtBolla) {
    this.dtBolla = dtBolla;
  }

  public Bolla getIdBolla() {
    return idBolla;
  }

  public void setIdBolla(Bolla idBolla) {
    this.idBolla = idBolla;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (codLotto != null ? codLotto.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Lotto)) {
      return false;
    }
    Lotto other = (Lotto) object;
    if ((this.codLotto == null && other.codLotto != null) || (this.codLotto != null && !this.codLotto.equals(other.codLotto))) {
      return false;
    }
    return true;
  }

  @XmlTransient
  public Collection<Chimica> getChimicaCollection() {
    return chimicaCollection;
  }

  public void setChimicaCollection(Collection<Chimica> chimicaCollection) {
    this.chimicaCollection = chimicaCollection;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
