/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Dizionario;
import it.personalfactory.syncorigami.server.entity.DizionarioTipo;
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
public class DizionarioTipoJpaController implements Serializable {

  public DizionarioTipoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(DizionarioTipo dizionarioTipo) {
    if (dizionarioTipo.getDizionarioCollection() == null) {
      dizionarioTipo.setDizionarioCollection(new ArrayList<Dizionario>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<Dizionario> attachedDizionarioCollection = new ArrayList<Dizionario>();
      for (Dizionario dizionarioCollectionDizionarioToAttach : dizionarioTipo.getDizionarioCollection()) {
        dizionarioCollectionDizionarioToAttach = em.getReference(dizionarioCollectionDizionarioToAttach.getClass(), dizionarioCollectionDizionarioToAttach.getIdDizionario());
        attachedDizionarioCollection.add(dizionarioCollectionDizionarioToAttach);
      }
      dizionarioTipo.setDizionarioCollection(attachedDizionarioCollection);
      em.persist(dizionarioTipo);
      for (Dizionario dizionarioCollectionDizionario : dizionarioTipo.getDizionarioCollection()) {
        DizionarioTipo oldIdDizTipoOfDizionarioCollectionDizionario = dizionarioCollectionDizionario.getIdDizTipo();
        dizionarioCollectionDizionario.setIdDizTipo(dizionarioTipo);
        dizionarioCollectionDizionario = em.merge(dizionarioCollectionDizionario);
        if (oldIdDizTipoOfDizionarioCollectionDizionario != null) {
          oldIdDizTipoOfDizionarioCollectionDizionario.getDizionarioCollection().remove(dizionarioCollectionDizionario);
          oldIdDizTipoOfDizionarioCollectionDizionario = em.merge(oldIdDizTipoOfDizionarioCollectionDizionario);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(DizionarioTipo dizionarioTipo) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      DizionarioTipo persistentDizionarioTipo = em.find(DizionarioTipo.class, dizionarioTipo.getIdDizTipo());
      Collection<Dizionario> dizionarioCollectionOld = persistentDizionarioTipo.getDizionarioCollection();
      Collection<Dizionario> dizionarioCollectionNew = dizionarioTipo.getDizionarioCollection();
      List<String> illegalOrphanMessages = null;
      for (Dizionario dizionarioCollectionOldDizionario : dizionarioCollectionOld) {
        if (!dizionarioCollectionNew.contains(dizionarioCollectionOldDizionario)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain Dizionario " + dizionarioCollectionOldDizionario + " since its idDizTipo field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<Dizionario> attachedDizionarioCollectionNew = new ArrayList<Dizionario>();
      for (Dizionario dizionarioCollectionNewDizionarioToAttach : dizionarioCollectionNew) {
        dizionarioCollectionNewDizionarioToAttach = em.getReference(dizionarioCollectionNewDizionarioToAttach.getClass(), dizionarioCollectionNewDizionarioToAttach.getIdDizionario());
        attachedDizionarioCollectionNew.add(dizionarioCollectionNewDizionarioToAttach);
      }
      dizionarioCollectionNew = attachedDizionarioCollectionNew;
      dizionarioTipo.setDizionarioCollection(dizionarioCollectionNew);
      dizionarioTipo = em.merge(dizionarioTipo);
      for (Dizionario dizionarioCollectionNewDizionario : dizionarioCollectionNew) {
        if (!dizionarioCollectionOld.contains(dizionarioCollectionNewDizionario)) {
          DizionarioTipo oldIdDizTipoOfDizionarioCollectionNewDizionario = dizionarioCollectionNewDizionario.getIdDizTipo();
          dizionarioCollectionNewDizionario.setIdDizTipo(dizionarioTipo);
          dizionarioCollectionNewDizionario = em.merge(dizionarioCollectionNewDizionario);
          if (oldIdDizTipoOfDizionarioCollectionNewDizionario != null && !oldIdDizTipoOfDizionarioCollectionNewDizionario.equals(dizionarioTipo)) {
            oldIdDizTipoOfDizionarioCollectionNewDizionario.getDizionarioCollection().remove(dizionarioCollectionNewDizionario);
            oldIdDizTipoOfDizionarioCollectionNewDizionario = em.merge(oldIdDizTipoOfDizionarioCollectionNewDizionario);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = dizionarioTipo.getIdDizTipo();
        if (findDizionarioTipo(id) == null) {
          throw new NonexistentEntityException("The dizionarioTipo with id " + id + " no longer exists.");
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
      DizionarioTipo dizionarioTipo;
      try {
        dizionarioTipo = em.getReference(DizionarioTipo.class, id);
        dizionarioTipo.getIdDizTipo();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The dizionarioTipo with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<Dizionario> dizionarioCollectionOrphanCheck = dizionarioTipo.getDizionarioCollection();
      for (Dizionario dizionarioCollectionOrphanCheckDizionario : dizionarioCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This DizionarioTipo (" + dizionarioTipo + ") cannot be destroyed since the Dizionario " + dizionarioCollectionOrphanCheckDizionario + " in its dizionarioCollection field has a non-nullable idDizTipo field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(dizionarioTipo);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<DizionarioTipo> findDizionarioTipoEntities() {
    return findDizionarioTipoEntities(true, -1, -1);
  }

  public List<DizionarioTipo> findDizionarioTipoEntities(int maxResults, int firstResult) {
    return findDizionarioTipoEntities(false, maxResults, firstResult);
  }

  private List<DizionarioTipo> findDizionarioTipoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from DizionarioTipo as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public DizionarioTipo findDizionarioTipo(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(DizionarioTipo.class, id);
    } finally {
      em.close();
    }
  }

  public int getDizionarioTipoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from DizionarioTipo as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<DizionarioTipo> findDizionarioTipoNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("DizionarioTipo.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
