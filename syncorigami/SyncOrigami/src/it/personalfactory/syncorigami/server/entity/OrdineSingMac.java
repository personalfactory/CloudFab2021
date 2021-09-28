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
@Table(name = "ordine_sing_mac")
@XmlRootElement
@NamedQueries({
    /**@NamedQuery(name = "OrdineSingMac.findAll", query = "SELECT o FROM OrdineSingMac o"),
    @NamedQuery(name = "OrdineSingMac.findByIdOrdineSm", query = "SELECT o FROM OrdineSingMac o WHERE o.idOrdineSm = :idOrdineSm"),
    @NamedQuery(name = "OrdineSingMac.findByIdProdotto", query = "SELECT o FROM OrdineSingMac o WHERE o.idProdotto = :idProdotto"),
    @NamedQuery(name = "OrdineSingMac.findByOrdineProduzione", query = "SELECT o FROM OrdineSingMac o WHERE o.ordineProduzione = :ordineProduzione"),
    @NamedQuery(name = "OrdineSingMac.findByNumPezzi", query = "SELECT o FROM OrdineSingMac o WHERE o.numPezzi = :numPezzi"),
    @NamedQuery(name = "OrdineSingMac.findByKgPezzo", query = "SELECT o FROM OrdineSingMac o WHERE o.kgPezzo = :kgPezzo"),
    @NamedQuery(name = "OrdineSingMac.findByContatore", query = "SELECT o FROM OrdineSingMac o WHERE o.contatore = :contatore"),
    @NamedQuery(name = "OrdineSingMac.findByStato", query = "SELECT o FROM OrdineSingMac o WHERE o.stato = :stato"),
    @NamedQuery(name = "OrdineSingMac.findByDescriStato", query = "SELECT o FROM OrdineSingMac o WHERE o.descriStato = :descriStato"),
    @NamedQuery(name = "OrdineSingMac.findByAbilitato", query = "SELECT o FROM OrdineSingMac o WHERE o.abilitato = :abilitato"),
    @NamedQuery(name = "OrdineSingMac.findByDtProgrammata", query = "SELECT o FROM OrdineSingMac o WHERE o.dtProgrammata = :dtProgrammata"),
    @NamedQuery(name = "OrdineSingMac.findByDtAbilitato", query = "SELECT o FROM OrdineSingMac o WHERE o.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "OrdineSingMac.findByDtProduzione", query = "SELECT o FROM OrdineSingMac o WHERE o.dtProduzione = :dtProduzione"),
    @NamedQuery(name = "OrdineSingMac.findByInfo1", query = "SELECT o FROM OrdineSingMac o WHERE o.info1 = :info1"),
    @NamedQuery(name = "OrdineSingMac.findByInfo2", query = "SELECT o FROM OrdineSingMac o WHERE o.info2 = :info2"),
    @NamedQuery(name = "OrdineSingMac.findByInfo3", query = "SELECT o FROM OrdineSingMac o WHERE o.info3 = :info3"),
    @NamedQuery(name = "OrdineSingMac.findByInfo4", query = "SELECT o FROM OrdineSingMac o WHERE o.info4 = :info4"),
    @NamedQuery(name = "OrdineSingMac.findByInfo5", query = "SELECT o FROM OrdineSingMac o WHERE o.info5 = :info5"),
    @NamedQuery(name = "OrdineSingMac.findByInfo6", query = "SELECT o FROM OrdineSingMac o WHERE o.info6 = :info6"),
    @NamedQuery(name = "OrdineSingMac.findByInfo7", query = "SELECT o FROM OrdineSingMac o WHERE o.info7 = :info7"),
    @NamedQuery(name = "OrdineSingMac.findByInfo8", query = "SELECT o FROM OrdineSingMac o WHERE o.info8 = :info8"),
    @NamedQuery(name = "OrdineSingMac.findByInfo9", query = "SELECT o FROM OrdineSingMac o WHERE o.info9 = :info9"),
    @NamedQuery(name = "OrdineSingMac.findByInfo10", query = "SELECT o FROM OrdineSingMac o WHERE o.info10 = :info10")*/
    @NamedQuery(name = "OrdineSingMac.findDatiNuovi", query = "SELECT o FROM OrdineSingMac o, OrdineElenco e WHERE o.idOrdine=e.idOrdine AND e.idMacchina=:idMacchina AND o.dtAbilitato>:dtAbilitato")})
