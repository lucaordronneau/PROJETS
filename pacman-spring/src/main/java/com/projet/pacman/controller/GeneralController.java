package com.projet.pacman.controller;

import com.projet.pacman.model.Personne;
import com.projet.pacman.service.PersonneService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.servlet.ModelAndView;

import javax.validation.Valid;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Controller
public class GeneralController {

    @Autowired
    private PersonneService personneService;

    //Mise à jour dans le profil joueur
    @PostMapping("/saveUpdate")
    public String savePersonne(@ModelAttribute("personne") @Valid Personne personne, BindingResult result) {

        Personne existingPseudo = personneService.findByPseudoAndIdIsNot(personne.getPseudo(), personne.getId());
        Personne existingEmail = personneService.findByEmailAndIdIsNot(personne.getEmail(),  personne.getId());

        System.out.println("Existe 1 " + existingPseudo);
        System.out.println("Existe 2 " + existingEmail);

        if (existingEmail != null) {
            result.rejectValue("email", null, "Cet email est déjà utilisé");
        }
        else if (existingPseudo != null) {
            result.rejectValue("pseudo", null, "Ce pseudo est déjà utilisé");
        }

        if (result.hasErrors()) {
            return "update";
        }

        personneService.saveUpdate(personne);

        if (personne.getStatut().equals("ADMINISTRATEUR")) {
            return "redirect:/profilAdministrateur";
        }
        else{
            return "redirect:/profilJoueur";
        }
    }

    @GetMapping("/update/{id}")
    public String update(@PathVariable(value = "id") int id, Model model) {
        Personne personne = personneService.findById(id);
        model.addAttribute("personne", personne);
        return "update";
    }

    //Mise à jour dans la liste des joueurs
    @PostMapping("/saveUpdateListeJoueurs")
    public String savePersonneListeJoueurs(@ModelAttribute("personne") @Valid Personne personne, BindingResult result) {

        Personne existingPseudo = personneService.findByPseudoAndIdIsNot(personne.getPseudo(), personne.getId());
        Personne existingEmail = personneService.findByEmailAndIdIsNot(personne.getEmail(),  personne.getId());

        System.out.println("Existe 1 " + existingPseudo);
        System.out.println("Existe 2 " + existingEmail);

        if (existingEmail != null) {
            result.rejectValue("email", null, "Cet email est déjà utilisé");
        }
        else if (existingPseudo != null) {
            result.rejectValue("pseudo", null, "Ce pseudo est déjà utilisé");
        }

        if (result.hasErrors()) {
            return "updateListeJoueurs";
        }

        personneService.saveUpdate(personne);

        return "redirect:/listeJoueurs";
    }

    @GetMapping("/updateListeJoueurs/{id}")
    public String updateListeJoueurs(@PathVariable(value = "id") int id, Model model) {
        Personne personne = personneService.findById(id);
        model.addAttribute("personne", personne);
        return "updateListeJoueurs";
    }




    @GetMapping("/")
    public ModelAndView getClassement() {

        String viewName = "/index";

        Map<String, Object> model = new HashMap<String, Object>();

        List<Personne> listeJoueurParScore = personneService.classement();
        System.out.println(listeJoueurParScore);
        HashMap<Integer, Personne> positionScore = new HashMap<Integer, Personne>();
        Integer i = 1;
        for (Personne p : listeJoueurParScore){
            positionScore.put(i, p);
            i = i + 1;
        }
        model.put("listeJoueurParScore", positionScore);

        return new ModelAndView(viewName, model);
    }
}
