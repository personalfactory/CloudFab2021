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
import javax.persistence.Lob;
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
@Table(name = "movimento_sing_mac")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "MovimentoSingMac.findAll", query = "SELECT m FROM MovimentoSingMac m"),
    @NamedQuery(name = "MovimentoSingMac.findByIdMovInephos", query = "SELECT m FROM MovimentoSingMac m WHERE m.idMovInephos = :idMovInephos"),
    @NamedQuery(name = "MovimentoSingMac.findByIdMovOri", query = "SELECT m FROM MovimentoSingMac m WHERE m.idMovOri = :idMovOri"),
    @NamedQuery(name = "MovimentoSingMac.findByIdMateriale", query = "SELECT m FROM MovimentoSingMac m WHERE m.idMateriale = :idMateriale"),
    @NamedQuery(name = "MovimentoSingMac.findByTipoMateriale", query = "SELECT m FROM MovimentoSingMac m WHERE m.tipoMateriale = :tipoMateriale"),
    @NamedQuery(name = "MovimentoSingMac.findByQuantita", query = "SELECT m FROM MovimentoSingMac m WHERE m.quantita = :quantita"),
    @NamedQuery(name = "MovimentoSingMac.findByCodIngressoComp", query = "SELECT m FROM MovimentoSingMac m WHERE m.codIngressoComp = :codIngressoComp"),
    @NamedQuery(name = "MovimentoSingMac.findByCodOperatore", query = "SELECT m FROM MovimentoSingMac m WHERE m.codOperatore = :codOperatore"),
    @NamedQuery(name = "MovimentoSingMac.findByOperazione", query = "SELECT m FROM MovimentoSingMac m WHERE m.operazione = :operazione"),
    @NamedQuery(name = "MovimentoSingMac.findByProceduraAdottata", query = "SELECT m FROM MovimentoSingMac m WHERE m.proceduraAdottata = :proceduraAdottata"),
    @NamedQuery(name = "MovimentoSingMac.findByTipoMov", query = "SELECT m FROM MovimentoSingMac m WHERE m.tipoMov = :tipoMov"),
    @NamedQuery(name = "MovimentoSingMac.findByDescriMov", query = "SELECT m FROM MovimentoSingMac m WHERE m.descriMov = :descriMov"),
    @NamedQuery(name = "MovimentoSingMac.findByDtMov", query = "SELECT m FROM MovimentoSingMac m WHERE m.dtMov = :dtMov"),
    @NamedQuery(name = "MovimentoSingMac.findBySilo", query = "SELECT m FROM MovimentoSingMac m WHERE m.silo = :silo"),
    @NamedQuery(name = "MovimentoSingMac.findByTipoConfezione", query = "SELECT m FROM MovimentoSingMac m WHERE m.tipoConfezione = :tipoConfezione"),
    @NamedQuery(name = "MovimentoSingMac.findByPesoConfezione", query = "SELECT m FROM MovimentoSingMac m WHERE m.pesoConfezione = :pesoConfezione"),
    @NamedQuery(name = "MovimentoSingMac.findByNumeroConfezioni", query = "SELECT m FROM MovimentoSingMac m WHERE m.numeroConfezioni = :numeroConfezioni"),
    @NamedQuery(name = "MovimentoSingMac.findByResponsabileProduzione", query = "SELECT m FROM MovimentoSingMac m WHERE m.responsabileProduzione = :responsabileProduzione"),
    @NamedQuery(name = "MovimentoSingMac.findByResponsabileQualita", query = "SELECT m FROM MovimentoSingMac m WHERE m.responsabileQualita = :responsabileQualita"),
    @NamedQuery(name = "MovimentoSingMac.findByConsulenteTecnico", query = "SELECT m FROM MovimentoSingMac m WHERE m.consulenteTecnico = :consulenteTecnico"),
    @NamedQuery(name = "MovimentoSingMac.findByMerceConforme", query = "SELECT m FROM MovimentoSingMac m WHERE m.merceConforme = :merceConforme"),
    @NamedQuery(name = "MovimentoSingMac.findByStabilitaConforme", query = "SELECT m FROM MovimentoSingMac m WHERE m.stabilitaConforme = :stabilitaConforme"),
    @NamedQuery(name = "MovimentoSingMac.findByMarchioCeConforme", query = "SELECT m FROM MovimentoSingMac m WHERE m.marchioCeConforme = :marchioCeConforme"),
    @NamedQuery(name = "MovimentoSingMac.findByCodiceCe", query = "SELECT m FROM MovimentoSingMac m WHERE m.codiceCe = :codiceCe"),
    @NamedQuery(name = "MovimentoSingMac.findByFornitore", query = "SELECT m FROM MovimentoSingMac m WHERE m.fornitore = :fornitore"),
    @NamedQuery(name = "MovimentoSingMac.findByDtAbilitato", query = "SELECT m FROM MovimentoSingMac m WHERE m.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "MovimentoSingMac.findByIdMacchina", query = "SELECT m FROM MovimentoSingMac m WHERE m.idMacchina = :idMacchina"),
    @NamedQuery(name = "MovimentoSingMac.findByPesoTeorico", query = "SELECT m FROM MovimentoSingMac m WHERE m.pesoTeorico = :pesoTeorico"),
    @NamedQuery(name = "MovimentoSingMac.findByIdCiclo", query = "SELECT m FROM MovimentoSingMac m WHERE m.idCiclo = :idCiclo"),
    @NamedQuery(name = "MovimentoSingMac.findByDtInizioProcedura", query = "SELECT m FROM MovimentoSingMac m WHERE m.dtInizioProcedura = :dtInizioProcedura"),
    @NamedQuery(name = "MovimentoSingMac.findByDtFineProcedura", query = "SELECT m FROM MovimentoSingMac m WHERE m.dtFineProcedura = :dtFineProcedura"),
    @NamedQuery(name = "MovimentoSingMac.findByAbilitato", query = "SELECT m FROM MovimentoSingMac m WHERE m.abilitato = :abilitato"),
    @NamedQuery(name = "MovimentoSingMac.findByOrigineMov", query = "SELECT m FROM MovimentoSingMac m WHERE m.origineMov = :origineMov"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo1", query = "SELECT m FROM MovimentoSingMac m WHERE m.info1 = :info1"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo2", query = "SELECT m FROM MovimentoSingMac m WHERE m.info2 = :info2"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo3", query = "SELECT m FROM MovimentoSingMac m WHERE m.info3 = :info3"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo4", query = "SELECT m FROM MovimentoSingMac m WHERE m.info4 = :info4"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo5", query = "SELECT m FROM MovimentoSingMac m WHERE m.info5 = :info5"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo6", query = "SELECT m FROM MovimentoSingMac m WHERE m.info6 = :info6"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo7", query = "SELECT m FROM MovimentoSingMac m WHERE m.info7 = :info7"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo8", query = "SELECT m FROM MovimentoSingMac m WHERE m.info8 = :info8"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo9", query = "SELECT m FROM MovimentoSingMac m WHERE m.info9 = :info9"),
    @NamedQuery(name = "MovimentoSingMac.findByInfo10", query = "SELECT m FROM MovimentoSingMac m WHERE m.info10 = :info10"),
    @NamedQuery(name = "MovimentoSingMac.findByNumDoc", query = "SELECT m FROM MovimentoSingMac m WHERE m.numDoc = :numDoc"),
    @NamedQuery(name = "MovimentoSingMac.findByDtDoc", query = "SELECT m FROM MovimentoSingMac m WHERE m.dtDoc = :dtDoc")*/
@NamedQuery(name = "MovimentoSingMac.findDatiNuovi", query = "SELECT m FROM MovimentoSingMac m WHERE  "
        + " m.idMacchina = :idMacchina AND m.dtAbilitato > :dtAbilitato AND origineMov=:origineMov")
    /**@NamedQuery(name = "MovimentoSingMac.findMovimentoByIdAndMac", query = "SELECT m FROM MovimentoSingMac m a WHERE  "
        + "AND m.idMacchina = :idMacchina AND  idMovOri=:idMovOri"),*/

    })
