package com.projet.pacman.model;

import javax.persistence.*;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

@Entity
public class Personne {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;
    @Column
    private String pseudo;
    @Column
    private String email;
    private String pays;
    @Column
    private String mdp;
    @Column
    private String statut = "";
    @Column
    private int score;
    @Column
    private String sexe;


    //Securité
    public Personne(String pseudo, String motDePasse, String statut) {
        this.pseudo = pseudo;
        this.mdp = motDePasse;
        this.statut = statut;
    }

    //Création d'un joueur
    public Personne(String pseudo, String email, String pays, String motDePasse, int score, String sexe) {
        this.pseudo = pseudo;
        this.email = email;
        this.pays = pays;
        this.mdp = motDePasse;
        this.score = score;
        this.statut = "JOUEUR";
        this.sexe = sexe;
    }

    public Personne(){}


    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getPseudo() {
        return pseudo;
    }

    public void setPseudo(String pseudo) {
        this.pseudo = pseudo;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPays() {
        return pays;
    }

    public void setPays(String pays) {
        this.pays = pays;
    }

    public String getMotDePasse() {
        return mdp;
    }

    public void setMotDePasse(String motDePasse) {
        this.mdp = motDePasse;
    }

    public int getScore() {
        return score;
    }

    public void setScore(int score) {
        this.score = score;
    }

    public String getStatut() {
        return statut;
    }

    public void setStatut(String statut) {
        this.statut = statut;
    }

    public String getSexe() {
        return sexe;
    }

    public void setSexe(String sexe) {
        this.sexe = sexe;
    }

    public List<String> getStatutList(){
        if (this.statut.length()>0){
            return Arrays.asList(this.statut.split(","));
        }
        return new ArrayList<>();

    }

    @Override
    public String toString() {
        return "Personne{" +
                "id=" + id +
                ", pseudo='" + pseudo + '\'' +
                ", email='" + email + '\'' +
                ", pays='" + pays + '\'' +
                ", mdp='" + mdp + '\'' +
                ", statut='" + statut + '\'' +
                ", score=" + score +
                '}';
    }
}
