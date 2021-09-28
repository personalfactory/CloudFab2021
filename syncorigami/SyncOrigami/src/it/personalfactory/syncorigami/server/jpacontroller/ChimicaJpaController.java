/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Chimica;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Lotto;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ChimicaJpaController implements Serializable {

  public ChimicaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Chimica chimica) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Lotto codLotto = chimica.getCodLotto();
      if (codLotto != null) {
        codLotto = em.getReference(codLotto.getClass(), codLotto.getCodLotto());
        chimica.setCodLotto(codLotto);
      }
      em.persist(chimica);
      if (codLotto != null) {
        codLotto.getChimicaCollection().add(chimica);
        codLotto = em.merge(codLotto);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Chimica chimica) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Chimica persistentChimica = em.find(Chimica.class, chimica.getIdChimica());
      Lotto codLottoOld = persistentChimica.getCodLotto();
      Lotto codLottoNew = chimica.getCodLotto();
      if (codLottoNew != null) {
        codLottoNew = em.getReference(codLottoNew.getClass(), codLottoNew.getCodLotto());
        chimica.setCodLotto(codLottoNew);
      }
      chimica = em.merge(chimica);
      if (codLottoOld != null && !codLottoOld.equals(codLottoNew)) {
        codLottoOld.getChimicaCollection().remove(chimica);
        codLottoOld = em.merge(codLottoOld);
      }
      if (codLottoNew != null && !codLottoNew.equals(codLottoOld)) {
        codLottoNew.getChimicaCollection().add(chimica);
        codLottoNew = em.merge(codLottoNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = chimica.getIdChimica();
        if (findChimica(id) == null) {
          throw new NonexistentEntityException("The chimica with id " + id + " no longer exists.");
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
      Chimica chimica;
      try {
        chimica = em.getReference(Chimica.class, id);
        chimica.getIdChimica();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The chimica with id " + id + " no longer exists.", enfe);
      }
      Lotto codLotto = chimica.getCodLotto();
      if (codLotto != null) {
        codLotto.getChimicaCollection().remove(chimica);
        codLotto = em.merge(codLotto);
      }
      em.remove(chimica);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Chimica> findChimicaEntities() {
    return findChimicaEntities(true, -1, -1);
  }

  public List<Chimica> findChimicaEntities(int maxResults, int firstResult) {
    return findChimicaEntities(false, maxResults, firstResult);
  }

  private List<Chimica> findChimicaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Chimica as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Chimica findChimica(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Chimica.class, id);
    } finally {
      em.close();
    }
  }

  public int getChimicaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Chimica as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  
  /**
   * Metodo che restituisce le chimiche nuove
   * @param data di costruzione dell'ultimo aggiornamento 
   * @param id della macchina da aggiornare
   * @return Una collection di tipo Chimica
   * Per recuperare le chimiche nuove lato server da inviare alla macchina 
   * si confronta la data dell'ultimo aggiornamento con il valore del campo dtAbilitato
   * N.B. La chiomica viaggia in un solo verso ovvero dal server alle macchine
   */
   public Collection<Chimica> findChimicaNew(Date dt_ult_agg, Integer idMacchina){
         
     EntityManager em = getEntityManager();
     try {
        Query q = em.createNamedQuery("Chimica.findDatiNuovi");
        q.setParameter ("idMacchina", idMacchina);
        q.setParameter ("dtAbilitato", dt_ult_agg);
      
       return  q.getResultList();
    
     } finally {
      em.close();
    }
     
  }    
  
       
    
   
   
}
