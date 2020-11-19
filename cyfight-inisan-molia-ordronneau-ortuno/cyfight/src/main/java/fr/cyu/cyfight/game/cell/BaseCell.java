package fr.cyu.cyfight.game.cell;

import fr.cyu.cyfight.event.args.LevelChangeRequestEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.LevelChangeRequestEventListener;
import fr.cyu.cyfight.game.entity.Entity;

import java.util.*;

/**
 * Base cell for the game grid
 *
 * @author Mika INISAN
 */
public class BaseCell implements Cell {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * Is the cell blocking? (e.g. "contains a wall")
     */
    protected boolean blocking;

    /**
     * Is the cell an exit?
     */
    protected boolean exit;

    /**
     * Is the cell an entry?
     */
    protected boolean entry;

    /**
     * Has the cell a high priority?
     * If the cell has a high priority, then the player interacts with it before interacting with the
     * cell's entities
     */
    protected boolean highPriority;

    /**
     * List of entities placed on the cell
     */
    protected Deque<Entity> entities;

    /**
     * X coordinate of the cell
     */
    public int x;

    /**
     * Y coordinate of the cell
     */
    public int y;

    // ---
    // CONSTRUCTORS
    // ---

    /**
     * Constructs a base cell
     *
     * @author Mika INISAN
     */
    public BaseCell() {
        entities = new ArrayDeque<>();
    }

    /**
     * Constructs a base cell.
     *
     * @param x        x coordinate of the cell
     * @param y        y coordinate of the cell
     * @param blocking true if the cell is a wall
     * @author ordronneau@eisti.eu
     */
    public BaseCell(int x, int y, boolean blocking) {
        this(blocking, false, false, false);

        this.x = x;
        this.y = y;
    }

    /**
     * Constructs a base cell.
     *
     * @param x            x coordinate of the cell
     * @param y            y coordinate of the cell
     * @param blocking     true if the cell is a wall
     * @param exit         true if the cell is an exit
     * @param entry        true if the cell is an entry
     * @param highPriority true is the cell has higher priority than it's entities
     * @author ordronneau@eisti.eu
     */
    public BaseCell(int x, int y, boolean blocking, boolean exit, boolean entry, boolean highPriority) {
        this(blocking, exit, entry, highPriority);

        this.x = x;
        this.y = y;
    }

    /**
     * Constructs a base cell.
     *
     * @param blocking     true if the cell is a wall
     * @param exit         true if the cell is an exit
     * @param entry        true if the cell is an entry
     * @param highPriority true is the cell has higher priority than it's entities
     * @author Mika INISAN
     */
    public BaseCell(boolean blocking, boolean exit, boolean entry, boolean highPriority) {
        this();

        this.blocking = blocking;
        this.exit = exit;
        this.entry = entry;
        this.highPriority = highPriority;
    }

    // ---
    // METHODS
    // ---

    /**
     * Is the cell blocking? (if so, the player cannot move onto the cell)
     *
     * @return true if the cell is a wall
     * @author Mika INISAN
     */
    @Override
    public boolean isBlocking() {
        return blocking;
    }

    /**
     * Is the cell an exit?
     *
     * @return true if the cell is an exit
     * @author Mika INISAN
     */
    @Override
    public boolean isExit() {
        return exit;
    }

    /**
     * Is the cell an entry?
     *
     * @return true if the cell is an entry
     * @author Mika INISAN
     */
    @Override
    public boolean isEntry() {
        return entry;
    }

    /**
     * Has the cell a high priority?
     *
     * @return true if the cell's priority is higher than it's entities priority
     * @author Mika INISAN
     */
    @Override
    public boolean hasHighPriority() {
        return highPriority;
    }

    /**
     * Retrieves the list of entities which are on the cell.
     *
     * @return List of entities
     * @author Mika INISAN
     */
    @Override
    public Deque<Entity> getEntities() {
        return entities;
    }

    /**
     * Interact with the cell and the entities on the cell
     *
     * @param interactingEntity The entity that interacts with the cell
     * @return true is the interaction is successful
     * @author Mika INISAN
     */
    @Override
    public boolean interact(Entity interactingEntity) {
        boolean successfulInteraction = true;

        if (!highPriority && entities.size() > 1) {
            successfulInteraction = doInteractions(interactingEntity);
        }

        if (exit || entry) {
            EventDispatcher.getInstance().dispatchEvent(this,
                    LevelChangeRequestEventListener.class,
                    new LevelChangeRequestEventArgs(entities.peek(), exit));
        }

        if (highPriority && entities.size() > 1) {
            successfulInteraction = doInteractions(interactingEntity);
        }

        return successfulInteraction;
    }

    /**
     * Interact with all entities on the cell
     *
     * @param interactingEntity the entity to interact with
     * @return true if all interactions are successful
     * @author Mika INISAN
     */
    private boolean doInteractions(Entity interactingEntity) {
        Iterator<Entity> iterator = entities.iterator();

        // We need an arraylist because the Deque is not Thread safe
        ArrayList<Entity> successfulInteractions = new ArrayList<>();

        boolean winningInterraction = true;

        iterator.next();

        while (iterator.hasNext() && winningInterraction) {
            Entity entity = iterator.next();

            if (entity.interact(interactingEntity)) {
                successfulInteractions.add(entity);
            } /*else {
				winningInterraction = false;
			}*/
        }

        for (Entity entity : successfulInteractions) {
            entities.remove(entity);
        }

        return winningInterraction;
    }

    /**
     * Change the fact that a cell is blocking (a wall) or not.
     *
     * @param blocking true to consider the cell as a wall
     * @author Mika INISAN
     */
    @Override
    public void setBlocking(boolean blocking) {
        this.blocking = blocking;
    }
}