package com.projet.pacman.controller;

import com.projet.pacman.model.Personne;
import com.projet.pacman.model.PersonneInscriptionDTO;
import com.projet.pacman.service.PersonneService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import javax.validation.Valid;

@Controller
@RequestMapping("/inscription")
public class InscriptionController {

    @Autowired
    private PersonneService personneService;

    @ModelAttribute("personne")
    public PersonneInscriptionDTO personneInscriptionDTO(){

        return new PersonneInscriptionDTO();
    }

    @GetMapping
    public String getInscription(Model model) {

        return "inscription";
    }

    @PostMapping
    public String inscriptionPersonneCompte(@ModelAttribute("personne") @Valid PersonneInscriptionDTO personneDTO,
                                      BindingResult result) {

        Personne existingPseudo = personneService.findByPseudo(personneDTO.getPseudo());
        Personne existingEmail = personneService.findByEmail(personneDTO.getEmail());

        if (existingEmail != null) {
            result.rejectValue("email", null, "Cet email est déjà utilisé");
        }
        else if (existingPseudo != null) {
            result.rejectValue("pseudo", null, "Ce pseudo est déjà utilisé");
        }

        if (result.hasErrors()) {
            return "inscription";
        }

        personneService.save(personneDTO);
        return "redirect:/inscription?success";
    }
}
