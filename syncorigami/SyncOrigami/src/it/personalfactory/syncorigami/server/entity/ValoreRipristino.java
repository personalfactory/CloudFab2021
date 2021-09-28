/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.*;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author Marilisa Tassone
 */
@Entity
@Table(name = "valore_ripristino")
@XmlRootElement
@NamedQueries({
//    @NamedQuery(name = "ValoreRipristino.findAll", query = "SELECT v FROM ValoreRipristino v"),
//    @NamedQuery(name = "ValoreRipristino.findByIdValoreRipristino", query = "SELECT v FROM ValoreRipristino v WHERE v.valoreRipristinoPK.idValoreRipristino = :idValoreRipristino"),
    @NamedQuery(name = "ValoreRipristino.findByIdMacchina", query = "SELECT v FROM ValoreRipristino v WHERE v.valoreRipristinoPK.idMacchina = :idMacchina"),
//    @NamedQuery(name = "ValoreRipristino.findByValoreVariabile", query = "SELECT v FROM ValoreRipristino v WHERE v.valoreVariabile = :valoreVariabile"),
//    @NamedQuery(name = "ValoreRipristino.findByIdProCorso", query = "SELECT v FROM ValoreRipristino v WHERE v.idProCorso = :idProCorso"),
//    @NamedQuery(name = "ValoreRipristino.findByDtRegistrato", query = "SELECT v FROM ValoreRipristino v WHERE v.dtRegistrato = :dtRegistrato"),
//    @NamedQuery(name = "ValoreRipristino.findByAbilitato", query = "SELECT v FROM ValoreRipristino v WHERE v.abilitato = :abilitato"),
//    @NamedQuery(name = "ValoreRipristino.findByDtAbilitato", query = "SELECT v FROM ValoreRipristino v WHERE v.dtAbilitato = :dtAbilitato"),
//    @NamedQuery(name = "ValoreRipristino.findByDtAggMac", query = "SELECT v FROM ValoreRipristino v WHERE v.dtAggMac = :dtAggMac"),
    @NamedQuery(name = "ValoreRipristino.findDatiNuovi", query = "SELECT v FROM ValoreRipristino v WHERE v.valoreRipristinoPK.idMacchina = :idMacchina "
                                                                + " AND v.dtAbilitato > :dtAbilitato")})


public class ValoreRipristino implements Serializable {
    private static final long serialVersionUID = 1L;
    @EmbeddedId
    protected ValoreRipristinoPK valoreRipristinoPK;
    @Size(max = 255)
    @Column(name = "valore_variabile")
    private String valoreVariabile;
    @Column(name = "id_pro_corso")
    private Integer idProCorso;
    @Basic(optional = false)
    @NotNull
    @Column(name = "dt_registrato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtRegistrato;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @NotNull
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Basic(optional = false)
    @NotNull
    @Column(name = "dt_agg_mac")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAggMac;
    @JoinColumn(name = "id_par_ripristino", referencedColumnName = "id_par_ripristino")
    @ManyToOne(optional = false)
    private ParametroRipristino idParRipristino;

    public ValoreRipristino() {
    }

    public ValoreRipristino(ValoreRipristinoPK valoreRipristinoPK) {
        this.valoreRipristinoPK = valoreRipristinoPK;
    }

    public ValoreRipristino(ValoreRipristinoPK valoreRipristinoPK, Date dtRegistrato, Date dtAbilitato, Date dtAggMac) {
        this.valoreRipristinoPK = valoreRipristinoPK;
        this.dtRegistrato = dtRegistrato;
        this.dtAbilitato = dtAbilitato;
        this.dtAggMac = dtAggMac;
    }

    public ValoreRipristino(int idValoreRipristino, int idMacchina) {
        this.valoreRipristinoPK = new ValoreRipristinoPK(idValoreRipristino, idMacchina);
    }

    public ValoreRipristinoPK getValoreRipristinoPK() {
        return valoreRipristinoPK;
    }

    public void setValoreRipristinoPK(ValoreRipristinoPK valoreRipristinoPK) {
        this.valoreRipristinoPK = valoreRipristinoPK;
    }

    public String getValoreVariabile() {
        return valoreVariabile;
    }

    public void setValoreVariabile(String valoreVariabile) {
        this.valoreVariabile = valoreVariabile;
    }

    public Integer getIdProCorso() {
        return idProCorso;
    }

    public void setIdProCorso(Integer idProCorso) {
        this.idProCorso = idProCorso;
    }

    public Date getDtRegistrato() {
        return dtRegistrato;
    }

    public void setDtRegistrato(Date dtRegistrato) {
        this.dtRegistrato = dtRegistrato;
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

    public Date getDtAggMac() {
        return dtAggMac;
    }

    public void setDtAggMac(Date dtAggMac) {
        this.dtAggMac = dtAggMac;
    }

    public ParametroRipristino getIdParRipristino() {
        return idParRipristino;
    }

    public void setIdParRipristino(ParametroRipristino idParRipristino) {
        this.idParRipristino = idParRipristino;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (valoreRipristinoPK != null ? valoreRipristinoPK.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof ValoreRipristino)) {
            return false;
        }
        ValoreRipristino other = (ValoreRipristino) object;
        if ((this.valoreRipristinoPK == null && other.valoreRipristinoPK != null) || (this.valoreRipristinoPK != null && !this.valoreRipristinoPK.equals(other.valoreRipristinoPK))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.ValoreRipristino[ valoreRipristinoPK=" + valoreRipristinoPK + " ]";
    }
    
}
