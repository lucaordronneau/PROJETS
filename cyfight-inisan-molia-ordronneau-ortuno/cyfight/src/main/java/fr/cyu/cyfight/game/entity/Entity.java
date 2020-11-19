package fr.cyu.cyfight.game.entity;

import fr.cyu.cyfight.game.base.Interactable;

/**
 * Base interface for all entities.
 *
 * @author Mika INISAN
 */
public interface Entity extends Interactable {
    /**
     * Interact with the entity.
     *
     * @param interactingEntity the entity to interact with
     * @return true is the interaction was successful
     * @author Mika INISAN
     */
    @Override
    boolean interact(Entity interactingEntity);
}
