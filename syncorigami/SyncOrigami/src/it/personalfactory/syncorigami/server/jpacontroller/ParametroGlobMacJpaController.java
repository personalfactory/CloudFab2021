/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroGlobMac;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ParametroGlobMacJpaController implements Serializable {

  public ParametroGlobMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ParametroGlobMac parametroGlobMac) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      em.persist(parametroGlobMac);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ParametroGlobMac parametroGlobMac) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      parametroGlobMac = em.merge(parametroGlobMac);
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = parametroGlobMac.getIdParGm();
        if (findParametroGlobMac(id) == null) {
          throw new NonexistentEntityException("The parametroGlobMac with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(Integer id) throws NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroGlobMac parametroGlobMac;
      try {
        parametroGlobMac = em.getReference(ParametroGlobMac.class, id);
        parametroGlobMac.getIdParGm();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The parametroGlobMac with id " + id + " no longer exists.", enfe);
      }
      em.remove(parametroGlobMac);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ParametroGlobMac> findParametroGlobMacEntities() {
    return findParametroGlobMacEntities(true, -1, -1);
  }

  public List<ParametroGlobMac> findParametroGlobMacEntities(int maxResults, int firstResult) {
    return findParametroGlobMacEntities(false, maxResults, firstResult);
  }

  private List<ParametroGlobMac> findParametroGlobMacEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroGlobMac as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroGlobMac findParametroGlobMac(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroGlobMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroGlobMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroGlobMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ParametroGlobMac> findParametroGlobMacNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroGlobMac.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
