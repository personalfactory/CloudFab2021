/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.*;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ComponenteProdottoJpaController implements Serializable {

  public ComponenteProdottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ComponenteProdotto componenteProdotto) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Prodotto idProdotto = componenteProdotto.getIdProdotto();
      if (idProdotto != null) {
        idProdotto = em.getReference(idProdotto.getClass(), idProdotto.getIdProdotto());
        componenteProdotto.setIdProdotto(idProdotto);
      }
      Componente idComp = componenteProdotto.getIdComp();
      if (idComp != null) {
        idComp = em.getReference(idComp.getClass(), idComp.getIdComp());
        componenteProdotto.setIdComp(idComp);
      }
      em.persist(componenteProdotto);
      if (idProdotto != null) {
        idProdotto.getComponenteProdottoCollection().add(componenteProdotto);
        idProdotto = em.merge(idProdotto);
      }
      if (idComp != null) {
        idComp.getComponenteProdottoCollection().add(componenteProdotto);
        idComp = em.merge(idComp);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ComponenteProdotto componenteProdotto) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ComponenteProdotto persistentComponenteProdotto = em.find(ComponenteProdotto.class, componenteProdotto.getIdCompProd());
      Prodotto idProdottoOld = persistentComponenteProdotto.getIdProdotto();
      Prodotto idProdottoNew = componenteProdotto.getIdProdotto();
      Componente idCompOld = persistentComponenteProdotto.getIdComp();
      Componente idCompNew = componenteProdotto.getIdComp();
      if (idProdottoNew != null) {
        idProdottoNew = em.getReference(idProdottoNew.getClass(), idProdottoNew.getIdProdotto());
        componenteProdotto.setIdProdotto(idProdottoNew);
      }
      if (idCompNew != null) {
        idCompNew = em.getReference(idCompNew.getClass(), idCompNew.getIdComp());
        componenteProdotto.setIdComp(idCompNew);
      }
      componenteProdotto = em.merge(componenteProdotto);
      if (idProdottoOld != null && !idProdottoOld.equals(idProdottoNew)) {
        idProdottoOld.getComponenteProdottoCollection().remove(componenteProdotto);
        idProdottoOld = em.merge(idProdottoOld);
      }
      if (idProdottoNew != null && !idProdottoNew.equals(idProdottoOld)) {
        idProdottoNew.getComponenteProdottoCollection().add(componenteProdotto);
        idProdottoNew = em.merge(idProdottoNew);
      }
      if (idCompOld != null && !idCompOld.equals(idCompNew)) {
        idCompOld.getComponenteProdottoCollection().remove(componenteProdotto);
        idCompOld = em.merge(idCompOld);
      }
      if (idCompNew != null && !idCompNew.equals(idCompOld)) {
        idCompNew.getComponenteProdottoCollection().add(componenteProdotto);
        idCompNew = em.merge(idCompNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = componenteProdotto.getIdCompProd();
        if (findComponenteProdotto(id) == null) {
          throw new NonexistentEntityException("The componenteProdotto with id " + id + " no longer exists.");
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
      ComponenteProdotto componenteProdotto;
      try {
        componenteProdotto = em.getReference(ComponenteProdotto.class, id);
        componenteProdotto.getIdCompProd();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The componenteProdotto with id " + id + " no longer exists.", enfe);
      }
      Prodotto idProdotto = componenteProdotto.getIdProdotto();
      if (idProdotto != null) {
        idProdotto.getComponenteProdottoCollection().remove(componenteProdotto);
        idProdotto = em.merge(idProdotto);
      }
      Componente idComp = componenteProdotto.getIdComp();
      if (idComp != null) {
        idComp.getComponenteProdottoCollection().remove(componenteProdotto);
        idComp = em.merge(idComp);
      }
      em.remove(componenteProdotto);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ComponenteProdotto> findComponenteProdottoEntities() {
    return findComponenteProdottoEntities(true, -1, -1);
  }

  public List<ComponenteProdotto> findComponenteProdottoEntities(int maxResults, int firstResult) {
    return findComponenteProdottoEntities(false, maxResults, firstResult);
  }

  private List<ComponenteProdotto> findComponenteProdottoEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ComponenteProdotto as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ComponenteProdotto findComponenteProdotto(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ComponenteProdotto.class, id);
    } finally {
      em.close();
    }
  }

  public int getComponenteProdottoCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ComponenteProdotto as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
   public Collection<ComponenteProdotto> findComponenteProdottoNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ComponenteProdotto.findDatiNuovi");
      
       q.setParameter ("dtAbilitato",dtUltAgg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }
   
   /**
    * Metodo che consente di selezionare i componenti dei prodotti in base al 
    * gruppo di appartenenza della macchina
    * @param dtUltAgg
    * @param idMacchina
    * @return 
    */
//   public Collection<ComponenteProdotto> findCompProdottoNewGruppo(Date dtUltAgg, Macchina idMacchina) {
//                        
//        EntityManager em = getEntityManager();
//        try {
//
//            Query q = em.createQuery("SELECT cp FROM AnagrafeProdotto p, "
//                    + "Gruppo g, AnagrafeMacchina m, ComponenteProdotto cp "
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
//                            + "p.idProdotto = cp.idProdotto "
//                        + "AND "
//                            + "m.idMacchina = :idMacchina "    
//                        + "AND "
//                            + "cp.dtAbilitato > :dtAbilitato "
//                    + " GROUP BY "
//                        + "cp.idCompProd, "
//                        + "p.idProdotto, "
//                        + "m.idMacchina, "
//                        + "p.gruppo, "
//                        + "m.gruppo "
//                    + " ORDER BY "
//                        + "p.idProdotto, "
//                        + "cp.idCompProd");
//      
//            q.setParameter("idMacchina", idMacchina);
//            q.setParameter("dtAbilitato", dtUltAgg);
//
//            return q.getResultList();
//
//        } finally {
//            em.close();
//        }
//   }
        
        /**
    * Metodo che consente di selezionare i componenti dei prodotti in base al 
    * riferimento geografico della macchina
    * @param dtUltAgg
    * @param idMacchina
    * @return 
    */
//   public Collection<ComponenteProdotto> findCompProdottoNewGeo(Date dtUltAgg, Macchina idMacchina) {
//                        
//        EntityManager em = getEntityManager();
//        try {
//
//            Query q = em.createQuery("SELECT cp FROM "
//                    + "AnagrafeProdotto p, Comune c, AnagrafeMacchina m ,ComponenteProdotto cp "
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
//                            + "p.idProdotto=cp.idProdotto "                    
//                        + "AND "
//                           + "m.idMacchina = :idMacchina "
//                        + "AND "
//                            + "cp.dtAbilitato > :dtAbilitato "
//                    + " GROUP BY "
//                        + "cp.idCompProd, "
//                        + "p.idProdotto, "
//                        + "m.idMacchina, "
//                        + "p.geografico, "
//                        + "m.geografico "
//                    + " ORDER BY "
//                        + "p.idProdotto, "
//                        + "cp.idCompProd"
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
//        
//        
//    }
   
   
   public Collection<ComponenteProdotto> findComponenteProdottoIdProd(Prodotto prodotto){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ComponenteProdotto.findByIdProdotto");
      
       q.setParameter ("idProdotto",prodotto);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }
}
