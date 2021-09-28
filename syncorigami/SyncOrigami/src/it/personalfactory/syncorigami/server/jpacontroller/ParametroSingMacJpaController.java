/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroSingMac;
import it.personalfactory.syncorigami.server.entity.ValoreParSingMac;
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
public class ParametroSingMacJpaController implements Serializable {

  public ParametroSingMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ParametroSingMac parametroSingMac) {
    if (parametroSingMac.getValoreParSingMacCollection() == null) {
      parametroSingMac.setValoreParSingMacCollection(new ArrayList<ValoreParSingMac>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ValoreParSingMac> attachedValoreParSingMacCollection = new ArrayList<ValoreParSingMac>();
      for (ValoreParSingMac valoreParSingMacCollectionValoreParSingMacToAttach : parametroSingMac.getValoreParSingMacCollection()) {
        valoreParSingMacCollectionValoreParSingMacToAttach = em.getReference(valoreParSingMacCollectionValoreParSingMacToAttach.getClass(), valoreParSingMacCollectionValoreParSingMacToAttach.getIdValParSm());
        attachedValoreParSingMacCollection.add(valoreParSingMacCollectionValoreParSingMacToAttach);
      }
      parametroSingMac.setValoreParSingMacCollection(attachedValoreParSingMacCollection);
      em.persist(parametroSingMac);
      for (ValoreParSingMac valoreParSingMacCollectionValoreParSingMac : parametroSingMac.getValoreParSingMacCollection()) {
        ParametroSingMac oldIdParSmOfValoreParSingMacCollectionValoreParSingMac = valoreParSingMacCollectionValoreParSingMac.getIdParSm();
        valoreParSingMacCollectionValoreParSingMac.setIdParSm(parametroSingMac);
        valoreParSingMacCollectionValoreParSingMac = em.merge(valoreParSingMacCollectionValoreParSingMac);
        if (oldIdParSmOfValoreParSingMacCollectionValoreParSingMac != null) {
          oldIdParSmOfValoreParSingMacCollectionValoreParSingMac.getValoreParSingMacCollection().remove(valoreParSingMacCollectionValoreParSingMac);
          oldIdParSmOfValoreParSingMacCollectionValoreParSingMac = em.merge(oldIdParSmOfValoreParSingMacCollectionValoreParSingMac);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ParametroSingMac parametroSingMac) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroSingMac persistentParametroSingMac = em.find(ParametroSingMac.class, parametroSingMac.getIdParSm());
      Collection<ValoreParSingMac> valoreParSingMacCollectionOld = persistentParametroSingMac.getValoreParSingMacCollection();
      Collection<ValoreParSingMac> valoreParSingMacCollectionNew = parametroSingMac.getValoreParSingMacCollection();
      List<String> illegalOrphanMessages = null;
      for (ValoreParSingMac valoreParSingMacCollectionOldValoreParSingMac : valoreParSingMacCollectionOld) {
        if (!valoreParSingMacCollectionNew.contains(valoreParSingMacCollectionOldValoreParSingMac)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParSingMac " + valoreParSingMacCollectionOldValoreParSingMac + " since its idParSm field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ValoreParSingMac> attachedValoreParSingMacCollectionNew = new ArrayList<ValoreParSingMac>();
      for (ValoreParSingMac valoreParSingMacCollectionNewValoreParSingMacToAttach : valoreParSingMacCollectionNew) {
        valoreParSingMacCollectionNewValoreParSingMacToAttach = em.getReference(valoreParSingMacCollectionNewValoreParSingMacToAttach.getClass(), valoreParSingMacCollectionNewValoreParSingMacToAttach.getIdValParSm());
        attachedValoreParSingMacCollectionNew.add(valoreParSingMacCollectionNewValoreParSingMacToAttach);
      }
      valoreParSingMacCollectionNew = attachedValoreParSingMacCollectionNew;
      parametroSingMac.setValoreParSingMacCollection(valoreParSingMacCollectionNew);
      parametroSingMac = em.merge(parametroSingMac);
      for (ValoreParSingMac valoreParSingMacCollectionNewValoreParSingMac : valoreParSingMacCollectionNew) {
        if (!valoreParSingMacCollectionOld.contains(valoreParSingMacCollectionNewValoreParSingMac)) {
          ParametroSingMac oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac = valoreParSingMacCollectionNewValoreParSingMac.getIdParSm();
          valoreParSingMacCollectionNewValoreParSingMac.setIdParSm(parametroSingMac);
          valoreParSingMacCollectionNewValoreParSingMac = em.merge(valoreParSingMacCollectionNewValoreParSingMac);
          if (oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac != null && !oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac.equals(parametroSingMac)) {
            oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac.getValoreParSingMacCollection().remove(valoreParSingMacCollectionNewValoreParSingMac);
            oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac = em.merge(oldIdParSmOfValoreParSingMacCollectionNewValoreParSingMac);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = parametroSingMac.getIdParSm();
        if (findParametroSingMac(id) == null) {
          throw new NonexistentEntityException("The parametroSingMac with id " + id + " no longer exists.");
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
      ParametroSingMac parametroSingMac;
      try {
        parametroSingMac = em.getReference(ParametroSingMac.class, id);
        parametroSingMac.getIdParSm();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The parametroSingMac with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ValoreParSingMac> valoreParSingMacCollectionOrphanCheck = parametroSingMac.getValoreParSingMacCollection();
      for (ValoreParSingMac valoreParSingMacCollectionOrphanCheckValoreParSingMac : valoreParSingMacCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This ParametroSingMac (" + parametroSingMac + ") cannot be destroyed since the ValoreParSingMac " + valoreParSingMacCollectionOrphanCheckValoreParSingMac + " in its valoreParSingMacCollection field has a non-nullable idParSm field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(parametroSingMac);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ParametroSingMac> findParametroSingMacEntities() {
    return findParametroSingMacEntities(true, -1, -1);
  }

  public List<ParametroSingMac> findParametroSingMacEntities(int maxResults, int firstResult) {
    return findParametroSingMacEntities(false, maxResults, firstResult);
  }

  private List<ParametroSingMac> findParametroSingMacEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroSingMac as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroSingMac findParametroSingMac(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroSingMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroSingMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroSingMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
 
   public Collection<ParametroSingMac> findParametroSingMacNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroSingMac.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
