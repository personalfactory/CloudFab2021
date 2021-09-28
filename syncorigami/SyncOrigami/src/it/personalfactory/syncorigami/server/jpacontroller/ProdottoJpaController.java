/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Prodotto;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ComponenteProdotto;
import java.util.ArrayList;
import java.util.Collection;
import it.personalfactory.syncorigami.server.entity.AnagrafeProdotto;
import it.personalfactory.syncorigami.server.entity.Macchina;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ProdottoJpaController implements Serializable {

  public ProdottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Prodotto prodotto) {
    if (prodotto.getComponenteProdottoCollection() == null) {
      prodotto.setComponenteProdottoCollection(new ArrayList<ComponenteProdotto>());
    }
    if (prodotto.getAnagrafeProdottoCollection() == null) {
      prodotto.setAnagrafeProdottoCollection(new ArrayList<AnagrafeProdotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ComponenteProdotto> attachedComponenteProdottoCollection = new ArrayList<ComponenteProdotto>();
      for (ComponenteProdotto componenteProdottoCollectionComponenteProdottoToAttach : prodotto.getComponenteProdottoCollection()) {
        componenteProdottoCollectionComponenteProdottoToAttach = em.getReference(componenteProdottoCollectionComponenteProdottoToAttach.getClass(), componenteProdottoCollectionComponenteProdottoToAttach.getIdCompProd());
        attachedComponenteProdottoCollection.add(componenteProdottoCollectionComponenteProdottoToAttach);
      }
      prodotto.setComponenteProdottoCollection(attachedComponenteProdottoCollection);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollection = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdottoToAttach : prodotto.getAnagrafeProdottoCollection()) {
        anagrafeProdottoCollectionAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollection.add(anagrafeProdottoCollectionAnagrafeProdottoToAttach);
      }
      prodotto.setAnagrafeProdottoCollection(attachedAnagrafeProdottoCollection);
      em.persist(prodotto);
      for (ComponenteProdotto componenteProdottoCollectionComponenteProdotto : prodotto.getComponenteProdottoCollection()) {
        Prodotto oldIdProdottoOfComponenteProdottoCollectionComponenteProdotto = componenteProdottoCollectionComponenteProdotto.getIdProdotto();
        componenteProdottoCollectionComponenteProdotto.setIdProdotto(prodotto);
        componenteProdottoCollectionComponenteProdotto = em.merge(componenteProdottoCollectionComponenteProdotto);
        if (oldIdProdottoOfComponenteProdottoCollectionComponenteProdotto != null) {
          oldIdProdottoOfComponenteProdottoCollectionComponenteProdotto.getComponenteProdottoCollection().remove(componenteProdottoCollectionComponenteProdotto);
          oldIdProdottoOfComponenteProdottoCollectionComponenteProdotto = em.merge(oldIdProdottoOfComponenteProdottoCollectionComponenteProdotto);
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionAnagrafeProdotto : prodotto.getAnagrafeProdottoCollection()) {
        Prodotto oldIdProdottoOfAnagrafeProdottoCollectionAnagrafeProdotto = anagrafeProdottoCollectionAnagrafeProdotto.getIdProdotto();
        anagrafeProdottoCollectionAnagrafeProdotto.setIdProdotto(prodotto);
        anagrafeProdottoCollectionAnagrafeProdotto = em.merge(anagrafeProdottoCollectionAnagrafeProdotto);
        if (oldIdProdottoOfAnagrafeProdottoCollectionAnagrafeProdotto != null) {
          oldIdProdottoOfAnagrafeProdottoCollectionAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionAnagrafeProdotto);
          oldIdProdottoOfAnagrafeProdottoCollectionAnagrafeProdotto = em.merge(oldIdProdottoOfAnagrafeProdottoCollectionAnagrafeProdotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Prodotto prodotto) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Prodotto persistentProdotto = em.find(Prodotto.class, prodotto.getIdProdotto());
      Collection<ComponenteProdotto> componenteProdottoCollectionOld = persistentProdotto.getComponenteProdottoCollection();
      Collection<ComponenteProdotto> componenteProdottoCollectionNew = prodotto.getComponenteProdottoCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOld = persistentProdotto.getAnagrafeProdottoCollection();
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionNew = prodotto.getAnagrafeProdottoCollection();
      List<String> illegalOrphanMessages = null;
      for (ComponenteProdotto componenteProdottoCollectionOldComponenteProdotto : componenteProdottoCollectionOld) {
        if (!componenteProdottoCollectionNew.contains(componenteProdottoCollectionOldComponenteProdotto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ComponenteProdotto " + componenteProdottoCollectionOldComponenteProdotto + " since its idProdotto field is not nullable.");
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionOldAnagrafeProdotto : anagrafeProdottoCollectionOld) {
        if (!anagrafeProdottoCollectionNew.contains(anagrafeProdottoCollectionOldAnagrafeProdotto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain AnagrafeProdotto " + anagrafeProdottoCollectionOldAnagrafeProdotto + " since its idProdotto field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ComponenteProdotto> attachedComponenteProdottoCollectionNew = new ArrayList<ComponenteProdotto>();
      for (ComponenteProdotto componenteProdottoCollectionNewComponenteProdottoToAttach : componenteProdottoCollectionNew) {
        componenteProdottoCollectionNewComponenteProdottoToAttach = em.getReference(componenteProdottoCollectionNewComponenteProdottoToAttach.getClass(), componenteProdottoCollectionNewComponenteProdottoToAttach.getIdCompProd());
        attachedComponenteProdottoCollectionNew.add(componenteProdottoCollectionNewComponenteProdottoToAttach);
      }
      componenteProdottoCollectionNew = attachedComponenteProdottoCollectionNew;
      prodotto.setComponenteProdottoCollection(componenteProdottoCollectionNew);
      Collection<AnagrafeProdotto> attachedAnagrafeProdottoCollectionNew = new ArrayList<AnagrafeProdotto>();
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdottoToAttach : anagrafeProdottoCollectionNew) {
        anagrafeProdottoCollectionNewAnagrafeProdottoToAttach = em.getReference(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getClass(), anagrafeProdottoCollectionNewAnagrafeProdottoToAttach.getIdAnProd());
        attachedAnagrafeProdottoCollectionNew.add(anagrafeProdottoCollectionNewAnagrafeProdottoToAttach);
      }
      anagrafeProdottoCollectionNew = attachedAnagrafeProdottoCollectionNew;
      prodotto.setAnagrafeProdottoCollection(anagrafeProdottoCollectionNew);
      prodotto = em.merge(prodotto);
      for (ComponenteProdotto componenteProdottoCollectionNewComponenteProdotto : componenteProdottoCollectionNew) {
        if (!componenteProdottoCollectionOld.contains(componenteProdottoCollectionNewComponenteProdotto)) {
          Prodotto oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto = componenteProdottoCollectionNewComponenteProdotto.getIdProdotto();
          componenteProdottoCollectionNewComponenteProdotto.setIdProdotto(prodotto);
          componenteProdottoCollectionNewComponenteProdotto = em.merge(componenteProdottoCollectionNewComponenteProdotto);
          if (oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto != null && !oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto.equals(prodotto)) {
            oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto.getComponenteProdottoCollection().remove(componenteProdottoCollectionNewComponenteProdotto);
            oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto = em.merge(oldIdProdottoOfComponenteProdottoCollectionNewComponenteProdotto);
          }
        }
      }
      for (AnagrafeProdotto anagrafeProdottoCollectionNewAnagrafeProdotto : anagrafeProdottoCollectionNew) {
        if (!anagrafeProdottoCollectionOld.contains(anagrafeProdottoCollectionNewAnagrafeProdotto)) {
          Prodotto oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto = anagrafeProdottoCollectionNewAnagrafeProdotto.getIdProdotto();
          anagrafeProdottoCollectionNewAnagrafeProdotto.setIdProdotto(prodotto);
          anagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(anagrafeProdottoCollectionNewAnagrafeProdotto);
          if (oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto != null && !oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto.equals(prodotto)) {
            oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdottoCollectionNewAnagrafeProdotto);
            oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto = em.merge(oldIdProdottoOfAnagrafeProdottoCollectionNewAnagrafeProdotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = prodotto.getIdProdotto();
        if (findProdotto(id) == null) {
          throw new NonexistentEntityException("The prodotto with id " + id + " no longer exists.");
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
      Prodotto prodotto;
      try {
        prodotto = em.getReference(Prodotto.class, id);
        prodotto.getIdProdotto();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The prodotto with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ComponenteProdotto> componenteProdottoCollectionOrphanCheck = prodotto.getComponenteProdottoCollection();
      for (ComponenteProdotto componenteProdottoCollectionOrphanCheckComponenteProdotto : componenteProdottoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Prodotto (" + prodotto + ") cannot be destroyed since the ComponenteProdotto " + componenteProdottoCollectionOrphanCheckComponenteProdotto + " in its componenteProdottoCollection field has a non-nullable idProdotto field.");
      }
      Collection<AnagrafeProdotto> anagrafeProdottoCollectionOrphanCheck = prodotto.getAnagrafeProdottoCollection();
      for (AnagrafeProdotto anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto : anagrafeProdottoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Prodotto (" + prodotto + ") cannot be destroyed since the AnagrafeProdotto " + anagrafeProdottoCollectionOrphanCheckAnagrafeProdotto + " in its anagrafeProdottoCollection field has a non-nullable idProdotto field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(prodotto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Prodotto> findProdottoEntities() {
    return findProdottoEntities(true, -1, -1);
  }

  public List<Prodotto> findProdottoEntities(int maxResults, int firstResult) {
    return findProdottoEntities(false, maxResults, firstResult);
  }

  private List<Prodotto> findProdottoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Prodotto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Prodotto findProdotto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Prodotto.class, id);
    } finally {
      em.close();
    }
  }

  public int getProdottoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Prodotto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<Prodotto> findProdottoNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Prodotto.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
  
  
  /**
   * 20-10-2015
     * Metodo che seleziona i prodotti dalla tabella prodotto in base al gruppo di appartenenza della macchina
     * @param idMacchina
     * @return 
     */
     public Collection<Prodotto> findProdottoGruppo(Macchina idMacchina) {
                        
        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT pr FROM Prodotto pr, AnagrafeProdotto p, Gruppo g, AnagrafeMacchina m "
                    + "WHERE "
                            + "CASE "
                            + "WHEN (m.gruppo = g.livello6) THEN 64 "
                            + "WHEN (m.gruppo = g.livello5) THEN 32 "
                            + "WHEN (m.gruppo = g.livello4) THEN 16 "
                            + "WHEN (m.gruppo = g.livello3) THEN 8 "
                            + "WHEN (m.gruppo = g.livello2) THEN 4 "
                            + "WHEN (m.gruppo = g.livello1) THEN 2 "
                            + "END "
                            + "<= "
                            + "CASE "
                            + "WHEN (p.gruppo = g.livello6) THEN 64 "
                            + "WHEN (p.gruppo = g.livello5) THEN 32 "
                            + "WHEN (p.gruppo = g.livello4) THEN 16 "
                            + "WHEN (p.gruppo = g.livello3) THEN 8 "
                            + "WHEN (p.gruppo = g.livello2) THEN 4 "
                            + "WHEN (p.gruppo = g.livello1) THEN 2 "
                            + "END "
                        + "AND "
                            + "((m.gruppo = g.livello1) OR "
                            + "(m.gruppo = g.livello2) OR "
                            + "(m.gruppo = g.livello3) OR "
                            + "(m.gruppo = g.livello4) OR "
                            + "(m.gruppo = g.livello5) OR "
                            + "(m.gruppo = g.livello6)) "
                        + "AND "
                            + "((p.gruppo = g.livello1) OR "
                            + "(p.gruppo = g.livello2) OR "
                            + "(p.gruppo = g.livello3) OR "
                            + "(p.gruppo = g.livello4) OR "
                            + "(p.gruppo = g.livello5) OR "
                            + "(p.gruppo = g.livello6)) "
                        + "AND "
                            + "m.idMacchina = :idMacchina "
                        + "AND "
                         +  "pr.idProdotto = p.idProdotto"                       
                    + " GROUP BY "
                        + "p.idProdotto, "
                        + "m.idMacchina, "
                        + "p.gruppo, "
                        + "m.gruppo "
                    + " ORDER BY "
                        + "p.idProdotto"
                       );
      
            q.setParameter("idMacchina", idMacchina);
           
            return q.getResultList();

        } finally {
            em.close();
        }

    }
    
    /**
     * 20-10-2015
     * Metodo che seleziona i prodotti dalla tabella prodotto in base al riferimento geografico della macchina
     * @param idMacchina
     * @return 
     */
    public Collection<Prodotto> findProdottoGeo(Macchina idMacchina) {

        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT pr FROM Prodotto pr, AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
                    + "WHERE "
                            + "CASE "                    
                            + "WHEN (m.geografico = c.mondo) THEN 64 "
                            + "WHEN (m.geografico = c.continente) THEN 32 "
                            + "WHEN (m.geografico = c.stato) THEN 16 "
                            + "WHEN (m.geografico = c.regione) THEN 8 "
                            + "WHEN (m.geografico = c.provincia) THEN 4 "
                            + "WHEN (m.geografico = c.comune) THEN 2 "
                            + "END "
                            + "<= "
                            + "CASE "
                            + "WHEN (p.geografico = c.mondo) THEN 64 "
                            + "WHEN (p.geografico = c.continente) THEN 32 "
                            + "WHEN (p.geografico = c.stato) THEN 16 "
                            + "WHEN (p.geografico = c.regione) THEN 8 "
                            + "WHEN (p.geografico = c.provincia) THEN 4 "
                            + "WHEN (p.geografico = c.comune) THEN 2 "
                            + "END "
                        + "AND "
                            + "((m.geografico = c.mondo) OR "
                            + "(m.geografico = c.continente) OR "
                            + "(m.geografico = c.stato) OR "
                            + "(m.geografico = c.regione) OR "
                            + "(m.geografico = c.provincia) OR "
                            + "(m.geografico = c.comune)) "
                        + "AND "
                            + "((p.geografico = c.mondo) OR "
                            + "(p.geografico = c.continente) OR "
                            + "(p.geografico = c.stato) OR "
                            + "(p.geografico = c.regione) OR "
                            + "(p.geografico = c.provincia) OR "
                            + "(p.geografico = c.comune)) "
                        + "AND "
                            + "m.idMacchina = :idMacchina "
                        + "AND "
                            + "pr.idProdotto = p.idProdotto "
                       
                    + " GROUP BY "
                        + "p.idProdotto, "
                        + "m.idMacchina, "
                        + "p.geografico, "
                        + "m.geografico "
                    + " ORDER BY "
                        + "p.idProdotto"
                        );
      
            q.setParameter("idMacchina", idMacchina);
            
            return q.getResultList();

        } finally {
            em.close();
        }

    }
    
    
    /**
     * 20-10-2015
     * Metodo che seleziona tutti i prodotti dalla tabella prodotto in base al gruppo e al rif geo facendo l'intersezione
     * @param idMacchina
     * @param emf
     * @return 
     */
    public Collection<Prodotto> findProdottiAssegnati(Macchina idMacchina) {
        
        
        Collection<Prodotto> prodottoGruppoColl = this.findProdottoGruppo(idMacchina);
        Collection<Prodotto> prodottoGeoColl = this.findProdottoGeo(idMacchina);

        Collection<Prodotto> prodottiAssegnatiColl = new ArrayList();
        

        //############ INTERSEZIONE DEI PRODOTTI ############################### 
        for (Object obj : prodottoGruppoColl) {
            Prodotto prodotto = (Prodotto) obj;
            //Per ogni prodotto che viene assegnato in base al gruppo
            //verifico se è stato assegnato anche in base al rif geografico
            //e in tal caso lo aggiungo alla collection dei prodotti assegnati       
            if (prodottoGeoColl.contains(prodotto)) {
                prodottiAssegnatiColl.add(prodotto);
            }
        }
        return prodottiAssegnatiColl;
    }
}