public class MovimentoSingMac implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_mov_inephos")
    private Integer idMovInephos;
    @Column(name = "id_mov_ori")
    private Integer idMovOri;
    @Column(name = "id_materiale")
    private Integer idMateriale;
    @Size(max = 45)
    @Column(name = "tipo_materiale")
    private String tipoMateriale;
    @Column(name = "quantita")
    private Integer quantita;
    @Size(max = 255)
    @Column(name = "cod_ingresso_comp")
    private String codIngressoComp;
    @Size(max = 255)
    @Column(name = "cod_operatore")
    private String codOperatore;
    @Size(max = 45)
    @Column(name = "operazione")
    private String operazione;
    @Size(max = 255)
    @Column(name = "procedura_adottata")
    private String proceduraAdottata;
    @Size(max = 45)
    @Column(name = "tipo_mov")
    private String tipoMov;
    @Size(max = 255)
    @Column(name = "descri_mov")
    private String descriMov;
    @Column(name = "dt_mov")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtMov;
    @Size(max = 45)
    @Column(name = "silo")
    private String silo;
    @Size(max = 255)
    @Column(name = "tipo_confezione")
    private String tipoConfezione;
    // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
    @Column(name = "peso_confezione")
    private Double pesoConfezione;
    @Column(name = "numero_confezioni")
    private Integer numeroConfezioni;
    @Size(max = 255)
    @Column(name = "responsabile_produzione")
    private String responsabileProduzione;
    @Size(max = 255)
    @Column(name = "responsabile_qualita")
    private String responsabileQualita;
    @Size(max = 255)
    @Column(name = "consulente_tecnico")
    private String consulenteTecnico;
    @Lob
    @Size(max = 65535)
    @Column(name = "note")
    private String note;
    @Size(max = 45)
    @Column(name = "merce_conforme")
    private String merceConforme;
    @Size(max = 45)
    @Column(name = "stabilita_conforme")
    private String stabilitaConforme;
    @Size(max = 45)
    @Column(name = "marchio_ce_conforme")
    private String marchioCeConforme;
    @Size(max = 45)
    @Column(name = "codice_ce")
    private String codiceCe;
    @Size(max = 255)
    @Column(name = "fornitore")
    private String fornitore;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Column(name = "id_macchina")
    private Integer idMacchina;
    @Column(name = "peso_teorico")
    private Integer pesoTeorico;
    @Column(name = "id_ciclo")
    private Integer idCiclo;
    @Column(name = "dt_inizio_procedura")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtInizioProcedura;
    @Column(name = "dt_fine_procedura")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtFineProcedura;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Size(max = 45)
    @Column(name = "origine_mov")
    private String origineMov;
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
    @Size(max = 255)
    @Column(name = "info6")
    private String info6;
    @Size(max = 255)
    @Column(name = "info7")
    private String info7;
    @Size(max = 255)
    @Column(name = "info8")
    private String info8;
    @Size(max = 255)
    @Column(name = "info9")
    private String info9;
    @Size(max = 255)
    @Column(name = "info10")
    private String info10;
    @Size(max = 255)
    @Column(name = "num_doc")
    private String numDoc;
    @Column(name = "dt_doc")
    @Temporal(TemporalType.DATE)
    private Date dtDoc;

    public MovimentoSingMac() {
    }

    public MovimentoSingMac(Integer idMovInephos) {
        this.idMovInephos = idMovInephos;
    }

    public Integer getIdMovInephos() {
        return idMovInephos;
    }

    public void setIdMovInephos(Integer idMovInephos) {
        this.idMovInephos = idMovInephos;
    }

    public Integer getIdMovOri() {
        return idMovOri;
    }

    public void setIdMovOri(Integer idMovOri) {
        this.idMovOri = idMovOri;
    }

    public Integer getIdMateriale() {
        return idMateriale;
    }

    public void setIdMateriale(Integer idMateriale) {
        this.idMateriale = idMateriale;
    }

    public String getTipoMateriale() {
        return tipoMateriale;
    }

    public void setTipoMateriale(String tipoMateriale) {
        this.tipoMateriale = tipoMateriale;
    }

    public Integer getQuantita() {
        return quantita;
    }

    public void setQuantita(Integer quantita) {
        this.quantita = quantita;
    }

    public String getCodIngressoComp() {
        return codIngressoComp;
    }

    public void setCodIngressoComp(String codIngressoComp) {
        this.codIngressoComp = codIngressoComp;
    }

    public String getCodOperatore() {
        return codOperatore;
    }

    public void setCodOperatore(String codOperatore) {
        this.codOperatore = codOperatore;
    }

    public String getOperazione() {
        return operazione;
    }

    public void setOperazione(String operazione) {
        this.operazione = operazione;
    }

    public String getProceduraAdottata() {
        return proceduraAdottata;
    }

    public void setProceduraAdottata(String proceduraAdottata) {
        this.proceduraAdottata = proceduraAdottata;
    }

    public String getTipoMov() {
        return tipoMov;
    }

    public void setTipoMov(String tipoMov) {
        this.tipoMov = tipoMov;
    }

    public String getDescriMov() {
        return descriMov;
    }

    public void setDescriMov(String descriMov) {
        this.descriMov = descriMov;
    }

    public Date getDtMov() {
        return dtMov;
    }

    public void setDtMov(Date dtMov) {
        this.dtMov = dtMov;
    }

    public String getSilo() {
        return silo;
    }

    public void setSilo(String silo) {
        this.silo = silo;
    }

    public String getTipoConfezione() {
        return tipoConfezione;
    }

    public void setTipoConfezione(String tipoConfezione) {
        this.tipoConfezione = tipoConfezione;
    }

    public Double getPesoConfezione() {
        return pesoConfezione;
    }

    public void setPesoConfezione(Double pesoConfezione) {
        this.pesoConfezione = pesoConfezione;
    }

    public Integer getNumeroConfezioni() {
        return numeroConfezioni;
    }

    public void setNumeroConfezioni(Integer numeroConfezioni) {
        this.numeroConfezioni = numeroConfezioni;
    }

    public String getResponsabileProduzione() {
        return responsabileProduzione;
    }

    public void setResponsabileProduzione(String responsabileProduzione) {
        this.responsabileProduzione = responsabileProduzione;
    }

    public String getResponsabileQualita() {
        return responsabileQualita;
    }

    public void setResponsabileQualita(String responsabileQualita) {
        this.responsabileQualita = responsabileQualita;
    }

    public String getConsulenteTecnico() {
        return consulenteTecnico;
    }

    public void setConsulenteTecnico(String consulenteTecnico) {
        this.consulenteTecnico = consulenteTecnico;
    }

    public String getNote() {
        return note;
    }

    public void setNote(String note) {
        this.note = note;
    }

    public String getMerceConforme() {
        return merceConforme;
    }

    public void setMerceConforme(String merceConforme) {
        this.merceConforme = merceConforme;
    }

    public String getStabilitaConforme() {
        return stabilitaConforme;
    }

    public void setStabilitaConforme(String stabilitaConforme) {
        this.stabilitaConforme = stabilitaConforme;
    }

    public String getMarchioCeConforme() {
        return marchioCeConforme;
    }

    public void setMarchioCeConforme(String marchioCeConforme) {
        this.marchioCeConforme = marchioCeConforme;
    }

    public String getCodiceCe() {
        return codiceCe;
    }

    public void setCodiceCe(String codiceCe) {
        this.codiceCe = codiceCe;
    }

    public String getFornitore() {
        return fornitore;
    }

    public void setFornitore(String fornitore) {
        this.fornitore = fornitore;
    }

    public Date getDtAbilitato() {
        return dtAbilitato;
    }

    public void setDtAbilitato(Date dtAbilitato) {
        this.dtAbilitato = dtAbilitato;
    }

    public Integer getIdMacchina() {
        return idMacchina;
    }

    public void setIdMacchina(Integer idMacchina) {
        this.idMacchina = idMacchina;
    }

    public Integer getPesoTeorico() {
        return pesoTeorico;
    }

    public void setPesoTeorico(Integer pesoTeorico) {
        this.pesoTeorico = pesoTeorico;
    }

    public Integer getIdCiclo() {
        return idCiclo;
    }

    public void setIdCiclo(Integer idCiclo) {
        this.idCiclo = idCiclo;
    }

    public Date getDtInizioProcedura() {
        return dtInizioProcedura;
    }

    public void setDtInizioProcedura(Date dtInizioProcedura) {
        this.dtInizioProcedura = dtInizioProcedura;
    }

    public Date getDtFineProcedura() {
        return dtFineProcedura;
    }

    public void setDtFineProcedura(Date dtFineProcedura) {
        this.dtFineProcedura = dtFineProcedura;
    }

    public Boolean getAbilitato() {
        return abilitato;
    }

    public void setAbilitato(Boolean abilitato) {
        this.abilitato = abilitato;
    }

    public String getOrigineMov() {
        return origineMov;
    }

    public void setOrigineMov(String origineMov) {
        this.origineMov = origineMov;
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

    public String getInfo6() {
        return info6;
    }

    public void setInfo6(String info6) {
        this.info6 = info6;
    }

    public String getInfo7() {
        return info7;
    }

    public void setInfo7(String info7) {
        this.info7 = info7;
    }

    public String getInfo8() {
        return info8;
    }

    public void setInfo8(String info8) {
        this.info8 = info8;
    }

    public String getInfo9() {
        return info9;
    }

    public void setInfo9(String info9) {
        this.info9 = info9;
    }

    public String getInfo10() {
        return info10;
    }

    public void setInfo10(String info10) {
        this.info10 = info10;
    }

    public String getNumDoc() {
        return numDoc;
    }

    public void setNumDoc(String numDoc) {
        this.numDoc = numDoc;
    }

    public Date getDtDoc() {
        return dtDoc;
    }

    public void setDtDoc(Date dtDoc) {
        this.dtDoc = dtDoc;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idMovInephos != null ? idMovInephos.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof MovimentoSingMac)) {
            return false;
        }
        MovimentoSingMac other = (MovimentoSingMac) object;
        if ((this.idMovInephos == null && other.idMovInephos != null) || (this.idMovInephos != null && !this.idMovInephos.equals(other.idMovInephos))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.MovimentoSingMac[ idMovInephos=" + idMovInephos + " ]";
    }
    
}
