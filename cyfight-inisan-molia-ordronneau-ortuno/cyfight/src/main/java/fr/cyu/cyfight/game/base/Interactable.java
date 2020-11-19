package fr.cyu.cyfight.game.base;

import fr.cyu.cyfight.game.entity.Entity;

/**
 * Interactable is an interface that allows other objects to interact with an
 * implementing one.
 *
 * @author Mika INISAN
 */
public interface Interactable {
    /**
     * Returns true if the interaction was successful.
     *
     * @param interactingEntity the entity to interact with
     * @return true is interaction ends correctly
     * @author Mika INISAN
     */
    boolean interact(Entity interactingEntity);
}