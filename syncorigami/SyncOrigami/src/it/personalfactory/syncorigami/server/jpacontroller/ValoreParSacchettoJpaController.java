/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Categoria;
import it.personalfactory.syncorigami.server.entity.NumSacchetto;
import it.personalfactory.syncorigami.server.entity.ParametroSacchetto;
import it.personalfactory.syncorigami.server.entity.ValoreParSacchetto;
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
public class ValoreParSacchettoJpaController implements Serializable {

  public ValoreParSacchettoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ValoreParSacchetto valoreParSacchetto) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Categoria idCat = valoreParSacchetto.getIdCat();
      if (idCat != null) {
        idCat = em.getReference(idCat.getClass(), idCat.getIdCat());
        valoreParSacchetto.setIdCat(idCat);
      }
      NumSacchetto idNumSac = valoreParSacchetto.getIdNumSac();
      if (idNumSac != null) {
        idNumSac = em.getReference(idNumSac.getClass(), idNumSac.getIdNumSac());
        valoreParSacchetto.setIdNumSac(idNumSac);
      }
      ParametroSacchetto idParSac = valoreParSacchetto.getIdParSac();
      if (idParSac != null) {
        idParSac = em.getReference(idParSac.getClass(), idParSac.getIdParSac());
        valoreParSacchetto.setIdParSac(idParSac);
      }
      em.persist(valoreParSacchetto);
      if (idCat != null) {
        idCat.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idCat = em.merge(idCat);
      }
      if (idNumSac != null) {
        idNumSac.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idNumSac = em.merge(idNumSac);
      }
      if (idParSac != null) {
        idParSac.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idParSac = em.merge(idParSac);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ValoreParSacchetto valoreParSacchetto) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ValoreParSacchetto persistentValoreParSacchetto = em.find(ValoreParSacchetto.class, valoreParSacchetto.getIdValParSac());
      Categoria idCatOld = persistentValoreParSacchetto.getIdCat();
      Categoria idCatNew = valoreParSacchetto.getIdCat();
      NumSacchetto idNumSacOld = persistentValoreParSacchetto.getIdNumSac();
      NumSacchetto idNumSacNew = valoreParSacchetto.getIdNumSac();
      ParametroSacchetto idParSacOld = persistentValoreParSacchetto.getIdParSac();
      ParametroSacchetto idParSacNew = valoreParSacchetto.getIdParSac();
      if (idCatNew != null) {
        idCatNew = em.getReference(idCatNew.getClass(), idCatNew.getIdCat());
        valoreParSacchetto.setIdCat(idCatNew);
      }
      if (idNumSacNew != null) {
        idNumSacNew = em.getReference(idNumSacNew.getClass(), idNumSacNew.getIdNumSac());
        valoreParSacchetto.setIdNumSac(idNumSacNew);
      }
      if (idParSacNew != null) {
        idParSacNew = em.getReference(idParSacNew.getClass(), idParSacNew.getIdParSac());
        valoreParSacchetto.setIdParSac(idParSacNew);
      }
      valoreParSacchetto = em.merge(valoreParSacchetto);
      if (idCatOld != null && !idCatOld.equals(idCatNew)) {
        idCatOld.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idCatOld = em.merge(idCatOld);
      }
      if (idCatNew != null && !idCatNew.equals(idCatOld)) {
        idCatNew.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idCatNew = em.merge(idCatNew);
      }
      if (idNumSacOld != null && !idNumSacOld.equals(idNumSacNew)) {
        idNumSacOld.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idNumSacOld = em.merge(idNumSacOld);
      }
      if (idNumSacNew != null && !idNumSacNew.equals(idNumSacOld)) {
        idNumSacNew.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idNumSacNew = em.merge(idNumSacNew);
      }
      if (idParSacOld != null && !idParSacOld.equals(idParSacNew)) {
        idParSacOld.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idParSacOld = em.merge(idParSacOld);
      }
      if (idParSacNew != null && !idParSacNew.equals(idParSacOld)) {
        idParSacNew.getValoreParSacchettoCollection().add(valoreParSacchetto);
        idParSacNew = em.merge(idParSacNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = valoreParSacchetto.getIdValParSac();
        if (findValoreParSacchetto(id) == null) {
          throw new NonexistentEntityException("The valoreParSacchetto with id " + id + " no longer exists.");
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
      ValoreParSacchetto valoreParSacchetto;
      try {
        valoreParSacchetto = em.getReference(ValoreParSacchetto.class, id);
        valoreParSacchetto.getIdValParSac();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The valoreParSacchetto with id " + id + " no longer exists.", enfe);
      }
      Categoria idCat = valoreParSacchetto.getIdCat();
      if (idCat != null) {
        idCat.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idCat = em.merge(idCat);
      }
      NumSacchetto idNumSac = valoreParSacchetto.getIdNumSac();
      if (idNumSac != null) {
        idNumSac.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idNumSac = em.merge(idNumSac);
      }
      ParametroSacchetto idParSac = valoreParSacchetto.getIdParSac();
      if (idParSac != null) {
        idParSac.getValoreParSacchettoCollection().remove(valoreParSacchetto);
        idParSac = em.merge(idParSac);
      }
      em.remove(valoreParSacchetto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ValoreParSacchetto> findValoreParSacchettoEntities() {
    return findValoreParSacchettoEntities(true, -1, -1);
  }

  public List<ValoreParSacchetto> findValoreParSacchettoEntities(int maxResults, int firstResult) {
    return findValoreParSacchettoEntities(false, maxResults, firstResult);
  }

  private List<ValoreParSacchetto> findValoreParSacchettoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ValoreParSacchetto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ValoreParSacchetto findValoreParSacchetto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreParSacchetto.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreParSacchettoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreParSacchetto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<ValoreParSacchetto> findValoreParSacchettoNew(Date dt_ult_agg){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParSacchetto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
