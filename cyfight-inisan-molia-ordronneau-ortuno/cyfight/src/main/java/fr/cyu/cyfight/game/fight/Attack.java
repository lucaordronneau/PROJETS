package fr.cyu.cyfight.game.fight;

/**
 * Attacks models an attack from a character
 *
 * @author Arthur Molia moliaarthu@eisti.eu
 */
public class Attack {
    private String name;
    // damageRatio x Charater's strength -> damage of the attack
    private int damageRatio;

    ///////////////////
    //               //
    //  Constructor  //
    //               //
    ///////////////////

    /**
     * preconditions - type exists in Type, damageRatio {@literal >=0}
     * postconditions - Initialize an attack
     *
     * @param damageRatio - damageRatio x Charater's strength {@literal ->} damage of the attack
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public Attack(/*String name, */ int damageRatio) { // TODO Implement display or remove (could be cool for animation)
        /*this.name = name;*/
        this.damageRatio = damageRatio;
    }

    ///////////////////////
    //                   //
    //  Getters/Setters  //
    //                   //
    ///////////////////////

    /**
     * postconditions - get the attack's name
     *
     * @return the attack's name
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public String getName() {
        return this.name;
    }

    /**
     * postconditions - get the attack's damageRatio
     *
     * @return Damage
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public int getDamage() {
        return this.damageRatio;
    }
}