public class OrdineSingMac implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_ordine_sm")
    private Integer idOrdineSm;
    @Column(name = "id_prodotto")
    private Integer idProdotto;
    @Column(name = "ordine_produzione")
    private Integer ordineProduzione;
    @Column(name = "num_pezzi")
    private Integer numPezzi;
    // @Max(value=?)  @Min(value=?)//if you know range of your decimal fields consider using these annotations to enforce field validation
    @Column(name = "kg_pezzo")
    private Double kgPezzo;
    @Column(name = "contatore")
    private Integer contatore;
    @Size(max = 45)
    @Column(name = "stato")
    private String stato;
    @Size(max = 255)
    @Column(name = "descri_stato")
    private String descriStato;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @Column(name = "dt_programmata")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtProgrammata;
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    @Column(name = "dt_produzione")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtProduzione;
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
    @JoinColumn(name = "id_ordine", referencedColumnName = "id_ordine")
    @ManyToOne
    private OrdineElenco idOrdine;

    public OrdineSingMac() {
    }

    public OrdineSingMac(Integer idOrdineSm) {
        this.idOrdineSm = idOrdineSm;
    }

    public Integer getIdOrdineSm() {
        return idOrdineSm;
    }

    public void setIdOrdineSm(Integer idOrdineSm) {
        this.idOrdineSm = idOrdineSm;
    }

    public Integer getIdProdotto() {
        return idProdotto;
    }

    public void setIdProdotto(Integer idProdotto) {
        this.idProdotto = idProdotto;
    }

    public Integer getOrdineProduzione() {
        return ordineProduzione;
    }

    public void setOrdineProduzione(Integer ordineProduzione) {
        this.ordineProduzione = ordineProduzione;
    }

    public Integer getNumPezzi() {
        return numPezzi;
    }

    public void setNumPezzi(Integer numPezzi) {
        this.numPezzi = numPezzi;
    }

    public Double getKgPezzo() {
        return kgPezzo;
    }

    public void setKgPezzo(Double kgPezzo) {
        this.kgPezzo = kgPezzo;
    }

    public Integer getContatore() {
        return contatore;
    }

    public void setContatore(Integer contatore) {
        this.contatore = contatore;
    }

    public String getStato() {
        return stato;
    }

    public void setStato(String stato) {
        this.stato = stato;
    }

    public String getDescriStato() {
        return descriStato;
    }

    public void setDescriStato(String descriStato) {
        this.descriStato = descriStato;
    }

    public Boolean getAbilitato() {
        return abilitato;
    }

    public void setAbilitato(Boolean abilitato) {
        this.abilitato = abilitato;
    }

    public Date getDtProgrammata() {
        return dtProgrammata;
    }

    public void setDtProgrammata(Date dtProgrammata) {
        this.dtProgrammata = dtProgrammata;
    }

    public Date getDtAbilitato() {
        return dtAbilitato;
    }

    public void setDtAbilitato(Date dtAbilitato) {
        this.dtAbilitato = dtAbilitato;
    }

    public Date getDtProduzione() {
        return dtProduzione;
    }

    public void setDtProduzione(Date dtProduzione) {
        this.dtProduzione = dtProduzione;
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

    public OrdineElenco getIdOrdine() {
        return idOrdine;
    }

    public void setIdOrdine(OrdineElenco idOrdine) {
        this.idOrdine = idOrdine;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idOrdineSm != null ? idOrdineSm.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof OrdineSingMac)) {
            return false;
        }
        OrdineSingMac other = (OrdineSingMac) object;
        if ((this.idOrdineSm == null && other.idOrdineSm != null) || (this.idOrdineSm != null && !this.idOrdineSm.equals(other.idOrdineSm))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "it.personalfactory.syncorigami.server.entity.OrdineSingMac[ idOrdineSm=" + idOrdineSm + " ]";
    }
    
}
