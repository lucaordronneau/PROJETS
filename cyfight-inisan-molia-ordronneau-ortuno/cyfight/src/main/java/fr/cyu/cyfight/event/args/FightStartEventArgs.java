package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Player;

/**
 * The FightStartingEventArgs class carries all needed information when a fight is starting.
 *
 * @author Mika INISAN
 */
public class FightStartEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

    /**
     * The player
     */
    private Player playerFighting;

    /**
     * The enemy
     */
    private Enemy enemyFighting;

    // ---
    // CONSTRUCTORS
    // ---

    /**
     * Constructs a new information object that carries all information needed when a
     * fight is starting
     *
     * @param playerFighting the player
     * @param enemyFighting  the enemy
     * @author Mika INISAN
     */
    public FightStartEventArgs(Player playerFighting, Enemy enemyFighting) {
        this.playerFighting = playerFighting;
        this.enemyFighting = enemyFighting;
    }

    // ---
    // METHODS
    // ---

    /**
     * Retrieve the player
     *
     * @return the player
     * @author Mika INISAN
     */
    public Player getPlayerFighting() {
        return playerFighting;
    }

    /**
     * Retrieve the enemy
     *
     * @return the enemy
     * @author Mika INISAN
     */
    public Enemy getEnemyFighting() {
        return enemyFighting;
    }
}