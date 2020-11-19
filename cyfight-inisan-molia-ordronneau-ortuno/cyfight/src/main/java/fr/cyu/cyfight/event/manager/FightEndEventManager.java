package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.FightEndEventArgs;
import fr.cyu.cyfight.event.args.FightStartEventArgs;
import fr.cyu.cyfight.event.listener.FightEndEventListener;
import fr.cyu.cyfight.event.listener.FightStartEventListener;

import java.lang.reflect.Type;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class FightEndEventManager extends EventManager<FightEndEventListener, FightEndEventArgs> {
    // ---
    // METHODS
    // ---

    @Override
    public Type getEventType() {
        return FightEndEventListener.class;
    }

    @Override
    public void raiseEvent(FightEndEventListener listener, Object sender, FightEndEventArgs eventArgs) {
        listener.onFightEnd(sender, eventArgs);
    }
}