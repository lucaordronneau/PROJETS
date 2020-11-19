package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.PlayerMoveEventArgs;

/**
 * The PlayerMoveEventListener is an interface that must be implemented by objects that want to be informed
 * that the player is moving.
 *
 * @author Mika INISAN
 */
public interface PlayerMoveEventListener extends EventListener {
	/**
	 * Called when the player moves on the grid.
	 *
	 * @author Mika INISAN
	 * @param sender the object that emitted the event
	 * @param eventArgs information about the player move
	 */
	void onPlayerMove(Object sender, PlayerMoveEventArgs eventArgs);
}
