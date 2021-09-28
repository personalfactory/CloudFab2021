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
@Table(name = "chimica")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Chimica.findAll", query = "SELECT c FROM Chimica c"),
//  @NamedQuery(name = "Chimica.findByIdChimica", query = "SELECT c FROM Chimica c WHERE c.idChimica = :idChimica"),
//  @NamedQuery(name = "Chimica.findByCodChimica", query = "SELECT c FROM Chimica c WHERE c.codChimica = :codChimica"),
//  @NamedQuery(name = "Chimica.findByDescriFormula", query = "SELECT c FROM Chimica c WHERE c.descriFormula = :descriFormula"),
//  @NamedQuery(name = "Chimica.findByData", query = "SELECT c FROM Chimica c WHERE c.data = :data"),
//  @NamedQuery(name = "Chimica.findByCodProdotto", query = "SELECT c FROM Chimica c WHERE c.codProdotto = :codProdotto"),
//  @NamedQuery(name = "Chimica.findByDtAbilitato", query = "SELECT c FROM Chimica c WHERE c.dtAbilitato = :dtAbilitato"),
  //Bisogna selezionare i codici lotto che hanno id_bolla NOT NULL altrimenti non funziona
  //Il programma di prod chimica prevede che il campo id_bolla possa essere null finchè non viene aggiornato
  @NamedQuery(name = "Chimica.findDatiNuovi", query = "SELECT c FROM Chimica c, Lotto l, Bolla b, Macchina m "
        + "                                             WHERE m.idMacchina = :idMacchina "
        + "                                               AND b.dtAbilitato > :dtAbilitato "
        + "                                               AND c.codLotto = l.codLotto "
        + "                                               AND l.idBolla = b.idBolla "
        + "                                               AND b.idMacchina = m.idMacchina")})
public class Chimica implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_chimica")
  private Integer idChimica;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "cod_chimica")
  private String codChimica;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "descri_formula")
  private String descriFormula;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "data")
  private String data;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "cod_prodotto")
  private String codProdotto;
  @Basic(optional = false)
  @NotNull
  @Column(name = "dt_abilitato")
  @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @JoinColumn(name = "cod_lotto", referencedColumnName = "cod_lotto")
  @ManyToOne(optional = false)
  private Lotto codLotto;

  public Chimica() {
  }

  public Chimica(Integer idChimica) {
    this.idChimica = idChimica;
  }

  public Chimica(Integer idChimica, String codChimica, String descriFormula, String data, String codProdotto, Date dtAbilitato) {
    this.idChimica = idChimica;
    this.codChimica = codChimica;
    this.descriFormula = descriFormula;
    this.data = data;
    this.codProdotto = codProdotto;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdChimica() {
    return idChimica;
  }

  public void setIdChimica(Integer idChimica) {
    this.idChimica = idChimica;
  }

  public String getCodChimica() {
    return codChimica;
  }

  public void setCodChimica(String codChimica) {
    this.codChimica = codChimica;
  }

  public String getDescriFormula() {
    return descriFormula;
  }

  public void setDescriFormula(String descriFormula) {
    this.descriFormula = descriFormula;
  }

  public String getData() {
    return data;
  }

  public void setData(String data) {
    this.data = data;
  }

  public String getCodProdotto() {
    return codProdotto;
  }

  public void setCodProdotto(String codProdotto) {
    this.codProdotto = codProdotto;
  }

  public Date getDtAbilitato() {
    return dtAbilitato;
  }

  public void setDtAbilitato(Date dtAbilitato) {
    this.dtAbilitato = dtAbilitato;
  }

  public Lotto getCodLotto() {
    return codLotto;
  }

  public void setCodLotto(Lotto codLotto) {
    this.codLotto = codLotto;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idChimica != null ? idChimica.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Chimica)) {
      return false;
    }
    Chimica other = (Chimica) object;
    if ((this.idChimica == null && other.idChimica != null) || (this.idChimica != null && !this.idChimica.equals(other.idChimica))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
