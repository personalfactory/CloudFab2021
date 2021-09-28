/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Categoria;
import it.personalfactory.syncorigami.server.entity.ParametroProdotto;
import it.personalfactory.syncorigami.server.entity.ValoreProdotto;
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
public class ValoreProdottoJpaController implements Serializable {

  public ValoreProdottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  

  

  public List<ValoreProdotto> findValoreProdottoEntities() {
    return findValoreProdottoEntities(true, -1, -1);
  }

  public List<ValoreProdotto> findValoreProdottoEntities(int maxResults, int firstResult) {
    return findValoreProdottoEntities(false, maxResults, firstResult);
  }

  private List<ValoreProdotto> findValoreProdottoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ValoreProdotto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ValoreProdotto findValoreProdotto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreProdotto.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreProdottoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreProdotto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   public Collection<ValoreProdotto> findValoreProdottoNew(Date dt_ult_agg){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreProdotto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
