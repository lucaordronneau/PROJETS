package com.projet.pacman.service;

import com.projet.pacman.model.Personne;
import com.projet.pacman.model.PersonneInscriptionDTO;
import com.projet.pacman.repository.PersonneRepository;
import com.projet.pacman.security.PersonnePrincipal;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class PersonneServiceImpl implements PersonneService {

    @Autowired
    private PersonneRepository personneRepository;

    @Autowired
    private BCryptPasswordEncoder passwordEncoder;

    public Personne findByEmail(String email) {

        return personneRepository.findByEmail(email);
    }

    public Personne findByPseudo(String pseudo) {

        return personneRepository.findByPseudo(pseudo);
    }

    @Override
    public Personne findById(int id) {

        return personneRepository.findById(id);
    }
    @Override
    public void deletePersonneById(int id) {
        this.personneRepository.deleteById(id);
    }

    public Personne save(PersonneInscriptionDTO inscription) {
        Personne personne = new Personne();
        personne.setPseudo(inscription.getPseudo());
        personne.setEmail(inscription.getEmail());
        personne.setPays(inscription.getPays());
        personne.setMotDePasse(passwordEncoder.encode(inscription.getMotDePasse()));
        personne.setStatut("JOUEUR");
        personne.setScore(0);
        personne.setSexe(inscription.getSexe());

        return personneRepository.save(personne);
    }

    @Override
    public void saveUpdate(Personne personne) {
        this.personneRepository.save(personne);
        System.out.println("Personne " + personne.toString());
    }

    @Override
    public void saveUpdateListeJoueurs(Personne personne) {
        this.personneRepository.save(personne);
        System.out.println("Personne " + personne.toString());
    }


    public List<Personne> getAllPersonne() {

        return personneRepository.findAll();
    }

    public List<Personne> classement(){
        return personneRepository.classement();
    }


    public List<Personne> findByStatut(String statut) {
        return personneRepository.findByStatut(statut);
    }

    public long countBySexe(String sexe){ return personneRepository.countBySexe(sexe);}

    public long countByPays(String pays){ return personneRepository.countByPays(pays);}

    @Override
    public Personne findByPseudoAndIdIsNot(String pseudo, int id) {
        return personneRepository.findByPseudoAndIdIsNot(pseudo,  id);
    }

    @Override
    public Personne findByEmailAndIdIsNot(String pseudo, int id) {
        return personneRepository.findByEmailAndIdIsNot(pseudo,  id);
    }

    @Override
    public UserDetails loadUserByUsername(String s) throws UsernameNotFoundException {
        Personne personne = this.personneRepository.findByPseudo(s);
        PersonnePrincipal personnePrincipal = new PersonnePrincipal(personne);

        if (personne == null) {
            throw new UsernameNotFoundException("");
        }

        return personnePrincipal;
    }
    @Override
    public void savePersonne(Personne personne) {
        personne.setMotDePasse(passwordEncoder.encode(personne.getMotDePasse()));
        personne.setStatut("JOUEUR");
        this.personneRepository.save(personne);
    }

    @Override
    public void updateScore(Personne personne) {
        this.personneRepository.save(personne);
    }
}
