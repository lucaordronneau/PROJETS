package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Entity;
import fr.cyu.cyfight.game.entity.Player;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class AttackerChangeEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

    // TODO Explain attributes?
    private Entity attacker;
    private Entity defender;

    // ---
    // CONSTRUCTORS
    // ---

    public AttackerChangeEventArgs(Entity attacker, Entity defender) {
        this.attacker = attacker;
        this.defender = defender;
    }

    // ---
    // GETTERS/SETTERS
    // ---

    public Entity getAttacker() {
        return attacker;
    }

    public Entity getDefender() {
        return defender;
    }
}