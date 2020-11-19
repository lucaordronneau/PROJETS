package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.EventArgs;

/**
 * The GameExitRequestEventListener is an interface that must be implemented by objects that want
 * to be informed of a game exit.
 *
 * @author Mika INISAN
 */
public interface GameExitRequestEventListener extends EventListener {
    /**
     * Called when a request for game exit has been sent
     *
     * @param sender    the object that was responsible for the exit request
     * @param eventArgs empty information
     * @author Mika INISAN
     */
    void onGameExit(Object sender, EventArgs eventArgs);
}