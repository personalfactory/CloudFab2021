/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Ciclo;
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
public class CicloJpaController implements Serializable {

    Logger log = Logger.getLogger(CicloJpaController.class);
    
    
    public CicloJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Ciclo ciclo) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(ciclo);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Ciclo ciclo) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ciclo = em.merge(ciclo);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = ciclo.getId();
                if (findCiclo(id) == null) {
                    throw new NonexistentEntityException("The ciclo with id " + id + " no longer exists.");
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
            Ciclo ciclo;
            try {
                ciclo = em.getReference(Ciclo.class, id);
                ciclo.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The ciclo with id " + id + " no longer exists.", enfe);
            }
            em.remove(ciclo);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Ciclo> findCicloEntities() {
        return findCicloEntities(true, -1, -1);
    }

    public List<Ciclo> findCicloEntities(int maxResults, int firstResult) {
        return findCicloEntities(false, maxResults, firstResult);
    }

    private List<Ciclo> findCicloEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from Ciclo as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public Ciclo findCiclo(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Ciclo.class, id);
        } finally {
            em.close();
        }
    }

    public int getCicloCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from Ciclo as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    public Collection<Ciclo> findCicloByIdCicloAndIdMac(Integer idCiclo, Integer idMacchina){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Ciclo.findCicloByIdCicloAndIdMac");
       q.setParameter ("idCiclo",idCiclo);
       q.setParameter ("idMacchina",idMacchina);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }
    
    
    
    /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto Ciclo da salvare
   * @author marilisa
   */
  public void merge(Ciclo ciclo) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();
      //Modifica fatta in locale il 5 febbraio 2018: da provare
      //il record viene salvato solo se non esiste già in tabella
      if (findCicloByIdCicloAndIdMac(ciclo.getIdCiclo(),ciclo.getIdMacchina()) == null) {
                  
        em.persist(ciclo);
      }
      
      
      /**if (findCicloByIdCicloAndIdMac(ciclo.getIdCiclo(),ciclo.getIdMacchina()) != null) {
                  
        em.merge(ciclo);
      } else {
        em.persist(ciclo);
      }*/
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
    
}
