package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;
import fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener;

import java.lang.reflect.Type;

/**
 * Event Manager for scene changing events.
 *
 * @author Mika INISAN
 */
public class SceneChangeRequestEventManager extends EventManager<SceneChangeRequestEventListener, SceneChangeRequestEventArgs> {
    // ---
    // METHODS
    // ---

    /**
     * {@inheritDoc}
     */
    @Override
    public Type getEventType() {
        return SceneChangeRequestEventListener.class;
    }

    /**
     * {@inheritDoc}
     */
    @Override
    public void raiseEvent(SceneChangeRequestEventListener listener, Object sender, SceneChangeRequestEventArgs eventArgs) {
        listener.onSceneChangeRequest(sender, eventArgs);
    }
}