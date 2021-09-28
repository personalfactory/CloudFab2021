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
@Table(name = "parametro_ripristino")
@XmlRootElement
@NamedQueries({
//  @NamedQuery(name = "ParametroRipristino.findAll", query = "SELECT p FROM ParametroRipristino p"),
//  @NamedQuery(name = "ParametroRipristino.findByIdParRipristino", query = "SELECT p FROM ParametroRipristino p WHERE p.idParRipristino = :idParRipristino"),
//  @NamedQuery(name = "ParametroRipristino.findByNomeVariabile", query = "SELECT p FROM ParametroRipristino p WHERE p.nomeVariabile = :nomeVariabile"),
//  @NamedQuery(name = "ParametroRipristino.findByDescriVariabile", query = "SELECT p FROM ParametroRipristino p WHERE p.descriVariabile = :descriVariabile"),
//  @NamedQuery(name = "ParametroRipristino.findByAbilitato", query = "SELECT p FROM ParametroRipristino p WHERE p.abilitato = :abilitato"),
//  @NamedQuery(name = "ParametroRipristino.findByDtAbilitato", query = "SELECT p FROM ParametroRipristino p WHERE p.dtAbilitato = :dtAbilitato"),
  @NamedQuery(name = "ParametroRipristino.findDatiNuovi", query = "SELECT p FROM ParametroRipristino p WHERE p.dtAbilitato > :dtAbilitato")})
public class ParametroRipristino implements Serializable {
    @Basic(optional = false)
    @NotNull
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
  private static final long serialVersionUID = 1L;
  @Id
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_par_ripristino")
  private Integer idParRipristino;
  @Size(max = 255)
  @Column(name = "nome_variabile")
  private String nomeVariabile;
  @Size(max = 255)
  @Column(name = "descri_variabile")
  private String descriVariabile;
  @Column(name = "abilitato")
  private Boolean abilitato;
  
  //MODIFICATA CascadeType.ALL a CascadeType.REMOVE 
  //TESTARE BENE
  @OneToMany(cascade = CascadeType.REMOVE, mappedBy = "idParRipristino")
  private Collection<ValoreRipristino> valoreRipristinoCollection;

  public ParametroRipristino() {
  }

  public ParametroRipristino(Integer idParRipristino) {
    this.idParRipristino = idParRipristino;
  }

  public ParametroRipristino(Integer idParRipristino, Date dtAbilitato) {
    this.idParRipristino = idParRipristino;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdParRipristino() {
    return idParRipristino;
  }

  public void setIdParRipristino(Integer idParRipristino) {
    this.idParRipristino = idParRipristino;
  }

  public String getNomeVariabile() {
    return nomeVariabile;
  }

  public void setNomeVariabile(String nomeVariabile) {
    this.nomeVariabile = nomeVariabile;
  }

  public String getDescriVariabile() {
    return descriVariabile;
  }

  public void setDescriVariabile(String descriVariabile) {
    this.descriVariabile = descriVariabile;
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
  public Collection<ValoreRipristino> getValoreRipristinoCollection() {
    return valoreRipristinoCollection;
  }

  public void setValoreRipristinoCollection(Collection<ValoreRipristino> valoreRipristinoCollection) {
    this.valoreRipristinoCollection = valoreRipristinoCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idParRipristino != null ? idParRipristino.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ParametroRipristino)) {
      return false;
    }
    ParametroRipristino other = (ParametroRipristino) object;
    if ((this.idParRipristino == null && other.idParRipristino != null) || (this.idParRipristino != null && !this.idParRipristino.equals(other.idParRipristino))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

  
}
