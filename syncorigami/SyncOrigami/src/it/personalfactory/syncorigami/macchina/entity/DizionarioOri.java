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
@Table(name = "dizionario_ori")
@XmlRootElement
public class DizionarioOri implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  //@GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_dizionario")
  private Integer idDizionario;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_diz_tipo")
  private int idDizTipo;
  @Size(max = 255)
  @Column(name = "nome_dizionario_tipo")
  private String nomeDizionarioTipo;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_lingua")
  private int idLingua;
  @Size(max = 255)
  @Column(name = "nome_lingua")
  private String nomeLingua;
  @Column(name = "id_vocabolo")
  private Integer idVocabolo;
  @Column(name = "vocabolo")
  private String vocabolo;
  @Column(name = "abilitato")
  private Boolean abilitato;
  
  //@Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  public DizionarioOri() {
  }

  public DizionarioOri(Integer idDizionario) {
    this.idDizionario = idDizionario;
  }

  public DizionarioOri(Integer idDizionario, int idDizTipo, int idLingua, Date dtAbilitato) {
    this.idDizionario = idDizionario;
    this.idDizTipo = idDizTipo;
    this.idLingua = idLingua;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdDizionario() {
    return idDizionario;
  }

  public void setIdDizionario(Integer idDizionario) {
    this.idDizionario = idDizionario;
  }

  public int getIdDizTipo() {
    return idDizTipo;
  }

  public void setIdDizTipo(int idDizTipo) {
    this.idDizTipo = idDizTipo;
  }

  public String getNomeDizionarioTipo() {
    return nomeDizionarioTipo;
  }

  public void setNomeDizionarioTipo(String nomeDizionarioTipo) {
    this.nomeDizionarioTipo = nomeDizionarioTipo;
  }

  public int getIdLingua() {
    return idLingua;
  }

  public void setIdLingua(int idLingua) {
    this.idLingua = idLingua;
  }

  public String getNomeLingua() {
    return nomeLingua;
  }

  public void setNomeLingua(String nomeLingua) {
    this.nomeLingua = nomeLingua;
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

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idDizionario != null ? idDizionario.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof DizionarioOri)) {
      return false;
    }
    DizionarioOri other = (DizionarioOri) object;
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
