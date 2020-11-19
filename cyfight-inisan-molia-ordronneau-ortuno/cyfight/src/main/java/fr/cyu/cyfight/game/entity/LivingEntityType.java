package fr.cyu.cyfight.game.entity;

/**
 * LivingEntityType models all the types from the game
 *
 * @author Arthur Molia moliaarthu@eisti.eu
 */
public enum LivingEntityType {
    STRONG(1),
    SMART(2),
    FAST(3);

    private int value;

    private LivingEntityType(int value) {
        this.value = value;
    }

    public int getValue() {
        return value;
    }
}
