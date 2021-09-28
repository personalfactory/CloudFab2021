/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

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
@Table(name = "colore_ori")
@XmlRootElement
public class ColoreOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  //@GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_colore")
  private Integer idColore;
  @Size(max = 50)
  @Column(name = "cod_colore")
  private String codColore;
  @Size(max = 100)
  @Column(name = "nome_colore")
  private String nomeColore;
  
  //Nel DB il valore di default è NULL 
  //perchè qui è NotNull?
  //@Basic(optional = false)
  //@NotNull
  @Column(name = "abilitato")
  private Boolean abilitato;
 
  //@Basic(optional = false) //se lo uso non riesco a salvare in tabella perchè 
  //questo campo non viene definito lato server quando si costruisce l'aggiornamento
  //ma viene settato automaticamente durante insert o update direttamente sulla macchina
  //ottengo la seguente eccezione
  //PropertyValueException: not-null property references a null or transient value
  //Se invece lato server quando trasformo l'oggetto colore in coloreOri definisco 
  //anche il campo dtAbilitato tutto funziona anche con @Basic
  //ma questo va contro la logica del programma
  @NotNull
  @Column(name = "dt_abilitato")
  //@Column(name = "dt_abilitato", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idColore")
  private Collection<MazzettaColorataOri> mazzettaColorataOriCollection;
//  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idColore")
//  private Collection<MazzettaColSingMacOri> mazzettaColSingMacOriCollection;

  public ColoreOri() {
  }

  public ColoreOri(Integer idColore) {
    this.idColore = idColore;
  }

  public ColoreOri(Integer idColore, Date dtAbilitato) {
    this.idColore = idColore;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdColore() {
    return idColore;
  }

  public void setIdColore(Integer idColore) {
    this.idColore = idColore;
  }

  public String getCodColore() {
    return codColore;
  }

  public void setCodColore(String codColore) {
    this.codColore = codColore;
  }

  public String getNomeColore() {
    return nomeColore;
  }

  public void setNomeColore(String nomeColore) {
    this.nomeColore = nomeColore;
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
  public Collection<MazzettaColorataOri> getMazzettaColorataOriCollection() {
    return mazzettaColorataOriCollection;
  }

  public void setMazzettaColorataOriCollection(Collection<MazzettaColorataOri> mazzettaColorataOriCollection) {
    this.mazzettaColorataOriCollection = mazzettaColorataOriCollection;
  }

//  @XmlTransient
//  public Collection<MazzettaColSingMacOri> getMazzettaColSingMacOriCollection() {
//    return mazzettaColSingMacOriCollection;
//  }
//
//  public void setMazzettaColSingMacOriCollection(Collection<MazzettaColSingMacOri> mazzettaColSingMacOriCollection) {
//    this.mazzettaColSingMacOriCollection = mazzettaColSingMacOriCollection;
//  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idColore != null ? idColore.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ColoreOri)) {
      return false;
    }
    ColoreOri other = (ColoreOri) object;
    if ((this.idColore == null && other.idColore != null) || (this.idColore != null && !this.idColore.equals(other.idColore))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
