/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ComponentePesatura;
import it.personalfactory.syncorigami.server.entity.Prodotto;
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
public class ComponentePesaturaJpaController implements Serializable {

   public ComponentePesaturaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ComponentePesatura componentePesatura) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(componentePesatura);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ComponentePesatura componentePesatura) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            componentePesatura = em.merge(componentePesatura);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = componentePesatura.getId();
                if (findComponentePesatura(id) == null) {
                    throw new NonexistentEntityException("The componentePesatura with id " + id + " no longer exists.");
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
            ComponentePesatura componentePesatura;
            try {
                componentePesatura = em.getReference(ComponentePesatura.class, id);
                componentePesatura.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The componentePesatura with id " + id + " no longer exists.", enfe);
            }
            em.remove(componentePesatura);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ComponentePesatura> findComponentePesaturaEntities() {
        return findComponentePesaturaEntities(true, -1, -1);
    }

    public List<ComponentePesatura> findComponentePesaturaEntities(int maxResults, int firstResult) {
        return findComponentePesaturaEntities(false, maxResults, firstResult);
    }

    private List<ComponentePesatura> findComponentePesaturaEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ComponentePesatura as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ComponentePesatura findComponentePesatura(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ComponentePesatura.class, id);
        } finally {
            em.close();
        }
    }

    public int getComponentePesaturaCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ComponentePesatura as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    public Collection<ComponentePesatura> findComponentePesaturaIdProd(Prodotto prodotto){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ComponentePesatura.findByIdProdotto");
      
       q.setParameter ("idProdotto",prodotto.getIdProdotto());
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }
    
     
    public Collection<ComponentePesatura> findComponentePesaturaNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ComponentePesatura.findDatiNuovi");
      
       q.setParameter ("dtAbilitato",dtUltAgg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }

}
