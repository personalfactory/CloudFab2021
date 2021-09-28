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
@Table(name = "codice")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "Codice.findAll", query = "SELECT c FROM Codice c"),
//  @NamedQuery(name = "Codice.findByIdCodice", query = "SELECT c FROM Codice c WHERE c.idCodice = :idCodice"),
//  @NamedQuery(name = "Codice.findByTipoCodice", query = "SELECT c FROM Codice c WHERE c.tipoCodice = :tipoCodice"),
//  @NamedQuery(name = "Codice.findByDescrizione", query = "SELECT c FROM Codice c WHERE c.descrizione = :descrizione"),
//  @NamedQuery(name = "Codice.findByAbilitato", query = "SELECT c FROM Codice c WHERE c.abilitato = :abilitato"),
//  @NamedQuery(name = "Codice.findByDtAbilitato", query = "SELECT c FROM Codice c WHERE c.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "Codice.findDatiNuovi", query = "SELECT c FROM Codice c WHERE  c.dtAbilitato > :dtAbilitato")})
public class Codice implements Serializable {
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_codice")
  private Integer idCodice;
  @Size(max = 255)
  @Column(name = "tipo_codice")
  private String tipoCodice;
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
  @OneToMany(mappedBy = "idCodice")
  private Collection<AnagrafeProdotto> anagrafeProdottoCollection;

  public Codice() {
  }

  public Codice(Integer idCodice) {
    this.idCodice = idCodice;
  }

  public Codice(Integer idCodice, Date dtAbilitato) {
    this.idCodice = idCodice;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdCodice() {
    return idCodice;
  }

  public void setIdCodice(Integer idCodice) {
    this.idCodice = idCodice;
  }

  public String getTipoCodice() {
    return tipoCodice;
  }

  public void setTipoCodice(String tipoCodice) {
    this.tipoCodice = tipoCodice;
  }

  public String getDescrizione() {
    return descrizione;
  }

  public void setDescrizione(String descrizione) {
    this.descrizione = descrizione;
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
  public Collection<AnagrafeProdotto> getAnagrafeProdottoCollection() {
    return anagrafeProdottoCollection;
  }

  public void setAnagrafeProdottoCollection(Collection<AnagrafeProdotto> anagrafeProdottoCollection) {
    this.anagrafeProdottoCollection = anagrafeProdottoCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idCodice != null ? idCodice.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Codice)) {
      return false;
    }
    Codice other = (Codice) object;
    if ((this.idCodice == null && other.idCodice != null) || (this.idCodice != null && !this.idCodice.equals(other.idCodice))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
