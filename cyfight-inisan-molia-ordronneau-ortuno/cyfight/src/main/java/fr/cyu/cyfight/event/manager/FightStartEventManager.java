package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.FightStartEventArgs;
import fr.cyu.cyfight.event.listener.FightStartEventListener;

import java.lang.reflect.Type;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class FightStartEventManager extends EventManager<FightStartEventListener, FightStartEventArgs> {
    // ---
    // METHODS
    // ---

    @Override
    public Type getEventType() {
        return FightStartEventListener.class;
    }

    @Override
    public void raiseEvent(FightStartEventListener listener, Object sender, FightStartEventArgs eventArgs) {
        listener.onFightStart(sender, eventArgs);
    }
}