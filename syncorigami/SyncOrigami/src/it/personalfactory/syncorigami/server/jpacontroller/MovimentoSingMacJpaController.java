/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.MovimentoSingMac;
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
public class MovimentoSingMacJpaController implements Serializable {

   private Logger log = Logger.getLogger(MovimentoSingMacJpaController.class);
    
    public MovimentoSingMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(MovimentoSingMac movimentoSingMac) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(movimentoSingMac);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(MovimentoSingMac movimentoSingMac) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            movimentoSingMac = em.merge(movimentoSingMac);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = movimentoSingMac.getIdMovInephos();
                if (findMovimentoSingMac(id) == null) {
                    throw new NonexistentEntityException("The movimentoSingMac with id " + id + " no longer exists.");
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
            MovimentoSingMac movimentoSingMac;
            try {
                movimentoSingMac = em.getReference(MovimentoSingMac.class, id);
                movimentoSingMac.getIdMovInephos();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The movimentoSingMac with id " + id + " no longer exists.", enfe);
            }
            em.remove(movimentoSingMac);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<MovimentoSingMac> findMovimentoSingMacEntities() {
        return findMovimentoSingMacEntities(true, -1, -1);
    }

    public List<MovimentoSingMac> findMovimentoSingMacEntities(int maxResults, int firstResult) {
        return findMovimentoSingMacEntities(false, maxResults, firstResult);
    }

    private List<MovimentoSingMac> findMovimentoSingMacEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from MovimentoSingMac as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public MovimentoSingMac findMovimentoSingMac(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(MovimentoSingMac.class, id);
        } finally {
            em.close();
        }
    }

    public int getMovimentoSingMacCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from MovimentoSingMac as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    
    public Collection<MovimentoSingMac> findMovimentoSingMacNew(Date dt_ult_agg,Integer idMacchina, String origineMov){
         
     EntityManager em = getEntityManager();
     try{
      Query q = em.createNamedQuery("MovimentoSingMac.findDatiNuovi");
       q.setParameter("dtAbilitato",dt_ult_agg);
       q.setParameter("idMacchina",idMacchina);
       q.setParameter("origineMov",origineMov);
     
      return   q.getResultList();
     
     } finally {
      em.close();
    } 
        
  }    
    
    
   public Collection<MovimentoSingMac> findMovimentoSingMacByIdAndMac(Integer idMacchina, Integer idMovOri){
         
     EntityManager em = getEntityManager();
     try{
      Query q = em.createNamedQuery("MovimentoSingMac.findMovimentoByIdAndMac");
      
       q.setParameter("idMacchina",idMacchina);
       q.setParameter("idMovOri",idMovOri);
     
      return   q.getResultList();
     
     } finally {
      em.close();
    } 
        
  } 
   
   /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto MovimentoSingMac da salvare
   * @author marilisa
   */
  public void merge(MovimentoSingMac movimentoSingMac) {
    EntityManager em = null;

     try {
      
        em = getEntityManager();
        em.getTransaction().begin();
      
      if (findMovimentoSingMacByIdAndMac(movimentoSingMac.getIdMacchina(),movimentoSingMac.getIdMovOri()) == null) {
        em.merge(movimentoSingMac);
      
      }
      
      /**if (findMovimentoSingMacByIdAndMac(movimentoSingMac.getIdMacchina(),movimentoSingMac.getIdMovOri()) != null) {
        em.merge(movimentoSingMac);
      } else {
        em.persist(movimentoSingMac);
      }*/
      
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
    
    
}
