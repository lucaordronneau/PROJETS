package fr.cyu.cyfight.game.cell;

import fr.cyu.cyfight.game.base.Interactable;
import fr.cyu.cyfight.game.entity.Entity;

import java.util.Deque;

/**
 * Cell is the interface for grid cells (a cell being a part of the grid on which the player moves).
 *
 * @author Mika INISAN
 */
public interface Cell extends Interactable {
	/**
	 * Is the cell blocking? (if so, the player cannot move onto the cell)
	 *
	 * @return true if the cell is a wall
	 * @author Mika INISAN
	 */
	boolean isBlocking();

	/**
	 * Change the fact that a cell is blocking (a wall) or not.
	 *
	 * @param blocking true to consider the cell as a wall
	 * @author Mika INISAN
	 */
	void setBlocking(boolean blocking);

	/**
	 * Is the cell an exit?
	 *
	 * @return true if the cell is an exit
	 * @author Mika INISAN
	 */
	boolean isExit();

	/**
	 * Is the cell an entry?
	 *
	 * @return true if the cell is an entry
	 * @author Mika INISAN
	 */
	boolean isEntry();

	/**
	 * Has the cell a high priority?
	 * (when a cell has a high priority, the player interacts with it before interacting with the entities of the cell)
	 *
	 * @return true if the cell's priority is higher than it's entities priority
	 * @author Mika INISAN
	 */
	boolean hasHighPriority();

	/**
	 * Retrieves the list of entities which are on the cell.
	 *
	 * @return List of entities
	 * @author Mika INISAN
	 */
	Deque<Entity> getEntities();
}