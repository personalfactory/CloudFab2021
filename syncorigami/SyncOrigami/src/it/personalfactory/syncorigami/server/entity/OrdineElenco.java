/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "ordine_elenco")
@XmlRootElement
/**@NamedQueries({
    @NamedQuery(name = "OrdineElenco.findAll", query = "SELECT o FROM OrdineElenco o"),
    @NamedQuery(name = "OrdineElenco.findByIdOrdine", query = "SELECT o FROM OrdineElenco o WHERE o.idOrdine = :idOrdine"),
    @NamedQuery(name = "OrdineElenco.findByIdMacchina", query = "SELECT o FROM OrdineElenco o WHERE o.idMacchina = :idMacchina"),
    @NamedQuery(name = "OrdineElenco.findByDtOrdine", query = "SELECT o FROM OrdineElenco o WHERE o.dtOrdine = :dtOrdine"),
    @NamedQuery(name = "OrdineElenco.findByDtProgrammata", query = "SELECT o FROM OrdineElenco o WHERE o.dtProgrammata = :dtProgrammata"),
    @NamedQuery(name = "OrdineElenco.findByCosto", query = "SELECT o FROM OrdineElenco o WHERE o.costo = :costo"),
    @NamedQuery(name = "OrdineElenco.findByStato", query = "SELECT o FROM OrdineElenco o WHERE o.stato = :stato"),
    @NamedQuery(name = "OrdineElenco.findByDescriStato", query = "SELECT o FROM OrdineElenco o WHERE o.descriStato = :descriStato"),
    @NamedQuery(name = "OrdineElenco.findByNote", query = "SELECT o FROM OrdineElenco o WHERE o.note = :note"),
    @NamedQuery(name = "OrdineElenco.findByAbilitato", query = "SELECT o FROM OrdineElenco o WHERE o.abilitato = :abilitato"),
    @NamedQuery(name = "OrdineElenco.findByDtAbilitato", query = "SELECT o FROM OrdineElenco o WHERE o.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "OrdineElenco.findByIdUtente", query = "SELECT o FROM OrdineElenco o WHERE o.idUtente = :idUtente"),
    @NamedQuery(name = "OrdineElenco.findByIdAzienda", query = "SELECT o FROM OrdineElenco o WHERE o.idAzienda = :idAzienda")})*/
public class OrdineElenco implements Serializable {
    @OneToMany(mappedBy = "id")
    private Collection<ValoreParOrdine> valoreParOrdineCollection;
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_ordine")
    private Integer idOrdine;
    @Column(name = "id_macchina")
    private Integer idMacchina;
    @Column(name = "dt_ordine")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtOrdine;
    @Column(name = "dt_programmata")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtProgrammata;
    // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
    @Column(name = "costo")
    private Double costo;
    @Size(max = 45)
    @Column(name = "stato")
    private String stato;
    @Size(max = 255)
    @Column(name = "descri_stato")
    private String descriStato;
    @Size(max = 45)
    @Column(name = "note")
    private String note;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Column(name = "id_utente")
    private Integer idUtente;
    @Column(name = "id_azienda")
    private Integer idAzienda;
    @OneToMany(mappedBy = "idOrdine")
    private Collection<OrdineSingMac> ordineSingMacCollection;

    public OrdineElenco() {
    }

    public OrdineElenco(Integer idOrdine) {
        this.idOrdine = idOrdine;
    }

    public Integer getIdOrdine() {
        return idOrdine;
    }

    public void setIdOrdine(Integer idOrdine) {
        this.idOrdine = idOrdine;
    }

    public Integer getIdMacchina() {
        return idMacchina;
    }

    public void setIdMacchina(Integer idMacchina) {
        this.idMacchina = idMacchina;
    }

    public Date getDtOrdine() {
        return dtOrdine;
    }

    public void setDtOrdine(Date dtOrdine) {
        this.dtOrdine = dtOrdine;
    }

    public Date getDtProgrammata() {
        return dtProgrammata;
    }

    public void setDtProgrammata(Date dtProgrammata) {
        this.dtProgrammata = dtProgrammata;
    }

    public Double getCosto() {
        return costo;
    }

    public void setCosto(Double costo) {
        this.costo = costo;
    }

    public String getStato() {
        return stato;
    }

    public void setStato(String stato) {
        this.stato = stato;
    }

    public String getDescriStato() {
        return descriStato;
    }

    public void setDescriStato(String descriStato) {
        this.descriStato = descriStato;
    }

    public String getNote() {
        return note;
    }

    public void setNote(String note) {
        this.note = note;
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

    public Integer getIdUtente() {
        return idUtente;
    }

    public void setIdUtente(Integer idUtente) {
        this.idUtente = idUtente;
    }

    public Integer getIdAzienda() {
        return idAzienda;
    }

    public void setIdAzienda(Integer idAzienda) {
        this.idAzienda = idAzienda;
    }

    @XmlTransient
    public Collection<OrdineSingMac> getOrdineSingMacCollection() {
        return ordineSingMacCollection;
    }

    public void setOrdineSingMacCollection(Collection<OrdineSingMac> ordineSingMacCollection) {
        this.ordineSingMacCollection = ordineSingMacCollection;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idOrdine != null ? idOrdine.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof OrdineElenco)) {
            return false;
        }
        OrdineElenco other = (OrdineElenco) object;
        if ((this.idOrdine == null && other.idOrdine != null) || (this.idOrdine != null && !this.idOrdine.equals(other.idOrdine))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.OrdineElenco[ idOrdine=" + idOrdine + " ]";
    }

    @XmlTransient
    public Collection<ValoreParOrdine> getValoreParOrdineCollection() {
        return valoreParOrdineCollection;
    }

    public void setValoreParOrdineCollection(Collection<ValoreParOrdine> valoreParOrdineCollection) {
        this.valoreParOrdineCollection = valoreParOrdineCollection;
    }
    
}
