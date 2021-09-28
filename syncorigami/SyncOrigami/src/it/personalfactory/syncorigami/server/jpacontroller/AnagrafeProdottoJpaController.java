/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.*;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.io.Serializable;
import java.util.ArrayList;
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
public class AnagrafeProdottoJpaController implements Serializable {

    public AnagrafeProdottoJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(AnagrafeProdotto anagrafeProdotto) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Codice idCodice = anagrafeProdotto.getIdCodice();
            if (idCodice != null) {
                idCodice = em.getReference(idCodice.getClass(), idCodice.getIdCodice());
                anagrafeProdotto.setIdCodice(idCodice);
            }
            Categoria idCat = anagrafeProdotto.getIdCat();
            if (idCat != null) {
                idCat = em.getReference(idCat.getClass(), idCat.getIdCat());
                anagrafeProdotto.setIdCat(idCat);
            }
            Prodotto idProdotto = anagrafeProdotto.getIdProdotto();
            if (idProdotto != null) {
                idProdotto = em.getReference(idProdotto.getClass(), idProdotto.getIdProdotto());
                anagrafeProdotto.setIdProdotto(idProdotto);
            }
            Mazzetta idMazzetta = anagrafeProdotto.getIdMazzetta();
            if (idMazzetta != null) {
                idMazzetta = em.getReference(idMazzetta.getClass(), idMazzetta.getIdMazzetta());
                anagrafeProdotto.setIdMazzetta(idMazzetta);
            }
            em.persist(anagrafeProdotto);
            if (idCodice != null) {
                idCodice.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idCodice = em.merge(idCodice);
            }
            if (idCat != null) {
                idCat.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idCat = em.merge(idCat);
            }
            if (idProdotto != null) {
                idProdotto.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idProdotto = em.merge(idProdotto);
            }
            if (idMazzetta != null) {
                idMazzetta.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idMazzetta = em.merge(idMazzetta);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(AnagrafeProdotto anagrafeProdotto) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            AnagrafeProdotto persistentAnagrafeProdotto = em.find(AnagrafeProdotto.class, anagrafeProdotto.getIdAnProd());
            Codice idCodiceOld = persistentAnagrafeProdotto.getIdCodice();
            Codice idCodiceNew = anagrafeProdotto.getIdCodice();
            Categoria idCatOld = persistentAnagrafeProdotto.getIdCat();
            Categoria idCatNew = anagrafeProdotto.getIdCat();
            Prodotto idProdottoOld = persistentAnagrafeProdotto.getIdProdotto();
            Prodotto idProdottoNew = anagrafeProdotto.getIdProdotto();
            Mazzetta idMazzettaOld = persistentAnagrafeProdotto.getIdMazzetta();
            Mazzetta idMazzettaNew = anagrafeProdotto.getIdMazzetta();
            if (idCodiceNew != null) {
                idCodiceNew = em.getReference(idCodiceNew.getClass(), idCodiceNew.getIdCodice());
                anagrafeProdotto.setIdCodice(idCodiceNew);
            }
            if (idCatNew != null) {
                idCatNew = em.getReference(idCatNew.getClass(), idCatNew.getIdCat());
                anagrafeProdotto.setIdCat(idCatNew);
            }
            if (idProdottoNew != null) {
                idProdottoNew = em.getReference(idProdottoNew.getClass(), idProdottoNew.getIdProdotto());
                anagrafeProdotto.setIdProdotto(idProdottoNew);
            }
            if (idMazzettaNew != null) {
                idMazzettaNew = em.getReference(idMazzettaNew.getClass(), idMazzettaNew.getIdMazzetta());
                anagrafeProdotto.setIdMazzetta(idMazzettaNew);
            }
            anagrafeProdotto = em.merge(anagrafeProdotto);
            if (idCodiceOld != null && !idCodiceOld.equals(idCodiceNew)) {
                idCodiceOld.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idCodiceOld = em.merge(idCodiceOld);
            }
            if (idCodiceNew != null && !idCodiceNew.equals(idCodiceOld)) {
                idCodiceNew.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idCodiceNew = em.merge(idCodiceNew);
            }
            if (idCatOld != null && !idCatOld.equals(idCatNew)) {
                idCatOld.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idCatOld = em.merge(idCatOld);
            }
            if (idCatNew != null && !idCatNew.equals(idCatOld)) {
                idCatNew.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idCatNew = em.merge(idCatNew);
            }
            if (idProdottoOld != null && !idProdottoOld.equals(idProdottoNew)) {
                idProdottoOld.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idProdottoOld = em.merge(idProdottoOld);
            }
            if (idProdottoNew != null && !idProdottoNew.equals(idProdottoOld)) {
                idProdottoNew.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idProdottoNew = em.merge(idProdottoNew);
            }
            if (idMazzettaOld != null && !idMazzettaOld.equals(idMazzettaNew)) {
                idMazzettaOld.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idMazzettaOld = em.merge(idMazzettaOld);
            }
            if (idMazzettaNew != null && !idMazzettaNew.equals(idMazzettaOld)) {
                idMazzettaNew.getAnagrafeProdottoCollection().add(anagrafeProdotto);
                idMazzettaNew = em.merge(idMazzettaNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = anagrafeProdotto.getIdAnProd();
                if (findAnagrafeProdotto(id) == null) {
                    throw new NonexistentEntityException("The anagrafeProdotto with id " + id + " no longer exists.");
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
            AnagrafeProdotto anagrafeProdotto;
            try {
                anagrafeProdotto = em.getReference(AnagrafeProdotto.class, id);
                anagrafeProdotto.getIdAnProd();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The anagrafeProdotto with id " + id + " no longer exists.", enfe);
            }
            Codice idCodice = anagrafeProdotto.getIdCodice();
            if (idCodice != null) {
                idCodice.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idCodice = em.merge(idCodice);
            }
            Categoria idCat = anagrafeProdotto.getIdCat();
            if (idCat != null) {
                idCat.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idCat = em.merge(idCat);
            }
            Prodotto idProdotto = anagrafeProdotto.getIdProdotto();
            if (idProdotto != null) {
                idProdotto.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idProdotto = em.merge(idProdotto);
            }
            Mazzetta idMazzetta = anagrafeProdotto.getIdMazzetta();
            if (idMazzetta != null) {
                idMazzetta.getAnagrafeProdottoCollection().remove(anagrafeProdotto);
                idMazzetta = em.merge(idMazzetta);
            }
            em.remove(anagrafeProdotto);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<AnagrafeProdotto> findAnagrafeProdottoEntities() {
        return findAnagrafeProdottoEntities(true, -1, -1);
    }

    public List<AnagrafeProdotto> findAnagrafeProdottoEntities(int maxResults, int firstResult) {
        return findAnagrafeProdottoEntities(false, maxResults, firstResult);
    }

    private List<AnagrafeProdotto> findAnagrafeProdottoEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from AnagrafeProdotto as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public AnagrafeProdotto findAnagrafeProdotto(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(AnagrafeProdotto.class, id);
        } finally {
            em.close();
        }
    }

    public int getAnagrafeProdottoCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from AnagrafeProdotto as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }

    /**
     * Metodo che restituisce l'anagrafe dei prodotti nuovi
     *
     * @param data di costruzione dell'ultimo aggiornamento
     * @return Una collection di prodotti Per recuperare i prodotti nuovi lato
     * server da inviare alla macchina si confronta la data dell'ultimo
     * aggiornamento con il valore del campo dtAbilitato N.B. L'anagrafe dei
     * prodotti viaggi in un solo verso ovvero dal server alle macchine
     */
    public Collection<AnagrafeProdotto> findAnagrafeProdottoNew(Date dtUltAgg) {

        EntityManager em = getEntityManager();
        try {

            Query q = em.createNamedQuery("AnagrafeProdotto.findDatiNuovi");
            q.setParameter("dtAbilitato", dtUltAgg);

            return q.getResultList();

        } finally {
            em.close();
        }

    }
    /**
     * Metodo che seleziona i prodotti (nuovi o modificati) in base al gruppo di appartenenza della macchina
     * @param dtUltAgg
     * @param idMacchina
     * @return 
     */
     public Collection<AnagrafeProdotto> findAnagrafeProdottoNewGruppo(Date dtUltAgg, Macchina idMacchina) {
                        
        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT p FROM AnagrafeProdotto p, Gruppo g, AnagrafeMacchina m "
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
                            + "p.dtAbilitato > :dtAbilitato "
                    + " GROUP BY "
                        + "p.idProdotto, "
                        + "m.idMacchina, "
                        + "p.gruppo, "
                        + "m.gruppo "
                    + " ORDER BY "
                        + "p.idProdotto"
                       );
      
            q.setParameter("idMacchina", idMacchina);
            q.setParameter("dtAbilitato", dtUltAgg);

            return q.getResultList();

        } finally {
            em.close();
        }

    }
    
