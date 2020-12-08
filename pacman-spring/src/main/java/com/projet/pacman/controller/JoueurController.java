package com.projet.pacman.controller;

import com.projet.pacman.model.Messagerie;
import com.projet.pacman.model.Personne;
import com.projet.pacman.security.PersonnePrincipal;
import com.projet.pacman.service.MessagerieService;
import com.projet.pacman.service.PersonneService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.ModelAndView;

import javax.validation.Valid;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import static org.springframework.web.bind.annotation.RequestMethod.GET;

@Controller
public class JoueurController {

    @Autowired
    private PersonneService personneService;
    @Autowired
    private MessagerieService messagerieService;

    @GetMapping("/profilJoueur")
    public String getProfilJoueur(@AuthenticationPrincipal PersonnePrincipal personnePrincipal, Model model) {

        String pseudo = personnePrincipal.getUsername();
        Personne personne = personneService.findByPseudo(pseudo);

        model.addAttribute("personne", personne);

        return "/profilJoueur";

    }

    @GetMapping("/jeuJoueur")
    public String getJeuJoueur(@AuthenticationPrincipal PersonnePrincipal personnePrincipal, Model model) {

        String viewName = "jeuJoueur";

        String pseudo = personnePrincipal.getUsername();
        Personne personne = personneService.findByPseudo(pseudo);

        model.addAttribute("personne", personne);

        List<Personne> listeJoueurParScore = personneService.classement();
        System.out.println(listeJoueurParScore);
        HashMap<Integer, Personne> positionScore = new HashMap<Integer, Personne>();
        Integer i = 1;
        for (Personne p : listeJoueurParScore){
            positionScore.put(i, p);
            i = i + 1;
        }
        model.addAttribute("listeJoueurParScore", positionScore);

        List<Messagerie> listeMessages = messagerieService.listeMessages();
        model.addAttribute("listeMessages", listeMessages);
        System.out.println(listeMessages);

        Messagerie messagerie = new Messagerie();
        model.addAttribute("messagerie", messagerie);

        return "/jeuJoueur";
    }

/*
    @RequestMapping(value = "/jeuJoueur")
    public String saveNewScore( value = "score"){

    } */


    @RequestMapping(value = "/jeuJoueur", params = { "id", "score" } ,method = GET)
    @ResponseBody
    public ModelAndView saveNewScore(@RequestParam("id") int id, @RequestParam("score") int score){
        Personne personne = personneService.findById(id);
        if(personne.getScore() < score){
            personne.setScore(score);
            personneService.updateScore(personne);
        }

        return  new ModelAndView("redirect:/jeuJoueur");
    }

    @PostMapping("/envoiMessage")
    public String envoiMessage(@ModelAttribute("messagerie") Messagerie messagerie){
         messagerieService.envoiMessage(messagerie);
         return  "redirect:/jeuJoueur";
    }


}
