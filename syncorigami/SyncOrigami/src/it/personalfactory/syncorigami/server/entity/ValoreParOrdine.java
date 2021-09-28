/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

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
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "valore_par_ordine")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "ValoreParOrdine.findAll", query = "SELECT v FROM ValoreParOrdine v"),
    @NamedQuery(name = "ValoreParOrdine.findById", query = "SELECT v FROM ValoreParOrdine v WHERE v.id = :id"),
    @NamedQuery(name = "ValoreParOrdine.findByIdMacchina", query = "SELECT v FROM ValoreParOrdine v WHERE v.idMacchina = :idMacchina"),
    @NamedQuery(name = "ValoreParOrdine.findByIdOrdineSm", query = "SELECT v FROM ValoreParOrdine v WHERE v.idOrdineSm = :idOrdineSm"),
    @NamedQuery(name = "ValoreParOrdine.findByValore", query = "SELECT v FROM ValoreParOrdine v WHERE v.valore = :valore"),
    @NamedQuery(name = "ValoreParOrdine.findByAbilitato", query = "SELECT v FROM ValoreParOrdine v WHERE v.abilitato = :abilitato"),
    @NamedQuery(name = "ValoreParOrdine.findByDtAbilitato", query = "SELECT v FROM ValoreParOrdine v WHERE v.dtAbilitato = :dtAbilitato"),*/
   @NamedQuery(name = "ValoreParOrdine.findDatiNuovi", query = "SELECT v FROM ValoreParOrdine v , OrdineSingMac o, OrdineElenco e "
           + " WHERE v.idOrdineSm=o.idOrdineSm "
           + " AND o.idOrdine=e.idOrdine "
           + " AND e.idMacchina=:idMacchina "
           + " AND v.dtAbilitato >= :dtAbilitato")})
public class ValoreParOrdine implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Column(name = "id_macchina")
    private Integer idMacchina;
    @Column(name = "id_ordine_sm")
    private Integer idOrdineSm;
    @Size(max = 255)
    @Column(name = "valore")
    private String valore;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @JoinColumn(name = "id_par_ordine", referencedColumnName = "id_par_ordine")
    @ManyToOne
    private ParametroOrdine idParOrdine;

    public ValoreParOrdine() {
    }

    public ValoreParOrdine(Integer id) {
        this.id = id;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getIdMacchina() {
        return idMacchina;
    }

    public void setIdMacchina(Integer idMacchina) {
        this.idMacchina = idMacchina;
    }

    public Integer getIdOrdineSm() {
        return idOrdineSm;
    }

    public void setIdOrdineSm(Integer idOrdineSm) {
        this.idOrdineSm = idOrdineSm;
    }

    public String getValore() {
        return valore;
    }

    public void setValore(String valore) {
        this.valore = valore;
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

    public ParametroOrdine getIdParOrdine() {
        return idParOrdine;
    }

    public void setIdParOrdine(ParametroOrdine idParOrdine) {
        this.idParOrdine = idParOrdine;
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
        if (!(object instanceof ValoreParOrdine)) {
            return false;
        }
        ValoreParOrdine other = (ValoreParOrdine) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.ValoreParOrdine[ id=" + id + " ]";
    }
    
}
