package com.projet.pacman.service;

import com.projet.pacman.model.Personne;
import com.projet.pacman.repository.PersonneRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.Arrays;
import java.util.List;

@Service
public class DBInit implements CommandLineRunner {

    private PersonneRepository personneRepository;
    private PasswordEncoder passwordEncoder;

    public DBInit(PersonneRepository personneRepository, PasswordEncoder passwordEncoder) {
        this.personneRepository = personneRepository;
        this.passwordEncoder = passwordEncoder;
    }

    @Override
    public void run(String... args) {
        this.personneRepository.deleteAll();

        Personne luca = new Personne("luca", "ordronneau@eisti.eu", "CANADA", passwordEncoder.encode("luca"), 21, "H");
        Personne maxime = new Personne("maxime", "addamaxim@eisti.eu", "CROATIE", passwordEncoder.encode("maxime"), 18, "H");
        Personne hugo = new Personne("hugo", "lagahehugo@eisti.eu", "COREE DU SUD", passwordEncoder.encode("hugo"), 19, "H");
        Personne enzo = new Personne("enzo", "jupilleenz@eisti.eu", "FRANCE", passwordEncoder.encode("enzo"), 17, "H");
        Personne tom = new Personne("tom", "soulagetom@eisti.eu", "CROATIE", passwordEncoder.encode("tom"), 20, "H");
        Personne manon = new Personne("manon", "cassagnema@eisti.eu", "RUSSIE", passwordEncoder.encode("manon"), 13, "F");
        Personne rebecca = new Personne("rebecca", "rebecca@icloud.com", "ANGLETERRE", passwordEncoder.encode("rebecca"), 34, "F");
        Personne perrine = new Personne("perrine", "perrine@gmail.com", "FRANCE", passwordEncoder.encode("perrine"), 12, "F");
        Personne autre = new Personne("autre", "autre@gmail.com", "AUTRE", passwordEncoder.encode("autre"), 5, "O");

        Personne admin = new Personne("admin", passwordEncoder.encode("admin"), "ADMINISTRATEUR");
        Personne root = new Personne("root", passwordEncoder.encode("root"), "ADMINISTRATEUR");

        List<Personne> personnes = Arrays.asList(luca,admin,root,enzo,tom,maxime,hugo, manon, rebecca, perrine, autre);

        this.personneRepository.saveAll(personnes);
    }
}
