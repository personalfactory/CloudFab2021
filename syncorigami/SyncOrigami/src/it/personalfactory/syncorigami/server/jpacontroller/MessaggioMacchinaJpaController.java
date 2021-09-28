/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.MessaggioMacchina;
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
public class MessaggioMacchinaJpaController implements Serializable {

  public MessaggioMacchinaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(MessaggioMacchina messaggioMacchina) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      em.persist(messaggioMacchina);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(MessaggioMacchina messaggioMacchina) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      messaggioMacchina = em.merge(messaggioMacchina);
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = messaggioMacchina.getIdMessaggio();
        if (findMessaggioMacchina(id) == null) {
          throw new NonexistentEntityException("The messaggioMacchina with id " + id + " no longer exists.");
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
      MessaggioMacchina messaggioMacchina;
      try {
        messaggioMacchina = em.getReference(MessaggioMacchina.class, id);
        messaggioMacchina.getIdMessaggio();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The messaggioMacchina with id " + id + " no longer exists.", enfe);
      }
      em.remove(messaggioMacchina);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<MessaggioMacchina> findMessaggioMacchinaEntities() {
    return findMessaggioMacchinaEntities(true, -1, -1);
  }

  public List<MessaggioMacchina> findMessaggioMacchinaEntities(int maxResults, int firstResult) {
    return findMessaggioMacchinaEntities(false, maxResults, firstResult);
  }

  private List<MessaggioMacchina> findMessaggioMacchinaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from MessaggioMacchina as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public MessaggioMacchina findMessaggioMacchina(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(MessaggioMacchina.class, id);
    } finally {
      em.close();
    }
  }

  public int getMessaggioMacchinaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from MessaggioMacchina as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   public Collection<MessaggioMacchina> findMessaggioMacchinaNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("MessaggioMacchina.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
