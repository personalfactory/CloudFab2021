/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.Figura;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.FiguraTipo;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class FiguraJpaController implements Serializable {

    Logger log = Logger.getLogger(FiguraJpaController.class);
    
    
    public FiguraJpaController(UserTransaction utx, EntityManagerFactory emf) {
    this.utx = utx;
    this.emf = emf;
  }
  private UserTransaction utx = null;
  private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Figura figura) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            FiguraTipo idFiguraTipo = figura.getIdFiguraTipo();
            if (idFiguraTipo != null) {
                idFiguraTipo = em.getReference(idFiguraTipo.getClass(), idFiguraTipo.getIdFiguraTipo());
                figura.setIdFiguraTipo(idFiguraTipo);
            }
            em.persist(figura);
            if (idFiguraTipo != null) {
                idFiguraTipo.getFiguraCollection().add(figura);
                idFiguraTipo = em.merge(idFiguraTipo);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Figura figura) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Figura persistentFigura = em.find(Figura.class, figura.getIdFigura());
            FiguraTipo idFiguraTipoOld = persistentFigura.getIdFiguraTipo();
            FiguraTipo idFiguraTipoNew = figura.getIdFiguraTipo();
            if (idFiguraTipoNew != null) {
                idFiguraTipoNew = em.getReference(idFiguraTipoNew.getClass(), idFiguraTipoNew.getIdFiguraTipo());
                figura.setIdFiguraTipo(idFiguraTipoNew);
            }
            figura = em.merge(figura);
            if (idFiguraTipoOld != null && !idFiguraTipoOld.equals(idFiguraTipoNew)) {
                idFiguraTipoOld.getFiguraCollection().remove(figura);
                idFiguraTipoOld = em.merge(idFiguraTipoOld);
            }
            if (idFiguraTipoNew != null && !idFiguraTipoNew.equals(idFiguraTipoOld)) {
                idFiguraTipoNew.getFiguraCollection().add(figura);
                idFiguraTipoNew = em.merge(idFiguraTipoNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = figura.getIdFigura();
                if (findFigura(id) == null) {
                    throw new NonexistentEntityException("The figura with id " + id + " no longer exists.");
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
            Figura figura;
            try {
                figura = em.getReference(Figura.class, id);
                figura.getIdFigura();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The figura with id " + id + " no longer exists.", enfe);
            }
            FiguraTipo idFiguraTipo = figura.getIdFiguraTipo();
            if (idFiguraTipo != null) {
                idFiguraTipo.getFiguraCollection().remove(figura);
                idFiguraTipo = em.merge(idFiguraTipo);
            }
            em.remove(figura);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Figura> findFiguraEntities() {
        return findFiguraEntities(true, -1, -1);
    }

    public List<Figura> findFiguraEntities(int maxResults, int firstResult) {
        return findFiguraEntities(false, maxResults, firstResult);
    }

    private List<Figura> findFiguraEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from Figura as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public Figura findFigura(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Figura.class, id);
        } finally {
            em.close();
        }
    }

    public int getFiguraCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from Figura as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
    
    public Collection<Figura> findFiguraNew(Date dt_ult_agg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("Figura.findDatiNuovi");
       q.setParameter ("dtAbilitato",dt_ult_agg);
     
      return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
    
}