    /**
     * Metodo che seleziona i prodotti (nuovi o modificati) in base al riferimento geografico della macchina
     * @param dtUltAgg
     * @param idMacchina
     * @return 
     */
    public Collection<AnagrafeProdotto> findAnagrafeProdottoNewGeo(Date dtUltAgg, Macchina idMacchina) {

        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT p FROM AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
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
                            + "p.dtAbilitato > :dtAbilitato "
                    + " GROUP BY "
                        + "p.idProdotto, "
                        + "m.idMacchina, "
                        + "p.geografico, "
                        + "m.geografico "
                    + " ORDER BY "
                        + "p.idProdotto"
                        );
      
            q.setParameter("idMacchina", idMacchina);
            q.setParameter("dtAbilitato", dtUltAgg);

            return q.getResultList();

        } finally {
            em.close();
        }

    }
    
    
    
    
    /**
     * Metodo che seleziona i prodotti in base al gruppo di appartenenza della macchina
     * @param idMacchina
     * @return 
     */
     public Collection<AnagrafeProdotto> findAnagrafeProdottoGruppo(Macchina idMacchina) {
                        
        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT p FROM AnagrafeProdotto p, Gruppo g, AnagrafeMacchina m "
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
     * Metodo che seleziona i prodotti in base al riferimento geografico della macchina
     * @param idMacchina
     * @return 
     */
    public Collection<AnagrafeProdotto> findAnagrafeProdottoGeo(Macchina idMacchina) {

        EntityManager em = getEntityManager();
        try {

            Query q = em.createQuery("SELECT p FROM AnagrafeProdotto p, Comune c, AnagrafeMacchina m "
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
    
    
    
    
}
