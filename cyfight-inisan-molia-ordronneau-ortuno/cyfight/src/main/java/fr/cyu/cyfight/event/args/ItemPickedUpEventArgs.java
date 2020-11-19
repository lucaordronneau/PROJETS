package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Entity;
import fr.cyu.cyfight.game.entity.Item;

/**
 * The ItemPickedUpEventArgs class carries information needed when an item is picked up by a player or
 * any other entity.
 *
 * @author Mika INISAN
 */
public class ItemPickedUpEventArgs implements EventArgs {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * The entity that picks up the item
     */
    private Entity entity;

    /**
     * The item that is picked up
     */
    private Item pickedUpItem;

    /**
     * y coordinate of the item
     */
    private int y;

    /**
     * x coordinate of the item
     */
    private int x;

    // ---
    // CONSTRUCTORS
    // ---

    /**
     * @param entity       The entity that picks up the item
     * @param pickedUpItem he item that is picked up
     * @param y            y coordinate of the item
     * @param x            x coordinate of the item
     * @author Mika INISAN
     */
    public ItemPickedUpEventArgs(Entity entity, Item pickedUpItem, int y, int x) {
        this.entity = entity;
        this.pickedUpItem = pickedUpItem;
        this.y = y;
        this.x = x;
    }

    // ---
    // METHODS
    // ---

    /**
     * Retrieve the entity
     *
     * @return the entity
     */
    public Entity getEntity() {
        return entity;
    }

    /**
     * Change the entity
     *
     * @param entity the entity
     */
    public void setEntity(Entity entity) {
        this.entity = entity;
    }

    /**
     * Retrieve the item that is picked up
     *
     * @return the item
     */
    public Item getPickedUpItem() {
        return pickedUpItem;
    }

    /**
     * Retrieve the y coordinate of the item
     *
     * @return the y coordinate of the item
     */
    public int getY() {
        return y;
    }

    /**
     * Retrieve the x coordinate of the item
     *
     * @return the x coordinate of the item
     */
    public int getX() {
        return x;
    }
}