package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.PlayerMoveEventArgs;
import fr.cyu.cyfight.event.listener.PlayerMoveEventListener;

import java.lang.reflect.Type;

/**
 * Event Manager for events signaling a player move.
 *
 * @author Mika INISAN
 */
public class PlayerMoveEventManager extends EventManager<PlayerMoveEventListener, PlayerMoveEventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return PlayerMoveEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(PlayerMoveEventListener listener, Object sender, PlayerMoveEventArgs eventArgs) {
        listener.onPlayerMove(sender, eventArgs);
    }
}