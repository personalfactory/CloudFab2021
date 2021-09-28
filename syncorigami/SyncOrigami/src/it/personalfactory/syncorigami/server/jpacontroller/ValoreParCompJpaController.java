/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ValoreParComp;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Macchina;
import it.personalfactory.syncorigami.server.entity.Componente;
import java.util.Collection;
import java.util.Date;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class ValoreParCompJpaController implements Serializable {

  public ValoreParCompJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

  public EntityManager getEntityManager() {
    return emf.createEntityManager();
  }

  public void create(ValoreParComp valoreParComp) {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      Macchina idMacchina = valoreParComp.getIdMacchina();
      if (idMacchina != null) {
        idMacchina = em.getReference(idMacchina.getClass(), idMacchina.getIdMacchina());
        valoreParComp.setIdMacchina(idMacchina);
      }
      Componente idComp = valoreParComp.getIdComp();
      if (idComp != null) {
        idComp = em.getReference(idComp.getClass(), idComp.getIdComp());
        valoreParComp.setIdComp(idComp);
      }
      em.persist(valoreParComp);
      if (idMacchina != null) {
        idMacchina.getValoreParCompCollection().add(valoreParComp);
        idMacchina = em.merge(idMacchina);
      }
      if (idComp != null) {
        idComp.getValoreParCompCollection().add(valoreParComp);
        idComp = em.merge(idComp);
      }
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public void edit(ValoreParComp valoreParComp) throws NonexistentEntityException, Exception {
    EntityManager em = null;
    try {
      em = getEntityManager();
      em.getTransaction().begin();
      ValoreParComp persistentValoreParComp = em.find(ValoreParComp.class, valoreParComp.getIdValComp());
      Macchina idMacchinaOld = persistentValoreParComp.getIdMacchina();
      Macchina idMacchinaNew = valoreParComp.getIdMacchina();
      Componente idCompOld = persistentValoreParComp.getIdComp();
      Componente idCompNew = valoreParComp.getIdComp();
      if (idMacchinaNew != null) {
        idMacchinaNew = em.getReference(idMacchinaNew.getClass(), idMacchinaNew.getIdMacchina());
        valoreParComp.setIdMacchina(idMacchinaNew);
      }
      if (idCompNew != null) {
        idCompNew = em.getReference(idCompNew.getClass(), idCompNew.getIdComp());
        valoreParComp.setIdComp(idCompNew);
      }
      valoreParComp = em.merge(valoreParComp);
      if (idMacchinaOld != null && !idMacchinaOld.equals(idMacchinaNew)) {
        idMacchinaOld.getValoreParCompCollection().remove(valoreParComp);
        idMacchinaOld = em.merge(idMacchinaOld);
      }
      if (idMacchinaNew != null && !idMacchinaNew.equals(idMacchinaOld)) {
        idMacchinaNew.getValoreParCompCollection().add(valoreParComp);
        idMacchinaNew = em.merge(idMacchinaNew);
      }
      if (idCompOld != null && !idCompOld.equals(idCompNew)) {
        idCompOld.getValoreParCompCollection().remove(valoreParComp);
        idCompOld = em.merge(idCompOld);
      }
      if (idCompNew != null && !idCompNew.equals(idCompOld)) {
        idCompNew.getValoreParCompCollection().add(valoreParComp);
        idCompNew = em.merge(idCompNew);
      }
      em.getTransaction().commit();
    } catch (Exception ex) {
      String msg = ex.getLocalizedMessage();
      if (msg == null || msg.length() == 0) {
        Integer id = valoreParComp.getIdValComp();
        if (findValoreParComp(id) == null) {
          throw new NonexistentEntityException("The valoreParComp with id " + id + " no longer exists.");
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
      ValoreParComp valoreParComp;
      try {
        valoreParComp = em.getReference(ValoreParComp.class, id);
        valoreParComp.getIdValComp();
      } catch (EntityNotFoundException enfe) {
        throw new NonexistentEntityException("The valoreParComp with id " + id + " no longer exists.", enfe);
      }
      Macchina idMacchina = valoreParComp.getIdMacchina();
      if (idMacchina != null) {
        idMacchina.getValoreParCompCollection().remove(valoreParComp);
        idMacchina = em.merge(idMacchina);
      }
      Componente idComp = valoreParComp.getIdComp();
      if (idComp != null) {
        idComp.getValoreParCompCollection().remove(valoreParComp);
        idComp = em.merge(idComp);
      }
      em.remove(valoreParComp);
      em.getTransaction().commit();
    } finally {
      if (em != null) {
        em.close();
      }
    }
  }

  public List<ValoreParComp> findValoreParCompEntities() {
    return findValoreParCompEntities(true, -1, -1);
  }

  public List<ValoreParComp> findValoreParCompEntities(int maxResults, int firstResult) {
    return findValoreParCompEntities(false, maxResults, firstResult);
  }

  private List<ValoreParComp> findValoreParCompEntities(boolean all, int maxResults, int firstResult) {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select object(o) from ValoreParComp as o");
      if (!all) {
        q.setMaxResults(maxResults);
        q.setFirstResult(firstResult);
      }
      return q.getResultList();
    } finally {
      em.close();
    }
  }

  public ValoreParComp findValoreParComp(Integer id) {
    EntityManager em = getEntityManager();
    try {
      return em.find(ValoreParComp.class, id);
    } finally {
      em.close();
    }
  }

  public int getValoreParCompCount() {
    EntityManager em = getEntityManager();
    try {
      Query q = em.createQuery("select count(o) from ValoreParComp as o");
      return ((Long) q.getSingleResult()).intValue();
    } finally {
      em.close();
    }
  }
  public Collection<ValoreParComp> findValoreParCompNew(Date dtUltAgg, Integer idMacchina){
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ValoreParComp.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       q.setParameter("idMacchina",idMacchina);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
  
  
  /**TEST 23-10-2014
   * Metodo che assegna ad una macchina i valori dei parametri dei componenti presenti nei prodotti che gli vengono assegnati in base al gruppo
   * @param dtUltAgg
   * @param idMacchina
   * @return 
   */
//  public Collection<ValoreParComp> findValParCompNewByGruppo(Date dtUltAgg, Macchina idMacchina) {
//                        
//        EntityManager em = getEntityManager();
//        try {
//
//            Query q = em.createQuery("SELECT v FROM ValoreParComp v, ComponenteProdotto cp, Gruppo g, AnagrafeMacchina m, AnagrafeProdotto p "
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
//                            + "v.idMacchina = m.idMacchina "
//                        + "AND "
//                            + "(v.dtAbilitato > :dtAbilitato OR p.dtAbilitato>:dtAbilitato OR cp.dtAbilitato>:dtAbilitato) "
//                    +"AND v.idComp=cp.idComp "
//                    +"AND p.idProdotto = cp.idProdotto "
//                    +"GROUP BY "
//                        + "v.idValComp "                       
//                    + " ORDER BY "
//                        + "v.idValComp");
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
//  
//  /**TEST 23-10-2014
//   * Metodo che seleziona per una macchina i componenti presenti nei prodotti che gli sono stati assegnati in base al riferimento geografico
//   * @param dtUltAgg
//   * @param idMacchina
//   * @return 
//   */
//   public Collection<ValoreParComp> findValParCompNewByGeo(Date dtUltAgg, Macchina idMacchina) {
//
//        EntityManager em = getEntityManager();
//        try {            
//
//            Query q = em.createQuery("SELECT v FROM ValoreParComp v, ComponenteProdotto cp, AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
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
//                            + "v.idMacchina = m.idMacchina "
//                        + "AND "
//                             + "(v.dtAbilitato > :dtAbilitato OR p.dtAbilitato>:dtAbilitato OR cp.dtAbilitato>:dtAbilitato) "
//                        +"AND "
//                            + "v.idComp=cp.idComp "
//                        +"AND "
//                            + "p.idProdotto = cp.idProdotto "
//                        + "GROUP BY v.idValComp "                       
//                        + "ORDER BY v.idValComp"
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
  
  
  
  
}
