package fr.cyu.cyfight.game.base;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.event.args.PlayerMoveEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.PlayerMoveEventListener;
import fr.cyu.cyfight.game.cell.BaseCell;
import fr.cyu.cyfight.game.cell.Cell;
import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Entity;
import fr.cyu.cyfight.game.entity.Item;
import fr.cyu.cyfight.game.entity.Player;
import fr.cyu.cyfight.util.Utility;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;
import java.util.Stack;

/**
 * Game grid
 *
 * @author Mika INISAN
 */
public class Grid {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * Grid
     */
    private Cell[][] grid;

    /**
     * Stack of cells
     */
    private Stack<BaseCell> stack = new Stack<>();

    /**
     * Start cell
     */
    BaseCell start;

    /**
     * End cell
     */
    BaseCell end;

    private Player player;

    // ---
    // CONSTRUCTORS
    // ---

    /**
     * Constructs a new grid
     *
     * @param player the player
     * @author Mika INISAN
     */
    public Grid(Player player) {
        grid = new Cell[Configuration.GAME_GRID_ROW_COUNT][Configuration.GAME_GRID_COL_COUNT];
        this.player = player;

        gridInitializationWithWall();
        gridGeneration();
        grid[start.x][start.y] = new BaseCell(start.x, start.y, false, false, true, false);
        grid[start.x][start.y].getEntities().add(player);
        grid[end.x][end.y] = new BaseCell(end.x, end.y, false, true, false, false);

        int[] startPos = {start.x, start.y};
        int[] endPos = {end.x, end.y};
        LinkedList<Case> path = ShortestPath.getPath(ShortestPath.createMatrix(grid), startPos, endPos);

        addEnemyAndItem();
    }

    /**
     * Constructs a new grid.
     *
     * @author Mika INISAN
     */
    public Grid() {
        this(0, 0);
    }

    /**
     * Constructs a new grid.
     *
     * @param playerY y coordinate of the player
     * @param playerX x coordinate of the player
     * @author Mika INISAN
     */
    public Grid(int playerY, int playerX) {
        this(new Player(playerY, playerX, GameConfiguration.getInstance().getPlayerClass()));
    }

    // ---
    // METHODS
    // ---

    public void addEnemyAndItem() {
        List<Cell> resultList = new ArrayList<Cell>();

        System.out.println("----- MAP GENERATION -----");
        System.out.println("EXIT (" + end.x + ", " + end.y + ")");
        System.out.println("ENTRY (" + start.x + ", " + start.y + ")");
        System.out.println("----- END MAP GENERATION -----");

        for (int i = 0; i < Configuration.GAME_GRID_ROW_COUNT; i++) {
            for (int j = 0; j < Configuration.GAME_GRID_COL_COUNT; j++) {
                if (grid[i][j].isBlocking() == false &&
                        (i != end.x && j != end.y) &&
                        (i != start.x && j != start.y)) {
                    resultList.add(grid[i][j]);
                }
            }
        }

        int enemyNumber = Utility.getRandomIntInRangeInc(1, 3);
        int itemNumber = Utility.getRandomIntInRangeInc(2, 5);

        for(int i = 0; i < enemyNumber; i ++) {
            int randomPosition = Utility.getRandomIntInRangeInc(2, resultList.size() - 1);
            resultList.get(randomPosition).getEntities().add(new Enemy());
            resultList.remove(randomPosition);
        }

        for(int i = 0; i < itemNumber; i ++) {
            int randomPosition = Utility.getRandomIntInRangeInc(2, resultList.size() - 1);
            resultList.get(randomPosition).getEntities().add(new Item(9, 1));
            resultList.remove(randomPosition);
        }
    }


    /**
     * gridInitializationWithWall, initialize the grid with only walls
     *
     * @author ordronneau@eisti.eu
     */
    private void gridInitializationWithWall() {
        for (int i = 0; i < Configuration.GAME_GRID_ROW_COUNT; i++) {
            for (int j = 0; j < Configuration.GAME_GRID_COL_COUNT; j++) {
                Cell cell = new BaseCell(i, j, true);
                grid[i][j] = cell;
            }
        }
    }

    /**
     * gridGeneration, Allows you to generate a random grid that is still valid with the method : Recursive backtracker
     * Link that help me : https://en.wikipedia.org/wiki/Maze_generation_algorithm | https://www.youtube.com/watch?v=_p5IH0L63wo
     *
     * @author ordronneau@eisti.eu
     */
    public void gridGeneration() {
        int row = player.getY();
//	    	Choose the initial cell, mark it free and push it to the stack
        start = new BaseCell(row, 0, false);
        stack.push(start);

        while (!stack.empty()) {
//	        	The current cell
            BaseCell current = stack.pop();
//	            If the current cell has any neighbors which have not been visited
            if (cellValidation(current)) {
                grid[current.x][current.y].setBlocking(false);
                ArrayList<Cell> neighbors = checkNeighbors(current);
//	                Choose a random cell that we push to the stack
                randomCellToStack(neighbors);
            }
        }

        end = (BaseCell) selectEndCell();
    }

    /**
     * selectEndCell, select a cell in the last column
     *
     * @return Cell, the end cell
     * @author ordronneau@eisti.eu
     */
    public Cell selectEndCell() {
        ArrayList<Cell> endList = new ArrayList<>();
        for (int i = 0; i < Configuration.GAME_GRID_ROW_COUNT; i++) {
//	    		If the cell is not a wall
            if (grid[i][Configuration.GAME_GRID_COL_COUNT - 1].isBlocking() == false) {
                endList.add(grid[i][Configuration.GAME_GRID_COL_COUNT - 1]);
            }
        }

        if (endList.size() > 0) {
            int index = Utility.getRandomIntInRange(0, endList.size());
            end = (BaseCell) endList.get(index);
        }
        return end;
    }

