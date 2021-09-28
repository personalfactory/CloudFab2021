/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Allarme;
import it.personalfactory.syncorigami.server.entity.Presa;
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
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class AllarmeJpaController implements Serializable {

    
    private Logger log = Logger.getLogger(AllarmeJpaController.class);
    
    public AllarmeJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Allarme allarme) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(allarme);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Allarme allarme) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            allarme = em.merge(allarme);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = allarme.getIdAllarme();
                if (findAllarme(id) == null) {
                    throw new NonexistentEntityException("The allarme with id " + id + " no longer exists.");
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
            Allarme allarme;
            try {
                allarme = em.getReference(Allarme.class, id);
                allarme.getIdAllarme();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The allarme with id " + id + " no longer exists.", enfe);
            }
            em.remove(allarme);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Allarme> findAllarmeEntities() {
        return findAllarmeEntities(true, -1, -1);
    }

    public List<Allarme> findAllarmeEntities(int maxResults, int firstResult) {
        return findAllarmeEntities(false, maxResults, firstResult);
    }

    private List<Allarme> findAllarmeEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from Allarme as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public Allarme findAllarme(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Allarme.class, id);
        } finally {
            em.close();
        }
    }

    public int getAllarmeCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from Allarme as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    public Collection<Allarme> findAllarmeNew(Date dt_ult_agg) {

    EntityManager em = getEntityManager();
    try {

      Query q = em.createNamedQuery("Allarme.findDatiNuovi");
      q.setParameter("dtAbilitato", dt_ult_agg);

      return q.getResultList();

    } finally {
      em.close();
    }

  }
    
    
}
