package fr.cyu.cyfight.game.entity;

import fr.cyu.cyfight.game.fight.Attack;
import fr.cyu.cyfight.util.Utility;

public class LivingEntity implements Entity {
    // Character's stats
    private int hpMax; // maximum hp stat
    private int hp;    // current hp
    private int str;   // strength stat
    private int spd;   // speed stat
    // Character's type
    private LivingEntityType type;

    ////////////////////
    //                //
    //  Constructors  //
    //                //
    ////////////////////

    public LivingEntity(LivingEntityType livingEntityType) {
        if(livingEntityType == null) {
            type = randomType();
        } else {
            type = livingEntityType;
        }

        hpMax = 10;
        str = 10;
        spd = 10;
        hp = hpMax;

        switch (type) {
            case FAST:
                spd = 12;
                break;
            case SMART:
                hpMax = 12;
                break;
            case STRONG:
                str = 12;
                break;
            default:
                break;
        }
    }

    ///////////////////////
    //                   //
    //  Getters/Setters  //
    //                   //
    ///////////////////////

    /**
     * postconditions - get the character's max hp
     *
     * @return max health point
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public int getHpMax() {
        return this.hpMax;
    }

    public int getHp() {
        return this.hp;
    }

    public int getStr() {
        return this.str;
    }

    public int getSpd() {
        return this.spd;
    }

    public LivingEntityType getType() {
        return this.type;
    }

    public void setHpMax(int hpMax) {
        this.hpMax = hpMax;
    }

    /**
     * postconditions - set the character's strength,  if str {@literal <=} 0 it won't be changed
     *
     * @param hp health point
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public void setHp(int hp) {
        if (hp > this.hpMax) {
            this.hp = this.hpMax;
        } else {
            this.hp = hp;
        }
    }

    /**
     * Set strength
     *
     * @param str strength value
     */
    public void setStr(int str) {
        if (str > 0) {
            this.str = str;
        }
    }

    /**
     * Set speed
     *
     * @param spd speed
     */
    public void setSpd(int spd) {
        this.spd = spd;
    }


    /**
     * postconditions - set the character's type, if the type doesn't exist it won't be changed
     *
     * @param type type of the entity
     * @author Arthur Molia
     */
    public void setType(String type) {
        switch (type) {
            case "FAST":
                this.type = LivingEntityType.FAST;
                break;
            case "SMART":
                this.type = LivingEntityType.SMART;
                break;
            case "STRONG":
                this.type = LivingEntityType.STRONG;
                break;
            // If the type doesn't exist, we don't change it
        }
    }

    /**
     * Set the character's type
     *
     * @param type type of the character (entity)
     */
    public void setType(LivingEntityType type) {
        this.type = type;
    }

    ///////////////////////
    //                   //
    //       Fight       //
    //                   //
    ///////////////////////

    // Calculate the bonus/malus when the character attacks depending
    //  the type of the character and of the defender
    public double typeBonus(LivingEntityType tDef) {
        // If they have the same type, no bonus/malus
        if (this.type == tDef) {
            return 1;
        }
        // If the character's type is strong against the defender's one :
        // the attack will be 2 times more effective
        else if (((this.type == LivingEntityType.FAST) && (tDef == LivingEntityType.SMART)) ||
                ((this.type == LivingEntityType.SMART) && (tDef == LivingEntityType.STRONG)) ||
                ((this.type == LivingEntityType.STRONG) && (tDef == LivingEntityType.FAST))) {
            return 2;
        }
        // else, the attack will be 2 times less effective
        else {
            return 0.5;
        }
    }

    /**
     * postconditions - Calculate the damages from an attack
     *
     * @param attack - the attack from the character
     * @param def    - the character that is receiving the attack
     * @return damage value
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    private int damage(Attack attack, LivingEntity def) {
        // Damages = attack's damageRatio * Character's strength * Type bonus
        return (int)(this.typeBonus(def.type) * attack.getDamage() * (Math.abs(this.str-def.str)+1));
    }

    /**
     * postconditions - Substract the defender's hp depending the attack's damages
     *
     * @param attack - the attack from the character
     * @param def    - the character that is receiving the attack
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public void attack(Attack attack, LivingEntity def) {
        def.hp -= damage(attack, def);

        ///EventDispatcher.getInstance().dispatchEvent();
    }

    // Use an item
//	public void useItem(Item item, Character target) {
//
//	}

    /**
     * postconditions - Check if the character is still alive
     *
     * @return true if the character is still alive
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    public boolean stillAlive() {
        return (this.hp > 0);
    }

    ///////////////////////
    //                   //
    //  Other functions  //
    //                   //
    ///////////////////////

    /**
     * postconditions - Pick a type randomly
     *
     * @return type of entity
     * @author Arthur Molia moliaarthu@eisti.eu
     */
    private LivingEntityType randomType() {
        // Initialize res as FAST (avoid a warning)
        LivingEntityType res = LivingEntityType.FAST;

        int rand = Utility.getRandomIntInRangeInc(1, 3);
        switch (rand) {
            case 1:
                res = LivingEntityType.FAST;
                break;
            case 2:
                res = LivingEntityType.SMART;
                break;
            case 3:
                res = LivingEntityType.STRONG;
                break;
        }
        return res;
    }

    @Override
    public boolean interact(Entity interactingEntity) {
        return false;
    }
}
