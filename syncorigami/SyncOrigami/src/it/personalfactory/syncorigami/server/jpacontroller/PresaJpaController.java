/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Presa;
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
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class PresaJpaController implements Serializable {

  Logger log = Logger.getLogger(PresaJpaController.class);

  public PresaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Presa presa) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      em.persist(presa);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Presa presa) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      presa = em.merge(presa);
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = presa.getIdPresa();
        if (findPresa(id) == null) {
          throw new NonexistentEntityException("The presa with id " + id + " no longer exists.");
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
      Presa presa;
      try {
        presa = em.getReference(Presa.class, id);
        presa.getIdPresa();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The presa with id " + id + " no longer exists.", enfe);
      }
      em.remove(presa);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Presa> findPresaEntities() {
    return findPresaEntities(true, -1, -1);
  }

  public List<Presa> findPresaEntities(int maxResults, int firstResult) {
    return findPresaEntities(false, maxResults, firstResult);
  }

  private List<Presa> findPresaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Presa as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Presa findPresa(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Presa.class, id);
    } finally {
      em.close();
    }
  }

  public int getPresaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Presa as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }

  public Collection<Presa> findPresaNew(Date dt_ult_agg) {

    EntityManager em = getEntityManager();
    try {

      Query q = em.createNamedQuery("Presa.findDatiNuovi");
      q.setParameter("dtAbilitato", dt_ult_agg);

      return q.getResultList();

    } finally {
      em.close();
    }

  }

 public void merge(Presa presa) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Integer id = presa.getIdPresa();
      if (findPresa(id) == null ) {
          em.persist(presa);
      } else {
          em.merge(presa);
      }
      em.getTransaction().commit();
      
    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }

//  public void merge(Presa presa) {
//    EntityManager em = null;
//    try {
//      em = getEntityManager();
//      em.getTransaction().begin();
//      presa = em.merge(presa);
//      em.getTransaction().commit();
//    
//    } catch (Exception ex) {
//
//      Integer id = presa.getIdPresa();
//      if (findPresa(id) == null) {
//        em.persist(presa);
//      }
//    } finally {
//      if (em != null) {
//        em.close();
//      }
//    }
//  }
// 
//  public void merge(Presa presa) throws Exception {
//    EntityManager em = null;
//    try {
//      em = getEntityManager();
//      em.getTransaction().begin();
//      Integer id = presa.getIdPresa();
//
//      if (findPresa(id) == null) {
//        em.persist(presa);
//      } else {
//        em.merge(presa);
//      }
//      em.getTransaction().commit();
//    
//    }finally {
//      if (em != null) {
//        em.close();
//      }
//    }
//  }
}
