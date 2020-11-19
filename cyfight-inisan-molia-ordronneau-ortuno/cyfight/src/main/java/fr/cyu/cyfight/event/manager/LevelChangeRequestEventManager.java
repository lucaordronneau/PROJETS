package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.LevelChangeRequestEventArgs;
import fr.cyu.cyfight.event.listener.LevelChangeRequestEventListener;

import java.lang.reflect.Type;

/**
 * Event Manager for level changing events.
 *
 * @author Mika INISAN
 */
public class LevelChangeRequestEventManager extends EventManager<LevelChangeRequestEventListener, LevelChangeRequestEventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return LevelChangeRequestEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(LevelChangeRequestEventListener listener, Object sender, LevelChangeRequestEventArgs eventArgs) {
        listener.onLevelChangeRequest(sender, eventArgs);
    }
}