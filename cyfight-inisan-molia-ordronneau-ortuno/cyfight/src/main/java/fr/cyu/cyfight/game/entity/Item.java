package fr.cyu.cyfight.game.entity;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.event.args.ItemPickedUpEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.ItemPickedUpEventListener;
import fr.cyu.cyfight.javafx.util.Utility;

/**
 * Base item
 *
 * @author Mika INISAN
 */
public class Item implements Entity {
    // ---
    // ATTRIBUTES
    // ---

    // item's id
    // 1 for hpMax, 2 for hp, 3 for strength, 4 for speed in %
    // 5 for hpMax, 6 for hp, 7 for strength, 8 for speed in fixed
    // positive for bonus and negative for malus
    private int id;
    // effect (percentage or fixed integer)
    private int effect;

    ///////////////////
    //               //
    //  Constructor  //
    //               //
    ///////////////////

    /**
     * postconditions - Initialize an item, if the id is {@literal >} 8 or {@literal <} -8, it will be randomly picked between all the items' id
     *
     * @param id     - item's id
     * @param effect - item's effect value
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public Item(int id, int effect) {
        if ((id <= 8) && (id >= -8)) {
            this.id = id;
        } else {
            this.id = fr.cyu.cyfight.util.Utility.getRandomIntInRangeInc(1, 8);
        }
        this.effect = effect;
    }

    // ---
    // METHODS
    // ---

    @Override
    public boolean interact(Entity interactingEntity) {
        Player player = (Player) interactingEntity;

		if(player.getBag().size() < Configuration.PLAYER_BAG_SIZE - 1) {
			player.addItem(this);

            EventDispatcher.getInstance().dispatchEvent(this,
                    ItemPickedUpEventListener.class,
                    new ItemPickedUpEventArgs(interactingEntity, this, ((Player) interactingEntity).getY(), ((Player) interactingEntity).getX()));

            return true;
        }

        return false;
    }

    public int getId() {
        return id;
    }
}
