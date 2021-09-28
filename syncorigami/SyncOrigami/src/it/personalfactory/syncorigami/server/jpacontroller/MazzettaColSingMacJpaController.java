/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.MazzettaColSingMac;
import it.personalfactory.syncorigami.server.entity.MazzettaColSingMacPK;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Mazzetta;
import it.personalfactory.syncorigami.server.entity.ColoreBase;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class MazzettaColSingMacJpaController implements Serializable {
  
  
  Logger log = Logger.getLogger(MazzettaColSingMacJpaController.class);

  public MazzettaColSingMacJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(MazzettaColSingMac mazzettaColSingMac) throws PreexistingEntityException, Exception {
    if (mazzettaColSingMac.getMazzettaColSingMacPK() == null) {
      mazzettaColSingMac.setMazzettaColSingMacPK(new MazzettaColSingMacPK());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Mazzetta idMazzetta = mazzettaColSingMac.getIdMazzetta();
      if (idMazzetta != null) {
        idMazzetta = em.getReference(idMazzetta.getClass(), idMazzetta.getIdMazzetta());
        mazzettaColSingMac.setIdMazzetta(idMazzetta);
      }
      ColoreBase idColoreBase = mazzettaColSingMac.getIdColoreBase();
      if (idColoreBase != null) {
        idColoreBase = em.getReference(idColoreBase.getClass(), idColoreBase.getIdColoreBase());
        mazzettaColSingMac.setIdColoreBase(idColoreBase);
      }
      em.persist(mazzettaColSingMac);
      if (idMazzetta != null) {
        idMazzetta.getMazzettaColSingMacCollection().add(mazzettaColSingMac);
        idMazzetta = em.merge(idMazzetta);
      }
      if (idColoreBase != null) {
        idColoreBase.getMazzettaColSingMacCollection().add(mazzettaColSingMac);
        idColoreBase = em.merge(idColoreBase);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      if (findMazzettaColSingMac(mazzettaColSingMac.getMazzettaColSingMacPK()) != null) {
        throw new PreexistingEntityException("MazzettaColSingMac " + mazzettaColSingMac + " already exists.", ex);
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(MazzettaColSingMac mazzettaColSingMac) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      MazzettaColSingMac persistentMazzettaColSingMac = em.find(MazzettaColSingMac.class, mazzettaColSingMac.getMazzettaColSingMacPK());
      Mazzetta idMazzettaOld = persistentMazzettaColSingMac.getIdMazzetta();
      Mazzetta idMazzettaNew = mazzettaColSingMac.getIdMazzetta();
      ColoreBase idColoreBaseOld = persistentMazzettaColSingMac.getIdColoreBase();
      ColoreBase idColoreBaseNew = mazzettaColSingMac.getIdColoreBase();
      if (idMazzettaNew != null) {
        idMazzettaNew = em.getReference(idMazzettaNew.getClass(), idMazzettaNew.getIdMazzetta());
        mazzettaColSingMac.setIdMazzetta(idMazzettaNew);
      }
      if (idColoreBaseNew != null) {
        idColoreBaseNew = em.getReference(idColoreBaseNew.getClass(), idColoreBaseNew.getIdColoreBase());
        mazzettaColSingMac.setIdColoreBase(idColoreBaseNew);
      }
      mazzettaColSingMac = em.merge(mazzettaColSingMac);
      if (idMazzettaOld != null && !idMazzettaOld.equals(idMazzettaNew)) {
        idMazzettaOld.getMazzettaColSingMacCollection().remove(mazzettaColSingMac);
        idMazzettaOld = em.merge(idMazzettaOld);
      }
      if (idMazzettaNew != null && !idMazzettaNew.equals(idMazzettaOld)) {
        idMazzettaNew.getMazzettaColSingMacCollection().add(mazzettaColSingMac);
        idMazzettaNew = em.merge(idMazzettaNew);
      }
      if (idColoreBaseOld != null && !idColoreBaseOld.equals(idColoreBaseNew)) {
        idColoreBaseOld.getMazzettaColSingMacCollection().remove(mazzettaColSingMac);
        idColoreBaseOld = em.merge(idColoreBaseOld);
      }
      if (idColoreBaseNew != null && !idColoreBaseNew.equals(idColoreBaseOld)) {
        idColoreBaseNew.getMazzettaColSingMacCollection().add(mazzettaColSingMac);
        idColoreBaseNew = em.merge(idColoreBaseNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        MazzettaColSingMacPK id = mazzettaColSingMac.getMazzettaColSingMacPK();
        if (findMazzettaColSingMac(id) == null) {
          throw new NonexistentEntityException("The mazzettaColSingMac with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(MazzettaColSingMacPK id) throws NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      MazzettaColSingMac mazzettaColSingMac;
      try {
        mazzettaColSingMac = em.getReference(MazzettaColSingMac.class, id);
        mazzettaColSingMac.getMazzettaColSingMacPK();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The mazzettaColSingMac with id " + id + " no longer exists.", enfe);
      }
      Mazzetta idMazzetta = mazzettaColSingMac.getIdMazzetta();
      if (idMazzetta != null) {
        idMazzetta.getMazzettaColSingMacCollection().remove(mazzettaColSingMac);
        idMazzetta = em.merge(idMazzetta);
      }
      ColoreBase idColoreBase = mazzettaColSingMac.getIdColoreBase();
      if (idColoreBase != null) {
        idColoreBase.getMazzettaColSingMacCollection().remove(mazzettaColSingMac);
        idColoreBase = em.merge(idColoreBase);
      }
      em.remove(mazzettaColSingMac);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<MazzettaColSingMac> findMazzettaColSingMacEntities() {
    return findMazzettaColSingMacEntities(true, -1, -1);
  }

  public List<MazzettaColSingMac> findMazzettaColSingMacEntities(int maxResults, int firstResult) {
    return findMazzettaColSingMacEntities(false, maxResults, firstResult);
  }

  private List<MazzettaColSingMac> findMazzettaColSingMacEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from MazzettaColSingMac as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public MazzettaColSingMac findMazzettaColSingMac(MazzettaColSingMacPK id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(MazzettaColSingMac.class, id);
    } finally {
      em.close();
    }
  }

  public int getMazzettaColSingMacCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from MazzettaColSingMac as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  /**
   * Metodo che consente di salvare un oggetto sul db, 
   * verifica l'esistenza dell'oggetto nel db 
   * effettua un insert se l'oggetto non esiste altrimenti effettua un update
   * @param oggetto MazzettaColSingMac da salvare
   * @author marilisa
   */
  public void merge(MazzettaColSingMac mazzettaColSingMac) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();
      
      if (findMazzettaColSingMac(mazzettaColSingMac.getMazzettaColSingMacPK()) != null) {
        em.merge(mazzettaColSingMac);
      } else {
        em.persist(mazzettaColSingMac);
      }
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
  
}
