/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Mazzetta;
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
import it.personalfactory.syncorigami.server.entity.AnagrafeProdotto;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class MazzettaJpaController implements Serializable {

  public MazzettaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Mazzetta mazzetta) {
    if (mazzetta.getMazzettaColorataCollection() == null) {
      mazzetta.setMazzettaColorataCollection(new ArrayList<MazzettaColorata>());
    }
    if (mazzetta.getMazzettaColSingMacCollection() == null) {
      mazzetta.setMazzettaColSingMacCollection(new ArrayList<MazzettaColSingMac>());
    }
    if (mazzetta.getAnagrafeProdottoCollection() == null) {
      mazzetta.setAnagrafeProdottoCollection(new ArrayList<AnagrafeProdotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<MazzettaColorata> attachedMazzettaColorataCollection = new ArrayList<MazzettaColorata>();
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorataToAttach : mazzetta.getMazzettaColorataCollection()) {
        mazzettaColorataCollectionMazzettaColorataToAttach = em.getReference(mazzettaColorataCollectionMazzettaColorataToAttach.getClass(), mazzettaColorataCollectionMazzettaColorataToAttach.getIdMazCol());
        attachedMazzettaColorataCollection.add(mazzettaColorataCollectionMazzettaColorataToAttach);
      }
      mazzetta.setMazzettaColorataCollection(attachedMazzettaColorataCollection);
      Collection<MazzettaColSingMac> attachedMazzettaColSingMacCollection = new ArrayList<MazzettaColSingMac>();
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMacToAttach : mazzetta.getMazzettaColSingMacCollection()) {
        mazzettaColSingMacCollectionMazzettaColSingMacToAttach = em.getReference(mazzettaColSingMacCollectionMazzettaColSingMacToAttach.getClass(), mazzettaColSingMacCollectionMazzettaColSingMacToAttach.getMazzettaColSingMacPK());
        attachedMazzettaColSingMacCollection.add(mazzettaColSingMacCollectionMazzettaColSingMacToAttach);
      }
      mazzetta.setMazzettaColSingMacCollection(attachedMazzettaColSingMacCollection);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollection = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdottoToAttach : mazzetta.getAnagrafeProdottoCollection()) {
        anagrafeProdottoCollectionAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollection.add(anagrafeProdottoCollectionAnagrafeProdottoToAttach);
      }
      mazzetta.setAnagrafeProdottoCollection(attachedAnagrafeProdottoCollection);
      em.persist(mazzetta);
      for (MazzettaColorata mazzettaColorataCollectionMazzettaColorata : mazzetta.getMazzettaColorataCollection()) {
        Mazzetta oldIdMazzettaOfMazzettaColorataCollectionMazzettaColorata = mazzettaColorataCollectionMazzettaColorata.getIdMazzetta();
        mazzettaColorataCollectionMazzettaColorata.setIdMazzetta(mazzetta);
        mazzettaColorataCollectionMazzettaColorata = em.merge(mazzettaColorataCollectionMazzettaColorata);
        if (oldIdMazzettaOfMazzettaColorataCollectionMazzettaColorata != null) {
          oldIdMazzettaOfMazzettaColorataCollectionMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionMazzettaColorata);
          oldIdMazzettaOfMazzettaColorataCollectionMazzettaColorata = em.merge(oldIdMazzettaOfMazzettaColorataCollectionMazzettaColorata);
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMac : mazzetta.getMazzettaColSingMacCollection()) {
        Mazzetta oldIdMazzettaOfMazzettaColSingMacCollectionMazzettaColSingMac = mazzettaColSingMacCollectionMazzettaColSingMac.getIdMazzetta();
        mazzettaColSingMacCollectionMazzettaColSingMac.setIdMazzetta(mazzetta);
        mazzettaColSingMacCollectionMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionMazzettaColSingMac);
        if (oldIdMazzettaOfMazzettaColSingMacCollectionMazzettaColSingMac != null) {
          oldIdMazzettaOfMazzettaColSingMacCollectionMazzettaColSingMac.getMazzettaColSingMacCollection().remove(mazzettaColSingMacCollectionMazzettaColSingMac);
          oldIdMazzettaOfMazzettaColSingMacCollectionMazzettaColSingMac = em.merge(oldIdMazzettaOfMazzettaColSingMacCollectionMazzettaColSingMac);
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdotto : mazzetta.getAnagrafeProdottoCollection()) {
        Mazzetta oldIdMazzettaOfAnagrafeProdottoCollectionAnagrafeProdotto = anagrafeProdottoCollectionAnagrafeProdotto.getIdMazzetta();
        anagrafeProdottoCollectionAnagrafeProdotto.setIdMazzetta(mazzetta);
        anagrafeProdottoCollectionAnagrafeProdotto = em.merge(anagrafeProdottoCollectionAnagrafeProdotto);
        if (oldIdMazzettaOfAnagrafeProdottoCollectionAnagrafeProdotto != null) {
          oldIdMazzettaOfAnagrafeProdottoCollectionAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionAnagrafeProdotto);
          oldIdMazzettaOfAnagrafeProdottoCollectionAnagrafeProdotto = em.merge(oldIdMazzettaOfAnagrafeProdottoCollectionAnagrafeProdotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Mazzetta mazzetta) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Mazzetta persistentMazzetta = em.find(Mazzetta.class, mazzetta.getIdMazzetta());
      Collection<MazzettaColorata> mazzettaColorataCollectionOld = persistentMazzetta.getMazzettaColorataCollection();
      Collection<MazzettaColorata> mazzettaColorataCollectionNew = mazzetta.getMazzettaColorataCollection();
      Collection<MazzettaColSingMac> mazzettaColSingMacCollectionOld = persistentMazzetta.getMazzettaColSingMacCollection();
      Collection<MazzettaColSingMac> mazzettaColSingMacCollectionNew = mazzetta.getMazzettaColSingMacCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOld = persistentMazzetta.getAnagrafeProdottoCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionNew = mazzetta.getAnagrafeProdottoCollection();
      List<String> illegalOrphanMessages = null;
      for (MazzettaColorata mazzettaColorataCollectionOldMazzettaColorata : mazzettaColorataCollectionOld) {
        if (!mazzettaColorataCollectionNew.contains(mazzettaColorataCollectionOldMazzettaColorata)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain MazzettaColorata " + mazzettaColorataCollectionOldMazzettaColorata + " since its idMazzetta field is not nullable.");
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionOldAnagrafeProdotto : anagrafeProdottoCollectionOld) {
        if (!anagrafeProdottoCollectionNew.contains(anagrafeProdottoCollectionOldAnagrafeProdotto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain AnagrafeProdotto " + anagrafeProdottoCollectionOldAnagrafeProdotto + " since its idMazzetta field is not nullable.");
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
      mazzetta.setMazzettaColorataCollection(mazzettaColorataCollectionNew);
      Collection<MazzettaColSingMac> attachedMazzettaColSingMacCollectionNew = new ArrayList<MazzettaColSingMac>();
      for (MazzettaColSingMac mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach : mazzettaColSingMacCollectionNew) {
        mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach = em.getReference(mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach.getClass(), mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach.getMazzettaColSingMacPK());
        attachedMazzettaColSingMacCollectionNew.add(mazzettaColSingMacCollectionNewMazzettaColSingMacToAttach);
      }
      mazzettaColSingMacCollectionNew = attachedMazzettaColSingMacCollectionNew;
      mazzetta.setMazzettaColSingMacCollection(mazzettaColSingMacCollectionNew);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollectionNew = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdottoToAttach : anagrafeProdottoCollectionNew) {
        anagrafeProdottoCollectionNewAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollectionNew.add(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach);
      }
      anagrafeProdottoCollectionNew = attachedAnagrafeProdottoCollectionNew;
      mazzetta.setAnagrafeProdottoCollection(anagrafeProdottoCollectionNew);
      mazzetta = em.merge(mazzetta);
      for (MazzettaColorata mazzettaColorataCollectionNewMazzettaColorata : mazzettaColorataCollectionNew) {
        if (!mazzettaColorataCollectionOld.contains(mazzettaColorataCollectionNewMazzettaColorata)) {
          Mazzetta oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata = mazzettaColorataCollectionNewMazzettaColorata.getIdMazzetta();
          mazzettaColorataCollectionNewMazzettaColorata.setIdMazzetta(mazzetta);
          mazzettaColorataCollectionNewMazzettaColorata = em.merge(mazzettaColorataCollectionNewMazzettaColorata);
          if (oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata != null && !oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata.equals(mazzetta)) {
            oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata.getMazzettaColorataCollection().remove(mazzettaColorataCollectionNewMazzettaColorata);
            oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata = em.merge(oldIdMazzettaOfMazzettaColorataCollectionNewMazzettaColorata);
          }
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionOldMazzettaColSingMac : mazzettaColSingMacCollectionOld) {
        if (!mazzettaColSingMacCollectionNew.contains(mazzettaColSingMacCollectionOldMazzettaColSingMac)) {
          mazzettaColSingMacCollectionOldMazzettaColSingMac.setIdMazzetta(null);
          mazzettaColSingMacCollectionOldMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionOldMazzettaColSingMac);
        }
      }
      for (MazzettaColSingMac mazzettaColSingMacCollectionNewMazzettaColSingMac : mazzettaColSingMacCollectionNew) {
        if (!mazzettaColSingMacCollectionOld.contains(mazzettaColSingMacCollectionNewMazzettaColSingMac)) {
          Mazzetta oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac = mazzettaColSingMacCollectionNewMazzettaColSingMac.getIdMazzetta();
          mazzettaColSingMacCollectionNewMazzettaColSingMac.setIdMazzetta(mazzetta);
          mazzettaColSingMacCollectionNewMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionNewMazzettaColSingMac);
          if (oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac != null && !oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac.equals(mazzetta)) {
            oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac.getMazzettaColSingMacCollection().remove(mazzettaColSingMacCollectionNewMazzettaColSingMac);
            oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac = em.merge(oldIdMazzettaOfMazzettaColSingMacCollectionNewMazzettaColSingMac);
          }
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdotto : anagrafeProdottoCollectionNew) {
        if (!anagrafeProdottoCollectionOld.contains(anagrafeProdottoCollectionNewAnagrafeProdotto)) {
          Mazzetta oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto = anagrafeProdottoCollectionNewAnagrafeProdotto.getIdMazzetta();
          anagrafeProdottoCollectionNewAnagrafeProdotto.setIdMazzetta(mazzetta);
          anagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(anagrafeProdottoCollectionNewAnagrafeProdotto);
          if (oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto != null && !oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto.equals(mazzetta)) {
            oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionNewAnagrafeProdotto);
            oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(oldIdMazzettaOfAnagrafeProdottoCollectionNewAnagrafeProdotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = mazzetta.getIdMazzetta();
        if (findMazzetta(id) == null) {
          throw new NonexistentEntityException("The mazzetta with id " + id + " no longer exists.");
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
      Mazzetta mazzetta;
      try {
        mazzetta = em.getReference(Mazzetta.class, id);
        mazzetta.getIdMazzetta();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The mazzetta with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<MazzettaColorata> mazzettaColorataCollectionOrphanCheck = mazzetta.getMazzettaColorataCollection();
      for (MazzettaColorata mazzettaColorataCollectionOrphanCheckMazzettaColorata : mazzettaColorataCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Mazzetta (" + mazzetta + ") cannot be destroyed since the MazzettaColorata " + mazzettaColorataCollectionOrphanCheckMazzettaColorata + " in its mazzettaColorataCollection field has a non-nullable idMazzetta field.");
      }
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOrphanCheck = mazzetta.getAnagrafeProdottoCollection();
      for (AnagrafeProdotto anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto : anagrafeProdottoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Mazzetta (" + mazzetta + ") cannot be destroyed since the AnagrafeProdotto " + anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto + " in its anagrafeProdottoCollection field has a non-nullable idMazzetta field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<MazzettaColSingMac> mazzettaColSingMacCollection = mazzetta.getMazzettaColSingMacCollection();
      for (MazzettaColSingMac mazzettaColSingMacCollectionMazzettaColSingMac : mazzettaColSingMacCollection) {
        mazzettaColSingMacCollectionMazzettaColSingMac.setIdMazzetta(null);
        mazzettaColSingMacCollectionMazzettaColSingMac = em.merge(mazzettaColSingMacCollectionMazzettaColSingMac);
      }
      em.remove(mazzetta);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Mazzetta> findMazzettaEntities() {
    return findMazzettaEntities(true, -1, -1);
  }

  public List<Mazzetta> findMazzettaEntities(int maxResults, int firstResult) {
    return findMazzettaEntities(false, maxResults, firstResult);
  }

  private List<Mazzetta> findMazzettaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Mazzetta as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Mazzetta findMazzetta(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Mazzetta.class, id);
    } finally {
      em.close();
    }
  }

  public int getMazzettaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Mazzetta as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
   public Collection<Mazzetta> findMazzettaNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Mazzetta.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