    /**
     * boundsVerification, check if the cell is in the grid
     *
     * @param x x coordinate
     * @param y y coordinate
     * @return Boolean, true if the cell is in the grid
     * @author ordronneau@eisti.eu
     */
    private boolean boundsVerification(int x, int y) {
        return (x >= 0 && x < Configuration.GAME_GRID_ROW_COUNT && y >= 0 && y < Configuration.GAME_GRID_COL_COUNT);
    }

    /**
     * cellValidation, verify if the next cell is valid
     *
     * @param cell the cell to check
     * @return Boolean, of the next cell are valid or not
     * @author ordronneau@eisti.eu
     */
    private boolean cellValidation(BaseCell cell) {
        int numberNeighbors = 0;
        int row = cell.x;
        int col = cell.y;
//	        Visit all neighbors
        for (int i = row - 1; i <= row + 1; i++) {
            for (int j = col - 1; j <= col + 1; j++) {
//	            	Check if the cell around is valid and if it's not a wall
                if (boundsVerification(i, j) && (i != row || j != col) && (grid[i][j].isBlocking() == false)) {
//	                	Number of neighbor free
                    numberNeighbors++;
                }
            }
        }
//	        if it's a wall and the number of neighbor free is < 3, cell become free
        return (grid[row][col].isBlocking() != false) && (numberNeighbors < 3);
    }

    /**
     * randomCellToStack, randomly add the neighbors of the cell to the stack
     *
     * @param neighbors neighbor cells
     * @author ordronneau@eisti.eu
     */
    private void randomCellToStack(ArrayList<Cell> neighbors) {
        int index;
        while (!neighbors.isEmpty()) {
            index = Utility.getRandomIntInRange(0, neighbors.size());
            stack.push((BaseCell) neighbors.get(index));
            neighbors.remove(index);
        }
    }

    /**
     * checkNeighbors, add all neighbors of a cell in a Arraylist
     *
     * @param cell the cell to check
     * @return Arraylist of neighbors
     * @author ordronneau@eisti.eu
     */
    private ArrayList<Cell> checkNeighbors(BaseCell cell) {
        ArrayList<Cell> neighbors = new ArrayList<>();

        int row = cell.x;
        int col = cell.y;
        for (int i = row - 1; i < row + 2; i++) {
            if (i >= 0 && i < Configuration.GAME_GRID_ROW_COUNT && i != row) {
                neighbors.add(new BaseCell(i, col, true));
            }
        }
        for (int j = col - 1; j < col + 2; j++) {
            if (j >= 0 && j < Configuration.GAME_GRID_COL_COUNT && j != col) {
                neighbors.add(new BaseCell(row, j, true));
            }
        }
        return neighbors;
    }

    /**
     * Move player to the right.
     *
     * @return true if move was successful
     * @author Mika INISAN
     */
    public boolean movePlayerRight() {
        return move(player.getY(), player.getX() + 1, MoveDirection.Right);
    }

    /**
     * Move player to the left.
     *
     * @return true if move was successful
     * @author Mika INISAN
     */
    public boolean movePlayerLeft() {
        return move(player.getY(), player.getX() - 1, MoveDirection.Left);
    }

    /**
     * Move player up.
     *
     * @return true if move was successful
     * @author Mika INISAN
     */
    public boolean movePlayerUp() {
        return move(player.getY() - 1, player.getX(), MoveDirection.Up);
    }

    /**
     * Move player down.
     *
     * @return true if move was successful
     * @author Mika INISAN
     */
    public boolean movePlayerDown() {
        return move(player.getY() + 1, player.getX(), MoveDirection.Down);
    }

    /**
     * Generic method to move player.
     *
     * @param playerNextY target y coordinate
     * @param playerNextX target x coordinate
     * @param direction   move direction
     * @return true if move was successful
     * @author Mika INISAN
     */
    private boolean move(int playerNextY, int playerNextX, MoveDirection direction) {
        if (moveOutOfGrid(playerNextY, playerNextX)) {
            return false;
        }

        Cell nextCell = grid[playerNextY][playerNextX];

        if (nextCell.isBlocking()) {
            return false;
        }

        Cell previousCell = grid[player.getY()][player.getX()];

        nextCell.getEntities().push(previousCell.getEntities().pop()); // TODO Check if cell is not null

        player.setOrientation(direction);
        EventDispatcher.getInstance().dispatchEvent(this,
                PlayerMoveEventListener.class,
                new PlayerMoveEventArgs(player, playerNextY, playerNextX));

        player.setY(playerNextY);
        player.setX(playerNextX);

        return nextCell.interact(player);
    }

    /**
     * Check if the player is trying to move out of the grid
     *
     * @param playerNextY yx coordinate of player's next position
     * @param playerNextX x coordinate of player's next position
     * @return true if the player tries to move out of the grid
     * @author Mika INISAN
     */
    private boolean moveOutOfGrid(int playerNextY, int playerNextX) {
        return !(playerNextY < grid.length &&
                playerNextY >= 0 &&
                playerNextX < grid[0].length &&
                playerNextX >= 0);
    }

    public Cell[][] getGrid() {
        return grid;
    }
}