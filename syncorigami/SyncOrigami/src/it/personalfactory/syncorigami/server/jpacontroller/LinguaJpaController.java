/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.AnagrafeMacchina;
import it.personalfactory.syncorigami.server.entity.Dizionario;
import it.personalfactory.syncorigami.server.entity.Lingua;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.transaction.UserTransaction;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import javax.persistence.NoResultException;
import javax.persistence.NonUniqueResultException;
import org.apache.log4j.Logger;


/**
 *
 * @author marilisa
 */
public class LinguaJpaController implements Serializable {
  
  Logger log = Logger.getLogger(LinguaJpaController.class);

  public LinguaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Lingua lingua) {
    if (lingua.getDizionarioCollection() == null) {
      lingua.setDizionarioCollection(new ArrayList<Dizionario>());
    }
    if (lingua.getAnagrafeMacchinaCollection() == null) {
      lingua.setAnagrafeMacchinaCollection(new ArrayList<AnagrafeMacchina>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<Dizionario> attachedDizionarioCollection = new ArrayList<Dizionario>();
      for (Dizionario dizionarioCollectionDizionarioToAttach : lingua.getDizionarioCollection()) {
        dizionarioCollectionDizionarioToAttach = em.getReference(dizionarioCollectionDizionarioToAttach.getClass(), dizionarioCollectionDizionarioToAttach.getIdDizionario());
        attachedDizionarioCollection.add(dizionarioCollectionDizionarioToAttach);
      }
      lingua.setDizionarioCollection(attachedDizionarioCollection);
      Collection<AnagrafeMacchina> attachedAnagrafeMacchinaCollection = new ArrayList<AnagrafeMacchina>();
      for (AnagrafeMacchina anagrafeMacchinaCollectionAnagrafeMacchinaToAttach : lingua.getAnagrafeMacchinaCollection()) {
        anagrafeMacchinaCollectionAnagrafeMacchinaToAttach = em.getReference(anagrafeMacchinaCollectionAnagrafeMacchinaToAttach.getClass(), anagrafeMacchinaCollectionAnagrafeMacchinaToAttach.getIdAnMac());
        attachedAnagrafeMacchinaCollection.add(anagrafeMacchinaCollectionAnagrafeMacchinaToAttach);
      }
      lingua.setAnagrafeMacchinaCollection(attachedAnagrafeMacchinaCollection);
      em.persist(lingua);
      for (Dizionario dizionarioCollectionDizionario : lingua.getDizionarioCollection()) {
        Lingua oldIdLinguaOfDizionarioCollectionDizionario = dizionarioCollectionDizionario.getIdLingua();
        dizionarioCollectionDizionario.setIdLingua(lingua);
        dizionarioCollectionDizionario = em.merge(dizionarioCollectionDizionario);
        if (oldIdLinguaOfDizionarioCollectionDizionario != null) {
          oldIdLinguaOfDizionarioCollectionDizionario.getDizionarioCollection().remove(dizionarioCollectionDizionario);
          oldIdLinguaOfDizionarioCollectionDizionario = em.merge(oldIdLinguaOfDizionarioCollectionDizionario);
        }
      }
      for (AnagrafeMacchina anagrafeMacchinaCollectionAnagrafeMacchina : lingua.getAnagrafeMacchinaCollection()) {
        Lingua oldIdLinguaOfAnagrafeMacchinaCollectionAnagrafeMacchina = anagrafeMacchinaCollectionAnagrafeMacchina.getIdLingua();
        anagrafeMacchinaCollectionAnagrafeMacchina.setIdLingua(lingua);
        anagrafeMacchinaCollectionAnagrafeMacchina = em.merge(anagrafeMacchinaCollectionAnagrafeMacchina);
        if (oldIdLinguaOfAnagrafeMacchinaCollectionAnagrafeMacchina != null) {
          oldIdLinguaOfAnagrafeMacchinaCollectionAnagrafeMacchina.getAnagrafeMacchinaCollection().remove(anagrafeMacchinaCollectionAnagrafeMacchina);
          oldIdLinguaOfAnagrafeMacchinaCollectionAnagrafeMacchina = em.merge(oldIdLinguaOfAnagrafeMacchinaCollectionAnagrafeMacchina);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Lingua lingua) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Lingua persistentLingua = em.find(Lingua.class, lingua.getIdLingua());
      Collection<Dizionario> dizionarioCollectionOld = persistentLingua.getDizionarioCollection();
      Collection<Dizionario> dizionarioCollectionNew = lingua.getDizionarioCollection();
      Collection<AnagrafeMacchina> anagrafeMacchinaCollectionOld = persistentLingua.getAnagrafeMacchinaCollection();
      Collection<AnagrafeMacchina> anagrafeMacchinaCollectionNew = lingua.getAnagrafeMacchinaCollection();
      List<String> illegalOrphanMessages = null;
      for (Dizionario dizionarioCollectionOldDizionario : dizionarioCollectionOld) {
        if (!dizionarioCollectionNew.contains(dizionarioCollectionOldDizionario)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain Dizionario " + dizionarioCollectionOldDizionario + " since its idLingua field is not nullable.");
        }
      }
      for (AnagrafeMacchina anagrafeMacchinaCollectionOldAnagrafeMacchina : anagrafeMacchinaCollectionOld) {
        if (!anagrafeMacchinaCollectionNew.contains(anagrafeMacchinaCollectionOldAnagrafeMacchina)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain AnagrafeMacchina " + anagrafeMacchinaCollectionOldAnagrafeMacchina + " since its idLingua field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<Dizionario> attachedDizionarioCollectionNew = new ArrayList<Dizionario>();
      for (Dizionario dizionarioCollectionNewDizionarioToAttach : dizionarioCollectionNew) {
        dizionarioCollectionNewDizionarioToAttach = em.getReference(dizionarioCollectionNewDizionarioToAttach.getClass(), dizionarioCollectionNewDizionarioToAttach.getIdDizionario());
        attachedDizionarioCollectionNew.add(dizionarioCollectionNewDizionarioToAttach);
      }
      dizionarioCollectionNew = attachedDizionarioCollectionNew;
      lingua.setDizionarioCollection(dizionarioCollectionNew);
      Collection<AnagrafeMacchina> attachedAnagrafeMacchinaCollectionNew = new ArrayList<AnagrafeMacchina>();
      for (AnagrafeMacchina anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach : anagrafeMacchinaCollectionNew) {
        anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach = em.getReference(anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach.getClass(), anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach.getIdAnMac());
        attachedAnagrafeMacchinaCollectionNew.add(anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach);
      }
      anagrafeMacchinaCollectionNew = attachedAnagrafeMacchinaCollectionNew;
      lingua.setAnagrafeMacchinaCollection(anagrafeMacchinaCollectionNew);
      lingua = em.merge(lingua);
      for (Dizionario dizionarioCollectionNewDizionario : dizionarioCollectionNew) {
        if (!dizionarioCollectionOld.contains(dizionarioCollectionNewDizionario)) {
          Lingua oldIdLinguaOfDizionarioCollectionNewDizionario = dizionarioCollectionNewDizionario.getIdLingua();
          dizionarioCollectionNewDizionario.setIdLingua(lingua);
          dizionarioCollectionNewDizionario = em.merge(dizionarioCollectionNewDizionario);
          if (oldIdLinguaOfDizionarioCollectionNewDizionario != null && !oldIdLinguaOfDizionarioCollectionNewDizionario.equals(lingua)) {
            oldIdLinguaOfDizionarioCollectionNewDizionario.getDizionarioCollection().remove(dizionarioCollectionNewDizionario);
            oldIdLinguaOfDizionarioCollectionNewDizionario = em.merge(oldIdLinguaOfDizionarioCollectionNewDizionario);
          }
        }
      }
      for (AnagrafeMacchina anagrafeMacchinaCollectionNewAnagrafeMacchina : anagrafeMacchinaCollectionNew) {
        if (!anagrafeMacchinaCollectionOld.contains(anagrafeMacchinaCollectionNewAnagrafeMacchina)) {
          Lingua oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina = anagrafeMacchinaCollectionNewAnagrafeMacchina.getIdLingua();
          anagrafeMacchinaCollectionNewAnagrafeMacchina.setIdLingua(lingua);
          anagrafeMacchinaCollectionNewAnagrafeMacchina = em.merge(anagrafeMacchinaCollectionNewAnagrafeMacchina);
          if (oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina != null && !oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina.equals(lingua)) {
            oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina.getAnagrafeMacchinaCollection().remove(anagrafeMacchinaCollectionNewAnagrafeMacchina);
            oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina = em.merge(oldIdLinguaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = lingua.getIdLingua();
        if (findLingua(id) == null) {
          throw new NonexistentEntityException("The lingua with id " + id + " no longer exists.");
        }
      }
      throw ex;
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void destroy(Integer id) throws IllegalOrphanException, NonexistentEntityException {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Lingua lingua;
      try {
        lingua = em.getReference(Lingua.class, id);
        lingua.getIdLingua();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The lingua with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<Dizionario> dizionarioCollectionOrphanCheck = lingua.getDizionarioCollection();
      for (Dizionario dizionarioCollectionOrphanCheckDizionario : dizionarioCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Lingua (" + lingua + ") cannot be destroyed since the Dizionario " + dizionarioCollectionOrphanCheckDizionario + " in its dizionarioCollection field has a non-nullable idLingua field.");
      }
      Collection<AnagrafeMacchina> anagrafeMacchinaCollectionOrphanCheck = lingua.getAnagrafeMacchinaCollection();
      for (AnagrafeMacchina anagrafeMacchinaCollectionOrphanCheckAnagrafeMacchina : anagrafeMacchinaCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Lingua (" + lingua + ") cannot be destroyed since the AnagrafeMacchina " + anagrafeMacchinaCollectionOrphanCheckAnagrafeMacchina + " in its anagrafeMacchinaCollection field has a non-nullable idLingua field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(lingua);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Lingua> findLinguaEntities() {
    return findLinguaEntities(true, -1, -1);
  }

  public List<Lingua> findLinguaEntities(int maxResults, int firstResult) {
    return findLinguaEntities(false, maxResults, firstResult);
  }

  private List<Lingua> findLinguaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Lingua as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Lingua findLingua(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Lingua.class, id);
    } finally {
      em.close();
    }
  }

  public int getLinguaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Lingua as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
  public Collection<Lingua> findLinguaNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try{
      Query q = em.createNamedQuery("Lingua.findDatiNuovi");
      q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return   q.getResultList();
     
     } finally {
      em.close();
    } 
        
  }    
  
}
