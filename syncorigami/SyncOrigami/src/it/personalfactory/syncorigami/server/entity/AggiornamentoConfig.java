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
@Table(name = "aggiornamento_config")
@XmlRootElement
@NamedQueries({
  @NamedQuery(name = "AggiornamentoConfig.findAll", query = "SELECT a FROM AggiornamentoConfig a"),
//  @NamedQuery(name = "AggiornamentoConfig.findById", query = "SELECT a FROM AggiornamentoConfig a WHERE a.id = :id"),
  @NamedQuery(name = "AggiornamentoConfig.findByParametro", query = "SELECT a FROM AggiornamentoConfig a WHERE a.parametro = :parametro"),
//  @NamedQuery(name = "AggiornamentoConfig.findByValore", query = "SELECT a FROM AggiornamentoConfig a WHERE a.valore = :valore"),
//  @NamedQuery(name = "AggiornamentoConfig.findByTipo", query = "SELECT a FROM AggiornamentoConfig a WHERE a.tipo = :tipo"),
//  @NamedQuery(name = "AggiornamentoConfig.findByDescrizione", query = "SELECT a FROM AggiornamentoConfig a WHERE a.descrizione = :descrizione"),
  @NamedQuery(name = "AggiornamentoConfig.findDatiNuovi", query = "SELECT a FROM AggiornamentoConfig a WHERE a.dtAbilitato > :dtAbilitato")})
public class AggiornamentoConfig implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id")
  private Integer id;
  @Size(max = 255)
  @Column(name = "parametro")
  private String parametro;
  @Size(max = 255)
  @Column(name = "valore")
  private String valore;
  @Size(max = 255)
  @Column(name = "tipo")
  private String tipo;
  @Size(max = 255)
  @Column(name = "descrizione")
  private String descrizione;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;

  
  public AggiornamentoConfig() {
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

  public AggiornamentoConfig(Integer id) {
    this.id = id;
  }

  public Integer getId() {
    return id;
  }

  public void setId(Integer id) {
    this.id = id;
  }

  public String getParametro() {
    return parametro;
  }

  public void setParametro(String parametro) {
    this.parametro = parametro;
  }

  public String getValore() {
    return valore;
  }

  public void setValore(String valore) {
    this.valore = valore;
  }

  public String getTipo() {
    return tipo;
  }

  public void setTipo(String tipo) {
    this.tipo = tipo;
  }

  public String getDescrizione() {
    return descrizione;
  }

  public void setDescrizione(String descrizione) {
    this.descrizione = descrizione;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (id != null ? id.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof AggiornamentoConfig)) {
      return false;
    }
    AggiornamentoConfig other = (AggiornamentoConfig) object;
    if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
