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
@Table(name = "comune")
@XmlRootElement

public class Comune implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @NotNull
    @Column(name = "id_comune")
    private Integer idComune;
    @Size(max = 50)
    @Column(name = "cap")
    private String cap;
    @Size(max = 10)
    @Column(name = "cod_cat")
    private String codCat;
    @Size(max = 10)
    @Column(name = "cod_istat")
    private String codIstat;
    @Size(max = 50)
    @Column(name = "comune")
    private String comune;
    @Size(max = 10)
    @Column(name = "cod_prov")
    private String codProv;
    @Size(max = 50)
    @Column(name = "provincia")
    private String provincia;
    @Size(max = 50)
    @Column(name = "cod_reg")
    private String codReg;
    @Size(max = 50)
    @Column(name = "regione")
    private String regione;
    @Size(max = 10)
    @Column(name = "cod_stat")
    private String codStat;
    @Size(max = 50)
    @Column(name = "stato")
    private String stato;
    @Size(max = 50)
    @Column(name = "continente")
    private String continente;
    @Size(max = 45)
    @Column(name = "mondo")
    private String mondo;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.DATE)
    private Date dtAbilitato;

    public Comune() {
    }

    public Comune(Integer idComune) {
        this.idComune = idComune;
    }

    public Integer getIdComune() {
        return idComune;
    }

    public void setIdComune(Integer idComune) {
        this.idComune = idComune;
    }

    public String getCap() {
        return cap;
    }

    public void setCap(String cap) {
        this.cap = cap;
    }

    public String getCodCat() {
        return codCat;
    }

    public void setCodCat(String codCat) {
        this.codCat = codCat;
    }

    public String getCodIstat() {
        return codIstat;
    }

    public void setCodIstat(String codIstat) {
        this.codIstat = codIstat;
    }

    public String getComune() {
        return comune;
    }

    public void setComune(String comune) {
        this.comune = comune;
    }

    public String getCodProv() {
        return codProv;
    }

    public void setCodProv(String codProv) {
        this.codProv = codProv;
    }

    public String getProvincia() {
        return provincia;
    }

    public void setProvincia(String provincia) {
        this.provincia = provincia;
    }

    public String getCodReg() {
        return codReg;
    }

    public void setCodReg(String codReg) {
        this.codReg = codReg;
    }

    public String getRegione() {
        return regione;
    }

    public void setRegione(String regione) {
        this.regione = regione;
    }

    public String getCodStat() {
        return codStat;
    }

    public void setCodStat(String codStat) {
        this.codStat = codStat;
    }

    public String getStato() {
        return stato;
    }

    public void setStato(String stato) {
        this.stato = stato;
    }

    public String getContinente() {
        return continente;
    }

    public void setContinente(String continente) {
        this.continente = continente;
    }

    public String getMondo() {
        return mondo;
    }

    public void setMondo(String mondo) {
        this.mondo = mondo;
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

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idComune != null ? idComune.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Comune)) {
            return false;
        }
        Comune other = (Comune) object;
        if ((this.idComune == null && other.idComune != null) || (this.idComune != null && !this.idComune.equals(other.idComune))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.Comune[ idComune=" + idComune + " ]";
    }
    
}
