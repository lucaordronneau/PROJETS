package fr.cyu.cyfight.game.base;

import fr.cyu.cyfight.game.entity.LivingEntityType;

/**
 * The GameConfiguration class stores global information during the game
 * (mainly the player character class).
 *
 * @author Mika INISAN
 */
public class GameConfiguration {

    // ---
    // ATTRIBUTES
    // ---

    /**
     * Game configuration instance
     */
    private static final GameConfiguration INSTANCE = new GameConfiguration();

    /**
     * The player class
     */
    private static LivingEntityType playerClass = LivingEntityType.STRONG;

    // ---
    // METHODS
    // ---

    /**
     * Private constructor to build a singleton
     */
    private GameConfiguration() {
    }

    /**
     * Retrieve the game configuration instance
     *
     * @return the global game configuration
     * @author Mika INISAN
     */
    public static GameConfiguration getInstance() {
        return INSTANCE;
    }

    /**
     * Retrieve player's class
     *
     * @return the player's class
     * @author Mika INISAN
     */
    public LivingEntityType getPlayerClass() {
        return playerClass;
    }

    /**
     * Define player's class
     *
     * @param charClass the character class (also called entity type in the game)
     * @author Mika INISAN
     */
    public void setPlayerClass(LivingEntityType charClass) {
        playerClass = charClass;
    }

}
