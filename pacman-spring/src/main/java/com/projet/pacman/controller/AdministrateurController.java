package com.projet.pacman.controller;

import com.projet.pacman.model.Messagerie;
import com.projet.pacman.model.Personne;
import com.projet.pacman.model.PersonneInscriptionDTO;
import com.projet.pacman.security.PersonnePrincipal;
import com.projet.pacman.service.MessagerieService;
import com.projet.pacman.service.PersonneService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
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
public class AdministrateurController {

    @Autowired
    private PersonneService personneService;
    @Autowired
    private MessagerieService messagerieService;

    @GetMapping("/listeJoueurs")
    public ModelAndView getListeJoueurs() {

        String viewName = "listeJoueurs";

        Map<String, Object> model = new HashMap<String, Object>();

        List<Personne> listeJoueur = personneService.findByStatut("JOUEUR");
        model.put("listeJoueur", listeJoueur);
        /*On affiche dans le terminal*/
        List<Messagerie> listeMessages = messagerieService.listeMessages();
        model.put("listeMessages", listeMessages);
        System.out.println(listeMessages);

        Messagerie messagerie = new Messagerie();
        model.put("messagerie", messagerie);


        System.out.println(listeJoueur);
        return new ModelAndView(viewName, model);


    }

    @GetMapping("/profilAdministrateur")
    public String getProfilAdministrateur(@AuthenticationPrincipal PersonnePrincipal personnePrincipal, Model model) {

        String pseudo = personnePrincipal.getUsername();
        Personne personne = personneService.findByPseudo(pseudo);

        model.addAttribute("personne", personne);

        return "/profilAdministrateur";

    }

    @GetMapping("/statistiquesAdministrateur")
    public ModelAndView getStatistiquesAdministrateur() {


        String viewName = "statistiquesAdministrateur";

        Map<String, Object> model = new HashMap<String, Object>();

        long listNbHomme = personneService.countBySexe("H");
        model.put("listNbHomme", listNbHomme);

        long listNbFemme = personneService.countBySexe("F");
        model.put("listNbFemme", listNbFemme);

        long listNbOther = personneService.countBySexe("O");
        model.put("listNbOther", listNbOther);

        long listNbFr = personneService.countByPays("FRANCE");
        model.put("listNbFr", listNbFr);

        long listNbCr = personneService.countByPays("CROATIE");
        model.put("listNbCr", listNbCr);

        long listNbCo = personneService.countByPays("COREE DU SUD");
        model.put("listNbCo", listNbCo);

        long listNbAng = personneService.countByPays("ANGLETERRE");
        model.put("listNbAng", listNbAng);

        long listNbRu = personneService.countByPays("RUSSIE");
        model.put("listNbRu", listNbRu);

        long listNbCan = personneService.countByPays("CANADA");
        model.put("listNbCan", listNbCan);

        long listNbNo = personneService.countByPays("NORVEGE");
        model.put("listNbNo", listNbNo);

        long listNbEt = personneService.countByPays("ETATS-UNIS");
        model.put("listNbEt", listNbEt);

        long listNbAu = personneService.countByPays("AUTRE");
        model.put("listNbAu", listNbAu);

        long listNbJa = personneService.countByPays("JAPON");
        model.put("listNbJa", listNbJa);

        return new ModelAndView(viewName, model);
    }

    @GetMapping("/deletePersonne/{id}")
    public String deletePersonne(@PathVariable(value = "id") int id) {
        this.personneService.deletePersonneById(id);
        return "redirect:/listeJoueurs";
    }

    @GetMapping("/showNewJoueur")
    public String showNewJoueur(Model model) {
        // create model attribute to bind form data
        Personne personne = new Personne();
        model.addAttribute("personne", personne);
        return "showNewJoueurForm";
    }

    @PostMapping("/savePersonne")
    public String savePersonne(@ModelAttribute("personne") Personne personne) {
        personneService.savePersonne(personne);
        return "redirect:/listeJoueurs";
    }

}
