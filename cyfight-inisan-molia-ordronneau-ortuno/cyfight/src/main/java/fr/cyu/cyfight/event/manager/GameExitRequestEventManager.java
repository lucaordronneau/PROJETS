package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.EventArgs;
import fr.cyu.cyfight.event.listener.GameExitRequestEventListener;

import java.lang.reflect.Type;

/**
 * Event Manager for game exit events.
 *
 * @author Mika INISAN
 */
public class GameExitRequestEventManager extends EventManager<GameExitRequestEventListener, EventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return GameExitRequestEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(GameExitRequestEventListener listener, Object sender, EventArgs eventArgs) {
        listener.onGameExit(sender, eventArgs);
    }
}