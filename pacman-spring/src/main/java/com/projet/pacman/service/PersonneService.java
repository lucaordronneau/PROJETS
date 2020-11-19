package com.projet.pacman.service;

import com.projet.pacman.model.Personne;
import com.projet.pacman.model.PersonneInscriptionDTO;
import org.springframework.security.core.userdetails.UserDetailsService;

import java.util.List;

public interface PersonneService extends UserDetailsService {
    Personne findByPseudo(String pseudo);
    Personne findById(int id);
    Personne findByEmail(String email);
    Personne save(PersonneInscriptionDTO inscriptionDTO);
    void saveUpdate(Personne personne);
    List< Personne > getAllPersonne();
    List<Personne> findByStatut(String statut);
    Personne findByPseudoAndIdIsNot(String pseudo, int id);
    Personne findByEmailAndIdIsNot(String pseudo, int id);
    void saveUpdateListeJoueurs(Personne personne);
    List<Personne> classement();
    long countBySexe(String sexe);
    long countByPays(String pays);
    void deletePersonneById(int id);
}
