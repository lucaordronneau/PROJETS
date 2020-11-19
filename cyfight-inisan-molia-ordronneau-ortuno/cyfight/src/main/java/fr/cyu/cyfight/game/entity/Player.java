package fr.cyu.cyfight.game.entity;

import fr.cyu.cyfight.game.base.MoveDirection;

import java.util.ArrayList;

/**
 * Player
 *
 * @author Mika INISAN
 */
public class Player extends LivingEntity {
	// ---
	// ATTRIBUTES
	// ---

	/**
	 * y coordinate
	 */
	private int y;

	/**
	 * x coordinate
	 */
	private int x;

	/**
	 * Player's bag for storing items
	 */
	private ArrayList<Item> bag;

	/**
	 * Item in player's hand
	 */
	private Item itemInHand;

	/**
	 * Orientation of the player
	 */
	private MoveDirection orientation;
	
	// ---
	// CONSTRUCTORS
	// ---

	/**
	 * Constructs a new player
	 *
	 * @param y          y coordinate
	 * @param x          x coordinate
	 * @param entityType character type
	 * @author Mika INISAN
	 */
	public Player(int y, int x, LivingEntityType entityType) {
		super(entityType);
		this.y = y;
		this.x = x;
		bag = new ArrayList<>();
		this.orientation = MoveDirection.Right;
	}
	
	// ---
	// METHODS
	// ---

	/**
	 * Interact with the player.
	 *
	 * @param interactingEntity entity to interact with
	 * @return true if interaction was successful
	 */
	@Override
	public boolean interact(Entity interactingEntity) {
		return true; // TODO Implement the method?
	}

	/**
	 * Get y coordinate
	 *
	 * @return y coordinate
	 * @author Mika INISAN
	 */
	public int getY() {
		return y;
	}

	/**
	 * Get x coordinate
	 *
	 * @return x coordinate
	 * @author Mika INISAN
	 */
	public int getX() {
		return x;
	}

	public ArrayList<Item> getBag() {
		return bag;
	}

	/**
	 * Define y coordinate
	 *
	 * @param y y coordinate
	 * @author Mika INISAN
	 */
	public void setY(int y) {
		this.y = y;
	}

	/**
	 * Define x coordinate
	 *
	 * @param x x coordinate
	 * @author Mika INISAN
	 */
	public void setX(int x) {
		this.x = x;
	}

	/**
	 * Add item to player's bag
	 *
	 * @param item the item
	 * @author Mika INISAN
	 */
	public void addItem(Item item) {
		if(itemInHand != null) {
			bag.add(item);
		} else {
			this.itemInHand = item;
		}
	}

	public void useItem() {
		switch(itemInHand.getId()) {
			case 1:
				setHpMax(getHpMax() + 1);
				break;
			case 2:
				setHp(getHp() + 4);
				break;
			case 3:
				setStr(getStr() + 1);
				break;
			case 4:
				setSpd(getSpd() + 1);
				break;
			case 5:
				setHpMax(getHpMax() + 10 / 100 * getHpMax());
				break;
			case 6:
				setHp(getHp() + 10 / 100 * getHpMax());
				break;
			case 7:
				setStr(getStr() + 10 / 100 * getStr());
				break;
			case 8:
				setSpd(getSpd() + 10 / 100 * getSpd());
				break;
			default:
				break;
		}

		if(!bag.isEmpty()) {
			itemInHand = bag.get(0);
		}

		bag.remove(itemInHand);
	}

	/**
	 * Get item in player's hand
	 *
	 * @return the item (or null if none)
	 * @author Mika INISAN
	 */
	public Item getItemInHand() {
		return itemInHand;
	}

	/**
	 * Get player's orientation
	 *
	 * @return player's orientation
	 * @author Mika INISAN
	 */
	public MoveDirection getOrientation() {
		return orientation;
	}

	/**
	 * Define player's orientation
	 *
	 * @param orientation playe's orientation
	 * @author Mika INISAN
	 */
	public void setOrientation(MoveDirection orientation) {
		this.orientation = orientation;
	}

}
