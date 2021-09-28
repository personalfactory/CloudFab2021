/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroCompProd;
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
public class ParametroCompProdJpaController implements Serializable {

  public ParametroCompProdJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ParametroCompProd parametroCompProd) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      em.persist(parametroCompProd);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ParametroCompProd parametroCompProd) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      parametroCompProd = em.merge(parametroCompProd);
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = parametroCompProd.getIdParComp();
        if (findParametroCompProd(id) == null) {
          throw new NonexistentEntityException("The parametroCompProd with id " + id + " no longer exists.");
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
      ParametroCompProd parametroCompProd;
      try {
        parametroCompProd = em.getReference(ParametroCompProd.class, id);
        parametroCompProd.getIdParComp();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The parametroCompProd with id " + id + " no longer exists.", enfe);
      }
      em.remove(parametroCompProd);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ParametroCompProd> findParametroCompProdEntities() {
    return findParametroCompProdEntities(true, -1, -1);
  }

  public List<ParametroCompProd> findParametroCompProdEntities(int maxResults, int firstResult) {
    return findParametroCompProdEntities(false, maxResults, firstResult);
  }

  private List<ParametroCompProd> findParametroCompProdEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroCompProd as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroCompProd findParametroCompProd(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroCompProd.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroCompProdCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroCompProd as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<ParametroCompProd> findParametroCompProdNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroCompProd.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
