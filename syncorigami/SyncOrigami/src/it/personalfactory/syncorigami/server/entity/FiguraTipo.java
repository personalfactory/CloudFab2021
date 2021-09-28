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
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "figura_tipo")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "FiguraTipo.findAll", query = "SELECT f FROM FiguraTipo f"),
    @NamedQuery(name = "FiguraTipo.findByIdFiguraTipo", query = "SELECT f FROM FiguraTipo f WHERE f.idFiguraTipo = :idFiguraTipo"),
    @NamedQuery(name = "FiguraTipo.findByFigura", query = "SELECT f FROM FiguraTipo f WHERE f.figura = :figura"),
    @NamedQuery(name = "FiguraTipo.findByAbilitato", query = "SELECT f FROM FiguraTipo f WHERE f.abilitato = :abilitato"),
    @NamedQuery(name = "FiguraTipo.findByDtAbilitato", query = "SELECT f FROM FiguraTipo f WHERE f.dtAbilitato = :dtAbilitato"),*/
    @NamedQuery(name = "FiguraTipo.findDatiNuovi", query = "SELECT f FROM FiguraTipo f WHERE f.dtAbilitato > :dtAbilitato")})
public class FiguraTipo implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_figura_tipo")
    private Integer idFiguraTipo;
    @Size(max = 255)
    @Column(name = "figura")
    private String figura;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "idFiguraTipo")
    private Collection<Figura> figuraCollection;

    public FiguraTipo() {
    }

    public FiguraTipo(Integer idFiguraTipo) {
        this.idFiguraTipo = idFiguraTipo;
    }

    public Integer getIdFiguraTipo() {
        return idFiguraTipo;
    }

    public void setIdFiguraTipo(Integer idFiguraTipo) {
        this.idFiguraTipo = idFiguraTipo;
    }

    public String getFigura() {
        return figura;
    }

    public void setFigura(String figura) {
        this.figura = figura;
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
    public Collection<Figura> getFiguraCollection() {
        return figuraCollection;
    }

    public void setFiguraCollection(Collection<Figura> figuraCollection) {
        this.figuraCollection = figuraCollection;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idFiguraTipo != null ? idFiguraTipo.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof FiguraTipo)) {
            return false;
        }
        FiguraTipo other = (FiguraTipo) object;
        if ((this.idFiguraTipo == null && other.idFiguraTipo != null) || (this.idFiguraTipo != null && !this.idFiguraTipo.equals(other.idFiguraTipo))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.FiguraTipo[ idFiguraTipo=" + idFiguraTipo + " ]";
    }
    
}
