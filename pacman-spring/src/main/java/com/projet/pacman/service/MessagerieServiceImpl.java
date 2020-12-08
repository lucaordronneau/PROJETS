package com.projet.pacman.service;

import com.projet.pacman.model.Messagerie;
import com.projet.pacman.repository.MessagerieRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;

@Service
public class MessagerieServiceImpl implements MessagerieService{

    @Autowired
    private MessagerieRepository messagerieRepository;

    public List<Messagerie> listeMessages(){
        return  messagerieRepository.findByOrderByIdAsc();
    }
    @Override
    public void envoiMessage(Messagerie messagerie) {
        Date date = Calendar.getInstance().getTime();
        DateFormat dateFormat = new SimpleDateFormat("dd-MM-yyyy hh:mm");
        String strDate = dateFormat.format(date);
        messagerie.setDate(strDate);
        this.messagerieRepository.save(messagerie);
        messagerie.toString();
    }
}
