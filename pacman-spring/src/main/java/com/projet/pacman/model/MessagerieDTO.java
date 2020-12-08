package com.projet.pacman.model;

import javax.validation.constraints.NotEmpty;

public class MessagerieDTO {


    @NotEmpty
    private String message;

    @NotEmpty
    private String date;


    @NotEmpty
    private Personne personne;

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public Personne getPersonne() {
        return personne;
    }

    public void setPersonne(Personne personne) {
        this.personne = personne;
    }
}
