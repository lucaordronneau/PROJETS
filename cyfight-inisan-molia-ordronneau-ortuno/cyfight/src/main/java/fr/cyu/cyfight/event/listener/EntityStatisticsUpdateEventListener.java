package fr.cyu.cyfight.event.listener;

import fr.cyu.cyfight.event.args.AttackerChangeEventArgs;
import fr.cyu.cyfight.event.args.EntityStatisticsUpdateEventArgs;

/**
 * TODO
 *
 * @author Mika INISAN
 */
public interface EntityStatisticsUpdateEventListener extends EventListener {
	/**
	 * TODO
	 *
	 * @author Mika INISAN
	 * @param sender TODO
	 * @param eventArgs TODO
	 */
	void onStatisticsUpdate(Object sender, EntityStatisticsUpdateEventArgs eventArgs);
}