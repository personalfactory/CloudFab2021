/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import it.divinotaras.jpa.entitysupport.DTEntityExtStatic;
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
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;

/**
 *
 * @author marilisa
 */
@Entity
@Table(name = "prodotto")
@XmlRootElement
@NamedQueries({
    //  @NamedQuery(name = "Prodotto.findAll", query = "SELECT p FROM Prodotto p"),
    //  @NamedQuery(name = "Prodotto.findByIdProdotto", query = "SELECT p FROM Prodotto p WHERE p.idProdotto = :idProdotto"),
    //  @NamedQuery(name = "Prodotto.findByCodProdotto", query = "SELECT p FROM Prodotto p WHERE p.codProdotto = :codProdotto"),
    //  @NamedQuery(name = "Prodotto.findByNomeProdotto", query = "SELECT p FROM Prodotto p WHERE p.nomeProdotto = :nomeProdotto"),
    //  @NamedQuery(name = "Prodotto.findByAbilitato", query = "SELECT p FROM Prodotto p WHERE p.abilitato = :abilitato"),
    //  @NamedQuery(name = "Prodotto.findByDtAbilitato", query = "SELECT p FROM Prodotto p WHERE p.dtAbilitato = :dtAbilitato"),
    @NamedQuery(name = "Prodotto.findDatiNuovi", query = "SELECT p FROM Prodotto p WHERE  p.dtAbilitato > :dtAbilitato")})
public class Prodotto implements Serializable {

    @Basic(optional = false)
    @NotNull
    @Column(name = "dt_abilitato")
    @Temporal(TemporalType.TIMESTAMP)
    private Date dtAbilitato;
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @NotNull
    @Column(name = "id_prodotto")
    private Integer idProdotto;
    @Size(max = 50)
    @Column(name = "cod_prodotto")
    private String codProdotto;
    @Size(max = 255)
    @Column(name = "nome_prodotto")
    private String nomeProdotto;
    @Column(name = "abilitato")
    private Boolean abilitato;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "idProdotto")
    private Collection<ComponenteProdotto> componenteProdottoCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "idProdotto")
    private Collection<AnagrafeProdotto> anagrafeProdottoCollection;

    @Size(max = 255)
    @Column(name = "tipo")
    private String tipo;
    @Size(max = 255)
    @Column(name = "serie_colore")
    private String serieColore;
    @Size(max = 255)
    @Column(name = "serie_additivo")
    private String serieAdditivo;
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

    public Prodotto() {
    }

    public Prodotto(Integer idProdotto) {
        this.idProdotto = idProdotto;
    }

    public Prodotto(Integer idProdotto, Date dtAbilitato) {
        this.idProdotto = idProdotto;
        this.dtAbilitato = dtAbilitato;
    }

    public Integer getIdProdotto() {
        return idProdotto;
    }

    public void setIdProdotto(Integer idProdotto) {
        this.idProdotto = idProdotto;
    }

    public String getCodProdotto() {
        return codProdotto;
    }

    public void setCodProdotto(String codProdotto) {
        this.codProdotto = codProdotto;
    }

    public String getNomeProdotto() {
        return nomeProdotto;
    }

    public void setNomeProdotto(String nomeProdotto) {
        this.nomeProdotto = nomeProdotto;
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

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public String getSerieColore() {
        return serieColore;
    }

    public void setSerieColore(String serieColore) {
        this.serieColore = serieColore;
    }

    public String getSerieAdditivo() {
        return serieAdditivo;
    }

    public void setSerieAdditivo(String serieAdditivo) {
        this.serieAdditivo = serieAdditivo;
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

    @XmlTransient
    public Collection<ComponenteProdotto> getComponenteProdottoCollection() {
        return componenteProdottoCollection;
    }

    public void setComponenteProdottoCollection(Collection<ComponenteProdotto> componenteProdottoCollection) {
        this.componenteProdottoCollection = componenteProdottoCollection;
    }

    @XmlTransient
    public Collection<AnagrafeProdotto> getAnagrafeProdottoCollection() {
        return anagrafeProdottoCollection;
    }

    public void setAnagrafeProdottoCollection(Collection<AnagrafeProdotto> anagrafeProdottoCollection) {
        this.anagrafeProdottoCollection = anagrafeProdottoCollection;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idProdotto != null ? idProdotto.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Prodotto)) {
            return false;
        }
        Prodotto other = (Prodotto) object;
        if ((this.idProdotto == null && other.idProdotto != null) || (this.idProdotto != null && !this.idProdotto.equals(other.idProdotto))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return DTEntityExtStatic.objToString(this);
    }

}
