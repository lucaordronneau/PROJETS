package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.ItemPickedUpEventArgs;

/**
 * The ItemPickedUpEventListener is an interface that must be implemented by objects that want
 * to be informed that an item has been picked up in the game.
 *
 * @author Mika INISAN
 */
public interface ItemPickedUpEventListener extends EventListener {
    /**
     * Called when an item is picked up.
     *
     * @param sender    the object that was responsible for the level change
     * @param eventArgs information about the level change
     * @author Mika INISAN
     */
    void onItemPickUp(Object sender, ItemPickedUpEventArgs eventArgs);
}