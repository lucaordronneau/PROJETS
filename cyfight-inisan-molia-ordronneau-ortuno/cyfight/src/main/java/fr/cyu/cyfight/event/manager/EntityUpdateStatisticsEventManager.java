package fr.cyu.cyfight.event.manager;


import fr.cyu.cyfight.event.args.AttackerChangeEventArgs;
import fr.cyu.cyfight.event.args.EntityStatisticsUpdateEventArgs;
import fr.cyu.cyfight.event.listener.AttackerChangeEventListener;
import fr.cyu.cyfight.event.listener.EntityStatisticsUpdateEventListener;

import java.lang.reflect.Type;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public class EntityUpdateStatisticsEventManager extends EventManager<EntityStatisticsUpdateEventListener, EntityStatisticsUpdateEventArgs> {
    // ---
    // METHODS
    // ---

    @Override
    public Type getEventType() {
        return EntityStatisticsUpdateEventListener.class;
    }

    @Override
    public void raiseEvent(EntityStatisticsUpdateEventListener listener, Object sender, EntityStatisticsUpdateEventArgs eventArgs) {
        listener.onStatisticsUpdate(sender, eventArgs);
    }
}