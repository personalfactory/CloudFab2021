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
@Table(name = "parametro_ordine")
@XmlRootElement
@NamedQueries({
    @NamedQuery(name = "ParametroOrdine.findAll", query = "SELECT p FROM ParametroOrdine p"),
    @NamedQuery(name = "ParametroOrdine.findByIdParOrdine", query = "SELECT p FROM ParametroOrdine p WHERE p.idParOrdine = :idParOrdine"),
    @NamedQuery(name = "ParametroOrdine.findByNome", query = "SELECT p FROM ParametroOrdine p WHERE p.nome = :nome"),
    @NamedQuery(name = "ParametroOrdine.findByDescrizione", query = "SELECT p FROM ParametroOrdine p WHERE p.descrizione = :descrizione"),
    @NamedQuery(name = "ParametroOrdine.findByAbilitato", query = "SELECT p FROM ParametroOrdine p WHERE p.abilitato = :abilitato"),
    @NamedQuery(name = "ParametroOrdine.findByDtAbilitato", query = "SELECT p FROM ParametroOrdine p WHERE p.dtAbilitato = :dtAbilitato")})
public class ParametroOrdine implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_par_ordine")
    private Integer idParOrdine;
    @Size(max = 255)
    @Column(name = "nome")
    private String nome;
    @Size(max = 255)
    @Column(name = "descrizione")
    private String descrizione;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @OneToMany(mappedBy = "idParOrdine")
    private Collection<ValoreParOrdine> valoreParOrdineCollection;

    public ParametroOrdine() {
    }

    public ParametroOrdine(Integer idParOrdine) {
        this.idParOrdine = idParOrdine;
    }

    public Integer getIdParOrdine() {
        return idParOrdine;
    }

    public void setIdParOrdine(Integer idParOrdine) {
        this.idParOrdine = idParOrdine;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
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
    public Collection<ValoreParOrdine> getValoreParOrdineCollection() {
        return valoreParOrdineCollection;
    }

    public void setValoreParOrdineCollection(Collection<ValoreParOrdine> valoreParOrdineCollection) {
        this.valoreParOrdineCollection = valoreParOrdineCollection;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idParOrdine != null ? idParOrdine.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof ParametroOrdine)) {
            return false;
        }
        ParametroOrdine other = (ParametroOrdine) object;
        if ((this.idParOrdine == null && other.idParOrdine != null) || (this.idParOrdine != null && !this.idParOrdine.equals(other.idParOrdine))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.ParametroOrdine[ idParOrdine=" + idParOrdine + " ]";
    }
    
}
