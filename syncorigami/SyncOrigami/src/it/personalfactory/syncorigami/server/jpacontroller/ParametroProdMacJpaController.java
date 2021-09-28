/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroProdMac;
import it.personalfactory.syncorigami.server.entity.ValoreParProd;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.transaction.UserTransaction;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;

/**
 *
 * @author marilisa
 */
public class ParametroProdMacJpaController implements Serializable {

  public ParametroProdMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public List<ParametroProdMac> findParametroProdMacEntities() {
    return findParametroProdMacEntities(true, -1, -1);
  }

  public List<ParametroProdMac> findParametroProdMacEntities(int maxResults, int firstResult) {
    return findParametroProdMacEntities(false, maxResults, firstResult);
  }

  private List<ParametroProdMac> findParametroProdMacEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroProdMac as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroProdMac findParametroProdMac(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroProdMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroProdMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroProdMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ParametroProdMac> findParametroProdMacNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroProdMac.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
  }    
}
