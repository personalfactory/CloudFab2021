/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Lotto;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Bolla;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class LottoJpaController implements Serializable {

  public LottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Lotto lotto) throws PreexistingEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Bolla idBolla = lotto.getIdBolla();
      if (idBolla != null) {
        idBolla = em.getReference(idBolla.getClass(), idBolla.getIdBolla());
        lotto.setIdBolla(idBolla);
      }
      em.persist(lotto);
      if (idBolla != null) {
        idBolla.getLottoCollection().add(lotto);
        idBolla = em.merge(idBolla);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      if (findLotto(lotto.getCodLotto()) != null) {
        throw new PreexistingEntityException("Lotto " + lotto + " already exists.", ex);
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Lotto lotto) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Lotto persistentLotto = em.find(Lotto.class, lotto.getCodLotto());
      Bolla idBollaOld = persistentLotto.getIdBolla();
      Bolla idBollaNew = lotto.getIdBolla();
      if (idBollaNew != null) {
        idBollaNew = em.getReference(idBollaNew.getClass(), idBollaNew.getIdBolla());
        lotto.setIdBolla(idBollaNew);
      }
      lotto = em.merge(lotto);
      if (idBollaOld != null && !idBollaOld.equals(idBollaNew)) {
        idBollaOld.getLottoCollection().remove(lotto);
        idBollaOld = em.merge(idBollaOld);
      }
      if (idBollaNew != null && !idBollaNew.equals(idBollaOld)) {
        idBollaNew.getLottoCollection().add(lotto);
        idBollaNew = em.merge(idBollaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        String id = lotto.getCodLotto();
        if (findLotto(id) == null) {
          throw new NonexistentEntityException("The lotto with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(String id) throws NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Lotto lotto;
      try {
        lotto = em.getReference(Lotto.class, id);
        lotto.getCodLotto();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The lotto with id " + id + " no longer exists.", enfe);
      }
      Bolla idBolla = lotto.getIdBolla();
      if (idBolla != null) {
        idBolla.getLottoCollection().remove(lotto);
        idBolla = em.merge(idBolla);
      }
      em.remove(lotto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Lotto> findLottoEntities() {
    return findLottoEntities(true, -1, -1);
  }

  public List<Lotto> findLottoEntities(int maxResults, int firstResult) {
    return findLottoEntities(false, maxResults, firstResult);
  }

  private List<Lotto> findLottoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Lotto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Lotto findLotto(String id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Lotto.class, id);
    } finally {
      em.close();
    }
  }

  public int getLottoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Lotto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
}
