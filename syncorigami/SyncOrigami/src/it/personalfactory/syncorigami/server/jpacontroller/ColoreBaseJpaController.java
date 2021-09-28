/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ColoreBase;
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
import it.personalfactory.syncorigami.server.entity.MazzettaColSingMac;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ColoreBaseJpaController implements Serializable {

  public ColoreBaseJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ColoreBase coloreBase) {
    if (coloreBase.getMazzettaColorataCollection() == null) {
      coloreBase.setMazzettaColorataCollection(new ArrayList<MazzettaColorata>());
    }
    if (coloreBase.getMazzettaColSingMacCollection() == null) {
      coloreBase.setMazzettaColSingMacCollection(new ArrayList<MazzettaColSingMac>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<MazzettaColorata> attachedMazzettaColorataCollection = new ArrayList<MazzettaColorata>();
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorataToAttach : coloreBase.getMazzettaColorataCollection()) {
        mazzettaColorataCollectionMazzettaColorataToAttach = em.getReference(mazzettaColorataCollectionMazzettaColorataToAttach.getClass(), mazzettaColorataCollectionMazzettaColorataToAttach.getIdMazCol());
        attachedMazzettaColorataCollection.add(mazzettaColorataCollectionMazzettaColorataToAttach);
      }
      coloreBase.setMazzettaColorataCollection(attachedMazzettaColorataCollection);
      Collection<MazzettaColSingMac> attachedMazzettaColSingMacCollection = new ArrayList<MazzettaColSingMac>();
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMacToAttach : coloreBase.getMazzettaColSingMacCollection()) {
        mazzettaColSingMacCollectionMazzettaColSingMacToAttach = em.getReference(mazzettaColSingMacCollectionMazzettaColSingMacToAttach.getClass(), mazzettaColSingMacCollectionMazzettaColSingMacToAttach.getMazzettaColSingMacPK());
        attachedMazzettaColSingMacCollection.add(mazzettaColSingMacCollectionMazzettaColSingMacToAttach);
      }
      coloreBase.setMazzettaColSingMacCollection(attachedMazzettaColSingMacCollection);
      em.persist(coloreBase);
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorata : coloreBase.getMazzettaColorataCollection()) {
        ColoreBase oldIdColoreBaseOfMazzettaColorataCollectionMazzettaColorata = mazzettaColorataCollectionMazzettaColorata.getIdColoreBase();
        mazzettaColorataCollectionMazzettaColorata.setIdColoreBase(coloreBase);
        mazzettaColorataCollectionMazzettaColorata = em.merge(mazzettaColorataCollectionMazzettaColorata);
        if (oldIdColoreBaseOfMazzettaColorataCollectionMazzettaColorata != null) {
          oldIdColoreBaseOfMazzettaColorataCollectionMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionMazzettaColorata);
          oldIdColoreBaseOfMazzettaColorataCollectionMazzettaColorata = em.merge(oldIdColoreBaseOfMazzettaColorataCollectionMazzettaColorata);
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMac : coloreBase.getMazzettaColSingMacCollection()) {
        ColoreBase oldIdColoreBaseOfMazzettaColSingMacCollectionMazzettaColSingMac = mazzettaColSingMacCollectionMazzettaColSingMac.getIdColoreBase();
        mazzettaColSingMacCollectionMazzettaColSingMac.setIdColoreBase(coloreBase);
        mazzettaColSingMacCollectionMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionMazzettaColSingMac);
        if (oldIdColoreBaseOfMazzettaColSingMacCollectionMazzettaColSingMac != null) {
          oldIdColoreBaseOfMazzettaColSingMacCollectionMazzettaColSingMac.getMazzettaColSingMacCollection().remove(mazzettaColSingMacCollectionMazzettaColSingMac);
          oldIdColoreBaseOfMazzettaColSingMacCollectionMazzettaColSingMac = em.merge(oldIdColoreBaseOfMazzettaColSingMacCollectionMazzettaColSingMac);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ColoreBase coloreBase) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ColoreBase persistentColoreBase = em.find(ColoreBase.class, coloreBase.getIdColoreBase());
      Collection<MazzettaColorata> mazzettaColorataCollectionOld = persistentColoreBase.getMazzettaColorataCollection();
      Collection<MazzettaColorata> mazzettaColorataCollectionNew = coloreBase.getMazzettaColorataCollection();
      Collection<MazzettaColSingMac> mazzettaColSingMacCollectionOld = persistentColoreBase.getMazzettaColSingMacCollection();
      Collection<MazzettaColSingMac> mazzettaColSingMacCollectionNew = coloreBase.getMazzettaColSingMacCollection();
      List<String> illegalOrphanMessages = null;
      for (MazzettaColorata mazzettaColorataCollectionOldMazzettaColorata : mazzettaColorataCollectionOld) {
        if (!mazzettaColorataCollectionNew.contains(mazzettaColorataCollectionOldMazzettaColorata)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain MazzettaColorata " + mazzettaColorataCollectionOldMazzettaColorata + " since its idColoreBase field is not nullable.");
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
      coloreBase.setMazzettaColorataCollection(mazzettaColorataCollectionNew);
      Collection<MazzettaColSingMac> attachedMazzettaColSingMacCollectionNew = new ArrayList<MazzettaColSingMac>();
      for (MazzettaColSingMac mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach : mazzettaColSingMacCollectionNew) {
        mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach = em.getReference(mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach.getClass(), mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach.getMazzettaColSingMacPK());
        attachedMazzettaColSingMacCollectionNew.add(mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach);
      }
      mazzettaColSingMacCollectionNew = attachedMazzettaColSingMacCollectionNew;
      coloreBase.setMazzettaColSingMacCollection(mazzettaColSingMacCollectionNew);
      coloreBase = em.merge(coloreBase);
      for (MazzettaColorata mazzettaColorataCollectionNewMazzettaColorata : mazzettaColorataCollectionNew) {
        if (!mazzettaColorataCollectionOld.contains(mazzettaColorataCollectionNewMazzettaColorata)) {
          ColoreBase oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata = mazzettaColorataCollectionNewMazzettaColorata.getIdColoreBase();
          mazzettaColorataCollectionNewMazzettaColorata.setIdColoreBase(coloreBase);
          mazzettaColorataCollectionNewMazzettaColorata = em.merge(mazzettaColorataCollectionNewMazzettaColorata);
          if (oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata != null && !oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata.equals(coloreBase)) {
            oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionNewMazzettaColorata);
            oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata = em.merge(oldIdColoreBaseOfMazzettaColorataCollectionNewMazzettaColorata);
          }
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionOldMazzettaColSingMac : mazzettaColSingMacCollectionOld) {
        if (!mazzettaColSingMacCollectionNew.contains(mazzettaColSingMacCollectionOldMazzettaColSingMac)) {
          mazzettaColSingMacCollectionOldMazzettaColSingMac.setIdColoreBase(null);
          mazzettaColSingMacCollectionOldMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionOldMazzettaColSingMac);
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionNewMazzettaColSingMac : mazzettaColSingMacCollectionNew) {
        if (!mazzettaColSingMacCollectionOld.contains(mazzettaColSingMacCollectionNewMazzettaColSingMac)) {
          ColoreBase oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac = mazzettaColSingMacCollectionNewMazzettaColSingMac.getIdColoreBase();
          mazzettaColSingMacCollectionNewMazzettaColSingMac.setIdColoreBase(coloreBase);
          mazzettaColSingMacCollectionNewMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionNewMazzettaColSingMac);
          if (oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac != null && !oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac.equals(coloreBase)) {
            oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac.getMazzettaColSingMacCollection().remove(mazzettaColSingMacCollectionNewMazzettaColSingMac);
            oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac = em.merge(oldIdColoreBaseOfMazzettaColSingMacCollectionNewMazzettaColSingMac);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = coloreBase.getIdColoreBase();
        if (findColoreBase(id) == null) {
          throw new NonexistentEntityException("The coloreBase with id " + id + " no longer exists.");
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
      ColoreBase coloreBase;
      try {
        coloreBase = em.getReference(ColoreBase.class, id);
        coloreBase.getIdColoreBase();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The coloreBase with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<MazzettaColorata> mazzettaColorataCollectionOrphanCheck = coloreBase.getMazzettaColorataCollection();
      for (MazzettaColorata mazzettaColorataCollectionOrphanCheckMazzettaColorata : mazzettaColorataCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This ColoreBase (" + coloreBase + ") cannot be destroyed since the MazzettaColorata " + mazzettaColorataCollectionOrphanCheckMazzettaColorata + " in its mazzettaColorataCollection field has a non-nullable idColoreBase field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<MazzettaColSingMac> mazzettaColSingMacCollection = coloreBase.getMazzettaColSingMacCollection();
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMac : mazzettaColSingMacCollection) {
        mazzettaColSingMacCollectionMazzettaColSingMac.setIdColoreBase(null);
        mazzettaColSingMacCollectionMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionMazzettaColSingMac);
      }
      em.remove(coloreBase);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ColoreBase> findColoreBaseEntities() {
    return findColoreBaseEntities(true, -1, -1);
  }

  public List<ColoreBase> findColoreBaseEntities(int maxResults, int firstResult) {
    return findColoreBaseEntities(false, maxResults, firstResult);
  }

  private List<ColoreBase> findColoreBaseEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ColoreBase as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ColoreBase findColoreBase(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ColoreBase.class, id);
    } finally {
      em.close();
    }
  }

  public int getColoreBaseCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ColoreBase as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
   public Collection<ColoreBase> findColoreBaseNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
      Query q = em.createNamedQuery("ColoreBase.findDatiNuovi");
      q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
      
     } finally {
      em.close();
    }  
  }
}
