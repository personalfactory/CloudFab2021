/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.Figura;
import it.personalfactory.syncorigami.server.entity.FiguraTipo;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.transaction.UserTransaction;

/**
 *
 * @author marilisa
 */
public class FiguraTipoJpaController implements Serializable {

  public FiguraTipoJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(FiguraTipo figuraTipo) {
        if (figuraTipo.getFiguraCollection() == null) {
            figuraTipo.setFiguraCollection(new ArrayList<Figura>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Collection<Figura> attachedFiguraCollection = new ArrayList<Figura>();
            for (Figura figuraCollectionFiguraToAttach : figuraTipo.getFiguraCollection()) {
                figuraCollectionFiguraToAttach = em.getReference(figuraCollectionFiguraToAttach.getClass(), figuraCollectionFiguraToAttach.getIdFigura());
                attachedFiguraCollection.add(figuraCollectionFiguraToAttach);
            }
            figuraTipo.setFiguraCollection(attachedFiguraCollection);
            em.persist(figuraTipo);
            for (Figura figuraCollectionFigura : figuraTipo.getFiguraCollection()) {
                FiguraTipo oldIdFiguraTipoOfFiguraCollectionFigura = figuraCollectionFigura.getIdFiguraTipo();
                figuraCollectionFigura.setIdFiguraTipo(figuraTipo);
                figuraCollectionFigura = em.merge(figuraCollectionFigura);
                if (oldIdFiguraTipoOfFiguraCollectionFigura != null) {
                    oldIdFiguraTipoOfFiguraCollectionFigura.getFiguraCollection().remove(figuraCollectionFigura);
                    oldIdFiguraTipoOfFiguraCollectionFigura = em.merge(oldIdFiguraTipoOfFiguraCollectionFigura);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(FiguraTipo figuraTipo) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            FiguraTipo persistentFiguraTipo = em.find(FiguraTipo.class, figuraTipo.getIdFiguraTipo());
            Collection<Figura> figuraCollectionOld = persistentFiguraTipo.getFiguraCollection();
            Collection<Figura> figuraCollectionNew = figuraTipo.getFiguraCollection();
            List<String> illegalOrphanMessages = null;
            for (Figura figuraCollectionOldFigura : figuraCollectionOld) {
                if (!figuraCollectionNew.contains(figuraCollectionOldFigura)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Figura " + figuraCollectionOldFigura + " since its idFiguraTipo field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            Collection<Figura> attachedFiguraCollectionNew = new ArrayList<Figura>();
            for (Figura figuraCollectionNewFiguraToAttach : figuraCollectionNew) {
                figuraCollectionNewFiguraToAttach = em.getReference(figuraCollectionNewFiguraToAttach.getClass(), figuraCollectionNewFiguraToAttach.getIdFigura());
                attachedFiguraCollectionNew.add(figuraCollectionNewFiguraToAttach);
            }
            figuraCollectionNew = attachedFiguraCollectionNew;
            figuraTipo.setFiguraCollection(figuraCollectionNew);
            figuraTipo = em.merge(figuraTipo);
            for (Figura figuraCollectionNewFigura : figuraCollectionNew) {
                if (!figuraCollectionOld.contains(figuraCollectionNewFigura)) {
                    FiguraTipo oldIdFiguraTipoOfFiguraCollectionNewFigura = figuraCollectionNewFigura.getIdFiguraTipo();
                    figuraCollectionNewFigura.setIdFiguraTipo(figuraTipo);
                    figuraCollectionNewFigura = em.merge(figuraCollectionNewFigura);
                    if (oldIdFiguraTipoOfFiguraCollectionNewFigura != null && !oldIdFiguraTipoOfFiguraCollectionNewFigura.equals(figuraTipo)) {
                        oldIdFiguraTipoOfFiguraCollectionNewFigura.getFiguraCollection().remove(figuraCollectionNewFigura);
                        oldIdFiguraTipoOfFiguraCollectionNewFigura = em.merge(oldIdFiguraTipoOfFiguraCollectionNewFigura);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = figuraTipo.getIdFiguraTipo();
                if (findFiguraTipo(id) == null) {
                    throw new NonexistentEntityException("The figuraTipo with id " + id + " no longer exists.");
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
            FiguraTipo figuraTipo;
            try {
                figuraTipo = em.getReference(FiguraTipo.class, id);
                figuraTipo.getIdFiguraTipo();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The figuraTipo with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            Collection<Figura> figuraCollectionOrphanCheck = figuraTipo.getFiguraCollection();
            for (Figura figuraCollectionOrphanCheckFigura : figuraCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This FiguraTipo (" + figuraTipo + ") cannot be destroyed since the Figura " + figuraCollectionOrphanCheckFigura + " in its figuraCollection field has a non-nullable idFiguraTipo field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            em.remove(figuraTipo);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<FiguraTipo> findFiguraTipoEntities() {
        return findFiguraTipoEntities(true, -1, -1);
    }

    public List<FiguraTipo> findFiguraTipoEntities(int maxResults, int firstResult) {
        return findFiguraTipoEntities(false, maxResults, firstResult);
    }

    private List<FiguraTipo> findFiguraTipoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from FiguraTipo as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public FiguraTipo findFiguraTipo(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(FiguraTipo.class, id);
        } finally {
            em.close();
        }
    }

    public int getFiguraTipoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from FiguraTipo as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    public Collection<FiguraTipo> findFiguraTipoNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("FiguraTipo.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
    
}
