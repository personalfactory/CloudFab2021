/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import java.io.Serializable;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Embeddable;
import javax.validation.constraints.NotNull;

/**
 *
 * @author marilisa
 */
@Embeddable
public class MazzettaColSingMacPK implements Serializable {
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_maz_sing_mac")
  private int idMazSingMac;
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_macchina")
  private int idMacchina;

  public MazzettaColSingMacPK() {
  }

  public MazzettaColSingMacPK(int idMazSingMac, int idMacchina) {
    this.idMazSingMac = idMazSingMac;
    this.idMacchina = idMacchina;
  }

  public int getIdMazSingMac() {
    return idMazSingMac;
  }

  public void setIdMazSingMac(int idMazSingMac) {
    this.idMazSingMac = idMazSingMac;
  }

  public int getIdMacchina() {
    return idMacchina;
  }

  public void setIdMacchina(int idMacchina) {
    this.idMacchina = idMacchina;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (int) idMazSingMac;
    hash += (int) idMacchina;
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof MazzettaColSingMacPK)) {
      return false;
    }
    MazzettaColSingMacPK other = (MazzettaColSingMacPK) object;
    if (this.idMazSingMac != other.idMazSingMac) {
      return false;
    }
    if (this.idMacchina != other.idMacchina) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return "it.personalfactory.syncorigami.server.entity.MazzettaColSingMacPK[ idMazSingMac=" + idMazSingMac + ", idMacchina=" + idMacchina + " ]";
  }
  
}
