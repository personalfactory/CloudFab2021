/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroSacchetto;
import it.personalfactory.syncorigami.server.entity.ValoreParSacchetto;
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
public class ParametroSacchettoJpaController implements Serializable {

  public ParametroSacchettoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ParametroSacchetto parametroSacchetto) {
    if (parametroSacchetto.getValoreParSacchettoCollection() == null) {
      parametroSacchetto.setValoreParSacchettoCollection(new ArrayList<ValoreParSacchetto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollection = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchettoToAttach : parametroSacchetto.getValoreParSacchettoCollection()) {
        valoreParSacchettoCollectionValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollection.add(valoreParSacchettoCollectionValoreParSacchettoToAttach);
      }
      parametroSacchetto.setValoreParSacchettoCollection(attachedValoreParSacchettoCollection);
      em.persist(parametroSacchetto);
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchetto : parametroSacchetto.getValoreParSacchettoCollection()) {
        ParametroSacchetto oldIdParSacOfValoreParSacchettoCollectionValoreParSacchetto = valoreParSacchettoCollectionValoreParSacchetto.getIdParSac();
        valoreParSacchettoCollectionValoreParSacchetto.setIdParSac(parametroSacchetto);
        valoreParSacchettoCollectionValoreParSacchetto = em.merge(valoreParSacchettoCollectionValoreParSacchetto);
        if (oldIdParSacOfValoreParSacchettoCollectionValoreParSacchetto != null) {
          oldIdParSacOfValoreParSacchettoCollectionValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionValoreParSacchetto);
          oldIdParSacOfValoreParSacchettoCollectionValoreParSacchetto = em.merge(oldIdParSacOfValoreParSacchettoCollectionValoreParSacchetto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ParametroSacchetto parametroSacchetto) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroSacchetto persistentParametroSacchetto = em.find(ParametroSacchetto.class, parametroSacchetto.getIdParSac());
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionOld = persistentParametroSacchetto.getValoreParSacchettoCollection();
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionNew = parametroSacchetto.getValoreParSacchettoCollection();
      List<String> illegalOrphanMessages = null;
      for (ValoreParSacchetto valoreParSacchettoCollectionOldValoreParSacchetto : valoreParSacchettoCollectionOld) {
        if (!valoreParSacchettoCollectionNew.contains(valoreParSacchettoCollectionOldValoreParSacchetto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParSacchetto " + valoreParSacchettoCollectionOldValoreParSacchetto + " since its idParSac field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollectionNew = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchettoToAttach : valoreParSacchettoCollectionNew) {
        valoreParSacchettoCollectionNewValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollectionNew.add(valoreParSacchettoCollectionNewValoreParSacchettoToAttach);
      }
      valoreParSacchettoCollectionNew = attachedValoreParSacchettoCollectionNew;
      parametroSacchetto.setValoreParSacchettoCollection(valoreParSacchettoCollectionNew);
      parametroSacchetto = em.merge(parametroSacchetto);
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchetto : valoreParSacchettoCollectionNew) {
        if (!valoreParSacchettoCollectionOld.contains(valoreParSacchettoCollectionNewValoreParSacchetto)) {
          ParametroSacchetto oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto = valoreParSacchettoCollectionNewValoreParSacchetto.getIdParSac();
          valoreParSacchettoCollectionNewValoreParSacchetto.setIdParSac(parametroSacchetto);
          valoreParSacchettoCollectionNewValoreParSacchetto = em.merge(valoreParSacchettoCollectionNewValoreParSacchetto);
          if (oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto != null && !oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto.equals(parametroSacchetto)) {
            oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionNewValoreParSacchetto);
            oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto = em.merge(oldIdParSacOfValoreParSacchettoCollectionNewValoreParSacchetto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = parametroSacchetto.getIdParSac();
        if (findParametroSacchetto(id) == null) {
          throw new NonexistentEntityException("The parametroSacchetto with id " + id + " no longer exists.");
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
      ParametroSacchetto parametroSacchetto;
      try {
        parametroSacchetto = em.getReference(ParametroSacchetto.class, id);
        parametroSacchetto.getIdParSac();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The parametroSacchetto with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionOrphanCheck = parametroSacchetto.getValoreParSacchettoCollection();
      for (ValoreParSacchetto valoreParSacchettoCollectionOrphanCheckValoreParSacchetto : valoreParSacchettoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This ParametroSacchetto (" + parametroSacchetto + ") cannot be destroyed since the ValoreParSacchetto " + valoreParSacchettoCollectionOrphanCheckValoreParSacchetto + " in its valoreParSacchettoCollection field has a non-nullable idParSac field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(parametroSacchetto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ParametroSacchetto> findParametroSacchettoEntities() {
    return findParametroSacchettoEntities(true, -1, -1);
  }

  public List<ParametroSacchetto> findParametroSacchettoEntities(int maxResults, int firstResult) {
    return findParametroSacchettoEntities(false, maxResults, firstResult);
  }

  private List<ParametroSacchetto> findParametroSacchettoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ParametroSacchetto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ParametroSacchetto findParametroSacchetto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ParametroSacchetto.class, id);
    } finally {
      em.close();
    }
  }

  public int getParametroSacchettoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ParametroSacchetto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ParametroSacchetto> findParametroSacchettoNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroSacchetto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
