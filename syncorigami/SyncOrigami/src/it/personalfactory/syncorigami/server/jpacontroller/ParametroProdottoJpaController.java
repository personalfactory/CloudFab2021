/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroProdotto;
import it.personalfactory.syncorigami.server.entity.ValoreParProd;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
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
public class ParametroProdottoJpaController implements Serializable {

  public ParametroProdottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ParametroProdotto parametroProdotto) {
    if (parametroProdotto.getValoreParProdCollection() == null) {
      parametroProdotto.setValoreParProdCollection(new ArrayList<ValoreParProd>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ValoreParProd> attachedValoreParProdCollection = new ArrayList<ValoreParProd>();
      for (ValoreParProd valoreParProdCollectionValoreParProdToAttach : parametroProdotto.getValoreParProdCollection()) {
        valoreParProdCollectionValoreParProdToAttach = em.getReference(valoreParProdCollectionValoreParProdToAttach.getClass(), valoreParProdCollectionValoreParProdToAttach.getIdValParPr());
        attachedValoreParProdCollection.add(valoreParProdCollectionValoreParProdToAttach);
      }
      parametroProdotto.setValoreParProdCollection(attachedValoreParProdCollection);
      em.persist(parametroProdotto);
      for (ValoreParProd valoreParProdCollectionValoreParProd : parametroProdotto.getValoreParProdCollection()) {
        ParametroProdotto oldIdParProdOfValoreParProdCollectionValoreParProd = valoreParProdCollectionValoreParProd.getIdParProd();
        valoreParProdCollectionValoreParProd.setIdParProd(parametroProdotto);
        valoreParProdCollectionValoreParProd = em.merge(valoreParProdCollectionValoreParProd);
        if (oldIdParProdOfValoreParProdCollectionValoreParProd != null) {
          oldIdParProdOfValoreParProdCollectionValoreParProd.getValoreParProdCollection().remove(valoreParProdCollectionValoreParProd);
          oldIdParProdOfValoreParProdCollectionValoreParProd = em.merge(oldIdParProdOfValoreParProdCollectionValoreParProd);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ParametroProdotto parametroProdotto) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroProdotto persistentParametroProdotto = em.find(ParametroProdotto.class, parametroProdotto.getIdParProd());
      Collection<ValoreParProd> valoreParProdCollectionOld = persistentParametroProdotto.getValoreParProdCollection();
      Collection<ValoreParProd> valoreParProdCollectionNew = parametroProdotto.getValoreParProdCollection();
      List<String> illegalOrphanMessages = null;
      for (ValoreParProd valoreParProdCollectionOldValoreParProd : valoreParProdCollectionOld) {
        if (!valoreParProdCollectionNew.contains(valoreParProdCollectionOldValoreParProd)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParProd " + valoreParProdCollectionOldValoreParProd + " since its idParProd field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ValoreParProd> attachedValoreParProdCollectionNew = new ArrayList<ValoreParProd>();
      for (ValoreParProd valoreParProdCollectionNewValoreParProdToAttach : valoreParProdCollectionNew) {
        valoreParProdCollectionNewValoreParProdToAttach = em.getReference(valoreParProdCollectionNewValoreParProdToAttach.getClass(), valoreParProdCollectionNewValoreParProdToAttach.getIdValParPr());
        attachedValoreParProdCollectionNew.add(valoreParProdCollectionNewValoreParProdToAttach);
      }
      valoreParProdCollectionNew = attachedValoreParProdCollectionNew;
      parametroProdotto.setValoreParProdCollection(valoreParProdCollectionNew);
      parametroProdotto = em.merge(parametroProdotto);
      for (ValoreParProd valoreParProdCollectionNewValoreParProd : valoreParProdCollectionNew) {
        if (!valoreParProdCollectionOld.contains(valoreParProdCollectionNewValoreParProd)) {
          ParametroProdotto oldIdParProdOfValoreParProdCollectionNewValoreParProd = valoreParProdCollectionNewValoreParProd.getIdParProd();
          valoreParProdCollectionNewValoreParProd.setIdParProd(parametroProdotto);
          valoreParProdCollectionNewValoreParProd = em.merge(valoreParProdCollectionNewValoreParProd);
          if (oldIdParProdOfValoreParProdCollectionNewValoreParProd != null && !oldIdParProdOfValoreParProdCollectionNewValoreParProd.equals(parametroProdotto)) {
            oldIdParProdOfValoreParProdCollectionNewValoreParProd.getValoreParProdCollection().remove(valoreParProdCollectionNewValoreParProd);
            oldIdParProdOfValoreParProdCollectionNewValoreParProd = em.merge(oldIdParProdOfValoreParProdCollectionNewValoreParProd);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = parametroProdotto.getIdParProd();
        if (findParametroProdotto(id) == null) {
          throw new NonexistentEntityException("The parametroProdotto with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(Integer id) throws IllegalOrphanException, NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroProdotto parametroProdotto;
      try {
        parametroProdotto = em.getReference(ParametroProdotto.class, id);
        parametroProdotto.getIdParProd();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The parametroProdotto with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ValoreParProd> valoreParProdCollectionOrphanCheck = parametroProdotto.getValoreParProdCollection();
      for (ValoreParProd valoreParProdCollectionOrphanCheckValoreParProd : valoreParProdCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This ParametroProdotto (" + parametroProdotto + ") cannot be destroyed since the ValoreParProd " + valoreParProdCollectionOrphanCheckValoreParProd + " in its valoreParProdCollection field has a non-nullable idParProd field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(parametroProdotto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ParametroProdotto> findParametroProdottoEntities() {
    return findParametroProdottoEntities(true, -1, -1);
  }

  public List<ParametroProdotto> findParametroProdottoEntities(int maxResults, int firstResult) {
    return findParametroProdottoEntities(false, maxResults, firstResult);
  }

  private List<ParametroProdotto> findParametroProdottoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroProdotto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroProdotto findParametroProdotto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroProdotto.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroProdottoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroProdotto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ParametroProdotto> findParametroProdottoNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroProdotto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
  }    
}
