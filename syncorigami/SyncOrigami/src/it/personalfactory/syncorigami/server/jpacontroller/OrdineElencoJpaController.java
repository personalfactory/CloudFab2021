/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.OrdineElenco;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import it.personalfactory.syncorigami.server.entity.OrdineSingMac;
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
public class OrdineElencoJpaController implements Serializable {

    public OrdineElencoJpaController(EntityManagerFactory emf) {
        this.emf = emf;
    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(OrdineElenco ordineElenco) {
        if (ordineElenco.getOrdineSingMacCollection() == null) {
            ordineElenco.setOrdineSingMacCollection(new ArrayList<OrdineSingMac>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Collection<OrdineSingMac> attachedOrdineSingMacCollection = new ArrayList<OrdineSingMac>();
            for (OrdineSingMac ordineSingMacCollectionOrdineSingMacToAttach : ordineElenco.getOrdineSingMacCollection()) {
                ordineSingMacCollectionOrdineSingMacToAttach = em.getReference(ordineSingMacCollectionOrdineSingMacToAttach.getClass(), ordineSingMacCollectionOrdineSingMacToAttach.getIdOrdineSm());
                attachedOrdineSingMacCollection.add(ordineSingMacCollectionOrdineSingMacToAttach);
            }
            ordineElenco.setOrdineSingMacCollection(attachedOrdineSingMacCollection);
            em.persist(ordineElenco);
            for (OrdineSingMac ordineSingMacCollectionOrdineSingMac : ordineElenco.getOrdineSingMacCollection()) {
                OrdineElenco oldIdOrdineOfOrdineSingMacCollectionOrdineSingMac = ordineSingMacCollectionOrdineSingMac.getIdOrdine();
                ordineSingMacCollectionOrdineSingMac.setIdOrdine(ordineElenco);
                ordineSingMacCollectionOrdineSingMac = em.merge(ordineSingMacCollectionOrdineSingMac);
                if (oldIdOrdineOfOrdineSingMacCollectionOrdineSingMac != null) {
                    oldIdOrdineOfOrdineSingMacCollectionOrdineSingMac.getOrdineSingMacCollection().remove(ordineSingMacCollectionOrdineSingMac);
                    oldIdOrdineOfOrdineSingMacCollectionOrdineSingMac = em.merge(oldIdOrdineOfOrdineSingMacCollectionOrdineSingMac);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(OrdineElenco ordineElenco) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            OrdineElenco persistentOrdineElenco = em.find(OrdineElenco.class, ordineElenco.getIdOrdine());
            Collection<OrdineSingMac> ordineSingMacCollectionOld = persistentOrdineElenco.getOrdineSingMacCollection();
            Collection<OrdineSingMac> ordineSingMacCollectionNew = ordineElenco.getOrdineSingMacCollection();
            Collection<OrdineSingMac> attachedOrdineSingMacCollectionNew = new ArrayList<OrdineSingMac>();
            for (OrdineSingMac ordineSingMacCollectionNewOrdineSingMacToAttach : ordineSingMacCollectionNew) {
                ordineSingMacCollectionNewOrdineSingMacToAttach = em.getReference(ordineSingMacCollectionNewOrdineSingMacToAttach.getClass(), ordineSingMacCollectionNewOrdineSingMacToAttach.getIdOrdineSm());
                attachedOrdineSingMacCollectionNew.add(ordineSingMacCollectionNewOrdineSingMacToAttach);
            }
            ordineSingMacCollectionNew = attachedOrdineSingMacCollectionNew;
            ordineElenco.setOrdineSingMacCollection(ordineSingMacCollectionNew);
            ordineElenco = em.merge(ordineElenco);
            for (OrdineSingMac ordineSingMacCollectionOldOrdineSingMac : ordineSingMacCollectionOld) {
                if (!ordineSingMacCollectionNew.contains(ordineSingMacCollectionOldOrdineSingMac)) {
                    ordineSingMacCollectionOldOrdineSingMac.setIdOrdine(null);
                    ordineSingMacCollectionOldOrdineSingMac = em.merge(ordineSingMacCollectionOldOrdineSingMac);
                }
            }
            for (OrdineSingMac ordineSingMacCollectionNewOrdineSingMac : ordineSingMacCollectionNew) {
                if (!ordineSingMacCollectionOld.contains(ordineSingMacCollectionNewOrdineSingMac)) {
                    OrdineElenco oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac = ordineSingMacCollectionNewOrdineSingMac.getIdOrdine();
                    ordineSingMacCollectionNewOrdineSingMac.setIdOrdine(ordineElenco);
                    ordineSingMacCollectionNewOrdineSingMac = em.merge(ordineSingMacCollectionNewOrdineSingMac);
                    if (oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac != null && !oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac.equals(ordineElenco)) {
                        oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac.getOrdineSingMacCollection().remove(ordineSingMacCollectionNewOrdineSingMac);
                        oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac = em.merge(oldIdOrdineOfOrdineSingMacCollectionNewOrdineSingMac);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = ordineElenco.getIdOrdine();
                if (findOrdineElenco(id) == null) {
                    throw new NonexistentEntityException("The ordineElenco with id " + id + " no longer exists.");
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
            OrdineElenco ordineElenco;
            try {
                ordineElenco = em.getReference(OrdineElenco.class, id);
                ordineElenco.getIdOrdine();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The ordineElenco with id " + id + " no longer exists.", enfe);
            }
            Collection<OrdineSingMac> ordineSingMacCollection = ordineElenco.getOrdineSingMacCollection();
            for (OrdineSingMac ordineSingMacCollectionOrdineSingMac : ordineSingMacCollection) {
                ordineSingMacCollectionOrdineSingMac.setIdOrdine(null);
                ordineSingMacCollectionOrdineSingMac = em.merge(ordineSingMacCollectionOrdineSingMac);
            }
            em.remove(ordineElenco);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<OrdineElenco> findOrdineElencoEntities() {
        return findOrdineElencoEntities(true, -1, -1);
    }

    public List<OrdineElenco> findOrdineElencoEntities(int maxResults, int firstResult) {
        return findOrdineElencoEntities(false, maxResults, firstResult);
    }

    private List<OrdineElenco> findOrdineElencoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from OrdineElenco as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public OrdineElenco findOrdineElenco(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(OrdineElenco.class, id);
        } finally {
            em.close();
        }
    }

    public int getOrdineElencoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from OrdineElenco as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
