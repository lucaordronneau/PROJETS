package com.projet.pacman.repository;

import com.projet.pacman.model.Messagerie;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface MessagerieRepository extends JpaRepository<Messagerie, Integer> {
    List<Messagerie> findByOrderByIdAsc();
}
