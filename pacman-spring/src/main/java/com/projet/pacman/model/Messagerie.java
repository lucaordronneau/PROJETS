package com.projet.pacman.model;

import javax.persistence.*;

@Entity
@Table(name = "messagerie")
public class Messagerie {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;
    @Column
    private String message;
    @Column
    private String date;

    @OneToOne(fetch = FetchType.LAZY, cascade = {CascadeType.MERGE, CascadeType.REMOVE})
    @JoinColumn(name = "id_personne", referencedColumnName = "id")
    private Personne personne;

    public Messagerie(String message, String date, Personne personne) {
        this.message = message;
        this.date = date;
        this.personne = personne;
    }

    public Messagerie(){}


    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

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

    @Override
    public String toString() {
        return "Messagerie{" +
                "id=" + id +
                ", message='" + message + '\'' +
                ", date='" + date + '\'' +
                ", personne=" + personne +
                '}';
    }
}
