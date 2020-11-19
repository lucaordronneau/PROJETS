package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.AttackerChangeEventArgs;
import fr.cyu.cyfight.event.listener.AttackerChangeEventListener;

import java.lang.reflect.Type;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class AttackerChangeEventManager extends EventManager<AttackerChangeEventListener, AttackerChangeEventArgs> {
    // ---
    // METHODS
    // ---

    @Override
    public Type getEventType() {
        return AttackerChangeEventListener.class;
    }

    @Override
    public void raiseEvent(AttackerChangeEventListener listener, Object sender, AttackerChangeEventArgs eventArgs) {
        listener.onAttackerChange(sender, eventArgs);
    }
}