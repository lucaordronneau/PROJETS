package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.FightEndEventArgs;
import fr.cyu.cyfight.event.args.FightStartEventArgs;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public interface FightEndEventListener extends EventListener {
	/**
	 * TODO
	 *
	 * @author Mika INISAN
	 * @param sender TODO
	 * @param eventArgs TODO
	 */
	void onFightEnd(Object sender, FightEndEventArgs eventArgs);
}