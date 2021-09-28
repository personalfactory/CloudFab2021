/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Componente;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ValoreParComp;
import java.util.ArrayList;
import java.util.Collection;
import it.personalfactory.syncorigami.server.entity.ComponenteProdotto;
import it.personalfactory.syncorigami.server.entity.Macchina;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ComponenteJpaController implements Serializable {

  public ComponenteJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(Componente componente) {
    if (componente.getValoreParCompCollection() == null) {
      componente.setValoreParCompCollection(new ArrayList<ValoreParComp>());
    }
    if (componente.getComponenteProdottoCollection() == null) {
      componente.setComponenteProdottoCollection(new ArrayList<ComponenteProdotto>());
    }
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Collection<ValoreParComp> attachedValoreParCompCollection = new ArrayList<ValoreParComp>();
      for (ValoreParComp valoreParCompCollectionValoreParCompToAttach : componente.getValoreParCompCollection()) {
        valoreParCompCollectionValoreParCompToAttach = em.getReference(valoreParCompCollectionValoreParCompToAttach.getClass(), valoreParCompCollectionValoreParCompToAttach.getIdValComp());
        attachedValoreParCompCollection.add(valoreParCompCollectionValoreParCompToAttach);
      }
      componente.setValoreParCompCollection(attachedValoreParCompCollection);
      Collection<ComponenteProdotto> attachedComponenteProdottoCollection = new ArrayList<ComponenteProdotto>();
      for (ComponenteProdotto componenteProdottoCollectionComponenteProdottoToAttach : componente.getComponenteProdottoCollection()) {
        componenteProdottoCollectionComponenteProdottoToAttach = em.getReference(componenteProdottoCollectionComponenteProdottoToAttach.getClass(), componenteProdottoCollectionComponenteProdottoToAttach.getIdCompProd());
        attachedComponenteProdottoCollection.add(componenteProdottoCollectionComponenteProdottoToAttach);
      }
      componente.setComponenteProdottoCollection(attachedComponenteProdottoCollection);
      em.persist(componente);
      for (ValoreParComp valoreParCompCollectionValoreParComp : componente.getValoreParCompCollection()) {
        Componente oldIdCompOfValoreParCompCollectionValoreParComp = valoreParCompCollectionValoreParComp.getIdComp();
        valoreParCompCollectionValoreParComp.setIdComp(componente);
        valoreParCompCollectionValoreParComp = em.merge(valoreParCompCollectionValoreParComp);
        if (oldIdCompOfValoreParCompCollectionValoreParComp != null) {
          oldIdCompOfValoreParCompCollectionValoreParComp.getValoreParCompCollection().remove(valoreParCompCollectionValoreParComp);
          oldIdCompOfValoreParCompCollectionValoreParComp = em.merge(oldIdCompOfValoreParCompCollectionValoreParComp);
        }
      }
      for (ComponenteProdotto componenteProdottoCollectionComponenteProdotto : componente.getComponenteProdottoCollection()) {
        Componente oldIdCompOfComponenteProdottoCollectionComponenteProdotto = componenteProdottoCollectionComponenteProdotto.getIdComp();
        componenteProdottoCollectionComponenteProdotto.setIdComp(componente);
        componenteProdottoCollectionComponenteProdotto = em.merge(componenteProdottoCollectionComponenteProdotto);
        if (oldIdCompOfComponenteProdottoCollectionComponenteProdotto != null) {
          oldIdCompOfComponenteProdottoCollectionComponenteProdotto.getComponenteProdottoCollection().remove(componenteProdottoCollectionComponenteProdotto);
          oldIdCompOfComponenteProdottoCollectionComponenteProdotto = em.merge(oldIdCompOfComponenteProdottoCollectionComponenteProdotto);
        }
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(Componente componente) throws IllegalOrphanException, NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Componente persistentComponente = em.find(Componente.class, componente.getIdComp());
      Collection<ValoreParComp> valoreParCompCollectionOld = persistentComponente.getValoreParCompCollection();
      Collection<ValoreParComp> valoreParCompCollectionNew = componente.getValoreParCompCollection();
      Collection<ComponenteProdotto> componenteProdottoCollectionOld = persistentComponente.getComponenteProdottoCollection();
      Collection<ComponenteProdotto> componenteProdottoCollectionNew = componente.getComponenteProdottoCollection();
      List<String> illegalOrphanMessages = null;
      for (ValoreParComp valoreParCompCollectionOldValoreParComp : valoreParCompCollectionOld) {
        if (!valoreParCompCollectionNew.contains(valoreParCompCollectionOldValoreParComp)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ValoreParComp " + valoreParCompCollectionOldValoreParComp + " since its idComp field is not nullable.");
        }
      }
      for (ComponenteProdotto componenteProdottoCollectionOldComponenteProdotto : componenteProdottoCollectionOld) {
        if (!componenteProdottoCollectionNew.contains(componenteProdottoCollectionOldComponenteProdotto)) {
          if (illegalOrphanMessages == null) {
            illegalOrphanMessages = new ArrayList<String>();
          }
          illegalOrphanMessages.add("You must retain ComponenteProdotto " + componenteProdottoCollectionOldComponenteProdotto + " since its idComp field is not nullable.");
        }
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      Collection<ValoreParComp> attachedValoreParCompCollectionNew = new ArrayList<ValoreParComp>();
      for (ValoreParComp valoreParCompCollectionNewValoreParCompToAttach : valoreParCompCollectionNew) {
        valoreParCompCollectionNewValoreParCompToAttach = em.getReference(valoreParCompCollectionNewValoreParCompToAttach.getClass(), valoreParCompCollectionNewValoreParCompToAttach.getIdValComp());
        attachedValoreParCompCollectionNew.add(valoreParCompCollectionNewValoreParCompToAttach);
      }
      valoreParCompCollectionNew = attachedValoreParCompCollectionNew;
      componente.setValoreParCompCollection(valoreParCompCollectionNew);
      Collection<ComponenteProdotto> attachedComponenteProdottoCollectionNew = new ArrayList<ComponenteProdotto>();
      for (ComponenteProdotto componenteProdottoCollectionNewComponenteProdottoToAttach : componenteProdottoCollectionNew) {
        componenteProdottoCollectionNewComponenteProdottoToAttach = em.getReference(componenteProdottoCollectionNewComponenteProdottoToAttach.getClass(), componenteProdottoCollectionNewComponenteProdottoToAttach.getIdCompProd());
        attachedComponenteProdottoCollectionNew.add(componenteProdottoCollectionNewComponenteProdottoToAttach);
      }
      componenteProdottoCollectionNew = attachedComponenteProdottoCollectionNew;
      componente.setComponenteProdottoCollection(componenteProdottoCollectionNew);
      componente = em.merge(componente);
      for (ValoreParComp valoreParCompCollectionNewValoreParComp : valoreParCompCollectionNew) {
        if (!valoreParCompCollectionOld.contains(valoreParCompCollectionNewValoreParComp)) {
          Componente oldIdCompOfValoreParCompCollectionNewValoreParComp = valoreParCompCollectionNewValoreParComp.getIdComp();
          valoreParCompCollectionNewValoreParComp.setIdComp(componente);
          valoreParCompCollectionNewValoreParComp = em.merge(valoreParCompCollectionNewValoreParComp);
          if (oldIdCompOfValoreParCompCollectionNewValoreParComp != null && !oldIdCompOfValoreParCompCollectionNewValoreParComp.equals(componente)) {
            oldIdCompOfValoreParCompCollectionNewValoreParComp.getValoreParCompCollection().remove(valoreParCompCollectionNewValoreParComp);
            oldIdCompOfValoreParCompCollectionNewValoreParComp = em.merge(oldIdCompOfValoreParCompCollectionNewValoreParComp);
          }
        }
      }
      for (ComponenteProdotto componenteProdottoCollectionNewComponenteProdotto : componenteProdottoCollectionNew) {
        if (!componenteProdottoCollectionOld.contains(componenteProdottoCollectionNewComponenteProdotto)) {
          Componente oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto = componenteProdottoCollectionNewComponenteProdotto.getIdComp();
          componenteProdottoCollectionNewComponenteProdotto.setIdComp(componente);
          componenteProdottoCollectionNewComponenteProdotto = em.merge(componenteProdottoCollectionNewComponenteProdotto);
          if (oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto != null && !oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto.equals(componente)) {
            oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto.getComponenteProdottoCollection().remove(componenteProdottoCollectionNewComponenteProdotto);
            oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto = em.merge(oldIdCompOfComponenteProdottoCollectionNewComponenteProdotto);
          }
        }
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = componente.getIdComp();
        if (findComponente(id) == null) {
          throw new NonexistentEntityException("The componente with id " + id + " no longer exists.");
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
      Componente componente;
      try {
        componente = em.getReference(Componente.class, id);
        componente.getIdComp();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The componente with id " + id + " no longer exists.", enfe);
      }
      List<String> illegalOrphanMessages = null;
      Collection<ValoreParComp> valoreParCompCollectionOrphanCheck = componente.getValoreParCompCollection();
      for (ValoreParComp valoreParCompCollectionOrphanCheckValoreParComp : valoreParCompCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Componente (" + componente + ") cannot be destroyed since the ValoreParComp " + valoreParCompCollectionOrphanCheckValoreParComp + " in its valoreParCompCollection field has a non-nullable idComp field.");
      }
      Collection<ComponenteProdotto> componenteProdottoCollectionOrphanCheck = componente.getComponenteProdottoCollection();
      for (ComponenteProdotto componenteProdottoCollectionOrphanCheckComponenteProdotto : componenteProdottoCollectionOrphanCheck) {
        if (illegalOrphanMessages == null) {
          illegalOrphanMessages = new ArrayList<String>();
        }
        illegalOrphanMessages.add("This Componente (" + componente + ") cannot be destroyed since the ComponenteProdotto " + componenteProdottoCollectionOrphanCheckComponenteProdotto + " in its componenteProdottoCollection field has a non-nullable idComp field.");
      }
      if (illegalOrphanMessages != null) {
        throw new IllegalOrphanException(illegalOrphanMessages);
      }
      em.remove(componente);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<Componente> findComponenteEntities() {
    return findComponenteEntities(true, -1, -1);
  }

  public List<Componente> findComponenteEntities(int maxResults, int firstResult) {
    return findComponenteEntities(false, maxResults, firstResult);
  }

  private List<Componente> findComponenteEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from Componente as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public Componente findComponente(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(Componente.class, id);
    } finally {
      em.close();
    }
  }

  public int getComponenteCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from Componente as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
   
  public Collection<Componente> findComponenteNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Componente.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
  
  }    
//  
//  /**TEST 23-10-2014
//   * Metodo che assegna ad una macchina i componenti presenti nei prodotti che gli vengono assegnati in base al gruppo
//   * Seleziona i componenti se vengono modificati nella tabella componente oppure se viene modificato il prodotto
//   * @param dtUltAgg
//   * @param idMacchina
//   * @return 
//   */
//  public Collection<Componente> findComponenteNewByGruppo(Date dtUltAgg, Macchina idMacchina) {
//                        
//        EntityManager em = getEntityManager();
//        try {
//
//            Query q = em.createQuery("SELECT c FROM Componente c, ComponenteProdotto cp, Gruppo g, AnagrafeMacchina m, AnagrafeProdotto p "
//                    + "WHERE "
//                            + "CASE "
//                            + "WHEN (m.gruppo = g.livello6) THEN 64 "
//                            + "WHEN (m.gruppo = g.livello5) THEN 32 "
//                            + "WHEN (m.gruppo = g.livello4) THEN 16 "
//                            + "WHEN (m.gruppo = g.livello3) THEN 8 "
//                            + "WHEN (m.gruppo = g.livello2) THEN 4 "
//                            + "WHEN (m.gruppo = g.livello1) THEN 2 "
//                            + "END "
//                            + "<= "
//                            + "CASE "
//                            + "WHEN (p.gruppo = g.livello6) THEN 64 "
//                            + "WHEN (p.gruppo = g.livello5) THEN 32 "
//                            + "WHEN (p.gruppo = g.livello4) THEN 16 "
//                            + "WHEN (p.gruppo = g.livello3) THEN 8 "
//                            + "WHEN (p.gruppo = g.livello2) THEN 4 "
//                            + "WHEN (p.gruppo = g.livello1) THEN 2 "
//                            + "END "
//                        + "AND "
//                            + "((m.gruppo = g.livello1) OR "
//                            + "(m.gruppo = g.livello2) OR "
//                            + "(m.gruppo = g.livello3) OR "
//                            + "(m.gruppo = g.livello4) OR "
//                            + "(m.gruppo = g.livello5) OR "
//                            + "(m.gruppo = g.livello6)) "
//                        + "AND "
//                            + "((p.gruppo = g.livello1) OR "
//                            + "(p.gruppo = g.livello2) OR "
//                            + "(p.gruppo = g.livello3) OR "
//                            + "(p.gruppo = g.livello4) OR "
//                            + "(p.gruppo = g.livello5) OR "
//                            + "(p.gruppo = g.livello6)) "
//                        + "AND "
//                            + "m.idMacchina = :idMacchina "
//                        + "AND "
//                            + "(c.dtAbilitato > :dtAbilitato OR p.dtAbilitato>:dtAbilitato OR cp.dtAbilitato>:dtAbilitato)"
//                    +"AND c.idComp=cp.idComp "
//                    +"AND p.idProdotto = cp.idProdotto "
//                    + " GROUP BY "
//                        + "c.idComp, "
//                        + "m.idMacchina, "
//                        + "p.gruppo, "
//                        + "m.gruppo "
//                    + " ORDER BY "
//                        + "c.idComp"
//                       );
//      
//            q.setParameter("idMacchina", idMacchina);
//            q.setParameter("dtAbilitato", dtUltAgg);
//
//            return q.getResultList();
//
//        } finally {
//            em.close();
//        }
//
//    }
//  /**TEST 23-10-2014
//   * Metodo che seleziona per una macchina i componenti presenti nei prodotti che gli sono stati assegnati in base al riferimento geografico
//   * @param dtUltAgg
//   * @param idMacchina
//   * @return 
//   */
//   public Collection<Componente> findComponenteNewByGeo(Date dtUltAgg, Macchina idMacchina) {
//
//        EntityManager em = getEntityManager();
//        try {
//            
//
//            Query q = em.createQuery("SELECT co FROM Componente co, ComponenteProdotto cp, AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
//                    + "WHERE "
//                            + "CASE "                    
//                            + "WHEN (m.geografico = c.mondo) THEN 64 "
//                            + "WHEN (m.geografico = c.continente) THEN 32 "
//                            + "WHEN (m.geografico = c.stato) THEN 16 "
//                            + "WHEN (m.geografico = c.regione) THEN 8 "
//                            + "WHEN (m.geografico = c.provincia) THEN 4 "
//                            + "WHEN (m.geografico = c.comune) THEN 2 "
//                            + "END "
//                            + "<= "
//                            + "CASE "
//                            + "WHEN (p.geografico = c.mondo) THEN 64 "
//                            + "WHEN (p.geografico = c.continente) THEN 32 "
//                            + "WHEN (p.geografico = c.stato) THEN 16 "
//                            + "WHEN (p.geografico = c.regione) THEN 8 "
//                            + "WHEN (p.geografico = c.provincia) THEN 4 "
//                            + "WHEN (p.geografico = c.comune) THEN 2 "
//                            + "END "
//                        + "AND "
//                            + "((m.geografico = c.mondo) OR "
//                            + "(m.geografico = c.continente) OR "
//                            + "(m.geografico = c.stato) OR "
//                            + "(m.geografico = c.regione) OR "
//                            + "(m.geografico = c.provincia) OR "
//                            + "(m.geografico = c.comune)) "
//                        + "AND "
//                            + "((p.geografico = c.mondo) OR "
//                            + "(p.geografico = c.continente) OR "
//                            + "(p.geografico = c.stato) OR "
//                            + "(p.geografico = c.regione) OR "
//                            + "(p.geografico = c.provincia) OR "
//                            + "(p.geografico = c.comune)) "
//                        + "AND "
//                            + "m.idMacchina = :idMacchina "
//                        + "AND "
//                            + "(co.dtAbilitato > :dtAbilitato OR p.dtAbilitato>:dtAbilitato OR cp.dtAbilitato>:dtAbilitato)"
//                        +"AND "
//                            + "co.idComp=cp.idComp "
//                        +"AND "
//                            + "p.idProdotto = cp.idProdotto "
//                        + "GROUP BY co.idComp "                       
//                        + "ORDER BY co.idComp"
//                        );
//      
//            q.setParameter("idMacchina", idMacchina);
//            q.setParameter("dtAbilitato", dtUltAgg);
//
//            return q.getResultList();
//
//        } finally {
//            em.close();
//        }
//
//    }
  
  
  /**TEST 25-10-2015
   * Metodo che seleziona per una macchina i componenti presenti nei prodotti che gli vengono assegnati in base al gruppo
   * @param idMacchina
   * @return 
   */
    public Collection<Componente> findComponenteByGruppo(Macchina idMacchina) {
                        
        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT c FROM Componente c, ComponenteProdotto cp, Gruppo g, AnagrafeMacchina m, AnagrafeProdotto p "
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
                    +"AND c.idComp=cp.idComp "
                    +"AND p.idProdotto = cp.idProdotto "
                    + " GROUP BY "
                        + "c.idComp, "
                        + "m.idMacchina, "
                        + "p.gruppo, "
                        + "m.gruppo "
                    + " ORDER BY "
                        + "c.idComp"
                       );
      
            q.setParameter("idMacchina", idMacchina);
            

            return q.getResultList();

        } finally {
            em.close();
        }

    }
  /**TEST 25-10-2015
   * Metodo che seleziona per una macchina i componenti presenti nei prodotti che gli sono stati assegnati in base al riferimento geografico
   * @param idMacchina
   * @return 
   */
   public Collection<Componente> findComponenteByGeo(Macchina idMacchina) {

        EntityManager em = getEntityManager();
        try {
            

            Query q = em.createQuery("SELECT co FROM Componente co, ComponenteProdotto cp, AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
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
                        +"AND "
                            + "co.idComp=cp.idComp "
                        +"AND "
                            + "p.idProdotto = cp.idProdotto "
                        + "GROUP BY co.idComp "                       
                        + "ORDER BY co.idComp"
                        );
      
            q.setParameter("idMacchina", idMacchina);
           

            return q.getResultList();

        } finally {
            em.close();
        }

    }

  /**
     * 20-10-2015
     * Metodo che seleziona tutti i prodotti dalla tabella componente in base al gruppo e al rif geo facendo l'intersezione
     * @param idMacchina
     * @param emf
     * @return 
     */
    public Collection<Componente> findComponentiAssegnati(Macchina idMacchina) {
        
        
        Collection<Componente> componenteGruppoColl = this.findComponenteByGruppo(idMacchina);
        Collection<Componente> componenteGeoColl = this.findComponenteByGeo(idMacchina);

        Collection<Componente> componentiAssegnatiColl = new ArrayList();
        

        //############ INTERSEZIONE DEI PRODOTTI ############################### 
        for (Object obj : componenteGeoColl) {
            Componente componente = (Componente) obj;
            //Per ogni componente presente nei prodotti assegnati in base al gruppo
            //verifico se è stato assegnato anche in base al rif geografico
            //e in tal caso lo aggiungo alla collection dei componenti assegnati       
            if (componenteGruppoColl.contains(componente)) {
                componentiAssegnatiColl.add(componente);
            }
        }
        return componentiAssegnatiColl;
    }
}
