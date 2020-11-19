package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Player;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class FightEndEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

    private int y;
    private int x;
    private Enemy enemy;

    // ---
    // CONSTRUCTORS
    // ---

    public FightEndEventArgs(int y, int x, Enemy enemy) {
        this.y = y;
        this.x = x;
        this.enemy = enemy;
    }

    // ---
    // METHODS
    // ---

    public int getY() {
        return y;
    }

    public int getX() {
        return x;
    }

    public Enemy getEnemy() {
        return enemy;
    }
}