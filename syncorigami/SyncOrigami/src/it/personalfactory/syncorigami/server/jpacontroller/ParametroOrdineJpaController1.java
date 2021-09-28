/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.ParametroOrdine;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.ValoreParOrdine;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;

/**
 *
 * @author marilisa
 */
public class ParametroOrdineJpaController1 implements Serializable {

    public ParametroOrdineJpaController1(EntityManagerFactory emf) {
        this.emf = emf;
    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ParametroOrdine parametroOrdine) {
        if (parametroOrdine.getValoreParOrdineCollection() == null) {
            parametroOrdine.setValoreParOrdineCollection(new ArrayList<ValoreParOrdine>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Collection<ValoreParOrdine> attachedValoreParOrdineCollection = new ArrayList<ValoreParOrdine>();
            for (ValoreParOrdine valoreParOrdineCollectionValoreParOrdineToAttach : parametroOrdine.getValoreParOrdineCollection()) {
                valoreParOrdineCollectionValoreParOrdineToAttach = em.getReference(valoreParOrdineCollectionValoreParOrdineToAttach.getClass(), valoreParOrdineCollectionValoreParOrdineToAttach.getId());
                attachedValoreParOrdineCollection.add(valoreParOrdineCollectionValoreParOrdineToAttach);
            }
            parametroOrdine.setValoreParOrdineCollection(attachedValoreParOrdineCollection);
            em.persist(parametroOrdine);
            for (ValoreParOrdine valoreParOrdineCollectionValoreParOrdine : parametroOrdine.getValoreParOrdineCollection()) {
                ParametroOrdine oldIdParOrdineOfValoreParOrdineCollectionValoreParOrdine = valoreParOrdineCollectionValoreParOrdine.getIdParOrdine();
                valoreParOrdineCollectionValoreParOrdine.setIdParOrdine(parametroOrdine);
                valoreParOrdineCollectionValoreParOrdine = em.merge(valoreParOrdineCollectionValoreParOrdine);
                if (oldIdParOrdineOfValoreParOrdineCollectionValoreParOrdine != null) {
                    oldIdParOrdineOfValoreParOrdineCollectionValoreParOrdine.getValoreParOrdineCollection().remove(valoreParOrdineCollectionValoreParOrdine);
                    oldIdParOrdineOfValoreParOrdineCollectionValoreParOrdine = em.merge(oldIdParOrdineOfValoreParOrdineCollectionValoreParOrdine);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ParametroOrdine parametroOrdine) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ParametroOrdine persistentParametroOrdine = em.find(ParametroOrdine.class, parametroOrdine.getIdParOrdine());
            Collection<ValoreParOrdine> valoreParOrdineCollectionOld = persistentParametroOrdine.getValoreParOrdineCollection();
            Collection<ValoreParOrdine> valoreParOrdineCollectionNew = parametroOrdine.getValoreParOrdineCollection();
            Collection<ValoreParOrdine> attachedValoreParOrdineCollectionNew = new ArrayList<ValoreParOrdine>();
            for (ValoreParOrdine valoreParOrdineCollectionNewValoreParOrdineToAttach : valoreParOrdineCollectionNew) {
                valoreParOrdineCollectionNewValoreParOrdineToAttach = em.getReference(valoreParOrdineCollectionNewValoreParOrdineToAttach.getClass(), valoreParOrdineCollectionNewValoreParOrdineToAttach.getId());
                attachedValoreParOrdineCollectionNew.add(valoreParOrdineCollectionNewValoreParOrdineToAttach);
            }
            valoreParOrdineCollectionNew = attachedValoreParOrdineCollectionNew;
            parametroOrdine.setValoreParOrdineCollection(valoreParOrdineCollectionNew);
            parametroOrdine = em.merge(parametroOrdine);
            for (ValoreParOrdine valoreParOrdineCollectionOldValoreParOrdine : valoreParOrdineCollectionOld) {
                if (!valoreParOrdineCollectionNew.contains(valoreParOrdineCollectionOldValoreParOrdine)) {
                    valoreParOrdineCollectionOldValoreParOrdine.setIdParOrdine(null);
                    valoreParOrdineCollectionOldValoreParOrdine = em.merge(valoreParOrdineCollectionOldValoreParOrdine);
                }
            }
            for (ValoreParOrdine valoreParOrdineCollectionNewValoreParOrdine : valoreParOrdineCollectionNew) {
                if (!valoreParOrdineCollectionOld.contains(valoreParOrdineCollectionNewValoreParOrdine)) {
                    ParametroOrdine oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine = valoreParOrdineCollectionNewValoreParOrdine.getIdParOrdine();
                    valoreParOrdineCollectionNewValoreParOrdine.setIdParOrdine(parametroOrdine);
                    valoreParOrdineCollectionNewValoreParOrdine = em.merge(valoreParOrdineCollectionNewValoreParOrdine);
                    if (oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine != null && !oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine.equals(parametroOrdine)) {
                        oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine.getValoreParOrdineCollection().remove(valoreParOrdineCollectionNewValoreParOrdine);
                        oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine = em.merge(oldIdParOrdineOfValoreParOrdineCollectionNewValoreParOrdine);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = parametroOrdine.getIdParOrdine();
                if (findParametroOrdine(id) == null) {
                    throw new NonexistentEntityException("The parametroOrdine with id " + id + " no longer exists.");
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
            ParametroOrdine parametroOrdine;
            try {
                parametroOrdine = em.getReference(ParametroOrdine.class, id);
                parametroOrdine.getIdParOrdine();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The parametroOrdine with id " + id + " no longer exists.", enfe);
            }
            Collection<ValoreParOrdine> valoreParOrdineCollection = parametroOrdine.getValoreParOrdineCollection();
            for (ValoreParOrdine valoreParOrdineCollectionValoreParOrdine : valoreParOrdineCollection) {
                valoreParOrdineCollectionValoreParOrdine.setIdParOrdine(null);
                valoreParOrdineCollectionValoreParOrdine = em.merge(valoreParOrdineCollectionValoreParOrdine);
            }
            em.remove(parametroOrdine);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ParametroOrdine> findParametroOrdineEntities() {
        return findParametroOrdineEntities(true, -1, -1);
    }

    public List<ParametroOrdine> findParametroOrdineEntities(int maxResults, int firstResult) {
        return findParametroOrdineEntities(false, maxResults, firstResult);
    }

    private List<ParametroOrdine> findParametroOrdineEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from ParametroOrdine as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public ParametroOrdine findParametroOrdine(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ParametroOrdine.class, id);
        } finally {
            em.close();
        }
    }

    public int getParametroOrdineCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from ParametroOrdine as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
