package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;

/**
 * The SceneChangeRequestEventListener is an interface that must be implemented by objects that want to be informed
 * that the scene is changing.
 *
 * @author Mika INISAN
 */
public interface SceneChangeRequestEventListener extends EventListener {

	/**
	 * Called when the scene is about to change.
	 *
	 * @param sender    the object that requested a scene change
	 * @param eventArgs information about the scene change
	 * @author Mika INISAN
	 */
	void onSceneChangeRequest(Object sender, SceneChangeRequestEventArgs eventArgs);
}
