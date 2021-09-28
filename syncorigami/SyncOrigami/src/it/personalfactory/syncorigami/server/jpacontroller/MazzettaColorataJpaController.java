/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Colore;
import it.personalfactory.syncorigami.server.entity.ColoreBase;
import it.personalfactory.syncorigami.server.entity.Mazzetta;
import it.personalfactory.syncorigami.server.entity.MazzettaColorata;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.transaction.UserTransaction;


/**
 *
 * @author marilisa
 */
public class MazzettaColorataJpaController implements Serializable {

  public MazzettaColorataJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(MazzettaColorata mazzettaColorata) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ColoreBase idColoreBase = mazzettaColorata.getIdColoreBase();
      if (idColoreBase != null) {
        idColoreBase = em.getReference(idColoreBase.getClass(), idColoreBase.getIdColoreBase());
        mazzettaColorata.setIdColoreBase(idColoreBase);
      }
      Colore idColore = mazzettaColorata.getIdColore();
      if (idColore != null) {
        idColore = em.getReference(idColore.getClass(), idColore.getIdColore());
        mazzettaColorata.setIdColore(idColore);
      }
      Mazzetta idMazzetta = mazzettaColorata.getIdMazzetta();
      if (idMazzetta != null) {
        idMazzetta = em.getReference(idMazzetta.getClass(), idMazzetta.getIdMazzetta());
        mazzettaColorata.setIdMazzetta(idMazzetta);
      }
      em.persist(mazzettaColorata);
      if (idColoreBase != null) {
        idColoreBase.getMazzettaColorataCollection().add(mazzettaColorata);
        idColoreBase = em.merge(idColoreBase);
      }
      if (idColore != null) {
        idColore.getMazzettaColorataCollection().add(mazzettaColorata);
        idColore = em.merge(idColore);
      }
      if (idMazzetta != null) {
        idMazzetta.getMazzettaColorataCollection().add(mazzettaColorata);
        idMazzetta = em.merge(idMazzetta);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(MazzettaColorata mazzettaColorata) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      MazzettaColorata persistentMazzettaColorata = em.find(MazzettaColorata.class, mazzettaColorata.getIdMazCol());
      ColoreBase idColoreBaseOld = persistentMazzettaColorata.getIdColoreBase();
      ColoreBase idColoreBaseNew = mazzettaColorata.getIdColoreBase();
      Colore idColoreOld = persistentMazzettaColorata.getIdColore();
      Colore idColoreNew = mazzettaColorata.getIdColore();
      Mazzetta idMazzettaOld = persistentMazzettaColorata.getIdMazzetta();
      Mazzetta idMazzettaNew = mazzettaColorata.getIdMazzetta();
      if (idColoreBaseNew != null) {
        idColoreBaseNew = em.getReference(idColoreBaseNew.getClass(), idColoreBaseNew.getIdColoreBase());
        mazzettaColorata.setIdColoreBase(idColoreBaseNew);
      }
      if (idColoreNew != null) {
        idColoreNew = em.getReference(idColoreNew.getClass(), idColoreNew.getIdColore());
        mazzettaColorata.setIdColore(idColoreNew);
      }
      if (idMazzettaNew != null) {
        idMazzettaNew = em.getReference(idMazzettaNew.getClass(), idMazzettaNew.getIdMazzetta());
        mazzettaColorata.setIdMazzetta(idMazzettaNew);
      }
      mazzettaColorata = em.merge(mazzettaColorata);
      if (idColoreBaseOld != null && !idColoreBaseOld.equals(idColoreBaseNew)) {
        idColoreBaseOld.getMazzettaColorataCollection().remove(mazzettaColorata);
        idColoreBaseOld = em.merge(idColoreBaseOld);
      }
      if (idColoreBaseNew != null && !idColoreBaseNew.equals(idColoreBaseOld)) {
        idColoreBaseNew.getMazzettaColorataCollection().add(mazzettaColorata);
        idColoreBaseNew = em.merge(idColoreBaseNew);
      }
      if (idColoreOld != null && !idColoreOld.equals(idColoreNew)) {
        idColoreOld.getMazzettaColorataCollection().remove(mazzettaColorata);
        idColoreOld = em.merge(idColoreOld);
      }
      if (idColoreNew != null && !idColoreNew.equals(idColoreOld)) {
        idColoreNew.getMazzettaColorataCollection().add(mazzettaColorata);
        idColoreNew = em.merge(idColoreNew);
      }
      if (idMazzettaOld != null && !idMazzettaOld.equals(idMazzettaNew)) {
        idMazzettaOld.getMazzettaColorataCollection().remove(mazzettaColorata);
        idMazzettaOld = em.merge(idMazzettaOld);
      }
      if (idMazzettaNew != null && !idMazzettaNew.equals(idMazzettaOld)) {
        idMazzettaNew.getMazzettaColorataCollection().add(mazzettaColorata);
        idMazzettaNew = em.merge(idMazzettaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = mazzettaColorata.getIdMazCol();
        if (findMazzettaColorata(id) == null) {
          throw new NonexistentEntityException("The mazzettaColorata with id " + id + " no longer exists.");
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
      MazzettaColorata mazzettaColorata;
      try {
        mazzettaColorata = em.getReference(MazzettaColorata.class, id);
        mazzettaColorata.getIdMazCol();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The mazzettaColorata with id " + id + " no longer exists.", enfe);
      }
      ColoreBase idColoreBase = mazzettaColorata.getIdColoreBase();
      if (idColoreBase != null) {
        idColoreBase.getMazzettaColorataCollection().remove(mazzettaColorata);
        idColoreBase = em.merge(idColoreBase);
      }
      Colore idColore = mazzettaColorata.getIdColore();
      if (idColore != null) {
        idColore.getMazzettaColorataCollection().remove(mazzettaColorata);
        idColore = em.merge(idColore);
      }
      Mazzetta idMazzetta = mazzettaColorata.getIdMazzetta();
      if (idMazzetta != null) {
        idMazzetta.getMazzettaColorataCollection().remove(mazzettaColorata);
        idMazzetta = em.merge(idMazzetta);
      }
      em.remove(mazzettaColorata);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<MazzettaColorata> findMazzettaColorataEntities() {
    return findMazzettaColorataEntities(true, -1, -1);
  }

  public List<MazzettaColorata> findMazzettaColorataEntities(int maxResults, int firstResult) {
    return findMazzettaColorataEntities(false, maxResults, firstResult);
  }

  private List<MazzettaColorata> findMazzettaColorataEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from MazzettaColorata as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public MazzettaColorata findMazzettaColorata(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(MazzettaColorata.class, id);
    } finally {
      em.close();
    }
  }

  public int getMazzettaColorataCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from MazzettaColorata as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<MazzettaColorata> findMazzettaColorataNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("MazzettaColorata.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
