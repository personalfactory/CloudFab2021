/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroRipristino;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ValoreRipristino;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.PreexistingEntityException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.transaction.UserTransaction;

/**
 *
 * @author Marilisa Tassone
 */
public class ParametroRipristinoJpaController implements Serializable {

    public ParametroRipristinoJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ParametroRipristino parametroRipristino) throws PreexistingEntityException, Exception {
        if (parametroRipristino.getValoreRipristinoCollection() == null) {
            parametroRipristino.setValoreRipristinoCollection(new ArrayList<ValoreRipristino>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Collection<ValoreRipristino> attachedValoreRipristinoCollection = new ArrayList<ValoreRipristino>();
            for (ValoreRipristino valoreRipristinoCollectionValoreRipristinoToAttach : parametroRipristino.getValoreRipristinoCollection()) {
                valoreRipristinoCollectionValoreRipristinoToAttach = em.getReference(valoreRipristinoCollectionValoreRipristinoToAttach.getClass(), valoreRipristinoCollectionValoreRipristinoToAttach.getValoreRipristinoPK());
                attachedValoreRipristinoCollection.add(valoreRipristinoCollectionValoreRipristinoToAttach);
            }
            parametroRipristino.setValoreRipristinoCollection(attachedValoreRipristinoCollection);
            em.persist(parametroRipristino);
            for (ValoreRipristino valoreRipristinoCollectionValoreRipristino : parametroRipristino.getValoreRipristinoCollection()) {
                ParametroRipristino oldIdParRipristinoOfValoreRipristinoCollectionValoreRipristino = valoreRipristinoCollectionValoreRipristino.getIdParRipristino();
                valoreRipristinoCollectionValoreRipristino.setIdParRipristino(parametroRipristino);
                valoreRipristinoCollectionValoreRipristino = em.merge(valoreRipristinoCollectionValoreRipristino);
                if (oldIdParRipristinoOfValoreRipristinoCollectionValoreRipristino != null) {
                    oldIdParRipristinoOfValoreRipristinoCollectionValoreRipristino.getValoreRipristinoCollection().remove(valoreRipristinoCollectionValoreRipristino);
                    oldIdParRipristinoOfValoreRipristinoCollectionValoreRipristino = em.merge(oldIdParRipristinoOfValoreRipristinoCollectionValoreRipristino);
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            if (findParametroRipristino(parametroRipristino.getIdParRipristino()) != null) {
                throw new PreexistingEntityException("ParametroRipristino " + parametroRipristino + " already exists.", ex);
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ParametroRipristino parametroRipristino) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ParametroRipristino persistentParametroRipristino = em.find(ParametroRipristino.class, parametroRipristino.getIdParRipristino());
            Collection<ValoreRipristino> valoreRipristinoCollectionOld = persistentParametroRipristino.getValoreRipristinoCollection();
            Collection<ValoreRipristino> valoreRipristinoCollectionNew = parametroRipristino.getValoreRipristinoCollection();
            List<String> illegalOrphanMessages = null;
            for (ValoreRipristino valoreRipristinoCollectionOldValoreRipristino : valoreRipristinoCollectionOld) {
                if (!valoreRipristinoCollectionNew.contains(valoreRipristinoCollectionOldValoreRipristino)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain ValoreRipristino " + valoreRipristinoCollectionOldValoreRipristino + " since its idParRipristino field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            Collection<ValoreRipristino> attachedValoreRipristinoCollectionNew = new ArrayList<ValoreRipristino>();
            for (ValoreRipristino valoreRipristinoCollectionNewValoreRipristinoToAttach : valoreRipristinoCollectionNew) {
                valoreRipristinoCollectionNewValoreRipristinoToAttach = em.getReference(valoreRipristinoCollectionNewValoreRipristinoToAttach.getClass(), valoreRipristinoCollectionNewValoreRipristinoToAttach.getValoreRipristinoPK());
                attachedValoreRipristinoCollectionNew.add(valoreRipristinoCollectionNewValoreRipristinoToAttach);
            }
            valoreRipristinoCollectionNew = attachedValoreRipristinoCollectionNew;
            parametroRipristino.setValoreRipristinoCollection(valoreRipristinoCollectionNew);
            parametroRipristino = em.merge(parametroRipristino);
            for (ValoreRipristino valoreRipristinoCollectionNewValoreRipristino : valoreRipristinoCollectionNew) {
                if (!valoreRipristinoCollectionOld.contains(valoreRipristinoCollectionNewValoreRipristino)) {
                    ParametroRipristino oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino = valoreRipristinoCollectionNewValoreRipristino.getIdParRipristino();
                    valoreRipristinoCollectionNewValoreRipristino.setIdParRipristino(parametroRipristino);
                    valoreRipristinoCollectionNewValoreRipristino = em.merge(valoreRipristinoCollectionNewValoreRipristino);
                    if (oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino != null && !oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino.equals(parametroRipristino)) {
                        oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino.getValoreRipristinoCollection().remove(valoreRipristinoCollectionNewValoreRipristino);
                        oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino = em.merge(oldIdParRipristinoOfValoreRipristinoCollectionNewValoreRipristino);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = parametroRipristino.getIdParRipristino();
                if (findParametroRipristino(id) == null) {
                    throw new NonexistentEntityException("The parametroRipristino with id " + id + " no longer exists.");
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
            ParametroRipristino parametroRipristino;
            try {
                parametroRipristino = em.getReference(ParametroRipristino.class, id);
                parametroRipristino.getIdParRipristino();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The parametroRipristino with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            Collection<ValoreRipristino> valoreRipristinoCollectionOrphanCheck = parametroRipristino.getValoreRipristinoCollection();
            for (ValoreRipristino valoreRipristinoCollectionOrphanCheckValoreRipristino : valoreRipristinoCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This ParametroRipristino (" + parametroRipristino + ") cannot be destroyed since the ValoreRipristino " + valoreRipristinoCollectionOrphanCheckValoreRipristino + " in its valoreRipristinoCollection field has a non-nullable idParRipristino field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            em.remove(parametroRipristino);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ParametroRipristino> findParametroRipristinoEntities() {
        return findParametroRipristinoEntities(true, -1, -1);
    }

    public List<ParametroRipristino> findParametroRipristinoEntities(int maxResults, int firstResult) {
        return findParametroRipristinoEntities(false, maxResults, firstResult);
    }

    private List<ParametroRipristino> findParametroRipristinoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ParametroRipristino as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ParametroRipristino findParametroRipristino(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ParametroRipristino.class, id);
        } finally {
            em.close();
        }
    }

    public int getParametroRipristinoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ParametroRipristino as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    public Collection<ParametroRipristino> findParametroRipristinoNew(Date dtUltAgg){
         
     EntityManager em = getEntityManager();
     try {
     
       Query q = em.createNamedQuery("ParametroRipristino.findDatiNuovi");
       q.setParameter ("dtAbilitato",dtUltAgg);
       return  q.getResultList();
            
    } finally {
      em.close();
    }
     
  }    
}
