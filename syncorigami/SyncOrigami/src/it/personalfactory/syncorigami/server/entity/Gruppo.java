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
@Table(name = "gruppo")
@XmlRootElement
public class Gruppo implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @NotNull
    @Column(name = "id_gruppo")
    private Integer idGruppo;
    @Size(max = 50)
    @Column(name = "livello_1")
    private String livello1;
    @Size(max = 50)
    @Column(name = "livello_2")
    private String livello2;
    @Size(max = 50)
    @Column(name = "livello_3")
    private String livello3;
    @Size(max = 50)
    @Column(name = "livello_4")
    private String livello4;
    @Size(max = 50)
    @Column(name = "livello_5")
    private String livello5;
    @Size(max = 50)
    @Column(name = "livello_6")
    private String livello6;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.DATE)
    private Date dtAbilitato;

    public Gruppo() {
    }

    public Gruppo(Integer idGruppo) {
        this.idGruppo = idGruppo;
    }

    public Integer getIdGruppo() {
        return idGruppo;
    }

    public void setIdGruppo(Integer idGruppo) {
        this.idGruppo = idGruppo;
    }

    public String getLivello1() {
        return livello1;
    }

    public void setLivello1(String livello1) {
        this.livello1 = livello1;
    }

    public String getLivello2() {
        return livello2;
    }

    public void setLivello2(String livello2) {
        this.livello2 = livello2;
    }

    public String getLivello3() {
        return livello3;
    }

    public void setLivello3(String livello3) {
        this.livello3 = livello3;
    }

    public String getLivello4() {
        return livello4;
    }

    public void setLivello4(String livello4) {
        this.livello4 = livello4;
    }

    public String getLivello5() {
        return livello5;
    }

    public void setLivello5(String livello5) {
        this.livello5 = livello5;
    }

    public String getLivello6() {
        return livello6;
    }

    public void setLivello6(String livello6) {
        this.livello6 = livello6;
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
        hash += (idGruppo != null ? idGruppo.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Gruppo)) {
            return false;
        }
        Gruppo other = (Gruppo) object;
        if ((this.idGruppo == null && other.idGruppo != null) || (this.idGruppo != null && !this.idGruppo.equals(other.idGruppo))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.Gruppo[ idGruppo=" + idGruppo + " ]";
    }
    
}
