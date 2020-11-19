package fr.cyu.cyfight.config;

/**
 * Application configuration.
 *
 * @author Mika INISAN
 */
public class Configuration {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * Package root (used by JavaFX resources)
     */
    public static final String PACKAGE_ROOT = "/fr/cyu/cyfight/";

    // ---
    // Values are fixed for the display of the grid in JavaFX
    // ---

    /**
     * Number of rows in a game grid
     */
    public static final int GAME_GRID_ROW_COUNT = 9;

    /**
     * Number of columns in a game grid
     */
    public static final int GAME_GRID_COL_COUNT = 17;

    /**
     * X offset when displaying grid
     */
    public static final int GAME_GRID_X_OFFSET = 64;

    /**
     * Y offset when displaying grid
     */
    public static final int GAME_GRID_Y_OFFSET = 32;

    /**
     * X coordinate of grid on screen
     */
    public static final int GAME_GRID_X_START = 112;

    /**
     * Y coordinate of grid on screen
     */
    public static final int GAME_GRID_Y_START = 580;

    /**
     * Maximum number of items in player's bag
     */
    public static int PLAYER_BAG_SIZE = 5;
}