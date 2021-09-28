/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ValoreParSingMac;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ParametroSingMac;
import it.personalfactory.syncorigami.server.entity.Macchina;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;


/**
 *
 * @author marilisa
 */
public class ValoreParSingMacJpaController implements Serializable {

  Logger log = Logger.getLogger(ValoreParSingMacJpaController.class);
  
  public ValoreParSingMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ValoreParSingMac valoreParSingMac) throws PreexistingEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ParametroSingMac idParSm = valoreParSingMac.getIdParSm();
      if (idParSm != null) {
        idParSm = em.getReference(idParSm.getClass(), idParSm.getIdParSm());
        valoreParSingMac.setIdParSm(idParSm);
      }
      Macchina idMacchina = valoreParSingMac.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        valoreParSingMac.setIdMacchina(idMacchina);
      }
      em.persist(valoreParSingMac);
      if (idParSm != null) {
        idParSm.getValoreParSingMacCollection().add(valoreParSingMac);
        idParSm = em.merge(idParSm);
      }
      if (idMacchina != null) {
        idMacchina.getValoreParSingMacCollection().add(valoreParSingMac);
        idMacchina = em.merge(idMacchina);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      if (findValoreParSingMac(valoreParSingMac.getIdValParSm()) != null) {
        throw new PreexistingEntityException("ValoreParSingMac " + valoreParSingMac + " already exists.", ex);
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ValoreParSingMac valoreParSingMac) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ValoreParSingMac persistentValoreParSingMac = em.find(ValoreParSingMac.class, valoreParSingMac.getIdValParSm());
      ParametroSingMac idParSmOld = persistentValoreParSingMac.getIdParSm();
      ParametroSingMac idParSmNew = valoreParSingMac.getIdParSm();
      Macchina idMacchinaOld = persistentValoreParSingMac.getIdMacchina();
      Macchina idMacchinaNew = valoreParSingMac.getIdMacchina();
      if (idParSmNew != null) {
        idParSmNew = em.getReference(idParSmNew.getClass(), idParSmNew.getIdParSm());
        valoreParSingMac.setIdParSm(idParSmNew);
      }
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        valoreParSingMac.setIdMacchina(idMacchinaNew);
      }
      valoreParSingMac = em.merge(valoreParSingMac);
      if (idParSmOld != null && !idParSmOld.equals(idParSmNew)) {
        idParSmOld.getValoreParSingMacCollection().remove(valoreParSingMac);
        idParSmOld = em.merge(idParSmOld);
      }
      if (idParSmNew != null && !idParSmNew.equals(idParSmOld)) {
        idParSmNew.getValoreParSingMacCollection().add(valoreParSingMac);
        idParSmNew = em.merge(idParSmNew);
      }
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getValoreParSingMacCollection().remove(valoreParSingMac);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getValoreParSingMacCollection().add(valoreParSingMac);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = valoreParSingMac.getIdValParSm();
        if (findValoreParSingMac(id) == null) {
          throw new NonexistentEntityException("The valoreParSingMac with id " + id + " no longer exists.");
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
      ValoreParSingMac valoreParSingMac;
      try {
        valoreParSingMac = em.getReference(ValoreParSingMac.class, id);
        valoreParSingMac.getIdValParSm();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The valoreParSingMac with id " + id + " no longer exists.", enfe);
      }
      ParametroSingMac idParSm = valoreParSingMac.getIdParSm();
      if (idParSm != null) {
        idParSm.getValoreParSingMacCollection().remove(valoreParSingMac);
        idParSm = em.merge(idParSm);
      }
      Macchina idMacchina = valoreParSingMac.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getValoreParSingMacCollection().remove(valoreParSingMac);
        idMacchina = em.merge(idMacchina);
      }
      em.remove(valoreParSingMac);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ValoreParSingMac> findValoreParSingMacEntities() {
    return findValoreParSingMacEntities(true, -1, -1);
  }

  public List<ValoreParSingMac> findValoreParSingMacEntities(int maxResults, int firstResult) {
    return findValoreParSingMacEntities(false, maxResults, firstResult);
  }

  private List<ValoreParSingMac> findValoreParSingMacEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ValoreParSingMac as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ValoreParSingMac findValoreParSingMac(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreParSingMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreParSingMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreParSingMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   public Collection<ValoreParSingMac> findValoreParSingMacNew(Date dtUltAgg, Integer idMacchina){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParSingMac.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       q.setParameter("idMacchina",idMacchina);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
   /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto ValoreParSingMac da salvare
   * @author marilisa
   */
  public void merge(ValoreParSingMac valoreParSingMac) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();

      Integer id = 0;
      id =valoreParSingMac.getIdValParSm();
      if (findValoreParSingMac(id) != null) {
        em.merge(valoreParSingMac);
      } else {
        em.persist(valoreParSingMac);
      }
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
  
  public ValoreParSingMac findValoreByMacchinaIdPar(Integer idMacchina,  ParametroSingMac idParSm){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParSingMac.findValoreByIdParMac");
       
       q.setParameter("idMacchina",idMacchina);
       q.setParameter ("idParSm",idParSm);
       
       ValoreParSingMac valorePSMac = (ValoreParSingMac) q.getSingleResult();
       return  valorePSMac ;
            
    } finally {
      em.close();
    }
     
  }    
  
  
}
