package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.LevelChangeEventArgs;
import fr.cyu.cyfight.event.listener.LevelChangeEventListener;

import java.lang.reflect.Type;

/**
 * Event Manager for level change events.
 *
 * @author Mika INISAN
 */
public class LevelChangeEventManager extends EventManager<LevelChangeEventListener, LevelChangeEventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return LevelChangeEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(LevelChangeEventListener listener, Object sender, LevelChangeEventArgs eventArgs) {
        listener.onLevelChange(sender, eventArgs);
    }
}