package com.projet.pacman.controller;

import org.springframework.boot.web.servlet.error.ErrorController;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.servlet.ModelAndView;

import javax.servlet.http.HttpServletResponse;

public class ErreurController implements ErrorController {
    @Override
    public String getErrorPath() {
        return "/error";
    }

    @GetMapping("/error")
    public ModelAndView handleError(HttpServletResponse response) {

        int code = response.getStatus();
        System.out.println("Statut de l'erreur " + code );
        return new ModelAndView("error");
    }
}
