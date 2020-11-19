package com.projet.pacman.controller;

import com.projet.pacman.model.Personne;
import com.projet.pacman.security.PersonnePrincipal;
import com.projet.pacman.service.PersonneService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.servlet.ModelAndView;

import java.util.HashMap;
import java.util.Map;

@Controller
public class JoueurController {

    @Autowired
    private PersonneService personneService;

    @GetMapping("/profilJoueur")
    public String getProfilJoueur(@AuthenticationPrincipal PersonnePrincipal personnePrincipal, Model model) {

        String pseudo = personnePrincipal.getUsername();
        Personne personne = personneService.findByPseudo(pseudo);

        model.addAttribute("personne", personne);

        return "/profilJoueur";

    }

    @GetMapping("/jeuJoueur")
    public ModelAndView getJeuJoueur() {

        String viewName = "jeuJoueur";

        Map<String, Object> model = new HashMap<String, Object>();

        model.put("validationProfilJoueur", 7);

        return new ModelAndView(viewName, model);
    }
}
