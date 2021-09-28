/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.AnagrafeProdotto;
import it.personalfactory.syncorigami.server.entity.Categoria;
import it.personalfactory.syncorigami.server.entity.NumSacchetto;
import it.personalfactory.syncorigami.server.entity.ValoreParProd;
import it.personalfactory.syncorigami.server.entity.ValoreParSacchetto;
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


/**
 *
 * @author marilisa
 */
public class CategoriaJpaController implements Serializable {

  public CategoriaJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Categoria categoria) {
    if (categoria.getValoreParSacchettoCollection() == null) {
      categoria.setValoreParSacchettoCollection(new ArrayList<ValoreParSacchetto>());
    }
    if (categoria.getNumSacchettoCollection() == null) {
      categoria.setNumSacchettoCollection(new ArrayList<NumSacchetto>());
    }
    if (categoria.getValoreParProdCollection() == null) {
      categoria.setValoreParProdCollection(new ArrayList<ValoreParProd>());
    }
    if (categoria.getAnagrafeProdottoCollection() == null) {
      categoria.setAnagrafeProdottoCollection(new ArrayList<AnagrafeProdotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollection = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchettoToAttach : categoria.getValoreParSacchettoCollection()) {
        valoreParSacchettoCollectionValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollection.add(valoreParSacchettoCollectionValoreParSacchettoToAttach);
      }
      categoria.setValoreParSacchettoCollection(attachedValoreParSacchettoCollection);
      Collection<NumSacchetto> attachedNumSacchettoCollection = new ArrayList<NumSacchetto>();
      for (NumSacchetto numSacchettoCollectionNumSacchettoToAttach : categoria.getNumSacchettoCollection()) {
        numSacchettoCollectionNumSacchettoToAttach = em.getReference(numSacchettoCollectionNumSacchettoToAttach.getClass(), numSacchettoCollectionNumSacchettoToAttach.getIdNumSac());
        attachedNumSacchettoCollection.add(numSacchettoCollectionNumSacchettoToAttach);
      }
      categoria.setNumSacchettoCollection(attachedNumSacchettoCollection);
      Collection<ValoreParProd> attachedValoreParProdCollection = new ArrayList<ValoreParProd>();
      for (ValoreParProd valoreParProdCollectionValoreParProdToAttach : categoria.getValoreParProdCollection()) {
        valoreParProdCollectionValoreParProdToAttach = em.getReference(valoreParProdCollectionValoreParProdToAttach.getClass(), valoreParProdCollectionValoreParProdToAttach.getIdValParPr());
        attachedValoreParProdCollection.add(valoreParProdCollectionValoreParProdToAttach);
      }
      categoria.setValoreParProdCollection(attachedValoreParProdCollection);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollection = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdottoToAttach : categoria.getAnagrafeProdottoCollection()) {
        anagrafeProdottoCollectionAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollection.add(anagrafeProdottoCollectionAnagrafeProdottoToAttach);
      }
      categoria.setAnagrafeProdottoCollection(attachedAnagrafeProdottoCollection);
      em.persist(categoria);
      for (ValoreParSacchetto valoreParSacchettoCollectionValoreParSacchetto : categoria.getValoreParSacchettoCollection()) {
        Categoria oldIdCatOfValoreParSacchettoCollectionValoreParSacchetto = valoreParSacchettoCollectionValoreParSacchetto.getIdCat();
        valoreParSacchettoCollectionValoreParSacchetto.setIdCat(categoria);
        valoreParSacchettoCollectionValoreParSacchetto = em.merge(valoreParSacchettoCollectionValoreParSacchetto);
        if (oldIdCatOfValoreParSacchettoCollectionValoreParSacchetto != null) {
          oldIdCatOfValoreParSacchettoCollectionValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionValoreParSacchetto);
          oldIdCatOfValoreParSacchettoCollectionValoreParSacchetto = em.merge(oldIdCatOfValoreParSacchettoCollectionValoreParSacchetto);
        }
      }
      for (NumSacchetto numSacchettoCollectionNumSacchetto : categoria.getNumSacchettoCollection()) {
        Categoria oldIdCatOfNumSacchettoCollectionNumSacchetto = numSacchettoCollectionNumSacchetto.getIdCat();
        numSacchettoCollectionNumSacchetto.setIdCat(categoria);
        numSacchettoCollectionNumSacchetto = em.merge(numSacchettoCollectionNumSacchetto);
        if (oldIdCatOfNumSacchettoCollectionNumSacchetto != null) {
          oldIdCatOfNumSacchettoCollectionNumSacchetto.getNumSacchettoCollection().remove(numSacchettoCollectionNumSacchetto);
          oldIdCatOfNumSacchettoCollectionNumSacchetto = em.merge(oldIdCatOfNumSacchettoCollectionNumSacchetto);
        }
      }
      for (ValoreParProd valoreParProdCollectionValoreParProd : categoria.getValoreParProdCollection()) {
        Categoria oldIdCatOfValoreParProdCollectionValoreParProd = valoreParProdCollectionValoreParProd.getIdCat();
        valoreParProdCollectionValoreParProd.setIdCat(categoria);
        valoreParProdCollectionValoreParProd = em.merge(valoreParProdCollectionValoreParProd);
        if (oldIdCatOfValoreParProdCollectionValoreParProd != null) {
          oldIdCatOfValoreParProdCollectionValoreParProd.getValoreParProdCollection().remove(valoreParProdCollectionValoreParProd);
          oldIdCatOfValoreParProdCollectionValoreParProd = em.merge(oldIdCatOfValoreParProdCollectionValoreParProd);
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdotto : categoria.getAnagrafeProdottoCollection()) {
        Categoria oldIdCatOfAnagrafeProdottoCollectionAnagrafeProdotto = anagrafeProdottoCollectionAnagrafeProdotto.getIdCat();
        anagrafeProdottoCollectionAnagrafeProdotto.setIdCat(categoria);
        anagrafeProdottoCollectionAnagrafeProdotto = em.merge(anagrafeProdottoCollectionAnagrafeProdotto);
        if (oldIdCatOfAnagrafeProdottoCollectionAnagrafeProdotto != null) {
          oldIdCatOfAnagrafeProdottoCollectionAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionAnagrafeProdotto);
          oldIdCatOfAnagrafeProdottoCollectionAnagrafeProdotto = em.merge(oldIdCatOfAnagrafeProdottoCollectionAnagrafeProdotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Categoria categoria) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Categoria persistentCategoria = em.find(Categoria.class, categoria.getIdCat());
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionOld = persistentCategoria.getValoreParSacchettoCollection();
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionNew = categoria.getValoreParSacchettoCollection();
      Collection<NumSacchetto> numSacchettoCollectionOld = persistentCategoria.getNumSacchettoCollection();
      Collection<NumSacchetto> numSacchettoCollectionNew = categoria.getNumSacchettoCollection();
      Collection<ValoreParProd> valoreParProdCollectionOld = persistentCategoria.getValoreParProdCollection();
      Collection<ValoreParProd> valoreParProdCollectionNew = categoria.getValoreParProdCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOld = persistentCategoria.getAnagrafeProdottoCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionNew = categoria.getAnagrafeProdottoCollection();
      List<String> illegalOrphanMessages = null;
      for (ValoreParSacchetto valoreParSacchettoCollectionOldValoreParSacchetto : valoreParSacchettoCollectionOld) {
        if (!valoreParSacchettoCollectionNew.contains(valoreParSacchettoCollectionOldValoreParSacchetto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParSacchetto " + valoreParSacchettoCollectionOldValoreParSacchetto + " since its idCat field is not nullable.");
        }
      }
      for (NumSacchetto numSacchettoCollectionOldNumSacchetto : numSacchettoCollectionOld) {
        if (!numSacchettoCollectionNew.contains(numSacchettoCollectionOldNumSacchetto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain NumSacchetto " + numSacchettoCollectionOldNumSacchetto + " since its idCat field is not nullable.");
        }
      }
      for (ValoreParProd valoreParProdCollectionOldValoreParProd : valoreParProdCollectionOld) {
        if (!valoreParProdCollectionNew.contains(valoreParProdCollectionOldValoreParProd)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParProd " + valoreParProdCollectionOldValoreParProd + " since its idCat field is not nullable.");
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionOldAnagrafeProdotto : anagrafeProdottoCollectionOld) {
        if (!anagrafeProdottoCollectionNew.contains(anagrafeProdottoCollectionOldAnagrafeProdotto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain AnagrafeProdotto " + anagrafeProdottoCollectionOldAnagrafeProdotto + " since its idCat field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ValoreParSacchetto> attachedValoreParSacchettoCollectionNew = new ArrayList<ValoreParSacchetto>();
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchettoToAttach : valoreParSacchettoCollectionNew) {
        valoreParSacchettoCollectionNewValoreParSacchettoToAttach = em.getReference(valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getClass(), valoreParSacchettoCollectionNewValoreParSacchettoToAttach.getIdValParSac());
        attachedValoreParSacchettoCollectionNew.add(valoreParSacchettoCollectionNewValoreParSacchettoToAttach);
      }
      valoreParSacchettoCollectionNew = attachedValoreParSacchettoCollectionNew;
      categoria.setValoreParSacchettoCollection(valoreParSacchettoCollectionNew);
      Collection<NumSacchetto> attachedNumSacchettoCollectionNew = new ArrayList<NumSacchetto>();
      for (NumSacchetto numSacchettoCollectionNewNumSacchettoToAttach : numSacchettoCollectionNew) {
        numSacchettoCollectionNewNumSacchettoToAttach = em.getReference(numSacchettoCollectionNewNumSacchettoToAttach.getClass(), numSacchettoCollectionNewNumSacchettoToAttach.getIdNumSac());
        attachedNumSacchettoCollectionNew.add(numSacchettoCollectionNewNumSacchettoToAttach);
      }
      numSacchettoCollectionNew = attachedNumSacchettoCollectionNew;
      categoria.setNumSacchettoCollection(numSacchettoCollectionNew);
      Collection<ValoreParProd> attachedValoreParProdCollectionNew = new ArrayList<ValoreParProd>();
      for (ValoreParProd valoreParProdCollectionNewValoreParProdToAttach : valoreParProdCollectionNew) {
        valoreParProdCollectionNewValoreParProdToAttach = em.getReference(valoreParProdCollectionNewValoreParProdToAttach.getClass(), valoreParProdCollectionNewValoreParProdToAttach.getIdValParPr());
        attachedValoreParProdCollectionNew.add(valoreParProdCollectionNewValoreParProdToAttach);
      }
      valoreParProdCollectionNew = attachedValoreParProdCollectionNew;
      categoria.setValoreParProdCollection(valoreParProdCollectionNew);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollectionNew = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdottoToAttach : anagrafeProdottoCollectionNew) {
        anagrafeProdottoCollectionNewAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollectionNew.add(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach);
      }
      anagrafeProdottoCollectionNew = attachedAnagrafeProdottoCollectionNew;
      categoria.setAnagrafeProdottoCollection(anagrafeProdottoCollectionNew);
      categoria = em.merge(categoria);
      for (ValoreParSacchetto valoreParSacchettoCollectionNewValoreParSacchetto : valoreParSacchettoCollectionNew) {
        if (!valoreParSacchettoCollectionOld.contains(valoreParSacchettoCollectionNewValoreParSacchetto)) {
          Categoria oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto = valoreParSacchettoCollectionNewValoreParSacchetto.getIdCat();
          valoreParSacchettoCollectionNewValoreParSacchetto.setIdCat(categoria);
          valoreParSacchettoCollectionNewValoreParSacchetto = em.merge(valoreParSacchettoCollectionNewValoreParSacchetto);
          if (oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto != null && !oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto.equals(categoria)) {
            oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto.getValoreParSacchettoCollection().remove(valoreParSacchettoCollectionNewValoreParSacchetto);
            oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto = em.merge(oldIdCatOfValoreParSacchettoCollectionNewValoreParSacchetto);
          }
        }
      }
      for (NumSacchetto numSacchettoCollectionNewNumSacchetto : numSacchettoCollectionNew) {
        if (!numSacchettoCollectionOld.contains(numSacchettoCollectionNewNumSacchetto)) {
          Categoria oldIdCatOfNumSacchettoCollectionNewNumSacchetto = numSacchettoCollectionNewNumSacchetto.getIdCat();
          numSacchettoCollectionNewNumSacchetto.setIdCat(categoria);
          numSacchettoCollectionNewNumSacchetto = em.merge(numSacchettoCollectionNewNumSacchetto);
          if (oldIdCatOfNumSacchettoCollectionNewNumSacchetto != null && !oldIdCatOfNumSacchettoCollectionNewNumSacchetto.equals(categoria)) {
            oldIdCatOfNumSacchettoCollectionNewNumSacchetto.getNumSacchettoCollection().remove(numSacchettoCollectionNewNumSacchetto);
            oldIdCatOfNumSacchettoCollectionNewNumSacchetto = em.merge(oldIdCatOfNumSacchettoCollectionNewNumSacchetto);
          }
        }
      }
      for (ValoreParProd valoreParProdCollectionNewValoreParProd : valoreParProdCollectionNew) {
        if (!valoreParProdCollectionOld.contains(valoreParProdCollectionNewValoreParProd)) {
          Categoria oldIdCatOfValoreParProdCollectionNewValoreParProd = valoreParProdCollectionNewValoreParProd.getIdCat();
          valoreParProdCollectionNewValoreParProd.setIdCat(categoria);
          valoreParProdCollectionNewValoreParProd = em.merge(valoreParProdCollectionNewValoreParProd);
          if (oldIdCatOfValoreParProdCollectionNewValoreParProd != null && !oldIdCatOfValoreParProdCollectionNewValoreParProd.equals(categoria)) {
            oldIdCatOfValoreParProdCollectionNewValoreParProd.getValoreParProdCollection().remove(valoreParProdCollectionNewValoreParProd);
            oldIdCatOfValoreParProdCollectionNewValoreParProd = em.merge(oldIdCatOfValoreParProdCollectionNewValoreParProd);
          }
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdotto : anagrafeProdottoCollectionNew) {
        if (!anagrafeProdottoCollectionOld.contains(anagrafeProdottoCollectionNewAnagrafeProdotto)) {
          Categoria oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto = anagrafeProdottoCollectionNewAnagrafeProdotto.getIdCat();
          anagrafeProdottoCollectionNewAnagrafeProdotto.setIdCat(categoria);
          anagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(anagrafeProdottoCollectionNewAnagrafeProdotto);
          if (oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto != null && !oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto.equals(categoria)) {
            oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionNewAnagrafeProdotto);
            oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(oldIdCatOfAnagrafeProdottoCollectionNewAnagrafeProdotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = categoria.getIdCat();
        if (findCategoria(id) == null) {
          throw new NonexistentEntityException("The categoria with id " + id + " no longer exists.");
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
      Categoria categoria;
      try {
        categoria = em.getReference(Categoria.class, id);
        categoria.getIdCat();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The categoria with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ValoreParSacchetto> valoreParSacchettoCollectionOrphanCheck = categoria.getValoreParSacchettoCollection();
      for (ValoreParSacchetto valoreParSacchettoCollectionOrphanCheckValoreParSacchetto : valoreParSacchettoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Categoria (" + categoria + ") cannot be destroyed since the ValoreParSacchetto " + valoreParSacchettoCollectionOrphanCheckValoreParSacchetto + " in its valoreParSacchettoCollection field has a non-nullable idCat field.");
      }
      Collection<NumSacchetto> numSacchettoCollectionOrphanCheck = categoria.getNumSacchettoCollection();
      for (NumSacchetto numSacchettoCollectionOrphanCheckNumSacchetto : numSacchettoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Categoria (" + categoria + ") cannot be destroyed since the NumSacchetto " + numSacchettoCollectionOrphanCheckNumSacchetto + " in its numSacchettoCollection field has a non-nullable idCat field.");
      }
      Collection<ValoreParProd> valoreParProdCollectionOrphanCheck = categoria.getValoreParProdCollection();
      for (ValoreParProd valoreParProdCollectionOrphanCheckValoreParProd : valoreParProdCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Categoria (" + categoria + ") cannot be destroyed since the ValoreParProd " + valoreParProdCollectionOrphanCheckValoreParProd + " in its valoreParProdCollection field has a non-nullable idCat field.");
      }
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOrphanCheck = categoria.getAnagrafeProdottoCollection();
      for (AnagrafeProdotto anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto : anagrafeProdottoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Categoria (" + categoria + ") cannot be destroyed since the AnagrafeProdotto " + anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto + " in its anagrafeProdottoCollection field has a non-nullable idCat field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(categoria);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Categoria> findCategoriaEntities() {
    return findCategoriaEntities(true, -1, -1);
  }

  public List<Categoria> findCategoriaEntities(int maxResults, int firstResult) {
    return findCategoriaEntities(false, maxResults, firstResult);
  }

  private List<Categoria> findCategoriaEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Categoria as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Categoria findCategoria(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Categoria.class, id);
    } finally {
      em.close();
    }
  }

  public int getCategoriaCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Categoria as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  
   /**
   * Metodo che restituisce le categorie nuove
   * @param data di costruzione dell'ultimo aggiornamento 
   * @return Una collection di categorie
   * Per recuperare le categorie nuove lato server 
   * si confronta la data dell'ultimo aggiornamento con il valore del campo dtAbilitato
   * N.B. Le categorie viaggiano in un solo verso ovvero dal serveralle macchine
   */
  public Collection<Categoria> findCategoriaNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Categoria.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
}
