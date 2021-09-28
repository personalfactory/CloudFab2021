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
@Table(name = "figura")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "Figura.findAll", query = "SELECT f FROM Figura f"),
    @NamedQuery(name = "Figura.findByIdFigura", query = "SELECT f FROM Figura f WHERE f.idFigura = :idFigura"),
    @NamedQuery(name = "Figura.findByNominativo", query = "SELECT f FROM Figura f WHERE f.nominativo = :nominativo"),
    @NamedQuery(name = "Figura.findByCodice", query = "SELECT f FROM Figura f WHERE f.codice = :codice"),
    @NamedQuery(name = "Figura.findByGeografico", query = "SELECT f FROM Figura f WHERE f.geografico = :geografico"),
    @NamedQuery(name = "Figura.findByTipoRiferimento", query = "SELECT f FROM Figura f WHERE f.tipoRiferimento = :tipoRiferimento"),
    @NamedQuery(name = "Figura.findByGruppo", query = "SELECT f FROM Figura f WHERE f.gruppo = :gruppo"),
    @NamedQuery(name = "Figura.findByLivelloGruppo", query = "SELECT f FROM Figura f WHERE f.livelloGruppo = :livelloGruppo"),
    @NamedQuery(name = "Figura.findByAbilitato", query = "SELECT f FROM Figura f WHERE f.abilitato = :abilitato"),
    @NamedQuery(name = "Figura.findByDtAbilitato", query = "SELECT f FROM Figura f WHERE f.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "Figura.findByIdUtente", query = "SELECT f FROM Figura f WHERE f.idUtente = :idUtente"),
    @NamedQuery(name = "Figura.findByIdAzienda", query = "SELECT f FROM Figura f WHERE f.idAzienda = :idAzienda")*/
@NamedQuery(name = "Figura.findDatiNuovi", query = "SELECT f FROM Figura f WHERE f.dtAbilitato > :dtAbilitato")})
public class Figura implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_figura")
    private Integer idFigura;
    @Size(max = 255)
    @Column(name = "nominativo")
    private String nominativo;
    @Size(max = 255)
    @Column(name = "codice")
    private String codice;
    @Size(max = 255)
    @Column(name = "geografico")
    private String geografico;
    @Size(max = 255)
    @Column(name = "tipo_riferimento")
    private String tipoRiferimento;
    @Size(max = 255)
    @Column(name = "gruppo")
    private String gruppo;
    @Size(max = 255)
    @Column(name = "livello_gruppo")
    private String livelloGruppo;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Column(name = "id_utente")
    private Integer idUtente;
    @Column(name = "id_azienda")
    private Integer idAzienda;
    @JoinColumn(name = "id_figura_tipo", referencedColumnName = "id_figura_tipo")
    @ManyToOne(optional = false)
    private FiguraTipo idFiguraTipo;

    public Figura() {
    }

   

    
    
    public Figura(Integer idFigura) {
        this.idFigura = idFigura;
    }

    public Integer getIdFigura() {
        return idFigura;
    }

    public void setIdFigura(Integer idFigura) {
        this.idFigura = idFigura;
    }

    public String getNominativo() {
        return nominativo;
    }

    public void setNominativo(String nominativo) {
        this.nominativo = nominativo;
    }

    public String getCodice() {
        return codice;
    }

    public void setCodice(String codice) {
        this.codice = codice;
    }

    public String getGeografico() {
        return geografico;
    }

    public void setGeografico(String geografico) {
        this.geografico = geografico;
    }

    public String getTipoRiferimento() {
        return tipoRiferimento;
    }

    public void setTipoRiferimento(String tipoRiferimento) {
        this.tipoRiferimento = tipoRiferimento;
    }

    public String getGruppo() {
        return gruppo;
    }

    public void setGruppo(String gruppo) {
        this.gruppo = gruppo;
    }

    public String getLivelloGruppo() {
        return livelloGruppo;
    }

    public void setLivelloGruppo(String livelloGruppo) {
        this.livelloGruppo = livelloGruppo;
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

    public FiguraTipo getIdFiguraTipo() {
        return idFiguraTipo;
    }

    public void setIdFiguraTipo(FiguraTipo idFiguraTipo) {
        this.idFiguraTipo = idFiguraTipo;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idFigura != null ? idFigura.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Figura)) {
            return false;
        }
        Figura other = (Figura) object;
        if ((this.idFigura == null && other.idFigura != null) || (this.idFigura != null && !this.idFigura.equals(other.idFigura))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.Figura[ idFigura=" + idFigura + " ]";
    }
    
}
