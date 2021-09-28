/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.OrdineElenco;
import it.personalfactory.syncorigami.server.entity.OrdineSingMac;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class OrdineSingMacJpaController implements Serializable {
    
    Logger log = Logger.getLogger(OrdineSingMacJpaController.class);
    
    public OrdineSingMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;
    
    
    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(OrdineSingMac ordineSingMac) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            OrdineElenco idOrdine = ordineSingMac.getIdOrdine();
            if (idOrdine != null) {
                idOrdine = em.getReference(idOrdine.getClass(), idOrdine.getIdOrdine());
                ordineSingMac.setIdOrdine(idOrdine);
            }
            em.persist(ordineSingMac);
            if (idOrdine != null) {
                idOrdine.getOrdineSingMacCollection().add(ordineSingMac);
                idOrdine = em.merge(idOrdine);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(OrdineSingMac ordineSingMac) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            OrdineSingMac persistentOrdineSingMac = em.find(OrdineSingMac.class, ordineSingMac.getIdOrdineSm());
            OrdineElenco idOrdineOld = persistentOrdineSingMac.getIdOrdine();
            OrdineElenco idOrdineNew = ordineSingMac.getIdOrdine();
            if (idOrdineNew != null) {
                idOrdineNew = em.getReference(idOrdineNew.getClass(), idOrdineNew.getIdOrdine());
                ordineSingMac.setIdOrdine(idOrdineNew);
            }
            ordineSingMac = em.merge(ordineSingMac);
            if (idOrdineOld != null && !idOrdineOld.equals(idOrdineNew)) {
                idOrdineOld.getOrdineSingMacCollection().remove(ordineSingMac);
                idOrdineOld = em.merge(idOrdineOld);
            }
            if (idOrdineNew != null && !idOrdineNew.equals(idOrdineOld)) {
                idOrdineNew.getOrdineSingMacCollection().add(ordineSingMac);
                idOrdineNew = em.merge(idOrdineNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = ordineSingMac.getIdOrdineSm();
                if (findOrdineSingMac(id) == null) {
                    throw new NonexistentEntityException("The ordineSingMac with id " + id + " no longer exists.");
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
            OrdineSingMac ordineSingMac;
            try {
                ordineSingMac = em.getReference(OrdineSingMac.class, id);
                ordineSingMac.getIdOrdineSm();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The ordineSingMac with id " + id + " no longer exists.", enfe);
            }
            OrdineElenco idOrdine = ordineSingMac.getIdOrdine();
            if (idOrdine != null) {
                idOrdine.getOrdineSingMacCollection().remove(ordineSingMac);
                idOrdine = em.merge(idOrdine);
            }
            em.remove(ordineSingMac);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<OrdineSingMac> findOrdineSingMacEntities() {
        return findOrdineSingMacEntities(true, -1, -1);
    }

    public List<OrdineSingMac> findOrdineSingMacEntities(int maxResults, int firstResult) {
        return findOrdineSingMacEntities(false, maxResults, firstResult);
    }

    private List<OrdineSingMac> findOrdineSingMacEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from OrdineSingMac as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public OrdineSingMac findOrdineSingMac(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(OrdineSingMac.class, id);
        } finally {
            em.close();
        }
    }

    public int getOrdineSingMacCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from OrdineSingMac as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    public Collection<OrdineSingMac> findOrdineSingMacNew(Date dt_ult_agg,Integer idMacchina){
         
     EntityManager em = getEntityManager();
     try{
      Query q = em.createNamedQuery("OrdineSingMac.findDatiNuovi");
      q.setParameter ("dtAbilitato",dt_ult_agg);
      q.setParameter ("idMacchina",idMacchina);
     
      return   q.getResultList();
     
     } finally {
      em.close();
    } 
        
  }    
    
}
