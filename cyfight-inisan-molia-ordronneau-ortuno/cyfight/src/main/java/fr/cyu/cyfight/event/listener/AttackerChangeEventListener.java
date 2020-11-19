package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.AttackerChangeEventArgs;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public interface AttackerChangeEventListener extends EventListener {
	/**
	 * TODO
	 *
	 * @author Mika INISAN
	 * @param sender TODO
	 * @param eventArgs TODO
	 */
	void onAttackerChange(Object sender, AttackerChangeEventArgs eventArgs);
}