/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.AnagrafeProdotto;
import it.personalfactory.syncorigami.server.entity.Codice;
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
public class CodiceJpaController implements Serializable {

  public CodiceJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Codice codice) {
    if (codice.getAnagrafeProdottoCollection() == null) {
      codice.setAnagrafeProdottoCollection(new ArrayList<AnagrafeProdotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollection = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdottoToAttach : codice.getAnagrafeProdottoCollection()) {
        anagrafeProdottoCollectionAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollection.add(anagrafeProdottoCollectionAnagrafeProdottoToAttach);
      }
      codice.setAnagrafeProdottoCollection(attachedAnagrafeProdottoCollection);
      em.persist(codice);
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdotto : codice.getAnagrafeProdottoCollection()) {
        Codice oldIdCodiceOfAnagrafeProdottoCollectionAnagrafeProdotto = anagrafeProdottoCollectionAnagrafeProdotto.getIdCodice();
        anagrafeProdottoCollectionAnagrafeProdotto.setIdCodice(codice);
        anagrafeProdottoCollectionAnagrafeProdotto = em.merge(anagrafeProdottoCollectionAnagrafeProdotto);
        if (oldIdCodiceOfAnagrafeProdottoCollectionAnagrafeProdotto != null) {
          oldIdCodiceOfAnagrafeProdottoCollectionAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionAnagrafeProdotto);
          oldIdCodiceOfAnagrafeProdottoCollectionAnagrafeProdotto = em.merge(oldIdCodiceOfAnagrafeProdottoCollectionAnagrafeProdotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Codice codice) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Codice persistentCodice = em.find(Codice.class, codice.getIdCodice());
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOld = persistentCodice.getAnagrafeProdottoCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionNew = codice.getAnagrafeProdottoCollection();
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollectionNew = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdottoToAttach : anagrafeProdottoCollectionNew) {
        anagrafeProdottoCollectionNewAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollectionNew.add(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach);
      }
      anagrafeProdottoCollectionNew = attachedAnagrafeProdottoCollectionNew;
      codice.setAnagrafeProdottoCollection(anagrafeProdottoCollectionNew);
      codice = em.merge(codice);
      for (AnagrafeProdotto anagrafeProdottoCollectionOldAnagrafeProdotto : anagrafeProdottoCollectionOld) {
        if (!anagrafeProdottoCollectionNew.contains(anagrafeProdottoCollectionOldAnagrafeProdotto)) {
          anagrafeProdottoCollectionOldAnagrafeProdotto.setIdCodice(null);
          anagrafeProdottoCollectionOldAnagrafeProdotto = em.merge(anagrafeProdottoCollectionOldAnagrafeProdotto);
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdotto : anagrafeProdottoCollectionNew) {
        if (!anagrafeProdottoCollectionOld.contains(anagrafeProdottoCollectionNewAnagrafeProdotto)) {
          Codice oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto = anagrafeProdottoCollectionNewAnagrafeProdotto.getIdCodice();
          anagrafeProdottoCollectionNewAnagrafeProdotto.setIdCodice(codice);
          anagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(anagrafeProdottoCollectionNewAnagrafeProdotto);
          if (oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto != null && !oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto.equals(codice)) {
            oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionNewAnagrafeProdotto);
            oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(oldIdCodiceOfAnagrafeProdottoCollectionNewAnagrafeProdotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = codice.getIdCodice();
        if (findCodice(id) == null) {
          throw new NonexistentEntityException("The codice with id " + id + " no longer exists.");
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
      Codice codice;
      try {
        codice = em.getReference(Codice.class, id);
        codice.getIdCodice();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The codice with id " + id + " no longer exists.", enfe);
      }
      Collection<AnagrafeProdotto> anagrafeProdottoCollection = codice.getAnagrafeProdottoCollection();
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdotto : anagrafeProdottoCollection) {
        anagrafeProdottoCollectionAnagrafeProdotto.setIdCodice(null);
        anagrafeProdottoCollectionAnagrafeProdotto = em.merge(anagrafeProdottoCollectionAnagrafeProdotto);
      }
      em.remove(codice);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Codice> findCodiceEntities() {
    return findCodiceEntities(true, -1, -1);
  }

  public List<Codice> findCodiceEntities(int maxResults, int firstResult) {
    return findCodiceEntities(false, maxResults, firstResult);
  }

  private List<Codice> findCodiceEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Codice as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Codice findCodice(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Codice.class, id);
    } finally {
      em.close();
    }
  }

  public int getCodiceCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Codice as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   public Collection<Codice> findCodiceNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Codice.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
