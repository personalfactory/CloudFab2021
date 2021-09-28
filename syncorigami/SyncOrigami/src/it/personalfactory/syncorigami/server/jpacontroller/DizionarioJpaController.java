/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Dizionario;
import it.personalfactory.syncorigami.server.entity.DizionarioTipo;
import it.personalfactory.syncorigami.server.entity.Lingua;
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
public class DizionarioJpaController implements Serializable {

  public DizionarioJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Dizionario dizionario) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      DizionarioTipo idDizTipo = dizionario.getIdDizTipo();
      if (idDizTipo != null) {
        idDizTipo = em.getReference(idDizTipo.getClass(), idDizTipo.getIdDizTipo());
        dizionario.setIdDizTipo(idDizTipo);
      }
      Lingua idLingua = dizionario.getIdLingua();
      if (idLingua != null) {
        idLingua = em.getReference(idLingua.getClass(), idLingua.getIdLingua());
        dizionario.setIdLingua(idLingua);
      }
      em.persist(dizionario);
      if (idDizTipo != null) {
        idDizTipo.getDizionarioCollection().add(dizionario);
        idDizTipo = em.merge(idDizTipo);
      }
      if (idLingua != null) {
        idLingua.getDizionarioCollection().add(dizionario);
        idLingua = em.merge(idLingua);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Dizionario dizionario) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Dizionario persistentDizionario = em.find(Dizionario.class, dizionario.getIdDizionario());
      DizionarioTipo idDizTipoOld = persistentDizionario.getIdDizTipo();
      DizionarioTipo idDizTipoNew = dizionario.getIdDizTipo();
      Lingua idLinguaOld = persistentDizionario.getIdLingua();
      Lingua idLinguaNew = dizionario.getIdLingua();
      if (idDizTipoNew != null) {
        idDizTipoNew = em.getReference(idDizTipoNew.getClass(), idDizTipoNew.getIdDizTipo());
        dizionario.setIdDizTipo(idDizTipoNew);
      }
      if (idLinguaNew != null) {
        idLinguaNew = em.getReference(idLinguaNew.getClass(), idLinguaNew.getIdLingua());
        dizionario.setIdLingua(idLinguaNew);
      }
      dizionario = em.merge(dizionario);
      if (idDizTipoOld != null && !idDizTipoOld.equals(idDizTipoNew)) {
        idDizTipoOld.getDizionarioCollection().remove(dizionario);
        idDizTipoOld = em.merge(idDizTipoOld);
      }
      if (idDizTipoNew != null && !idDizTipoNew.equals(idDizTipoOld)) {
        idDizTipoNew.getDizionarioCollection().add(dizionario);
        idDizTipoNew = em.merge(idDizTipoNew);
      }
      if (idLinguaOld != null && !idLinguaOld.equals(idLinguaNew)) {
        idLinguaOld.getDizionarioCollection().remove(dizionario);
        idLinguaOld = em.merge(idLinguaOld);
      }
      if (idLinguaNew != null && !idLinguaNew.equals(idLinguaOld)) {
        idLinguaNew.getDizionarioCollection().add(dizionario);
        idLinguaNew = em.merge(idLinguaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = dizionario.getIdDizionario();
        if (findDizionario(id) == null) {
          throw new NonexistentEntityException("The dizionario with id " + id + " no longer exists.");
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
      Dizionario dizionario;
      try {
        dizionario = em.getReference(Dizionario.class, id);
        dizionario.getIdDizionario();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The dizionario with id " + id + " no longer exists.", enfe);
      }
      DizionarioTipo idDizTipo = dizionario.getIdDizTipo();
      if (idDizTipo != null) {
        idDizTipo.getDizionarioCollection().remove(dizionario);
        idDizTipo = em.merge(idDizTipo);
      }
      Lingua idLingua = dizionario.getIdLingua();
      if (idLingua != null) {
        idLingua.getDizionarioCollection().remove(dizionario);
        idLingua = em.merge(idLingua);
      }
      em.remove(dizionario);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Dizionario> findDizionarioEntities() {
    return findDizionarioEntities(true, -1, -1);
  }

  public List<Dizionario> findDizionarioEntities(int maxResults, int firstResult) {
    return findDizionarioEntities(false, maxResults, firstResult);
  }

  private List<Dizionario> findDizionarioEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Dizionario as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Dizionario findDizionario(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Dizionario.class, id);
    } finally {
      em.close();
    }
  }

  public int getDizionarioCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Dizionario as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<Dizionario> findDizionarioNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Dizionario.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
