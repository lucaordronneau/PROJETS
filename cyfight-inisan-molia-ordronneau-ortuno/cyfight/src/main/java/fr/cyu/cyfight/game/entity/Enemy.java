package fr.cyu.cyfight.game.entity;

import fr.cyu.cyfight.event.args.FightStartEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.FightStartEventListener;

/**
 * Enemy class.
 *
 * @author Mika INISAN
 */
public class Enemy extends LivingEntity {
	// ---
	// CONSTRUCTORS
	// ---

	public Enemy() {
		super(null);
	}

	// ---
	// METHODS
	// ---

	@Override
	public boolean interact(Entity interactingEntity) { // TODO Could be void?
		EventDispatcher.getInstance().dispatchEvent(this, FightStartEventListener.class, new FightStartEventArgs((Player) interactingEntity, this));

		return true;
	}

}