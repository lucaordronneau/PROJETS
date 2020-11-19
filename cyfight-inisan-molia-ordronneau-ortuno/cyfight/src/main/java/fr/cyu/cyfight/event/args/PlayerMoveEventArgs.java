package fr.cyu.cyfight.event.args;

import fr.cyu.cyfight.game.entity.Player;

/**
 * The PlayerMoveEventArgs class carries information required when the player has moved.
 *
 * @author Mika INISAN
 * @see fr.cyu.cyfight.event.listener.PlayerMoveEventListener
 */
public class PlayerMoveEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

	/**
	 * The player
	 */
	private Player movingPlayer;

	/**
	 * Y coordinate of the player on the game grid
	 */
	private int playerNextY;

	/**
	 * X coordinate of the player on the game grid
	 */
	private int playerNextX;

	// ---
	// CONSTRUCTORS
	// ---

	/**
	 * Constructs a new information object that carries all information requested when the player in moving on the grid.
	 *
	 * @param movingPlayer The player
	 * @param playerNextY  Y coordinate of the player on the game grid
	 * @param playerNextX  X coordinate of the player on the game grid
	 * @author Mika INISAN
	 */
	public PlayerMoveEventArgs(Player movingPlayer, int playerNextY, int playerNextX) {
		this.movingPlayer = movingPlayer;
		this.playerNextY = playerNextY;
		this.playerNextX = playerNextX;
	}

	// ---
	// METHODS
	// ---

	/**
	 * Retrieves the player.
	 *
	 * @return The player
	 * @author Mika INISAN
	 */
	public Player getMovingPlayer() {
		return movingPlayer;
	}

	/**
	 * Retrieves the Y coordinate of the player on the game grid.
	 *
	 * @return the Y coordinate of the player on the game grid.
	 */
	public int getPlayerNextY() {
		return playerNextY;
	}

	/**
	 * Retrieves the X coordinate of the player on the game grid.
	 *
	 * @return the X coordinate of the player on the game grid.
	 * @author Mika INISAN
	 */
	public int getPlayerNextX() {
		return playerNextX;
	}
}