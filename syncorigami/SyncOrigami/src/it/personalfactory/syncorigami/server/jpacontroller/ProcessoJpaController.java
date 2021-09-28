/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Macchina;
import it.personalfactory.syncorigami.server.entity.Processo;
import it.personalfactory.syncorigami.server.entity.ProcessoPK;
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
public class ProcessoJpaController implements Serializable {

  Logger log = Logger.getLogger(ProcessoJpaController.class);
  
  public ProcessoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Processo processo) throws PreexistingEntityException, Exception {
    if (processo.getProcessoPK() == null) {
      processo.setProcessoPK(new ProcessoPK());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Macchina idMacchina = processo.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        processo.setIdMacchina(idMacchina);
      }
      em.persist(processo);
      if (idMacchina != null) {
        idMacchina.getProcessoCollection().add(processo);
        idMacchina = em.merge(idMacchina);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      if (findProcesso(processo.getProcessoPK()) != null) {
        throw new PreexistingEntityException("Processo " + processo + " already exists.", ex);
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Processo processo) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Processo persistentProcesso = em.find(Processo.class, processo.getProcessoPK());
      Macchina idMacchinaOld = persistentProcesso.getIdMacchina();
      Macchina idMacchinaNew = processo.getIdMacchina();
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        processo.setIdMacchina(idMacchinaNew);
      }
      processo = em.merge(processo);
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getProcessoCollection().remove(processo);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getProcessoCollection().add(processo);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        ProcessoPK id = processo.getProcessoPK();
        if (findProcesso(id) == null) {
          throw new NonexistentEntityException("The processo with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(ProcessoPK id) throws NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Processo processo;
      try {
        processo = em.getReference(Processo.class, id);
        processo.getProcessoPK();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The processo with id " + id + " no longer exists.", enfe);
      }
      Macchina idMacchina = processo.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getProcessoCollection().remove(processo);
        idMacchina = em.merge(idMacchina);
      }
      em.remove(processo);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Processo> findProcessoEntities() {
    return findProcessoEntities(true, -1, -1);
  }

  public List<Processo> findProcessoEntities(int maxResults, int firstResult) {
    return findProcessoEntities(false, maxResults, firstResult);
  }

  private List<Processo> findProcessoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Processo as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Processo findProcesso(ProcessoPK id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Processo.class, id);
    } finally {
      em.close();
    }
  }

  public int getProcessoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Processo as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  
  

  
  
   /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto Processo da salvare
   * @author marilisa
   */
  public void merge(Processo processo) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();
      
      if (findProcesso(processo.getProcessoPK()) != null) {
        em.merge(processo);
      } else {
        em.persist(processo);
      }
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
}
