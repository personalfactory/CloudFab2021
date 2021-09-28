/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ValoreParProdMac;
import java.io.Serializable;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ValoreParProdMacJpaController implements Serializable {

  public ValoreParProdMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  
  

  public ValoreParProdMac findValoreParProdMac(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreParProdMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreParProdMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreParProdMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<ValoreParProdMac> findValoreParProdMacNew(Date dtUltAgg, Integer idMacchina){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParProdMac.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       q.setParameter("idMacchina",idMacchina);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
  
  /**
   * Scrivere Metodi per selezionare i valori dei parametri da inviare
   */
  
  
  
}
