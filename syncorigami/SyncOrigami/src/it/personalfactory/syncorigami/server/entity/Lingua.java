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
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
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
@Table(name = "lingua")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Lingua.findAll", query = "SELECT l FROM Lingua l"),
//  @NamedQuery(name = "Lingua.findByIdLingua", query = "SELECT l FROM Lingua l WHERE l.idLingua = :idLingua"),
//  @NamedQuery(name = "Lingua.findByLingua", query = "SELECT l FROM Lingua l WHERE l.lingua = :lingua"),
//  @NamedQuery(name = "Lingua.findByAbilitato", query = "SELECT l FROM Lingua l WHERE l.abilitato = :abilitato"),
//  @NamedQuery(name = "Lingua.findByDtAbilitato", query = "SELECT l FROM Lingua l WHERE l.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Lingua.findDatiNuovi", query = "SELECT l FROM Lingua l WHERE l.dtAbilitato > :dtAbilitato")})
public class Lingua implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_lingua")
  private Integer idLingua;
  @Size(max = 255)
  @Column(name = "lingua")
  private String lingua;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idLingua")
  private Collection<Dizionario> dizionarioCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idLingua")
  private Collection<AnagrafeMacchina> anagrafeMacchinaCollection;

  public Lingua() {
  }

  public Lingua(Integer idLingua) {
    this.idLingua = idLingua;
  }

  public Lingua(Integer idLingua, Date dtAbilitato) {
    this.idLingua = idLingua;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdLingua() {
    return idLingua;
  }

  public void setIdLingua(Integer idLingua) {
    this.idLingua = idLingua;
  }

  public String getLingua() {
    return lingua;
  }

  public void setLingua(String lingua) {
    this.lingua = lingua;
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

  @XmlTransient
  public Collection<Dizionario> getDizionarioCollection() {
    return dizionarioCollection;
  }

  public void setDizionarioCollection(Collection<Dizionario> dizionarioCollection) {
    this.dizionarioCollection = dizionarioCollection;
  }

  @XmlTransient
  public Collection<AnagrafeMacchina> getAnagrafeMacchinaCollection() {
    return anagrafeMacchinaCollection;
  }

  public void setAnagrafeMacchinaCollection(Collection<AnagrafeMacchina> anagrafeMacchinaCollection) {
    this.anagrafeMacchinaCollection = anagrafeMacchinaCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idLingua != null ? idLingua.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Lingua)) {
      return false;
    }
    Lingua other = (Lingua) object;
    if ((this.idLingua == null && other.idLingua != null) || (this.idLingua != null && !this.idLingua.equals(other.idLingua))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
