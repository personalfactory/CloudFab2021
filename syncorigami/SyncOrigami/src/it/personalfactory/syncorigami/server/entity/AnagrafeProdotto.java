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
import javax.persistence.FetchType;
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
@Table(name = "anagrafe_prodotto")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "AnagrafeProdotto.findAll", query = "SELECT a FROM AnagrafeProdotto a"),
//  @NamedQuery(name = "AnagrafeProdotto.findByColorato", query = "SELECT a FROM AnagrafeProdotto a WHERE a.colorato = :colorato"),
//  @NamedQuery(name = "AnagrafeProdotto.findByLimColore", query = "SELECT a FROM AnagrafeProdotto a WHERE a.limColore = :limColore"),
//  @NamedQuery(name = "AnagrafeProdotto.findByFattoreDiv", query = "SELECT a FROM AnagrafeProdotto a WHERE a.fattoreDiv = :fattoreDiv"),
//  @NamedQuery(name = "AnagrafeProdotto.findByFascia", query = "SELECT a FROM AnagrafeProdotto a WHERE a.fascia = :fascia"),
//  @NamedQuery(name = "AnagrafeProdotto.findByGeografico", query = "SELECT a FROM AnagrafeProdotto a WHERE a.geografico = :geografico"),
//  @NamedQuery(name = "AnagrafeProdotto.findByTipoRiferimento", query = "SELECT a FROM AnagrafeProdotto a WHERE a.tipoRiferimento = :tipoRiferimento"),
//  @NamedQuery(name = "AnagrafeProdotto.findByGruppo", query = "SELECT a FROM AnagrafeProdotto a WHERE a.gruppo = :gruppo"),
//  @NamedQuery(name = "AnagrafeProdotto.findByLivelloGruppo", query = "SELECT a FROM AnagrafeProdotto a WHERE a.livelloGruppo = :livelloGruppo"),
//  @NamedQuery(name = "AnagrafeProdotto.findByAbilitato", query = "SELECT a FROM AnagrafeProdotto a WHERE a.abilitato = :abilitato"),
//  @NamedQuery(name = "AnagrafeProdotto.findByDtAbilitato", query = "SELECT a FROM AnagrafeProdotto a WHERE a.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "AnagrafeProdotto.findByIdAnProd", query = "SELECT a FROM AnagrafeProdotto a WHERE a.idAnProd = :idAnProd"),
  @NamedQuery(name = "AnagrafeProdotto.findDatiNuovi", query = "SELECT a FROM AnagrafeProdotto a WHERE  a.dtAbilitato > :dtAbilitato")})

    
public class AnagrafeProdotto implements Serializable {
  private static final long serialVersionUID = 1L;
  @Size(max = 50)
  @Column(name = "colorato")
  private String colorato;
  @Size(max = 50)
  @Column(name = "lim_colore")
  private String limColore;
  @Size(max = 50)
  @Column(name = "fattore_div")
  private String fattoreDiv;
  @Size(max = 50)
  @Column(name = "fascia")
  private String fascia;
  @Size(max = 255)
  @Column(name = "geografico")
  private String geografico;
  @Size(max = 50)
  @Column(name = "tipo_riferimento")
  private String tipoRiferimento;
  @Size(max = 50)
  @Column(name = "gruppo")
  private String gruppo;
  @Size(max = 50)
  @Column(name = "livello_gruppo")
  private String livelloGruppo;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_an_prod")
  private Integer idAnProd;
  @JoinColumn(name = "id_codice", referencedColumnName = "id_codice")
  @ManyToOne
  private Codice idCodice;
  @JoinColumn(name = "id_cat", referencedColumnName = "id_cat")
  @ManyToOne(optional = false)
  private Categoria idCat;
  @JoinColumn(name = "id_prodotto", referencedColumnName = "id_prodotto")
  
  @ManyToOne(optional = false)
  private Prodotto idProdotto;
  @JoinColumn(name = "id_mazzetta", referencedColumnName = "id_mazzetta")
  @ManyToOne(optional = false)
  private Mazzetta idMazzetta;

  public AnagrafeProdotto() {
  }

  public AnagrafeProdotto(Integer idAnProd) {
    this.idAnProd = idAnProd;
  }

  public AnagrafeProdotto(Integer idAnProd, Date dtAbilitato) {
    this.idAnProd = idAnProd;
    this.dtAbilitato = dtAbilitato;
  }

  public String getColorato() {
    return colorato;
  }

  public void setColorato(String colorato) {
    this.colorato = colorato;
  }

  public String getLimColore() {
    return limColore;
  }

  public void setLimColore(String limColore) {
    this.limColore = limColore;
  }

  public String getFattoreDiv() {
    return fattoreDiv;
  }

  public void setFattoreDiv(String fattoreDiv) {
    this.fattoreDiv = fattoreDiv;
  }

  public String getFascia() {
    return fascia;
  }

  public void setFascia(String fascia) {
    this.fascia = fascia;
  }

  public String getGeografico() {
    return geografico;
  }

  public void setGeografico(String geografico) {
    this.geografico = geografico;
  }

  public String getTipoRiferimento() {
    return tipoRiferimento;
  }

  public void setTipoRiferimento(String tipoRiferimento) {
    this.tipoRiferimento = tipoRiferimento;
  }

  public String getGruppo() {
    return gruppo;
  }

  public void setGruppo(String gruppo) {
    this.gruppo = gruppo;
  }

  public String getLivelloGruppo() {
    return livelloGruppo;
  }

  public void setLivelloGruppo(String livelloGruppo) {
    this.livelloGruppo = livelloGruppo;
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

  public Integer getIdAnProd() {
    return idAnProd;
  }

  public void setIdAnProd(Integer idAnProd) {
    this.idAnProd = idAnProd;
  }

  public Codice getIdCodice() {
    return idCodice;
  }

  public void setIdCodice(Codice idCodice) {
    this.idCodice = idCodice;
  }

  public Categoria getIdCat() {
    return idCat;
  }

  public void setIdCat(Categoria idCat) {
    this.idCat = idCat;
  }

  public Prodotto getIdProdotto() {
    return idProdotto;
  }

  public void setIdProdotto(Prodotto idProdotto) {
    this.idProdotto = idProdotto;
  }

  public Mazzetta getIdMazzetta() {
    return idMazzetta;
  }

  public void setIdMazzetta(Mazzetta idMazzetta) {
    this.idMazzetta = idMazzetta;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idAnProd != null ? idAnProd.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof AnagrafeProdotto)) {
      return false;
    }
    AnagrafeProdotto other = (AnagrafeProdotto) object;
    if ((this.idAnProd == null && other.idAnProd != null) || (this.idAnProd != null && !this.idAnProd.equals(other.idAnProd))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
