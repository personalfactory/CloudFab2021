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
@Table(name = "dizionario")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Dizionario.findAll", query = "SELECT d FROM Dizionario d"),
//  @NamedQuery(name = "Dizionario.findByIdDizionario", query = "SELECT d FROM Dizionario d WHERE d.idDizionario = :idDizionario"),
//  @NamedQuery(name = "Dizionario.findByIdVocabolo", query = "SELECT d FROM Dizionario d WHERE d.idVocabolo = :idVocabolo"),
//  @NamedQuery(name = "Dizionario.findByVocabolo", query = "SELECT d FROM Dizionario d WHERE d.vocabolo = :vocabolo"),
//  @NamedQuery(name = "Dizionario.findByAbilitato", query = "SELECT d FROM Dizionario d WHERE d.abilitato = :abilitato"),
//  @NamedQuery(name = "Dizionario.findByDtAbilitato", query = "SELECT d FROM Dizionario d WHERE d.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Dizionario.findDatiNuovi", query = "SELECT d FROM Dizionario d WHERE d.dtAbilitato > :dtAbilitato")})
public class Dizionario implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_dizionario")
  private Integer idDizionario;
  @Column(name = "id_vocabolo")
  private Integer idVocabolo;
  @Column(name = "vocabolo")
  private String vocabolo;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @JoinColumn(name = "id_diz_tipo", referencedColumnName = "id_diz_tipo")
  @ManyToOne(optional = false)
  private DizionarioTipo idDizTipo;
  @JoinColumn(name = "id_lingua", referencedColumnName = "id_lingua")
  @ManyToOne(optional = false)
  private Lingua idLingua;

  public Dizionario() {
  }

  public Dizionario(Integer idDizionario) {
    this.idDizionario = idDizionario;
  }

  public Dizionario(Integer idDizionario, Date dtAbilitato) {
    this.idDizionario = idDizionario;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdDizionario() {
    return idDizionario;
  }

  public void setIdDizionario(Integer idDizionario) {
    this.idDizionario = idDizionario;
  }

  public Integer getIdVocabolo() {
    return idVocabolo;
  }

  public void setIdVocabolo(Integer idVocabolo) {
    this.idVocabolo = idVocabolo;
  }

  public String getVocabolo() {
    return vocabolo;
  }

  public void setVocabolo(String vocabolo) {
    this.vocabolo = vocabolo;
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

  public DizionarioTipo getIdDizTipo() {
    return idDizTipo;
  }

  public void setIdDizTipo(DizionarioTipo idDizTipo) {
    this.idDizTipo = idDizTipo;
  }

  public Lingua getIdLingua() {
    return idLingua;
  }

  public void setIdLingua(Lingua idLingua) {
    this.idLingua = idLingua;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idDizionario != null ? idDizionario.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Dizionario)) {
      return false;
    }
    Dizionario other = (Dizionario) object;
    if ((this.idDizionario == null && other.idDizionario != null) || (this.idDizionario != null && !this.idDizionario.equals(other.idDizionario))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
