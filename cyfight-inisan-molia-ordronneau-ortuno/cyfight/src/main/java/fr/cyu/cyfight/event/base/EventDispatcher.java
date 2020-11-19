package fr.cyu.cyfight.event.base;

import fr.cyu.cyfight.event.args.EventArgs;
import fr.cyu.cyfight.event.listener.EventListener;
import fr.cyu.cyfight.event.manager.EventManager;

import java.lang.reflect.Type;
import java.util.HashMap;

/**
 * The EventDispatcher class is the central class managing all game events. It centralizes event managers that
 * are responsible for emitting events to any object that subscribes to a specific event. Then it can be called
 * by any event emitter in order to send the event to all objects listening.
 * <p>
 * An EventManager needs to register itself on the EventDispatcher in order to emit events.
 *
 * @author Mika INISAN
 * @see fr.cyu.cyfight.event.manager.EventManager
 * @see fr.cyu.cyfight.event.listener.EventListener
 */
public class EventDispatcher {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * Unique instance of the EventDispatcher
     */
    private static final EventDispatcher INSTANCE = new EventDispatcher();

    /**
     * List of registered event managers
     */
    private HashMap<Type, EventManager> eventManagers = new HashMap<>();

    /**
     * Lock events (when event are locked, the EventDispatcher does not raise any event)
     */
    private boolean lockEvents = false;

    // ---
    // CONSTRUCTORS
    // ---

    /**
     * Constructs a new instance of the EventDispatcher.
     *
     * @author Mika INISAN
     */
    private EventDispatcher() {
    }

    // ---
    // METHODS
    // ---

    /**
     * Retrieves the unique instance of the EventDispatcher.
     *
     * @return The application EventDisptacher
     * @author Mika INISAN
     */
    public static EventDispatcher getInstance() {
        return INSTANCE;
    }

    /**
     * Registers an EventManager so that his events can be dispatched.
     * Should be called when initializing the application.
     *
     * @param eventManager an event manager
     * @return the instance of the EventDispatcher
     * @author Mika INISAN
     */

    public EventDispatcher register(EventManager eventManager) {
        eventManagers.put(eventManager.getEventType(), eventManager);

        return getInstance();
    }

    /**
     * Lock events.
     *
     * @param lock true to disable all events
     * @author Mika INISAN
     */
    public void lockEvents(boolean lock) {
        lockEvents = lock;
    }

    /**
     * Subscribes an object so that it can listen to a specific event.
     *
     * @param eventType     type of the event to subscribe to
     * @param eventListener object that wants to listen to the event
     * @return the instance of the EventDispatcher
     */
    public EventDispatcher subscribe(Type eventType, EventListener eventListener) {
        if (lockEvents) return getInstance();

        if (eventManagers.containsKey(eventType)) {
            eventManagers.get(eventType).addListener(eventListener);

            return getInstance();
        }

        return raiseEventManagerNotFound(eventType);
    }

    /**
     * Unsubscribes an object so that it stops listening to an event.
     *
     * @param eventType     type of the event to unsubscribe to
     * @param eventListener object that wants to listen to the event
     * @return the instance of the EventDispatcher
     * @author Mika INISAN
     */
    public EventDispatcher unsubscribe(Type eventType, EventListener eventListener) {
        if (eventManagers.containsKey(eventType)) {
            eventManagers.get(eventType).removeListener(eventListener);

            return getInstance();
        }

        return raiseEventManagerNotFound(eventType);
    }

    /**
     * Sends an event to all objects listening to it.
     *
     * @param sender    the object that is sending the event
     * @param eventType type of the event
     * @param eventArgs information that is required by the event to send information to listeners
     * @author Mika INISAN
     */
    public void dispatchEvent(Object sender, Type eventType, EventArgs eventArgs) {
        if (eventManagers.containsKey(eventType)) {
            eventManagers.get(eventType).dispatchEvent(sender, eventArgs);

            return;
        }

        raiseEventManagerNotFound(eventType);
    }

    /**
     * Displays an error when no event manager has been found to manage a specific event.
     *
     * @param eventType the type of the event
     * @return the instance of the EventDispatcher
     * @author Mika INISAN
     */
    private EventDispatcher raiseEventManagerNotFound(Type eventType) {
        System.err.println("No event manager for type " + eventType.getTypeName());

        return getInstance();
    }
}