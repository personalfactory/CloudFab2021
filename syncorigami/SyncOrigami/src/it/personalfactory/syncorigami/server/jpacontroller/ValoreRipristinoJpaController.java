/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ParametroRipristino;
import it.personalfactory.syncorigami.server.entity.ValoreRipristino;
import it.personalfactory.syncorigami.server.entity.ValoreRipristinoPK;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.*;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author Marilisa Tassone
 */
public class ValoreRipristinoJpaController implements Serializable {

    Logger log = Logger.getLogger(ValoreRipristinoJpaController.class);
    public ValoreRipristinoJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ValoreRipristino valoreRipristino) throws PreexistingEntityException, Exception {
        if (valoreRipristino.getValoreRipristinoPK() == null) {
            valoreRipristino.setValoreRipristinoPK(new ValoreRipristinoPK());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ParametroRipristino idParRipristino = valoreRipristino.getIdParRipristino();
            if (idParRipristino != null) {
                idParRipristino = em.getReference(idParRipristino.getClass(), idParRipristino.getIdParRipristino());
                valoreRipristino.setIdParRipristino(idParRipristino);
            }
            em.persist(valoreRipristino);
            if (idParRipristino != null) {
                idParRipristino.getValoreRipristinoCollection().add(valoreRipristino);
                idParRipristino = em.merge(idParRipristino);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            if (findValoreRipristino(valoreRipristino.getValoreRipristinoPK()) != null) {
                throw new PreexistingEntityException("ValoreRipristino " + valoreRipristino + " already exists.", ex);
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ValoreRipristino valoreRipristino) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ValoreRipristino persistentValoreRipristino = em.find(ValoreRipristino.class, valoreRipristino.getValoreRipristinoPK());
            ParametroRipristino idParRipristinoOld = persistentValoreRipristino.getIdParRipristino();
            ParametroRipristino idParRipristinoNew = valoreRipristino.getIdParRipristino();
            if (idParRipristinoNew != null) {
                idParRipristinoNew = em.getReference(idParRipristinoNew.getClass(), idParRipristinoNew.getIdParRipristino());
                valoreRipristino.setIdParRipristino(idParRipristinoNew);
            }
            valoreRipristino = em.merge(valoreRipristino);
            if (idParRipristinoOld != null && !idParRipristinoOld.equals(idParRipristinoNew)) {
                idParRipristinoOld.getValoreRipristinoCollection().remove(valoreRipristino);
                idParRipristinoOld = em.merge(idParRipristinoOld);
            }
            if (idParRipristinoNew != null && !idParRipristinoNew.equals(idParRipristinoOld)) {
                idParRipristinoNew.getValoreRipristinoCollection().add(valoreRipristino);
                idParRipristinoNew = em.merge(idParRipristinoNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                ValoreRipristinoPK id = valoreRipristino.getValoreRipristinoPK();
                if (findValoreRipristino(id) == null) {
                    throw new NonexistentEntityException("The valoreRipristino with id " + id + " no longer exists.");
                }
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void destroy(ValoreRipristinoPK id) throws NonexistentEntityException {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ValoreRipristino valoreRipristino;
            try {
                valoreRipristino = em.getReference(ValoreRipristino.class, id);
                valoreRipristino.getValoreRipristinoPK();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The valoreRipristino with id " + id + " no longer exists.", enfe);
            }
            ParametroRipristino idParRipristino = valoreRipristino.getIdParRipristino();
            if (idParRipristino != null) {
                idParRipristino.getValoreRipristinoCollection().remove(valoreRipristino);
                idParRipristino = em.merge(idParRipristino);
            }
            em.remove(valoreRipristino);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ValoreRipristino> findValoreRipristinoEntities() {
        return findValoreRipristinoEntities(true, -1, -1);
    }

    public List<ValoreRipristino> findValoreRipristinoEntities(int maxResults, int firstResult) {
        return findValoreRipristinoEntities(false, maxResults, firstResult);
    }

    private List<ValoreRipristino> findValoreRipristinoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ValoreRipristino as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ValoreRipristino findValoreRipristino(ValoreRipristinoPK id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ValoreRipristino.class, id);
        } finally {
            em.close();
        }
    }

    public int getValoreRipristinoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ValoreRipristino as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
public Collection<ValoreRipristino> findValoreRipristinoNew(Date dtUltAgg, Integer idMacchina) {
    EntityManager em = getEntityManager();
    try {

      Query q = em.createNamedQuery("ValoreRipristino.findDatiNuovi");
      q.setParameter("dtAbilitato", dtUltAgg);
      q.setParameter("idMacchina", idMacchina);
      return q.getResultList();

    } finally {
      em.close();
    }

  }

/**
 * Metodo che restituisce una collection di valori ripristino associati 
 * ad una specifice macchina
 * @param idMacchina
 * @return 
 */
  public Collection<ValoreRipristino> findAllValoreRipristino(Integer idMacchina) {
    EntityManager em = getEntityManager();
    
      Query q = em.createNamedQuery("ValoreRipristino.findByIdMacchina");
      q.setParameter("idMacchina", idMacchina);
    
    try {

      q.getResultList();

    } catch (NoResultException ex) {
      log.error("##### La tabella valore_ripristino non contiene già parametri per la macchina " + idMacchina );
//      throw ex;
    }
    return q.getResultList();
  }

  
  /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto ValoreRipristino da salvare
   * @author marilisa
   */
  public void merge(ValoreRipristino valoreRipristino) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
       if (findValoreRipristino(valoreRipristino.getValoreRipristinoPK()) != null) {
        em.merge(valoreRipristino);
      } else {
        em.persist(valoreRipristino);
      }
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }

}

