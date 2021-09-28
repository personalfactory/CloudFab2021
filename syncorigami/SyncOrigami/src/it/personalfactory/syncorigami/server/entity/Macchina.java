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
@Table(name = "macchina")
@XmlRootElement
@NamedQueries({
  @NamedQuery(name = "Macchina.findAll", query = "SELECT m FROM Macchina m"),
  @NamedQuery(name = "Macchina.findByIdMacchina", query = "SELECT m FROM Macchina m WHERE m.idMacchina = :idMacchina"),
//  @NamedQuery(name = "Macchina.findByCodStab", query = "SELECT m FROM Macchina m WHERE m.codStab = :codStab"),
//  @NamedQuery(name = "Macchina.findByDescriStab", query = "SELECT m FROM Macchina m WHERE m.descriStab = :descriStab"),
//  @NamedQuery(name = "Macchina.findByRagso1", query = "SELECT m FROM Macchina m WHERE m.ragso1 = :ragso1"),
  @NamedQuery(name = "Macchina.findByAbilitato", query = "SELECT m FROM Macchina m WHERE m.abilitato = :abilitato")
//  @NamedQuery(name = "Macchina.findByDtAbilitato", query = "SELECT m FROM Macchina m WHERE m.dtAbilitato = :dtAbilitato"),
//  @NamedQuery(name = "Macchina.findByUserOrigami", query = "SELECT m FROM Macchina m WHERE m.userOrigami = :userOrigami"),
//  @NamedQuery(name = "Macchina.findByUserServer", query = "SELECT m FROM Macchina m WHERE m.userServer = :userServer"),
//  @NamedQuery(name = "Macchina.findByPassOrigami", query = "SELECT m FROM Macchina m WHERE m.passOrigami = :passOrigami"),
//  @NamedQuery(name = "Macchina.findByPassServer", query = "SELECT m FROM Macchina m WHERE m.passServer = :passServer"),
//  @NamedQuery(name = "Macchina.findDatiNuovi", query = "SELECT m FROM Macchina m WHERE  m.idMacchina = :idMacchina AND m.dtAbilitato > :dtAbilitato")
})
public class Macchina implements Serializable {
    @Basic(optional =     false)
    @NotNull
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
  private Date dtAbilitato;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<ValoreParComp> valoreParCompCollection;
 
   
  private static final long serialVersionUID = 1L;
  @Id
  @GeneratedValue(strategy = GenerationType.IDENTITY)
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_macchina")
  private Integer idMacchina;
  @Size(max = 50)
  @Column(name = "cod_stab")
  private String codStab;
  @Size(max = 50)
  @Column(name = "descri_stab")
  private String descriStab;
  @Size(max = 50)
  @Column(name = "ragso1")
  private String ragso1;
  @Column(name = "abilitato")
  private Boolean abilitato;
  @Size(max = 50)
  @Column(name = "user_origami")
  private String userOrigami;
  @Size(max = 50)
  @Column(name = "user_server")
  private String userServer;
  @Size(max = 50)
  @Column(name = "pass_origami")
  private String passOrigami;
  @Size(max = 50)
  @Column(name = "pass_server")
  private String passServer;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<Bolla> bollaCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<Processo> processoCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<ValoreParSingMac> valoreParSingMacCollection;
  @OneToMany(mappedBy = "idMacchina")
  private Collection<MazzettaColSingMac> mazzettaColSingMacCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<Aggiornamento> aggiornamentoCollection;
  @OneToMany(cascade = CascadeType.ALL, mappedBy = "idMacchina")
  private Collection<AnagrafeMacchina> anagrafeMacchinaCollection;
  
  @Size(max = 255)
  @Column(name = "ftp_user")
  private String ftpUser;
  
  @Size(max = 255)
  @Column(name = "ftp_password")
  private String ftpPassword;
  
  @Size(max = 255)
  @Column(name = "zip_password")
  private String zipPassword;

  public String getFtpPassword() {
    return ftpPassword;
  }

  public void setFtpPassword(String ftpPassword) {
    this.ftpPassword = ftpPassword;
  }

