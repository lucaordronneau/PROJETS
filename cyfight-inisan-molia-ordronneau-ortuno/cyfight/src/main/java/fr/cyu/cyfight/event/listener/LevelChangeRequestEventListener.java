package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.LevelChangeRequestEventArgs;

/**
 * The LevelChangeRequestEventListener is an interface that must be implemented by objects that want to be informed
 * that a level is changing.
 *
 * @author Mika INISAN
 */
public interface LevelChangeRequestEventListener extends EventListener {
	/**
	 * Called when a level is changing.
	 *
	 * @author Mika INISAN
	 * @param sender the object that requested the level change
	 * @param eventArgs information about the level change
	 */
	void onLevelChangeRequest(Object sender, LevelChangeRequestEventArgs eventArgs);
}
