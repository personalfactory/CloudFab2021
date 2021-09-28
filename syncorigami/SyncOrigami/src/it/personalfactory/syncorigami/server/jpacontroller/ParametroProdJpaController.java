/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroProd;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.transaction.UserTransaction;
import java.util.Collection;
import java.util.Date;

/**
 *
 * @author marilisa
 */
public class ParametroProdJpaController implements Serializable {

  public ParametroProdJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }
 

  public List<ParametroProd> findParametroProdEntities() {
    return findParametroProdEntities(true, -1, -1);
  }

  public List<ParametroProd> findParametroProdEntities(int maxResults, int firstResult) {
    return findParametroProdEntities(false, maxResults, firstResult);
  }

  private List<ParametroProd> findParametroProdEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroProd as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroProd findParametroProd(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroProd.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroProdCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroProd as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ParametroProd> findParametroProdNew( Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroProd.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
  }    
}
