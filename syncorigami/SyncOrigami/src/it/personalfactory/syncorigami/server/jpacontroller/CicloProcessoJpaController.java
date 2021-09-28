/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.CicloProcesso;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.io.Serializable;
import java.util.Collection;
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
public class CicloProcessoJpaController implements Serializable {

  Logger log = Logger.getLogger(CicloProcessoJpaController.class);    
    
  public CicloProcessoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(CicloProcesso cicloProcesso) throws PreexistingEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(cicloProcesso);
            em.getTransaction().commit();
        } catch (Exception ex) {
            if (findCicloProcesso(cicloProcesso.getId()) != null) {
                throw new PreexistingEntityException("CicloProcesso " + cicloProcesso + " already exists.", ex);
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(CicloProcesso cicloProcesso) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            cicloProcesso = em.merge(cicloProcesso);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = cicloProcesso.getId();
                if (findCicloProcesso(id) == null) {
                    throw new NonexistentEntityException("The cicloProcesso with id " + id + " no longer exists.");
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
            CicloProcesso cicloProcesso;
            try {
                cicloProcesso = em.getReference(CicloProcesso.class, id);
                cicloProcesso.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The cicloProcesso with id " + id + " no longer exists.", enfe);
            }
            em.remove(cicloProcesso);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<CicloProcesso> findCicloProcessoEntities() {
        return findCicloProcessoEntities(true, -1, -1);
    }

    public List<CicloProcesso> findCicloProcessoEntities(int maxResults, int firstResult) {
        return findCicloProcessoEntities(false, maxResults, firstResult);
    }

    private List<CicloProcesso> findCicloProcessoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from CicloProcesso as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public CicloProcesso findCicloProcesso(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(CicloProcesso.class, id);
        } finally {
            em.close();
        }
    }

    public int getCicloProcessoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from CicloProcesso as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    public Collection<CicloProcesso> findCicloByIdCicloIdMacIdProc(Integer idCiclo, Integer idMacchina, Integer idProcesso){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("CicloProcesso.findCicloByIdCicloIdMacIdProc");
       q.setParameter ("idCiclo",idCiclo);
       q.setParameter ("idMacchina",idMacchina);
       q.setParameter ("idProcesso",idProcesso);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }
    
   /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto CicloProcesso da salvare
   * @author marilisa
   */
  public void merge(CicloProcesso cicloProcesso) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();
      
      if (findCicloByIdCicloIdMacIdProc(cicloProcesso.getIdCiclo(),cicloProcesso.getIdMacchina(),cicloProcesso.getIdProcesso()) == null) {
       
        em.persist(cicloProcesso);
      }
      
     /** if (findCicloByIdCicloIdMacIdProc(cicloProcesso.getIdCiclo(),cicloProcesso.getIdMacchina(),cicloProcesso.getIdProcesso()) != null) {
        em.merge(cicloProcesso);
      } else {
        em.persist(cicloProcesso);
      }*/
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
    
    
    
}
