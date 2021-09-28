/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ParametroOrdine;
import it.personalfactory.syncorigami.server.entity.ValoreParOrdine;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ValoreParOrdineJpaController implements Serializable {

    public ValoreParOrdineJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ValoreParOrdine valoreParOrdine) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ParametroOrdine idParOrdine = valoreParOrdine.getIdParOrdine();
            if (idParOrdine != null) {
                idParOrdine = em.getReference(idParOrdine.getClass(), idParOrdine.getIdParOrdine());
                valoreParOrdine.setIdParOrdine(idParOrdine);
            }
            em.persist(valoreParOrdine);
            if (idParOrdine != null) {
                idParOrdine.getValoreParOrdineCollection().add(valoreParOrdine);
                idParOrdine = em.merge(idParOrdine);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ValoreParOrdine valoreParOrdine) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ValoreParOrdine persistentValoreParOrdine = em.find(ValoreParOrdine.class, valoreParOrdine.getId());
            ParametroOrdine idParOrdineOld = persistentValoreParOrdine.getIdParOrdine();
            ParametroOrdine idParOrdineNew = valoreParOrdine.getIdParOrdine();
            if (idParOrdineNew != null) {
                idParOrdineNew = em.getReference(idParOrdineNew.getClass(), idParOrdineNew.getIdParOrdine());
                valoreParOrdine.setIdParOrdine(idParOrdineNew);
            }
            valoreParOrdine = em.merge(valoreParOrdine);
            if (idParOrdineOld != null && !idParOrdineOld.equals(idParOrdineNew)) {
                idParOrdineOld.getValoreParOrdineCollection().remove(valoreParOrdine);
                idParOrdineOld = em.merge(idParOrdineOld);
            }
            if (idParOrdineNew != null && !idParOrdineNew.equals(idParOrdineOld)) {
                idParOrdineNew.getValoreParOrdineCollection().add(valoreParOrdine);
                idParOrdineNew = em.merge(idParOrdineNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = valoreParOrdine.getId();
                if (findValoreParOrdine(id) == null) {
                    throw new NonexistentEntityException("The valoreParOrdine with id " + id + " no longer exists.");
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
            ValoreParOrdine valoreParOrdine;
            try {
                valoreParOrdine = em.getReference(ValoreParOrdine.class, id);
                valoreParOrdine.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The valoreParOrdine with id " + id + " no longer exists.", enfe);
            }
            ParametroOrdine idParOrdine = valoreParOrdine.getIdParOrdine();
            if (idParOrdine != null) {
                idParOrdine.getValoreParOrdineCollection().remove(valoreParOrdine);
                idParOrdine = em.merge(idParOrdine);
            }
            em.remove(valoreParOrdine);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ValoreParOrdine> findValoreParOrdineEntities() {
        return findValoreParOrdineEntities(true, -1, -1);
    }

    public List<ValoreParOrdine> findValoreParOrdineEntities(int maxResults, int firstResult) {
        return findValoreParOrdineEntities(false, maxResults, firstResult);
    }

    private List<ValoreParOrdine> findValoreParOrdineEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ValoreParOrdine as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ValoreParOrdine findValoreParOrdine(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ValoreParOrdine.class, id);
        } finally {
            em.close();
        }
    }

    public int getValoreParOrdineCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ValoreParOrdine as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    public Collection<ValoreParOrdine> findValoreParOrdineNew(Date dt_ult_agg,Integer idMacchina){
         
     EntityManager em = getEntityManager();
     
     try {   
       Query q = em.createNamedQuery("ValoreParOrdine.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       q.setParameter("idMacchina",idMacchina);
     
       return q.getResultList();
     } finally {
      em.close();
    }   
  }
    
    
    public Collection<ValoreParOrdine> findValoreParOrdineNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParOrdine.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
    
}
