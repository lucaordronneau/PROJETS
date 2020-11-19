package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.FightStartEventArgs;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public interface FightStartEventListener extends EventListener {
	/**
	 * TODO
	 *
	 * @author Mika INISAN
	 * @param sender TODO
	 * @param eventArgs TODO
	 */
	void onFightStart(Object sender, FightStartEventArgs eventArgs);
}