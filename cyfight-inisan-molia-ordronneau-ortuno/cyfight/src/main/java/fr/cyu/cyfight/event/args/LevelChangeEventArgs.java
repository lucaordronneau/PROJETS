package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.base.Grid;

/**
 * The LevelChangeEventArgs class carries information about a level change, such as the new level.
 *
 * @author Mika INISAN
 * @see fr.cyu.cyfight.event.listener.LevelChangeEventListener
 */
public class LevelChangeEventArgs implements EventArgs {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * The grid associated to the new level
     */
    private Grid newGrid;

    /**
     * The new level index
     */
    private int level;

    // ---
    // CONSTRUCTORS
    // ----

    /**
     * Constructs a new information object. This object carries all information required by the "level change event".
     *
     * @param newGrid The grid associated to the new level
     * @param level   The new level index
     * @author Mika INISAN
     * @see fr.cyu.cyfight.event.listener.LevelChangeEventListener
     */
    public LevelChangeEventArgs(Grid newGrid, int level) {
        this.newGrid = newGrid;
        this.level = level;
    }

    // ---
    // METHODS
    // ---

    /**
     * Retrieves the grid for the new level
     *
     * @return The grid associated to the new level
     * @author Mika INISAN
     */
    public Grid getNewGrid() {
        return newGrid;
    }

    /**
     * Retrieves the new level index
     *
     * @return The new level index
     * @author Mika INISAN
     */
    public int getLevel() {
        return level;
    }
}