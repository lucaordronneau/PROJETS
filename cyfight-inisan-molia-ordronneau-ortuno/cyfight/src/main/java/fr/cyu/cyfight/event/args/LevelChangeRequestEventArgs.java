package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Entity;

/**
 * The LevelChangeRequestEventArgs class carries all information required when a game level is about to change.
 *
 * @author Mika INISAN
 * @see fr.cyu.cyfight.event.listener.LevelChangeRequestEventListener
 */
public class LevelChangeRequestEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

	/**
	 * The entity requesting a level change
	 */
	private Entity requestingEntity;

	/**
	 * Is the requesting entity located on an exit?
	 */
	private boolean entityLocationIsExit;

	// ---
	// CONSTRUCTORS
	// ----

	/**
	 * Constructs a new information object. This object carries all information required by the "level change request event".
	 *
	 * @param requestingEntity     the entity requesting a level change
	 * @param entityLocationIsExit is the requesting entity located on an exit?
	 * @author Mika INISAN
	 * @see fr.cyu.cyfight.event.listener.LevelChangeRequestEventListener
	 */
	public LevelChangeRequestEventArgs(Entity requestingEntity, boolean entityLocationIsExit) {
		this.requestingEntity = requestingEntity;
		this.entityLocationIsExit = entityLocationIsExit;
	}

	/**
	 * The entity requesting a level change.
	 *
	 * @return The entity that requested the level change
	 * @author Mika INISAN
	 */
	public Entity getRequestingEntity() {
		return requestingEntity;
	}

	/**
	 * Is the requesting entity located on an exit?
	 *
	 * @return true if the requesting entity is located on an exit, false otherwise
	 * @author Mika INISAN
	 */
	public boolean locationIsExit() {
		return entityLocationIsExit;
	}
}