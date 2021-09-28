/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.AnagrafeMacchina;
import it.personalfactory.syncorigami.server.entity.Lingua;
import it.personalfactory.syncorigami.server.entity.Macchina;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.NonUniqueResultException;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;


/**
 *
 * @author marilisa
 */
public class AnagrafeMacchinaJpaController implements Serializable {

  Logger log = Logger.getLogger(AnagrafeMacchinaJpaController.class);
  
  public AnagrafeMacchinaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(AnagrafeMacchina anagrafeMacchina) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Macchina idMacchina = anagrafeMacchina.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        anagrafeMacchina.setIdMacchina(idMacchina);
      }
      Lingua idLingua = anagrafeMacchina.getIdLingua();
      if (idLingua != null) {
        idLingua = em.getReference(idLingua.getClass(), idLingua.getIdLingua());
        anagrafeMacchina.setIdLingua(idLingua);
      }
      em.persist(anagrafeMacchina);
      if (idMacchina != null) {
        idMacchina.getAnagrafeMacchinaCollection().add(anagrafeMacchina);
        idMacchina = em.merge(idMacchina);
      }
      if (idLingua != null) {
        idLingua.getAnagrafeMacchinaCollection().add(anagrafeMacchina);
        idLingua = em.merge(idLingua);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(AnagrafeMacchina anagrafeMacchina) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      AnagrafeMacchina persistentAnagrafeMacchina = em.find(AnagrafeMacchina.class, anagrafeMacchina.getIdAnMac());
      Macchina idMacchinaOld = persistentAnagrafeMacchina.getIdMacchina();
      Macchina idMacchinaNew = anagrafeMacchina.getIdMacchina();
      Lingua idLinguaOld = persistentAnagrafeMacchina.getIdLingua();
      Lingua idLinguaNew = anagrafeMacchina.getIdLingua();
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        anagrafeMacchina.setIdMacchina(idMacchinaNew);
      }
      if (idLinguaNew != null) {
        idLinguaNew = em.getReference(idLinguaNew.getClass(), idLinguaNew.getIdLingua());
        anagrafeMacchina.setIdLingua(idLinguaNew);
      }
      anagrafeMacchina = em.merge(anagrafeMacchina);
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getAnagrafeMacchinaCollection().remove(anagrafeMacchina);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getAnagrafeMacchinaCollection().add(anagrafeMacchina);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      if (idLinguaOld != null && !idLinguaOld.equals(idLinguaNew)) {
        idLinguaOld.getAnagrafeMacchinaCollection().remove(anagrafeMacchina);
        idLinguaOld = em.merge(idLinguaOld);
      }
      if (idLinguaNew != null && !idLinguaNew.equals(idLinguaOld)) {
        idLinguaNew.getAnagrafeMacchinaCollection().add(anagrafeMacchina);
        idLinguaNew = em.merge(idLinguaNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = anagrafeMacchina.getIdAnMac();
        if (findAnagrafeMacchina(id) == null) {
          throw new NonexistentEntityException("The anagrafeMacchina with id " + id + " no longer exists.");
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
      AnagrafeMacchina anagrafeMacchina;
      try {
        anagrafeMacchina = em.getReference(AnagrafeMacchina.class, id);
        anagrafeMacchina.getIdAnMac();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The anagrafeMacchina with id " + id + " no longer exists.", enfe);
      }
      Macchina idMacchina = anagrafeMacchina.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getAnagrafeMacchinaCollection().remove(anagrafeMacchina);
        idMacchina = em.merge(idMacchina);
      }
      Lingua idLingua = anagrafeMacchina.getIdLingua();
      if (idLingua != null) {
        idLingua.getAnagrafeMacchinaCollection().remove(anagrafeMacchina);
        idLingua = em.merge(idLingua);
      }
      em.remove(anagrafeMacchina);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<AnagrafeMacchina> findAnagrafeMacchinaEntities() {
    return findAnagrafeMacchinaEntities(true, -1, -1);
  }

  public List<AnagrafeMacchina> findAnagrafeMacchinaEntities(int maxResults, int firstResult) {
    return findAnagrafeMacchinaEntities(false, maxResults, firstResult);
  }

  private List<AnagrafeMacchina> findAnagrafeMacchinaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from AnagrafeMacchina as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public AnagrafeMacchina findAnagrafeMacchina(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(AnagrafeMacchina.class, id);
    } finally {
      em.close();
    }
  }

  public int getAnagrafeMacchinaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from AnagrafeMacchina as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
//  public Collection<AnagrafeMacchina> findAnagrafeMacchinaNew(Date dt_ult_agg, Integer id_macchina){
//         
//     EntityManager em = getEntityManager();
//     try {
//     
//       Query q = em.createNamedQuery("AnagrafeMacchina.findDatiNuovi");
//       q.setParameter ("idMacchina",id_macchina);
//       q.setParameter ("dtAbilitato",dt_ult_agg);
//     
//      return  q.getResultList();
//            
//    } finally {
//      em.close();
//    }
//     
//  }    
//   public AnagrafeMacchina findUniqueAnagrafeMacchinaNew(Date dt_ult_agg, Integer id_macchina){
//         
//     EntityManager em = getEntityManager();
//     
//     Query q = em.createNamedQuery("AnagrafeMacchina.findDatiNuovi");
//     q.setParameter ("idMacchina",id_macchina);
//     q.setParameter ("dtAbilitato",dt_ult_agg);
//     
//     AnagrafeMacchina anagrafeMacchina = null;
//     
//     try {
//        anagrafeMacchina = (AnagrafeMacchina) q.getSingleResult();
//       }  catch (NonUniqueResultException nre) {
//          log.error("##### Macchina duplicata in findUniqueAnagrafeMacchinaNew" );
//       } catch (Exception e){
//         log.error("##### eccezione inattesa su findUniqueAnagrafeMacchinaNew: " + e.toString());
//      }
//     
//     return  anagrafeMacchina;
//     
//  }    
  
}
