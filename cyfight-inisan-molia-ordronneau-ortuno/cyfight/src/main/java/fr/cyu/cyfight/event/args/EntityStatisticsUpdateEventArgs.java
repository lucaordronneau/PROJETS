package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Entity;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class EntityStatisticsUpdateEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

    // TODO Explain attributes?
    private Entity player;
    private Entity opponent;

    // ---
    // CONSTRUCTORS
    // ---

    public EntityStatisticsUpdateEventArgs(Entity player, Entity opponent) {
        this.player = player;
        this.opponent = opponent;
    }

    // ---
    // GETTERS/SETTERS
    // ---

    public Entity getPlayer() {
        return player;
    }

    public Entity getOpponent() {
        return opponent;
    }
}