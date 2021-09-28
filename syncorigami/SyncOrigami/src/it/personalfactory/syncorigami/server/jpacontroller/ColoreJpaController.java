/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Colore;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.MazzettaColorata;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ColoreJpaController implements Serializable {

  public ColoreJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Colore colore) {
    if (colore.getMazzettaColorataCollection() == null) {
      colore.setMazzettaColorataCollection(new ArrayList<MazzettaColorata>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<MazzettaColorata> attachedMazzettaColorataCollection = new ArrayList<MazzettaColorata>();
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorataToAttach : colore.getMazzettaColorataCollection()) {
        mazzettaColorataCollectionMazzettaColorataToAttach = em.getReference(mazzettaColorataCollectionMazzettaColorataToAttach.getClass(), mazzettaColorataCollectionMazzettaColorataToAttach.getIdMazCol());
        attachedMazzettaColorataCollection.add(mazzettaColorataCollectionMazzettaColorataToAttach);
      }
      colore.setMazzettaColorataCollection(attachedMazzettaColorataCollection);
      em.persist(colore);
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorata : colore.getMazzettaColorataCollection()) {
        Colore oldIdColoreOfMazzettaColorataCollectionMazzettaColorata = mazzettaColorataCollectionMazzettaColorata.getIdColore();
        mazzettaColorataCollectionMazzettaColorata.setIdColore(colore);
        mazzettaColorataCollectionMazzettaColorata = em.merge(mazzettaColorataCollectionMazzettaColorata);
        if (oldIdColoreOfMazzettaColorataCollectionMazzettaColorata != null) {
          oldIdColoreOfMazzettaColorataCollectionMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionMazzettaColorata);
          oldIdColoreOfMazzettaColorataCollectionMazzettaColorata = em.merge(oldIdColoreOfMazzettaColorataCollectionMazzettaColorata);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Colore colore) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Colore persistentColore = em.find(Colore.class, colore.getIdColore());
      Collection<MazzettaColorata> mazzettaColorataCollectionOld = persistentColore.getMazzettaColorataCollection();
      Collection<MazzettaColorata> mazzettaColorataCollectionNew = colore.getMazzettaColorataCollection();
      List<String> illegalOrphanMessages = null;
      for (MazzettaColorata mazzettaColorataCollectionOldMazzettaColorata : mazzettaColorataCollectionOld) {
        if (!mazzettaColorataCollectionNew.contains(mazzettaColorataCollectionOldMazzettaColorata)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain MazzettaColorata " + mazzettaColorataCollectionOldMazzettaColorata + " since its idColore field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<MazzettaColorata> attachedMazzettaColorataCollectionNew = new ArrayList<MazzettaColorata>();
      for (MazzettaColorata mazzettaColorataCollectionNewMazzettaColorataToAttach : mazzettaColorataCollectionNew) {
        mazzettaColorataCollectionNewMazzettaColorataToAttach = em.getReference(mazzettaColorataCollectionNewMazzettaColorataToAttach.getClass(), mazzettaColorataCollectionNewMazzettaColorataToAttach.getIdMazCol());
        attachedMazzettaColorataCollectionNew.add(mazzettaColorataCollectionNewMazzettaColorataToAttach);
      }
      mazzettaColorataCollectionNew = attachedMazzettaColorataCollectionNew;
      colore.setMazzettaColorataCollection(mazzettaColorataCollectionNew);
      colore = em.merge(colore);
      for (MazzettaColorata mazzettaColorataCollectionNewMazzettaColorata : mazzettaColorataCollectionNew) {
        if (!mazzettaColorataCollectionOld.contains(mazzettaColorataCollectionNewMazzettaColorata)) {
          Colore oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata = mazzettaColorataCollectionNewMazzettaColorata.getIdColore();
          mazzettaColorataCollectionNewMazzettaColorata.setIdColore(colore);
          mazzettaColorataCollectionNewMazzettaColorata = em.merge(mazzettaColorataCollectionNewMazzettaColorata);
          if (oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata != null && !oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata.equals(colore)) {
            oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionNewMazzettaColorata);
            oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata = em.merge(oldIdColoreOfMazzettaColorataCollectionNewMazzettaColorata);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = colore.getIdColore();
        if (findColore(id) == null) {
          throw new NonexistentEntityException("The colore with id " + id + " no longer exists.");
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
      Colore colore;
      try {
        colore = em.getReference(Colore.class, id);
        colore.getIdColore();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The colore with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<MazzettaColorata> mazzettaColorataCollectionOrphanCheck = colore.getMazzettaColorataCollection();
      for (MazzettaColorata mazzettaColorataCollectionOrphanCheckMazzettaColorata : mazzettaColorataCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Colore (" + colore + ") cannot be destroyed since the MazzettaColorata " + mazzettaColorataCollectionOrphanCheckMazzettaColorata + " in its mazzettaColorataCollection field has a non-nullable idColore field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(colore);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Colore> findColoreEntities() {
    return findColoreEntities(true, -1, -1);
  }

  public List<Colore> findColoreEntities(int maxResults, int firstResult) {
    return findColoreEntities(false, maxResults, firstResult);
  }

  private List<Colore> findColoreEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Colore as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Colore findColore(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Colore.class, id);
    } finally {
      em.close();
    }
  }

  public int getColoreCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Colore as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<Colore> findColoreNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     
     try {   
       Query q = em.createNamedQuery("Colore.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
       return q.getResultList();
     } finally {
      em.close();
    }   
  }
}
