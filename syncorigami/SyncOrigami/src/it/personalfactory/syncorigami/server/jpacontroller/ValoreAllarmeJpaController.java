/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ValoreAllarme;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class ValoreAllarmeJpaController implements Serializable {

    Logger log = Logger.getLogger(ValoreAllarmeJpaController.class);
    
    public ValoreAllarmeJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private EntityManagerFactory emf = null;
    private UserTransaction utx = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ValoreAllarme valoreAllarme) throws PreexistingEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(valoreAllarme);
            em.getTransaction().commit();
        } catch (Exception ex) {
            if (findValoreAllarme(valoreAllarme.getId()) != null) {
                throw new PreexistingEntityException("ValoreAllarme " + valoreAllarme + " already exists.", ex);
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ValoreAllarme valoreAllarme) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            valoreAllarme = em.merge(valoreAllarme);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = valoreAllarme.getId();
                if (findValoreAllarme(id) == null) {
                    throw new NonexistentEntityException("The valoreAllarme with id " + id + " no longer exists.");
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
            ValoreAllarme valoreAllarme;
            try {
                valoreAllarme = em.getReference(ValoreAllarme.class, id);
                valoreAllarme.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The valoreAllarme with id " + id + " no longer exists.", enfe);
            }
            em.remove(valoreAllarme);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ValoreAllarme> findValoreAllarmeEntities() {
        return findValoreAllarmeEntities(true, -1, -1);
    }

    public List<ValoreAllarme> findValoreAllarmeEntities(int maxResults, int firstResult) {
        return findValoreAllarmeEntities(false, maxResults, firstResult);
    }

    private List<ValoreAllarme> findValoreAllarmeEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ValoreAllarme as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ValoreAllarme findValoreAllarme(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ValoreAllarme.class, id);
        } finally {
            em.close();
        }
    }

    public int getValoreAllarmeCount(){
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ValoreAllarme as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
   
    }
            
}
