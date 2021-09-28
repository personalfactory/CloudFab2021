/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Bolla;
import it.personalfactory.syncorigami.server.entity.Lotto;
import it.personalfactory.syncorigami.server.entity.Macchina;
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

/**
 *
 * @author marilisa
 */
public class BollaJpaController implements Serializable {

  public BollaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Bolla bolla) {
    if (bolla.getLottoCollection() == null) {
      bolla.setLottoCollection(new ArrayList<Lotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Macchina idMacchina = bolla.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        bolla.setIdMacchina(idMacchina);
      }
      Collection<Lotto> attachedLottoCollection = new ArrayList<Lotto>();
      for (Lotto lottoCollectionLottoToAttach : bolla.getLottoCollection()) {
        lottoCollectionLottoToAttach = em.getReference(lottoCollectionLottoToAttach.getClass(), lottoCollectionLottoToAttach.getCodLotto());
        attachedLottoCollection.add(lottoCollectionLottoToAttach);
      }
      bolla.setLottoCollection(attachedLottoCollection);
      em.persist(bolla);
      if (idMacchina != null) {
        idMacchina.getBollaCollection().add(bolla);
        idMacchina = em.merge(idMacchina);
      }
      for (Lotto lottoCollectionLotto : bolla.getLottoCollection()) {
        Bolla oldIdBollaOfLottoCollectionLotto = lottoCollectionLotto.getIdBolla();
        lottoCollectionLotto.setIdBolla(bolla);
        lottoCollectionLotto = em.merge(lottoCollectionLotto);
        if (oldIdBollaOfLottoCollectionLotto != null) {
          oldIdBollaOfLottoCollectionLotto.getLottoCollection().remove(lottoCollectionLotto);
          oldIdBollaOfLottoCollectionLotto = em.merge(oldIdBollaOfLottoCollectionLotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Bolla bolla) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Bolla persistentBolla = em.find(Bolla.class, bolla.getIdBolla());
      Macchina idMacchinaOld = persistentBolla.getIdMacchina();
      Macchina idMacchinaNew = bolla.getIdMacchina();
      Collection<Lotto> lottoCollectionOld = persistentBolla.getLottoCollection();
      Collection<Lotto> lottoCollectionNew = bolla.getLottoCollection();
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        bolla.setIdMacchina(idMacchinaNew);
      }
      Collection<Lotto> attachedLottoCollectionNew = new ArrayList<Lotto>();
      for (Lotto lottoCollectionNewLottoToAttach : lottoCollectionNew) {
        lottoCollectionNewLottoToAttach = em.getReference(lottoCollectionNewLottoToAttach.getClass(), lottoCollectionNewLottoToAttach.getCodLotto());
        attachedLottoCollectionNew.add(lottoCollectionNewLottoToAttach);
      }
      lottoCollectionNew = attachedLottoCollectionNew;
      bolla.setLottoCollection(lottoCollectionNew);
      bolla = em.merge(bolla);
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getBollaCollection().remove(bolla);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getBollaCollection().add(bolla);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      for (Lotto lottoCollectionOldLotto : lottoCollectionOld) {
        if (!lottoCollectionNew.contains(lottoCollectionOldLotto)) {
          lottoCollectionOldLotto.setIdBolla(null);
          lottoCollectionOldLotto = em.merge(lottoCollectionOldLotto);
        }
      }
      for (Lotto lottoCollectionNewLotto : lottoCollectionNew) {
        if (!lottoCollectionOld.contains(lottoCollectionNewLotto)) {
          Bolla oldIdBollaOfLottoCollectionNewLotto = lottoCollectionNewLotto.getIdBolla();
          lottoCollectionNewLotto.setIdBolla(bolla);
          lottoCollectionNewLotto = em.merge(lottoCollectionNewLotto);
          if (oldIdBollaOfLottoCollectionNewLotto != null && !oldIdBollaOfLottoCollectionNewLotto.equals(bolla)) {
            oldIdBollaOfLottoCollectionNewLotto.getLottoCollection().remove(lottoCollectionNewLotto);
            oldIdBollaOfLottoCollectionNewLotto = em.merge(oldIdBollaOfLottoCollectionNewLotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = bolla.getIdBolla();
        if (findBolla(id) == null) {
          throw new NonexistentEntityException("The bolla with id " + id + " no longer exists.");
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
      Bolla bolla;
      try {
        bolla = em.getReference(Bolla.class, id);
        bolla.getIdBolla();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The bolla with id " + id + " no longer exists.", enfe);
      }
      Macchina idMacchina = bolla.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getBollaCollection().remove(bolla);
        idMacchina = em.merge(idMacchina);
      }
      Collection<Lotto> lottoCollection = bolla.getLottoCollection();
      for (Lotto lottoCollectionLotto : lottoCollection) {
        lottoCollectionLotto.setIdBolla(null);
        lottoCollectionLotto = em.merge(lottoCollectionLotto);
      }
      em.remove(bolla);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Bolla> findBollaEntities() {
    return findBollaEntities(true, -1, -1);
  }

  public List<Bolla> findBollaEntities(int maxResults, int firstResult) {
    return findBollaEntities(false, maxResults, firstResult);
  }

  private List<Bolla> findBollaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Bolla as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Bolla findBolla(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Bolla.class, id);
    } finally {
      em.close();
    }
  }

  public int getBollaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Bolla as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
}
