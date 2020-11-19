package fr.cyu.cyfight.util;

import java.util.Random;

/**
 * General utility methods.
 */
public class Utility {
    // ---
    // METHODS
    // ---

    /**
     * Allows you to generate an integer between two bounds
     *
     * @param lower lower value
     * @param upper upper value
     * @return a random number between lower and upper
     * @author ordronneau@eisti.eu
     */
    public static int getRandomIntInRange(int lower, int upper) {
        Random random = new Random();
        return lower + random.nextInt(upper - lower);
    }

    /**
     * Allows you to generate an integer between two bounds (min and max bounds included)
     *
     * @param lower lower value
     * @param upper upper value
     * @return a random number between lower and upper
     * @author ordronneau@eisti.eu
     */
    public static int getRandomIntInRangeInc(int lower, int upper) {
        Random random = new Random();
        return lower + random.nextInt(upper - lower + 1);
    }
}
