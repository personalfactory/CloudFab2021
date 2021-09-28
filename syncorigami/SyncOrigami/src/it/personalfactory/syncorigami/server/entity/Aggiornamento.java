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
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.persistence.Transient;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "aggiornamento")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Aggiornamento.findAll", query = "SELECT a FROM Aggiornamento a"),
//  @NamedQuery(name = "Aggiornamento.findById", query = "SELECT a FROM Aggiornamento a WHERE a.id = :id"),
//  @NamedQuery(name = "Aggiornamento.findByTipo", query = "SELECT a FROM Aggiornamento a WHERE a.tipo = :tipo"),
//  @NamedQuery(name = "Aggiornamento.findByDtAggiornamento", query = "SELECT a FROM Aggiornamento a WHERE a.dtAggiornamento = :dtAggiornamento"),
//  @NamedQuery(name = "Aggiornamento.findByNomeFile", query = "SELECT a FROM Aggiornamento a WHERE a.nomeFile = :nomeFile"),
//  @NamedQuery(name = "Aggiornamento.findByVersione", query = "SELECT a FROM Aggiornamento a WHERE a.versione = :versione"),
//  @NamedQuery(name = "Aggiornamento.findLastVersione", query = "SELECT MAX(a.versione) FROM Aggiornamento a, Macchina m "
//  + "WHERE m.idMacchina = :idMacchina "
//  + "AND a.tipo= :tipo"),
//  @NamedQuery(name = "Aggiornamento.findByIdMacchinaTipo", query = "SELECT a FROM Aggiornamento a, Macchina m "
//  + "WHERE m.idMacchina = :idMacchina "
//  + "AND a.tipo= :tipo")
})
public class Aggiornamento implements Serializable {

  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id")
  private Integer id;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 10)
  @Column(name = "tipo")
  private String tipo;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_aggiornamento")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAggiornamento;
  @Size(max = 255)
  @Column(name = "nome_file")
  private String nomeFile;
  @Column(name = "versione")
  private Integer versione;
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;
  @Transient
  private Collection daInserire;

  public Collection getDaCancellare() {
    return daCancellare;
  }

  public void setDaCancellare(Collection daCancellare) {
    this.daCancellare = daCancellare;
  }

  public Collection getDaInserire() {
    return daInserire;
  }

  public void setDaInserire(Collection daInserire) {
    this.daInserire = daInserire;
  }
  @Transient
  private Collection daCancellare;

  public Aggiornamento() {
  }

  public Aggiornamento(Integer id) {
    this.id = id;
  }

  public Aggiornamento(Integer id, String tipo, Date dtAggiornamento, String urlRemoto) {
    this.id = id;
    this.tipo = tipo;
    this.dtAggiornamento = dtAggiornamento;
  }

  public Integer getId() {
    return id;
  }

  public void setId(Integer id) {
    this.id = id;
  }

  public String getTipo() {
    return tipo;
  }

  public void setTipo(String tipo) {
    this.tipo = tipo;
  }

  public Date getDtAggiornamento() {
    return dtAggiornamento;
  }

  public void setDtAggiornamento(Date dtAggiornamento) {
    this.dtAggiornamento = dtAggiornamento;
  }

  public String getNomeFile() {
    return nomeFile;
  }

  public void setNomeFile(String nomeFile) {
    this.nomeFile = nomeFile;
  }

  public Integer getVersione() {
    return versione;
  }

  public void setVersione(Integer versione) {
    this.versione = versione;
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
    hash += (id != null ? id.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Aggiornamento)) {
      return false;
    }
    Aggiornamento other = (Aggiornamento) object;
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
