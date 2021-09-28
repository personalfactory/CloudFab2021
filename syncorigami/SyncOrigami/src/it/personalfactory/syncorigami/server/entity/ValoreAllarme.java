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
@Table(name = "valore_allarme")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "ValoreAllarme.findAll", query = "SELECT v FROM ValoreAllarme v"),
    @NamedQuery(name = "ValoreAllarme.findById", query = "SELECT v FROM ValoreAllarme v WHERE v.id = :id"),
    @NamedQuery(name = "ValoreAllarme.findByIdAllarme", query = "SELECT v FROM ValoreAllarme v WHERE v.idAllarme = :idAllarme"),
    @NamedQuery(name = "ValoreAllarme.findByValore", query = "SELECT v FROM ValoreAllarme v WHERE v.valore = :valore"),
    @NamedQuery(name = "ValoreAllarme.findByIdTabellaRif", query = "SELECT v FROM ValoreAllarme v WHERE v.idTabellaRif = :idTabellaRif"),
    @NamedQuery(name = "ValoreAllarme.findByAbilitato", query = "SELECT v FROM ValoreAllarme v WHERE v.abilitato = :abilitato"),
    @NamedQuery(name = "ValoreAllarme.findByDtAbilitato", query = "SELECT v FROM ValoreAllarme v WHERE v.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "ValoreAllarme.findByInfo1", query = "SELECT v FROM ValoreAllarme v WHERE v.info1 = :info1"),
    @NamedQuery(name = "ValoreAllarme.findByInfo2", query = "SELECT v FROM ValoreAllarme v WHERE v.info2 = :info2"),
    @NamedQuery(name = "ValoreAllarme.findByInfo3", query = "SELECT v FROM ValoreAllarme v WHERE v.info3 = :info3"),
    @NamedQuery(name = "ValoreAllarme.findByInfo4", query = "SELECT v FROM ValoreAllarme v WHERE v.info4 = :info4"),
    @NamedQuery(name = "ValoreAllarme.findByInfo5", query = "SELECT v FROM ValoreAllarme v WHERE v.info5 = :info5")*/})
public class ValoreAllarme implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @Basic(optional = false)
    @NotNull
    @Column(name = "id")
    private Integer id;
    @Size(max = 255)
    @Column(name = "valore")
    private String valore;
    @Column(name = "id_tabella_rif")
    private Integer idTabellaRif;
    @Column(name = "id_macchina")
    private Integer idMacchina;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Size(max = 255)
    @Column(name = "info1")
    private String info1;
    @Size(max = 255)
    @Column(name = "info2")
    private String info2;
    @Size(max = 255)
    @Column(name = "info3")
    private String info3;
    @Size(max = 255)
    @Column(name = "info4")
    private String info4;
    @Size(max = 255)
    @Column(name = "info5")
    private String info5;
    @JoinColumn(name = "id_allarme", referencedColumnName = "id_allarme")
    @ManyToOne
    private Allarme idAllarme;

    public ValoreAllarme() {
    }

    public ValoreAllarme(Integer id) {
        this.id = id;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Allarme getIdAllarme() {
        return idAllarme;
    }

    public void setIdAllarme(Allarme idAllarme) {
        this.idAllarme = idAllarme;
    }

    public Integer getIdMacchina() {
        return idMacchina;
    }

    public void setIdMacchina(Integer idMacchina) {
        this.idMacchina = idMacchina;
    }
    

    public String getValore() {
        return valore;
    }

    public void setValore(String valore) {
        this.valore = valore;
    }

    public Integer getIdTabellaRif() {
        return idTabellaRif;
    }

    public void setIdTabellaRif(Integer idTabellaRif) {
        this.idTabellaRif = idTabellaRif;
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

    public String getInfo1() {
        return info1;
    }

    public void setInfo1(String info1) {
        this.info1 = info1;
    }

    public String getInfo2() {
        return info2;
    }

    public void setInfo2(String info2) {
        this.info2 = info2;
    }

    public String getInfo3() {
        return info3;
    }

    public void setInfo3(String info3) {
        this.info3 = info3;
    }

    public String getInfo4() {
        return info4;
    }

    public void setInfo4(String info4) {
        this.info4 = info4;
    }

    public String getInfo5() {
        return info5;
    }

    public void setInfo5(String info5) {
        this.info5 = info5;
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
        if (!(object instanceof ValoreAllarme)) {
            return false;
        }
        ValoreAllarme other = (ValoreAllarme) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.ValoreAllarme[ id=" + id + " ]";
    }
    
}
