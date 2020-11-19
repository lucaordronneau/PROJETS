package com.projet.pacman.model;

import javax.validation.constraints.NotEmpty;

public class PersonneInscriptionDTO {

    @NotEmpty
    private String pseudo;

    @NotEmpty
    private String email;

    @NotEmpty
    private String pays;

    @NotEmpty
    private String mdp;

    @NotEmpty
    private String sexe;

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

    public void setMotDePasse(String mdp) {
        this.mdp = mdp;
    }

    public String getSexe() {
        return sexe;
    }

    public void setSexe(String sexe) {
        this.sexe = sexe;
    }
}
