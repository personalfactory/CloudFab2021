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
@Table(name = "anagrafe_macchina")
@XmlRootElement
//@NamedQueries({
//  @NamedQuery(name = "AnagrafeMacchina.findAll", query = "SELECT a FROM AnagrafeMacchina a"),
//  @NamedQuery(name = "AnagrafeMacchina.findByGeografico", query = "SELECT a FROM AnagrafeMacchina a WHERE a.geografico = :geografico"),
//  @NamedQuery(name = "AnagrafeMacchina.findByGruppo", query = "SELECT a FROM AnagrafeMacchina a WHERE a.gruppo = :gruppo"),
//  @NamedQuery(name = "AnagrafeMacchina.findByAbilitato", query = "SELECT a FROM AnagrafeMacchina a WHERE a.abilitato = :abilitato"),
//  @NamedQuery(name = "AnagrafeMacchina.findByDtAbilitato", query = "SELECT a FROM AnagrafeMacchina a WHERE a.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "AnagrafeMacchina.findByIdClienteGaz", query = "SELECT a FROM AnagrafeMacchina a WHERE a.idClienteGaz = :idClienteGaz"),
//  @NamedQuery(name = "AnagrafeMacchina.findByTipoRiferimento", query = "SELECT a FROM AnagrafeMacchina a WHERE a.tipoRiferimento = :tipoRiferimento"),
//  @NamedQuery(name = "AnagrafeMacchina.findByLivelloGruppo", query = "SELECT a FROM AnagrafeMacchina a WHERE a.livelloGruppo = :livelloGruppo"),
//  @NamedQuery(name = "AnagrafeMacchina.findByIdAnMac", query = "SELECT a FROM AnagrafeMacchina a WHERE a.idAnMac = :idAnMac"),
//  @NamedQuery(name = "AnagrafeMacchina.findDatiNuovi", query = "SELECT a FROM AnagrafeMacchina a, Macchina m WHERE  m.idMacchina = :idMacchina AND a.dtAbilitato > :dtAbilitato")})
public class AnagrafeMacchina implements Serializable {
  private static final long serialVersionUID = 1L;
  @Size(max = 100)
  @Column(name = "geografico")
  private String geografico;
  @Size(max = 100)
  @Column(name = "gruppo")
  private String gruppo;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @Column(name = "id_cliente_gaz")
  private Integer idClienteGaz;
  @Size(max = 50)
  @Column(name = "tipo_riferimento")
  private String tipoRiferimento;
  @Size(max = 50)
  @Column(name = "livello_gruppo")
  private String livelloGruppo;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_an_mac")
  private Integer idAnMac;
  @JoinColumn(name = "id_macchina", referencedColumnName = "id_macchina")
  @ManyToOne(optional = false)
  private Macchina idMacchina;
  @JoinColumn(name = "id_lingua", referencedColumnName = "id_lingua")
  @ManyToOne(optional = false)
  private Lingua idLingua;

  public AnagrafeMacchina() {
  }

  public AnagrafeMacchina(Integer idAnMac) {
    this.idAnMac = idAnMac;
  }

  public AnagrafeMacchina(Integer idAnMac, Date dtAbilitato) {
    this.idAnMac = idAnMac;
    this.dtAbilitato = dtAbilitato;
  }

  public String getGeografico() {
    return geografico;
  }

  public void setGeografico(String geografico) {
    this.geografico = geografico;
  }

  public String getGruppo() {
    return gruppo;
  }

  public void setGruppo(String gruppo) {
    this.gruppo = gruppo;
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

  public Integer getIdClienteGaz() {
    return idClienteGaz;
  }

  public void setIdClienteGaz(Integer idClienteGaz) {
    this.idClienteGaz = idClienteGaz;
  }

  public String getTipoRiferimento() {
    return tipoRiferimento;
  }

  public void setTipoRiferimento(String tipoRiferimento) {
    this.tipoRiferimento = tipoRiferimento;
  }

  public String getLivelloGruppo() {
    return livelloGruppo;
  }

  public void setLivelloGruppo(String livelloGruppo) {
    this.livelloGruppo = livelloGruppo;
  }

  public Integer getIdAnMac() {
    return idAnMac;
  }

  public void setIdAnMac(Integer idAnMac) {
    this.idAnMac = idAnMac;
  }

  public Macchina getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(Macchina idMacchina) {
    this.idMacchina = idMacchina;
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
    hash += (idAnMac != null ? idAnMac.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof AnagrafeMacchina)) {
      return false;
    }
    AnagrafeMacchina other = (AnagrafeMacchina) object;
    if ((this.idAnMac == null && other.idAnMac != null) || (this.idAnMac != null && !this.idAnMac.equals(other.idAnMac))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
