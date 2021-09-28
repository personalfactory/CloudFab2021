/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.macchina.entity.AggiornamentoConfigOri;
import it.personalfactory.syncorigami.server.entity.AggiornamentoConfig;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.NoResultException;
import javax.persistence.NonUniqueResultException;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class AggiornamentoConfigJpaController implements Serializable {

  Logger log = Logger.getLogger(AggiornamentoConfigJpaController.class);

  public AggiornamentoConfigJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(AggiornamentoConfig aggiornamentoConfig) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      em.persist(aggiornamentoConfig);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(AggiornamentoConfig aggiornamentoConfig) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      aggiornamentoConfig = em.merge(aggiornamentoConfig);
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = aggiornamentoConfig.getId();
        if (findAggiornamentoConfig(id) == null) {
          throw new NonexistentEntityException("The aggiornamentoConfig with id " + id + " no longer exists.");
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
      AggiornamentoConfig aggiornamentoConfig;
      try {
        aggiornamentoConfig = em.getReference(AggiornamentoConfig.class, id);
        aggiornamentoConfig.getId();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The aggiornamentoConfig with id " + id + " no longer exists.", enfe);
      }
      em.remove(aggiornamentoConfig);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<AggiornamentoConfig> findAggiornamentoConfigEntities() {
    return findAggiornamentoConfigEntities(true, -1, -1);
  }

  public List<AggiornamentoConfig> findAggiornamentoConfigEntities(int maxResults, int firstResult) {
    return findAggiornamentoConfigEntities(false, maxResults, firstResult);
  }

  private List<AggiornamentoConfig> findAggiornamentoConfigEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from AggiornamentoConfig as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public AggiornamentoConfig findAggiornamentoConfig(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(AggiornamentoConfig.class, id);
    } finally {
      em.close();
    }
  }

  public int getAggiornamentoConfigCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from AggiornamentoConfig as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }

  

  /**
   * Metodo che restituisce una collection di tutte le proprietà della tabella aggiornamento_config
   * @param
   * @return 
   */
  public Collection<AggiornamentoConfig> findAggiornamentoConfigAll() {
    EntityManager em = getEntityManager();
    try {

      Query q = em.createNamedQuery("AggiornamentoConfig.findAll");
      return q.getResultList();

    } catch (NoResultException ex) {
      log.error("######## PROPRIETA' NON TROVATE NEL DB!!");
      throw ex;

    } finally {
      em.close();
    }
  }

  /**
   * Metodo che restituisce un oggetto AggiornamentoConfig corrispondente al parametro passato
   * @param String nome del parametro
   * @return AggiornamentoConfig
   */
  public AggiornamentoConfig findProperty(String parametro) {
    EntityManager em = getEntityManager();
    
    Query q = em.createNamedQuery("AggiornamentoConfig.findByParametro");
    q.setParameter("parametro", parametro);
    
    try {
     
     q.getSingleResult();

    } catch (NoResultException ex) {
      log.error("######## PROPRIETA' NON TROVATA NEL DB!!");
      throw ex;
    } catch (NonUniqueResultException ex) {
      log.error("##### PROPRIETA'DUPLICATA NELLA TABELLA aggiornamento_config");
      throw ex;
    }  
    return (AggiornamentoConfig) q.getSingleResult();
  }

   /**
   * Metodo che restituisce le proprietà nuove
   * @param data di costruzione dell'ultimo aggiornamento 
   * @return Una collection di AggiornamentoConfig
   * Per recuperare le proprietà nuove lato server 
   * si confronta la data dell'ultimo aggiornamento con il valore del campo dtAbilitato
   * N.B. Le proprietà viaggiano in un solo verso ovvero dal server alle macchine
   */
  public Collection<AggiornamentoConfig> findAggiornamentoConfigNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("AggiornamentoConfig.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    



}
