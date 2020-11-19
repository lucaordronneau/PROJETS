package fr.cyu.cyfight.event.manager;

import fr.cyu.cyfight.event.args.EventArgs;
import fr.cyu.cyfight.event.listener.EventListener;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.List;

/**
 * The EventManager class stores all objects that listen to a specific event, and thus is able of dispatch this
 * event to these objects.
 *
 * This class is the base class for concrete event managers.
 *
 * @param <T> type of the event that is managed
 * @param <U> event arguments that are required by the event, and that will be sent to the listeners
 * @author Mika INISAN
 */
public abstract class EventManager<T extends EventListener, U extends EventArgs> {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * List of the objects that subscribed to the event
     */
    private List<T> listeners = new ArrayList<>();

    // ---
    // METHODS
    // ---

    /**
     * Subscribes an object that wants to listen to the event
     *
     * @param listener the object that is to listen to the event
     * @author Mika INISAN
     */
    public final void addListener(T listener) {
        listeners.add(listener);
    }

    /**
     * Stops listening to the event
     *
     * @param listener the object that doesn't want to listen to the event anymore
     * @author Mika INISAN
     */
    public final void removeListener(T listener) {
        listeners.remove(listener);
    }

    /**
     * Sends an event to all objects that have subscribed to this event
     *
     * @param sender    the object that is emitting the event
     * @param eventArgs information required by the event
     * @author Mika INISAN
     */
    public final void dispatchEvent(Object sender, U eventArgs) {
        for (T listener : listeners) {
            raiseEvent(listener, sender, eventArgs);
        }
    }

    /**
     * Retrieves event type.
     *
     * @return the type of the event
     * @author Mika INISAN
     */
    public abstract Type getEventType();

    /**
     * Sends an event to one listener.
     *
     * @param listener  an object listening to the event
     * @param sender    the object emitting the event
     * @param eventArgs information that is sent to the listener
     * @author Mika INISAN
     */
    public abstract void raiseEvent(T listener, Object sender, U eventArgs);
}