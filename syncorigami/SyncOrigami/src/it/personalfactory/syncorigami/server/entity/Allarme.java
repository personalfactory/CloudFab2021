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
@Table(name = "allarme")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "Allarme.findAll", query = "SELECT a FROM Allarme a"),
    @NamedQuery(name = "Allarme.findByIdAllarme", query = "SELECT a FROM Allarme a WHERE a.idAllarme = :idAllarme"),
    @NamedQuery(name = "Allarme.findByNome", query = "SELECT a FROM Allarme a WHERE a.nome = :nome"),
    @NamedQuery(name = "Allarme.findByDescrizione", query = "SELECT a FROM Allarme a WHERE a.descrizione = :descrizione"),
    @NamedQuery(name = "Allarme.findByTabellaRiferimento", query = "SELECT a FROM Allarme a WHERE a.tabellaRiferimento = :tabellaRiferimento"),
    @NamedQuery(name = "Allarme.findByAbilitato", query = "SELECT a FROM Allarme a WHERE a.abilitato = :abilitato"),
    @NamedQuery(name = "Allarme.findByDtAbilitato", query = "SELECT a FROM Allarme a WHERE a.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "Allarme.findByInfo1", query = "SELECT a FROM Allarme a WHERE a.info1 = :info1"),
    @NamedQuery(name = "Allarme.findByInfo2", query = "SELECT a FROM Allarme a WHERE a.info2 = :info2"),
    @NamedQuery(name = "Allarme.findByInfo3", query = "SELECT a FROM Allarme a WHERE a.info3 = :info3"),
    @NamedQuery(name = "Allarme.findByInfo4", query = "SELECT a FROM Allarme a WHERE a.info4 = :info4"),
    @NamedQuery(name = "Allarme.findByInfo5", query = "SELECT a FROM Allarme a WHERE a.info5 = :info5"),*/
    @NamedQuery(name = "Allarme.findDatiNuovi", query = "SELECT a FROM Allarme a WHERE a.dtAbilitato > :dtAbilitato")
})

public class Allarme implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_allarme")
    private Integer idAllarme;
    @Size(max = 255)
    @Column(name = "nome")
    private String nome;
    @Size(max = 255)
    @Column(name = "descrizione")
    private String descrizione;
    @Size(max = 255)
    @Column(name = "tabella_riferimento")
    private String tabellaRiferimento;
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

    public Allarme() {
    }

    public Allarme(Integer idAllarme) {
        this.idAllarme = idAllarme;
    }

    public Integer getIdAllarme() {
        return idAllarme;
    }

    public void setIdAllarme(Integer idAllarme) {
        this.idAllarme = idAllarme;
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

    public String getTabellaRiferimento() {
        return tabellaRiferimento;
    }

    public void setTabellaRiferimento(String tabellaRiferimento) {
        this.tabellaRiferimento = tabellaRiferimento;
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
        hash += (idAllarme != null ? idAllarme.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Allarme)) {
            return false;
        }
        Allarme other = (Allarme) object;
        if ((this.idAllarme == null && other.idAllarme != null) || (this.idAllarme != null && !this.idAllarme.equals(other.idAllarme))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.Allarme[ idAllarme=" + idAllarme + " ]";
    }
    
}
