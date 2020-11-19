package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.LevelChangeEventArgs;

/**
 * The LevelChangeEventListener is an interface that must be implemented by objects that want
 * to be informed of a level change.
 *
 * @author Mika INISAN
 */
public interface LevelChangeEventListener extends EventListener {
	/**
	 * Called when a level has changed.
	 *
	 * @param sender    the object that was responsible for the level change
	 * @param eventArgs information about the level change
	 * @author Mika INISAN
	 */
	void onLevelChange(Object sender, LevelChangeEventArgs eventArgs);
}