/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.entity;

import it.divinotaras.jpa.entitysupport.DTEntityExtStatic;
import java.io.Serializable;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Embeddable;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

/**
 *
 * @author marilisa
 */
@Embeddable
public class ProcessoPK implements Serializable {
  @Basic(optional = false)
  @NotNull
  @Column(name = "id_processo")
  private int idProcesso;
  @Basic(optional = false)
  @NotNull
  @Size(min = 1, max = 255)
  @Column(name = "cod_stab")
  private String codStab;

  public ProcessoPK() {
  }

  public ProcessoPK(int idProcesso, String codStab) {
    this.idProcesso = idProcesso;
    this.codStab = codStab;
  }

  public int getIdProcesso() {
    return idProcesso;
  }

  public void setIdProcesso(int idProcesso) {
    this.idProcesso = idProcesso;
  }

  public String getCodStab() {
    return codStab;
  }

  public void setCodStab(String codStab) {
    this.codStab = codStab;
  }

  @Override
  public int hashCode() {
    int hash = 0;
    hash += (int) idProcesso;
    hash += (codStab != null ? codStab.hashCode() : 0);
    return hash;
  }

  @Override
  public boolean equals(Object object) {
    // TODO: Warning - this method won't work in the case the id fields are not set
    if (!(object instanceof ProcessoPK)) {
      return false;
    }
    ProcessoPK other = (ProcessoPK) object;
    if (this.idProcesso != other.idProcesso) {
      return false;
    }
    if ((this.codStab == null && other.codStab != null) || (this.codStab != null && !this.codStab.equals(other.codStab))) {
      return false;
    }
    return true;
  }

  @Override
  public String toString() {
    return DTEntityExtStatic.objToString(this);
  }
  
}