  public String getFtpUser() {
    return ftpUser;
  }

  public void setFtpUser(String ftpUser) {
    this.ftpUser = ftpUser;
  }

  public String getZipPassword() {
    return zipPassword;
  }

  public Macchina() {
  }

  public Macchina(Integer idMacchina) {
    this.idMacchina = idMacchina;
  }

  public Macchina(Integer idMacchina, Date dtAbilitato) {
    this.idMacchina = idMacchina;
    this.dtAbilitato = dtAbilitato;
  }

  public Integer getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(Integer idMacchina) {
    this.idMacchina = idMacchina;
  }

  public String getCodStab() {
    return codStab;
  }

  public void setCodStab(String codStab) {
    this.codStab = codStab;
  }

  public String getDescriStab() {
    return descriStab;
  }

  public void setDescriStab(String descriStab) {
    this.descriStab = descriStab;
  }

  public String getRagso1() {
    return ragso1;
  }

  public void setRagso1(String ragso1) {
    this.ragso1 = ragso1;
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

  public String getUserOrigami() {
    return userOrigami;
  }

  public void setUserOrigami(String userOrigami) {
    this.userOrigami = userOrigami;
  }

  public String getUserServer() {
    return userServer;
  }

  public void setUserServer(String userServer) {
    this.userServer = userServer;
  }

  public String getPassOrigami() {
    return passOrigami;
  }

  public void setPassOrigami(String passOrigami) {
    this.passOrigami = passOrigami;
  }

  public String getPassServer() {
    return passServer;
  }

  public void setPassServer(String passServer) {
    this.passServer = passServer;
  }

  @XmlTransient
  public Collection<Bolla> getBollaCollection() {
    return bollaCollection;
  }

  public void setBollaCollection(Collection<Bolla> bollaCollection) {
    this.bollaCollection = bollaCollection;
  }

  @XmlTransient
  public Collection<Processo> getProcessoCollection() {
    return processoCollection;
  }

  public void setProcessoCollection(Collection<Processo> processoCollection) {
    this.processoCollection = processoCollection;
  }

  

  @XmlTransient
  public Collection<ValoreParSingMac> getValoreParSingMacCollection() {
    return valoreParSingMacCollection;
  }

  public void setValoreParSingMacCollection(Collection<ValoreParSingMac> valoreParSingMacCollection) {
    this.valoreParSingMacCollection = valoreParSingMacCollection;
  }

  @XmlTransient
  public Collection<MazzettaColSingMac> getMazzettaColSingMacCollection() {
    return mazzettaColSingMacCollection;
  }

  public void setMazzettaColSingMacCollection(Collection<MazzettaColSingMac> mazzettaColSingMacCollection) {
    this.mazzettaColSingMacCollection = mazzettaColSingMacCollection;
  }

  @XmlTransient
  public Collection<Aggiornamento> getAggiornamentoCollection() {
    return aggiornamentoCollection;
  }

  public void setAggiornamentoCollection(Collection<Aggiornamento> aggiornamentoCollection) {
    this.aggiornamentoCollection = aggiornamentoCollection;
  }

  @XmlTransient
  public Collection<AnagrafeMacchina> getAnagrafeMacchinaCollection() {
    return anagrafeMacchinaCollection;
  }

  public void setAnagrafeMacchinaCollection(Collection<AnagrafeMacchina> anagrafeMacchinaCollection) {
    this.anagrafeMacchinaCollection = anagrafeMacchinaCollection;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (idMacchina != null ? idMacchina.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof Macchina)) {
      return false;
    }
    Macchina other = (Macchina) object;
    if ((this.idMacchina == null && other.idMacchina != null) || (this.idMacchina != null && !this.idMacchina.equals(other.idMacchina))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }

 
  @XmlTransient
  public Collection<ValoreParComp> getValoreParCompCollection() {
    return valoreParCompCollection;
  }

  public void setValoreParCompCollection(Collection<ValoreParComp> valoreParCompCollection) {
    this.valoreParCompCollection = valoreParCompCollection;
  }

           
  
}
