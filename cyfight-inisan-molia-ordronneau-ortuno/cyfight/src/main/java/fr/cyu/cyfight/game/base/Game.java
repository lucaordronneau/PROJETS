package fr.cyu.cyfight.game.base;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.event.args.*;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.*;
import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Entity;
import fr.cyu.cyfight.game.entity.LivingEntity;
import fr.cyu.cyfight.game.entity.Player;
import fr.cyu.cyfight.game.fight.Attack;
import fr.cyu.cyfight.javafx.builder.GameOverSceneBuilder;
import fr.cyu.cyfight.javafx.builder.GameSceneBuilder;
import javafx.scene.input.KeyCode;

import java.util.ArrayList;

/**
 * Game is the class that starts, ends and manages a game of Cyfight through
 * a game loop and game events. A Game object encapsulates main game
 * informations,to be specific, game localLevels.
 *
 * @author Mika INISAN
 */
public class Game implements LevelChangeRequestEventListener,
		FightStartEventListener {
	// ---
	// ATTRIBUTES
	// ---
	/**
	 * List of local levels
	 */
	private ArrayList<Grid> localLevels;

	/**
	 * List of local levels
	 */
	private int localLevelIndex;

	/**
	 * Current grid
	 */
	private Grid currentGrid;

	/**
	 * Total levels
	 */
	private int totalLevel;

	private boolean playerTurn;
	private int fightStepCount;

	// ---
	// CONSTRUCTORS
	// ---

	/**
	 * Constructs a game by initializing the first level, listening for events
	 * requiring a game state update, and starting the game loop. // TODO No more gameloop
	 *
	 * @author Mika INISAN
	 */
	public Game() {
		subscribeEvents();

		localLevels = new ArrayList<>();
		localLevelIndex = 1;
		totalLevel = 1;
		Grid grid = new Grid();
		localLevels.add(grid);
		switchLevel(grid);

		//gameLoop();
	}

	private void subscribeEvents() {
		// Subscribe the object to events of the event dispatcher, that require a game state update
		EventDispatcher.getInstance()
				.subscribe(LevelChangeRequestEventListener.class,this)
				.subscribe(FightStartEventListener.class, this);
	}

	public void unsubscribeEvents() {
		EventDispatcher.getInstance()
				.unsubscribe(LevelChangeRequestEventListener.class, this)
				.unsubscribe(FightStartEventListener.class, this);
	}
	// ---
	// METHODS
	// ---

	/**
	 * Manages a game by getting the player next action, processing it and
	 * updating the game information and state accordingly.
	 *
	 * @param keyCode code of the key
	 * @return true if the move was successful
	 * @author Mika INISAN
	 */
	public boolean play(KeyCode keyCode) {
		boolean moved = false;

		switch (keyCode) {
			case UP:
				moved = currentGrid.movePlayerUp();
				break;
			case RIGHT:
				moved = currentGrid.movePlayerRight();
				break;
			case DOWN:
				moved = currentGrid.movePlayerDown();
				break;
			case LEFT:
				moved = currentGrid.movePlayerLeft();
				break;
			default:
				break;
		}

		return moved;
	}

	private void switchLevel(Grid grid) {
		currentGrid = grid;

		EventDispatcher.getInstance().dispatchEvent(this,
														LevelChangeEventListener.class,
														new LevelChangeEventArgs(currentGrid, totalLevel));
	}

	@Override
	public void onLevelChangeRequest(Object sender, LevelChangeRequestEventArgs eventArgs) {
		Player player = (Player) eventArgs.getRequestingEntity();

		// Update player coordinates
		if(localLevelIndex != 1 || eventArgs.locationIsExit()) {
			player.setX(Math.abs(player.getX() - Configuration.GAME_GRID_COL_COUNT + 1));
		}

		if(eventArgs.locationIsExit()) { // Take the player to the next level
			totalLevel ++;

			if(localLevelIndex == localLevels.size()) { // Generate the next level
				Grid grid = new Grid(player);
				localLevels.add(grid);
				switchLevel(grid);
			} else {
				switchLevel(localLevels.get(localLevelIndex));
			}

			localLevelIndex ++;
		} else { // Take the player to the previous level
			if(localLevelIndex != 1) {
				totalLevel --;

				switchLevel(localLevels.get(localLevelIndex - 2));

				localLevelIndex --;
			}
		}
	}

	public Grid getGrid() {
		return currentGrid;
	}

	@Override
	public void onFightStart(Object sender, FightStartEventArgs eventArgs) {
		fightStepCount = 0;
		fight(eventArgs.getPlayerFighting(), eventArgs.getEnemyFighting());
	}

	private void fight(Player player, Enemy opponent) {
		if(player.stillAlive() && opponent.stillAlive()) {
			if(fightStepCount == 0 || fightStepCount == 2) {
				fightStepCount = 1;

				playerTurn = player.getSpd() >= opponent.getSpd();

				if(playerTurn) {
					playerTurn = false;
					EventDispatcher.getInstance().dispatchEvent(this, AttackerChangeEventListener.class, new AttackerChangeEventArgs(player, opponent));
					EventDispatcher.getInstance().dispatchEvent(this, EntityStatisticsUpdateEventListener.class, new EntityStatisticsUpdateEventArgs(player, opponent));
				} else {
					playerTurn = true;
					EventDispatcher.getInstance().dispatchEvent(this, AttackerChangeEventListener.class, new AttackerChangeEventArgs(opponent, player));

					attack(opponent, player);

					EventDispatcher.getInstance().dispatchEvent(this, EntityStatisticsUpdateEventListener.class, new EntityStatisticsUpdateEventArgs(player, opponent));

					fight(player, opponent);
				}
			} else {
				fightStepCount = 2;

				if(playerTurn) {
					playerTurn = false;
					EventDispatcher.getInstance().dispatchEvent(this, AttackerChangeEventListener.class, new AttackerChangeEventArgs(player, opponent));
					EventDispatcher.getInstance().dispatchEvent(this, EntityStatisticsUpdateEventListener.class, new EntityStatisticsUpdateEventArgs(player, opponent));
				} else {
					playerTurn = true;
					EventDispatcher.getInstance().dispatchEvent(this, AttackerChangeEventListener.class, new AttackerChangeEventArgs(opponent, player));

					attack(opponent, player);
					EventDispatcher.getInstance().dispatchEvent(this, EntityStatisticsUpdateEventListener.class, new EntityStatisticsUpdateEventArgs(player, opponent));
					fight(player, opponent);
				}
			}
		} else {
			if(player.stillAlive()) {
				EventDispatcher.getInstance().dispatchEvent(this, FightEndEventListener.class, new FightEndEventArgs(player.getY(), player.getX(), opponent));
			} else {
				try {
					unsubscribeEvents();

					EventDispatcher.getInstance().dispatchEvent(this,
							SceneChangeRequestEventListener.class,
							new SceneChangeRequestEventArgs(GameOverSceneBuilder.class));
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		}
	}

	public void attack(Entity attacker, Entity defender) {
		LivingEntity livingAttacker = (LivingEntity) attacker;
		LivingEntity livingDefender = (LivingEntity) defender;

		if(attacker instanceof Player) {
			System.out.println("----- PLAYER ATTACKS ENEMY -----");
			System.out.println("[Statistics before the attack]");
			System.out.println("Player : HPMAX -> " + livingAttacker.getHpMax() + " HP -> " + livingAttacker.getHp() + " SPEED -> " + livingAttacker.getSpd() + " FORCE -> " + livingAttacker.getStr());
			System.out.println("Enemy : HPMAX -> " + livingDefender.getHpMax() + " HP -> " + livingDefender.getHp() + " SPEED -> " + livingDefender.getSpd() + " FORCE -> " + livingDefender.getStr());

			((Player) attacker).attack(new Attack(1), (Enemy) defender);

			System.out.println("[Statistics after the attack]");
			System.out.println("Player : HPMAX -> " + livingAttacker.getHpMax() + " HP -> " + livingAttacker.getHp() + " SPEED -> " + livingAttacker.getSpd() + " FORCE -> " + livingAttacker.getStr());
			System.out.println("Enemy : HPMAX -> " + livingDefender.getHpMax() + " HP -> " + livingDefender.getHp() + " SPEED -> " + livingDefender.getSpd() + " FORCE -> " + livingDefender.getStr());
			System.out.println("----- END PLAYER ATTACKS ENEMY -----");
		} else if(attacker instanceof Enemy) {
			System.out.println("----- ENEMY ATTACKS PLAYER -----");
			System.out.println("[Statistics before the attack]");
			System.out.println("Enemy : HPMAX -> " + livingAttacker.getHpMax() + " HP -> " + livingAttacker.getHp() + " SPEED -> " + livingAttacker.getSpd() + " FORCE -> " + livingAttacker.getStr());
			System.out.println("Player : HPMAX -> " + livingDefender.getHpMax() + " HP -> " + livingDefender.getHp() + " SPEED -> " + livingDefender.getSpd() + " FORCE -> " + livingDefender.getStr());

			((Enemy) attacker).attack(new Attack(1), (Player) defender);

			System.out.println("[Statistics after the attack]");
			System.out.println("Enemy : HPMAX -> " + livingAttacker.getHpMax() + " HP -> " + livingAttacker.getHp() + " SPEED -> " + livingAttacker.getSpd() + " FORCE -> " + livingAttacker.getStr());
			System.out.println("Player : HPMAX -> " + livingDefender.getHpMax() + " HP -> " + livingDefender.getHp() + " SPEED -> " + livingDefender.getSpd() + " FORCE -> " + livingDefender.getStr());
			System.out.println("----- END ENEMY ATTACKS PLAYER -----");
		}
	}

	public void useItem(Entity attacker, Entity defender) {
		Player player = (Player) attacker;
		Enemy enemy = (Enemy) defender;

		System.out.println("----- PLAYER USES AN ITEM -----");
		System.out.println("[Statistics before use]");
		System.out.println("Player : HPMAX -> " + player.getHpMax() + " HP -> " + player.getHp() + " SPEED -> " + player.getSpd() + " FORCE -> " + player.getStr());
		System.out.println("Enemy : HPMAX -> " + enemy.getHpMax() + " HP -> " + enemy.getHp() + " SPEED -> " + enemy.getSpd() + " FORCE -> " + enemy.getStr());

		player.useItem();

		System.out.println("[Statistics after use]");
		System.out.println("Player : HPMAX -> " + player.getHpMax() + " HP -> " + player.getHp() + " SPEED -> " + player.getSpd() + " FORCE -> " + player.getStr());
		System.out.println("Enemy : HPMAX -> " + enemy.getHpMax() + " HP -> " + enemy.getHp() + " SPEED -> " + enemy.getSpd() + " FORCE -> " + enemy.getStr());
		System.out.println("----- END PLAYER USES AN ITEM -----");

		fight((Player) attacker, (Enemy) defender);
	}

	public void combat(Player player, Enemy opponent) {
		attack(player, opponent);
		EventDispatcher.getInstance().dispatchEvent(this, EntityStatisticsUpdateEventListener.class, new EntityStatisticsUpdateEventArgs(player, opponent));
		fight(player, opponent);
	}
}
