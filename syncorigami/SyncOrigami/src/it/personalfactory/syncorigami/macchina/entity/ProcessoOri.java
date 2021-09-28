/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.macchina.entity;

import it.divinotaras.jpa.entitysupport.DTEntityExtStatic;
import java.io.Serializable;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
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
@Table(name = "processo_ori")
@XmlRootElement
public class ProcessoOri implements Serializable {

    private static final long serialVersionUID = 1L;
    @Id
    @Basic(optional = false)
    @NotNull
    @Column(name = "id_processo")
    private Integer idProcesso;
    @Size(max = 255)
    @Column(name = "cod_prodotto")
    private String codProdotto;
    @Size(max = 255)
    @Column(name = "cod_chimica")
    private String codChimica;
    @Size(max = 255)
    @Column(name = "cod_sacco")
    private String codSacco;
    @Column(name = "peso_reale_sacco")
    private Integer pesoRealeSacco;
    @Size(max = 255)
    @Column(name = "cod_comp_peso")
    private String codCompPeso;
    @Size(max = 255)
    @Column(name = "cod_colore")
    private String codColore;
    @Size(max = 255)
    @Column(name = "cliente")
    private String cliente;
    @Basic(optional = false)
    @NotNull
    @Column(name = "dt_produzione")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtProduzione;
    //##### NUOVI CAMPI MODIFICA 13-10-2014
    @Size(max = 255)
    @Column(name = "cod_operatore")
    private String codOperatore;
    @Size(max = 255)
    @Column(name = "cod_comp_in")
    private String codCompIn;
    @Column(name = "tipo_processo")
    private Integer tipoProcesso;
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
//##### FINE NUOVI CAMPI

    public ProcessoOri() {
    }

    public ProcessoOri(Integer idProcesso) {
        this.idProcesso = idProcesso;
    }

    public ProcessoOri(Integer idProcesso, Date dtProduzione) {
        this.idProcesso = idProcesso;
        this.dtProduzione = dtProduzione;
    }

    public Integer getIdProcesso() {
        return idProcesso;
    }

    public void setIdProcesso(Integer idProcesso) {
        this.idProcesso = idProcesso;
    }

    public String getCodProdotto() {
        return codProdotto;
    }

    public void setCodProdotto(String codProdotto) {
        this.codProdotto = codProdotto;
    }

    public String getCodChimica() {
        return codChimica;
    }

    public void setCodChimica(String codChimica) {
        this.codChimica = codChimica;
    }

    public String getCodSacco() {
        return codSacco;
    }

    public void setCodSacco(String codSacco) {
        this.codSacco = codSacco;
    }

    public Integer getPesoRealeSacco() {
        return pesoRealeSacco;
    }

    public void setPesoRealeSacco(Integer pesoRealeSacco) {
        this.pesoRealeSacco = pesoRealeSacco;
    }

    public String getCodCompPeso() {
        return codCompPeso;
    }

    public void setCodCompPeso(String codCompPeso) {
        this.codCompPeso = codCompPeso;
    }

    public String getCodColore() {
        return codColore;
    }

    public void setCodColore(String codColore) {
        this.codColore = codColore;
    }

    public String getCliente() {
        return cliente;
    }

    public void setCliente(String cliente) {
        this.cliente = cliente;
    }

    public Date getDtProduzione() {
        return dtProduzione;
    }

    public void setDtProduzione(Date dtProduzione) {
        this.dtProduzione = dtProduzione;
    }
    
    //NUOVI METODI PER NUOVI CAMPI 13-10-2014
    public String getCodOperatore() {
        return codOperatore;
    }

    public void setCodOperatore(String codOperatore) {
        this.codOperatore = codOperatore;
    }

    public String getCodCompIn() {
        return codCompIn;
    }

    public void setCodCompIn(String codCompIn) {
        this.codCompIn = codCompIn;
    }

    public Integer getTipoProcesso() {
        return tipoProcesso;
    }

    public void setTipoProcesso(Integer tipoProcesso) {
        this.tipoProcesso = tipoProcesso;
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
    

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idProcesso != null ? idProcesso.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof ProcessoOri)) {
            return false;
        }
        ProcessoOri other = (ProcessoOri) object;
        if ((this.idProcesso == null && other.idProcesso != null) || (this.idProcesso != null && !this.idProcesso.equals(other.idProcesso))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return DTEntityExtStatic.objToString(this);
    }
}
