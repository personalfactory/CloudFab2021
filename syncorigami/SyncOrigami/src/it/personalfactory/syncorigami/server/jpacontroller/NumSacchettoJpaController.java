/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Categoria;
import it.personalfactory.syncorigami.server.entity.NumSacchetto;
import it.personalfactory.syncorigami.server.entity.ValoreParSacchetto;
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
public class NumSacchettoJpaController implements Serializable {

  public NumSacchettoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(NumSacchetto numSacchetto) {
    if (numSacchetto.getValoreParSacchettoCollection() == null) {
      numSacchetto.setValoreParSacchettoCollection(new ArrayList<ValoreParSacchetto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Categoria idCat = numSacchetto.getIdCat();
      if (idCat != null) {
        idCat = em.getReference(idCat.getClass(), idCat.getIdCat());
        numSacchetto.setIdCat(idCat);
      }
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollection = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchettoToAttach : numSacchetto.getValoreParSacchettoCollection()) {
        valoreParSacchettoCollectionValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollection.add(valoreParSacchettoCollectionValoreParSacchettoToAttach);
      }
      numSacchetto.setValoreParSacchettoCollection(attachedValoreParSacchettoCollection);
      em.persist(numSacchetto);
      if (idCat != null) {
        idCat.getNumSacchettoCollection().add(numSacchetto);
        idCat = em.merge(idCat);
      }
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchetto : numSacchetto.getValoreParSacchettoCollection()) {
        NumSacchetto oldIdNumSacOfValoreParSacchettoCollectionValoreParSacchetto = valoreParSacchettoCollectionValoreParSacchetto.getIdNumSac();
        valoreParSacchettoCollectionValoreParSacchetto.setIdNumSac(numSacchetto);
        valoreParSacchettoCollectionValoreParSacchetto = em.merge(valoreParSacchettoCollectionValoreParSacchetto);
        if (oldIdNumSacOfValoreParSacchettoCollectionValoreParSacchetto != null) {
          oldIdNumSacOfValoreParSacchettoCollectionValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionValoreParSacchetto);
          oldIdNumSacOfValoreParSacchettoCollectionValoreParSacchetto = em.merge(oldIdNumSacOfValoreParSacchettoCollectionValoreParSacchetto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(NumSacchetto numSacchetto) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      NumSacchetto persistentNumSacchetto = em.find(NumSacchetto.class, numSacchetto.getIdNumSac());
      Categoria idCatOld = persistentNumSacchetto.getIdCat();
      Categoria idCatNew = numSacchetto.getIdCat();
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionOld = persistentNumSacchetto.getValoreParSacchettoCollection();
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionNew = numSacchetto.getValoreParSacchettoCollection();
      if (idCatNew != null) {
        idCatNew = em.getReference(idCatNew.getClass(), idCatNew.getIdCat());
        numSacchetto.setIdCat(idCatNew);
      }
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollectionNew = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchettoToAttach : valoreParSacchettoCollectionNew) {
        valoreParSacchettoCollectionNewValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollectionNew.add(valoreParSacchettoCollectionNewValoreParSacchettoToAttach);
      }
      valoreParSacchettoCollectionNew = attachedValoreParSacchettoCollectionNew;
      numSacchetto.setValoreParSacchettoCollection(valoreParSacchettoCollectionNew);
      numSacchetto = em.merge(numSacchetto);
      if (idCatOld != null && !idCatOld.equals(idCatNew)) {
        idCatOld.getNumSacchettoCollection().remove(numSacchetto);
        idCatOld = em.merge(idCatOld);
      }
      if (idCatNew != null && !idCatNew.equals(idCatOld)) {
        idCatNew.getNumSacchettoCollection().add(numSacchetto);
        idCatNew = em.merge(idCatNew);
      }
      for (ValoreParSacchetto valoreParSacchettoCollectionOldValoreParSacchetto : valoreParSacchettoCollectionOld) {
        if (!valoreParSacchettoCollectionNew.contains(valoreParSacchettoCollectionOldValoreParSacchetto)) {
          valoreParSacchettoCollectionOldValoreParSacchetto.setIdNumSac(null);
          valoreParSacchettoCollectionOldValoreParSacchetto = em.merge(valoreParSacchettoCollectionOldValoreParSacchetto);
        }
      }
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchetto : valoreParSacchettoCollectionNew) {
        if (!valoreParSacchettoCollectionOld.contains(valoreParSacchettoCollectionNewValoreParSacchetto)) {
          NumSacchetto oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto = valoreParSacchettoCollectionNewValoreParSacchetto.getIdNumSac();
          valoreParSacchettoCollectionNewValoreParSacchetto.setIdNumSac(numSacchetto);
          valoreParSacchettoCollectionNewValoreParSacchetto = em.merge(valoreParSacchettoCollectionNewValoreParSacchetto);
          if (oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto != null && !oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto.equals(numSacchetto)) {
            oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionNewValoreParSacchetto);
            oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto = em.merge(oldIdNumSacOfValoreParSacchettoCollectionNewValoreParSacchetto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = numSacchetto.getIdNumSac();
        if (findNumSacchetto(id) == null) {
          throw new NonexistentEntityException("The numSacchetto with id " + id + " no longer exists.");
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
      NumSacchetto numSacchetto;
      try {
        numSacchetto = em.getReference(NumSacchetto.class, id);
        numSacchetto.getIdNumSac();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The numSacchetto with id " + id + " no longer exists.", enfe);
      }
      Categoria idCat = numSacchetto.getIdCat();
      if (idCat != null) {
        idCat.getNumSacchettoCollection().remove(numSacchetto);
        idCat = em.merge(idCat);
      }
      Collection<ValoreParSacchetto> valoreParSacchettoCollection = numSacchetto.getValoreParSacchettoCollection();
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchetto : valoreParSacchettoCollection) {
        valoreParSacchettoCollectionValoreParSacchetto.setIdNumSac(null);
        valoreParSacchettoCollectionValoreParSacchetto = em.merge(valoreParSacchettoCollectionValoreParSacchetto);
      }
      em.remove(numSacchetto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<NumSacchetto> findNumSacchettoEntities() {
    return findNumSacchettoEntities(true, -1, -1);
  }

  public List<NumSacchetto> findNumSacchettoEntities(int maxResults, int firstResult) {
    return findNumSacchettoEntities(false, maxResults, firstResult);
  }

  private List<NumSacchetto> findNumSacchettoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from NumSacchetto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public NumSacchetto findNumSacchetto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(NumSacchetto.class, id);
    } finally {
      em.close();
    }
  }

  public int getNumSacchettoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from NumSacchetto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<NumSacchetto> findNumSacchettoNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("NumSacchetto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
