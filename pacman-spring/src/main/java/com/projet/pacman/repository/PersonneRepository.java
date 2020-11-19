package com.projet.pacman.repository;

import com.projet.pacman.model.Personne;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface PersonneRepository extends JpaRepository<Personne, Integer> {
    Personne findByPseudo(String pseudo);
    Personne findByPseudoAndIdIsNot(String pseudo, int id);
    Personne findByEmailAndIdIsNot(String pseudo, int id);
    Personne findByEmail(String email);
    List<Personne> findByStatut(String statut);
    @Query(
            value = "SELECT * FROM personne p WHERE p.statut = 'JOUEUR' ORDER BY p.score DESC ",
            nativeQuery = true)
    List<Personne> classement();
    Personne findById(int id);

    long countBySexe(String sexe);
    long countByPays(String pays);

}
