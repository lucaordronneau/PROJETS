package fr.cyu.cyfight.javafx.util;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.LivingEntity;
import fr.cyu.cyfight.game.entity.LivingEntityType;
import fr.cyu.cyfight.game.entity.Player;

/**
 * Utility methods for JavaFX.
 *
 * @author Mika INISAN
 */
public class Utility {

    /**
     * Get an item image path from the item id.
     *
     * @param id the item id
     * @return the item's image path
     * @author Mika INISAN
     */
    public static String getItemImagePath(int id) {
        String path = "image/entity/item/";

        if (id == 1 || id == 5) {
            path += "blue-max-heal-bonus-light";
        } else if (id == 2 || id == 6) {
            path += "blue-heal-bonus-light";
        } else if (id == 3 || id == 7) {
            path += "blue-strength-bonus-light";
        } else if (id == 4 || id == 8) {
            path += "blue-speed-bonus-light";
        }

        return path;
    }

    /**
     * Get entity image path.
     *
     * @param entity player or enemy
     * @param side   side (front, back, right-profile, left-profile)
     * @param state  number from 0 to 2 corresponding to the entity state (idle, walk1 or walk2)
     * @return absolute image path
     * @author Mika INISAN
     */
    public static String getEntityFullImagePath(LivingEntity entity, String side, int state) {
        return Configuration.PACKAGE_ROOT + getEntityImagePath(entity, side, state);
    }

    /**
     * Get entity image path.
     *
     * @param entity player or enemy
     * @param side   side (front, back, right-profile, left-profile)
     * @param state  number from 0 to 2 corresponding to the entity state (idle, walk1 or walk2)
     * @return image path (relative to the resource package)
     * @author Mika INISAN
     */
    public static String getEntityImagePath(LivingEntity entity, String side, int state) {
        String path = "image/entity/livingentity/";

        LivingEntityType livingEntityType = entity.getType();

        if (entity instanceof Player) {
            path += "blue";
        } else if (entity instanceof Enemy) {
            path += "red";
        }

        path += "-character" + livingEntityType.getValue();
        path += "-" + side;

        switch (state) {
            case 0:
                break;
            case 1:
                path += "-walk" + state;
                break;
            case 2:
                path += "-walk" + state;
                break;
            default:
                break;
        }

        path += ".png";

        return path;
    }
}
