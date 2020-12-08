package com.projet.pacman.service;

import com.projet.pacman.model.Messagerie;

import java.util.List;

public interface MessagerieService {
    List<Messagerie> listeMessages();
    void envoiMessage(Messagerie message);

}
