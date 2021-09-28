/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Aggiornamento;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Macchina;
import java.util.Date;
import javax.persistence.NoResultException;
import javax.persistence.NonUniqueResultException;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class AggiornamentoJpaController implements Serializable {

  Logger log = Logger.getLogger(AggiornamentoJpaController.class);

  public AggiornamentoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Aggiornamento aggiornamento) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Macchina idMacchina = aggiornamento.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        aggiornamento.setIdMacchina(idMacchina);
      }
      em.persist(aggiornamento);
      if (idMacchina != null) {
        idMacchina.getAggiornamentoCollection().add(aggiornamento);
        idMacchina = em.merge(idMacchina);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Aggiornamento aggiornamento) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Aggiornamento persistentAggiornamento = em.find(Aggiornamento.class, aggiornamento.getId());
      Macchina idMacchinaOld = persistentAggiornamento.getIdMacchina();
      Macchina idMacchinaNew = aggiornamento.getIdMacchina();
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        aggiornamento.setIdMacchina(idMacchinaNew);
      }
      aggiornamento = em.merge(aggiornamento);
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getAggiornamentoCollection().remove(aggiornamento);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getAggiornamentoCollection().add(aggiornamento);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = aggiornamento.getId();
        if (findAggiornamento(id) == null) {
          throw new NonexistentEntityException("The aggiornamento with id " + id + " no longer exists.");
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
      Aggiornamento aggiornamento;
      try {
        aggiornamento = em.getReference(Aggiornamento.class, id);
        aggiornamento.getId();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The aggiornamento with id " + id + " no longer exists.", enfe);
      }
      Macchina idMacchina = aggiornamento.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getAggiornamentoCollection().remove(aggiornamento);
        idMacchina = em.merge(idMacchina);
      }
      em.remove(aggiornamento);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Aggiornamento> findAggiornamentoEntities() {
    return findAggiornamentoEntities(true, -1, -1);
  }

  public List<Aggiornamento> findAggiornamentoEntities(int maxResults, int firstResult) {
    return findAggiornamentoEntities(false, maxResults, firstResult);
  }

  private List<Aggiornamento> findAggiornamentoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Aggiornamento as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Aggiornamento findAggiornamento(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Aggiornamento.class, id);
    } finally {
      em.close();
    }
  }

  public int getAggiornamentoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Aggiornamento as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }

  /** Restituisce la data dell'ultimo aggiornamento di una macchina
   * @param un intero che indica l'id della macchina 
   * @param il tipo di aggiornamento (IN/OUT)
   * @return data di costruzione dell'ultimo aggiornamento
   * @exception NoResultException, NonUniqueResultException
   */
   public Date recuperaDtUltimoAggiornamento(Integer idMacchina, String tipo) {
  
    EntityManager em = getEntityManager();

    Query q = em.createQuery("SELECT MAX(a.dtAggiornamento) FROM Aggiornamento a, Macchina m WHERE m.idMacchina =a.idMacchina AND m.idMacchina= :idMacchina AND a.tipo= :tipo )");
    q.setParameter("idMacchina", idMacchina);
    q.setParameter("tipo", tipo);

    try {

      q.getSingleResult();

    } catch (NoResultException ex) {
      log.error("##### Nessun Risultato in recuperaDtUltimoAggiornamento");
      throw ex;
    } catch (NonUniqueResultException ex) {
      log.error("##### Data ultimo aggiornamento duplicata in recuperaDtUltimoAggiornamento");
      throw ex;
   }

    return (Date) q.getSingleResult();
  }


  
//  //Prende come parametri l'idMacchina ed il tipo di aggiornamento
//  //Recupera dalla tabella aggiornamento l'ultima versione di un dato tipo di aggiornamento di una data macchina 
//  //Restituisce l'ultima versione.
//  public Integer findLastUpdateVersion2(Integer idMacchina, String tipo) throws LastUpdateVersionNotFoundException {
//
//    EntityManager em = getEntityManager();
//
//    Query q = em.createNamedQuery("Aggiornamento.findLastVersione");
//    q.setParameter("idMacchina", idMacchina);
//    q.setParameter("tipo", tipo);
//
//    if (q.getSingleResult() == null) {
//      throw new LastUpdateVersionNotFoundException("ERRORE!!! - Versione ultimo aggiornamento Macchina: " + idMacchina + " NON TROVATA!!!");
//    }
//
//    return (Integer) q.getSingleResult();
//
//  }
  
//  /**
//   * Metodo che restituiscel'ultima versione di un dato tipo di aggiornamento di una data macchina 
//   * @param idMacchina macchina da aggiornare, tipo aggiornamento(IN/OUT) 
//   * @return Un oggetto Integer ovvero l'ultima versione dell'aggiornamento
//   */
//   public Integer findLastUpdateVersion(Integer idMacchina, String tipo) {
//
//    EntityManager em = getEntityManager();
//
//    Query q = em.createNamedQuery("Aggiornamento.findLastVersione");
//    q.setParameter("idMacchina", idMacchina);
//    q.setParameter("tipo", tipo);
//
//    try {
//
//      q.getSingleResult();
//
//    } catch (NoResultException nre) {
//      log.error("##### Nessun Risultato in findLastUpdateVersion");
//      throw nre;
//    } catch (NonUniqueResultException nure) {
//      log.error("##### Data ultimo aggiornamento duplicata in findLastUpdateVersion");
//      throw nure;
//    } catch (Exception e) {
//      log.error("##### eccezione inattesa su findLastUpdateVersion: " + e.toString());
//    }
//
//    return (Integer) q.getSingleResult();
//
//  }
}
