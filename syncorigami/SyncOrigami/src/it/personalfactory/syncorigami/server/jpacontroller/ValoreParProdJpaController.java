/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Categoria;
import it.personalfactory.syncorigami.server.entity.ParametroProdotto;
import it.personalfactory.syncorigami.server.entity.ValoreParProd;
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
public class ValoreParProdJpaController implements Serializable {

  public ValoreParProdJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ValoreParProd valoreParProd) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Categoria idCat = valoreParProd.getIdCat();
      if (idCat != null) {
        idCat = em.getReference(idCat.getClass(), idCat.getIdCat());
        valoreParProd.setIdCat(idCat);
      }
      ParametroProdotto idParProd = valoreParProd.getIdParProd();
      if (idParProd != null) {
        idParProd = em.getReference(idParProd.getClass(), idParProd.getIdParProd());
        valoreParProd.setIdParProd(idParProd);
      }
      em.persist(valoreParProd);
      if (idCat != null) {
        idCat.getValoreParProdCollection().add(valoreParProd);
        idCat = em.merge(idCat);
      }
      if (idParProd != null) {
        idParProd.getValoreParProdCollection().add(valoreParProd);
        idParProd = em.merge(idParProd);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ValoreParProd valoreParProd) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ValoreParProd persistentValoreParProd = em.find(ValoreParProd.class, valoreParProd.getIdValParPr());
      Categoria idCatOld = persistentValoreParProd.getIdCat();
      Categoria idCatNew = valoreParProd.getIdCat();
      ParametroProdotto idParProdOld = persistentValoreParProd.getIdParProd();
      ParametroProdotto idParProdNew = valoreParProd.getIdParProd();
      if (idCatNew != null) {
        idCatNew = em.getReference(idCatNew.getClass(), idCatNew.getIdCat());
        valoreParProd.setIdCat(idCatNew);
      }
      if (idParProdNew != null) {
        idParProdNew = em.getReference(idParProdNew.getClass(), idParProdNew.getIdParProd());
        valoreParProd.setIdParProd(idParProdNew);
      }
      valoreParProd = em.merge(valoreParProd);
      if (idCatOld != null && !idCatOld.equals(idCatNew)) {
        idCatOld.getValoreParProdCollection().remove(valoreParProd);
        idCatOld = em.merge(idCatOld);
      }
      if (idCatNew != null && !idCatNew.equals(idCatOld)) {
        idCatNew.getValoreParProdCollection().add(valoreParProd);
        idCatNew = em.merge(idCatNew);
      }
      if (idParProdOld != null && !idParProdOld.equals(idParProdNew)) {
        idParProdOld.getValoreParProdCollection().remove(valoreParProd);
        idParProdOld = em.merge(idParProdOld);
      }
      if (idParProdNew != null && !idParProdNew.equals(idParProdOld)) {
        idParProdNew.getValoreParProdCollection().add(valoreParProd);
        idParProdNew = em.merge(idParProdNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = valoreParProd.getIdValParPr();
        if (findValoreParProd(id) == null) {
          throw new NonexistentEntityException("The valoreParProd with id " + id + " no longer exists.");
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
      ValoreParProd valoreParProd;
      try {
        valoreParProd = em.getReference(ValoreParProd.class, id);
        valoreParProd.getIdValParPr();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The valoreParProd with id " + id + " no longer exists.", enfe);
      }
      Categoria idCat = valoreParProd.getIdCat();
      if (idCat != null) {
        idCat.getValoreParProdCollection().remove(valoreParProd);
        idCat = em.merge(idCat);
      }
      ParametroProdotto idParProd = valoreParProd.getIdParProd();
      if (idParProd != null) {
        idParProd.getValoreParProdCollection().remove(valoreParProd);
        idParProd = em.merge(idParProd);
      }
      em.remove(valoreParProd);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ValoreParProd> findValoreParProdEntities() {
    return findValoreParProdEntities(true, -1, -1);
  }

  public List<ValoreParProd> findValoreParProdEntities(int maxResults, int firstResult) {
    return findValoreParProdEntities(false, maxResults, firstResult);
  }

  private List<ValoreParProd> findValoreParProdEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ValoreParProd as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ValoreParProd findValoreParProd(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreParProd.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreParProdCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreParProd as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   public Collection<ValoreParProd> findValoreParProdNew(Date dt_ult_agg){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParProd.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
