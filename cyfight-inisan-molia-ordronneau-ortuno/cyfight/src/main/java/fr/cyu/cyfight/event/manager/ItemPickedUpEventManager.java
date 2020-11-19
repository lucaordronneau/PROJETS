package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.ItemPickedUpEventArgs;
import fr.cyu.cyfight.event.listener.ItemPickedUpEventListener;

import java.lang.reflect.Type;

/**
 * Event manager for "item picked up" events.
 *
 * @author Mika INISAN
 */
public class ItemPickedUpEventManager extends EventManager<ItemPickedUpEventListener, ItemPickedUpEventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return ItemPickedUpEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(ItemPickedUpEventListener listener, Object sender, ItemPickedUpEventArgs eventArgs) {
        listener.onItemPickUp(sender, eventArgs);
    }
}