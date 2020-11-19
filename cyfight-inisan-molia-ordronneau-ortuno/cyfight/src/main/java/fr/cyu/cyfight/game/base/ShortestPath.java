package fr.cyu.cyfight.game.base;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.game.cell.Cell;

import java.util.LinkedList;

public class ShortestPath {
    /**
     * verificationBounds, check if the cell is in the grid or not
     *
     * @param cases matrix of cells
     * @param x     x coordinate
     * @param y     y coordinate
     * @return Boolean, true if the cell is in the grid
     * @author ordronneau@eisti.eu
     */
    public static boolean verificationBounds(Case[][] cases, int x, int y) {
        boolean result = true;
        if (x < 0 || x >= cases.length || y < 0 || y >= cases[0].length || cases[x][y] == null) {
            result = false;
        }
        return result;
    }

    /**
     * visitNeighbor, visit a neighbor and add to the queue if the current distance {@literal >} the previous distance
     *
     * @param cases  matrix of cells
     * @param queue  list of cells
     * @param x      x coordinate
     * @param y      y coordinate
     * @param parent parent cell
     * @author ordronneau@eisti.eu
     */
    public static void visitNeighbor(Case[][] cases, LinkedList<Case> queue, int x, int y, Case parent) {
        int distance = parent.distance + 1;
        boolean verifBounds = verificationBounds(cases, x, y);
        if (verifBounds) {
            Case current = cases[x][y];
            if (current.distance > distance) {
                current.distance = distance;
                current.parent = parent;
                queue.add(current);
            }
        }
    }

    /**
     * createCases, create a matrix of Case
     *
     * @param matrix matrix of boolean values
     * @return a matrix of Case
     * @author ordronneau@eisti.eu
     */
    public static Case[][] createCases(boolean[][] matrix) {
        Case[][] cases = new Case[matrix.length][matrix[0].length];
        for (int i = 0; i < cases.length; i++) {
            for (int j = 0; j < cases[0].length; j++) {
                if (matrix[i][j] != false) {
                    cases[i][j] = new Case(i, j, Integer.MAX_VALUE, null);
                }
            }
        }
        return cases;
    }

    /**
     * verificationStartEnd, verify if start and and are not a wall
     *
     * @param matrix matrix of booleans
     * @param start  start values
     * @param end    end values
     * @return if we can do the shortest path
     * @author ordronneau@eisti.eu
     */
    public static boolean verificationStartEnd(boolean[][] matrix, int[] start, int[] end) {
        boolean result = true;
        int startX = start[0];
        int startY = start[1];
        int endX = end[0];
        int endY = end[1];
        if (matrix[startX][startY] == false || matrix[endX][endY] == false) {
            result = false;
        }
        return result;
    }

    /**
     * visitAllNeighbors, visit all neighbors for the smallest distance
     *
     * @param cases   matrix of cells
     * @param current current cell
     * @param queue   list of cells
     * @author ordronneau@eisti.eu
     */
    public static void visitAllNeighbors(Case[][] cases, LinkedList<Case> queue, Case current) {
        visitNeighbor(cases, queue, current.x - 1, current.y, current);
        visitNeighbor(cases, queue, current.x + 1, current.y, current);
        visitNeighbor(cases, queue, current.x, current.y - 1, current);
        visitNeighbor(cases, queue, current.x, current.y + 1, current);
    }

    /**
     * constructPath, construct the path thanks to parent of each node
     *
     * @param destination destination cell
     * @param path        the path
     * @author ordronneau@eisti.eu
     */
    public static void constructPath(Case destination, LinkedList<Case> path) {
        Case current;
        if (destination != null) {
            current = destination;
            while (current != null) {
                path.addFirst(current);
                current = current.parent;
            }
        }
    }

    /**
     * getPath, return a list with the position of the case that construct the path
     *
     * @param matrix a matrix of boolean values
     * @param start  start values
     * @param end    end values
     * @return list of Case
     * @author ordronneau@eisti.eu
     */
    public static LinkedList<Case> getPath(boolean[][] matrix, int[] start, int[] end) {
        LinkedList<Case> path = new LinkedList<Case>();
        LinkedList<Case> queue = new LinkedList<>();
        int startX = start[0];
        int startY = start[1];
        int endX = end[0];
        int endY = end[1];
        Case destination = null;
        Case current;

        boolean verifStartEnd = verificationStartEnd(matrix, start, end);
        if (verifStartEnd) {

            Case[][] cases = createCases(matrix);
            Case source = cases[startX][startY];
            source.distance = 0;
            queue.add(source);

            while (!queue.isEmpty()) {
                current = queue.poll();
                if (current.x == endX && current.y == endY) {
                    destination = current;
                    break;
                }
                visitAllNeighbors(cases, queue, current);
            }
            constructPath(destination, path);
        }
        return (path);
    }

    public static boolean[][] createMatrix(Cell[][] grid) {
        boolean[][] matrix = new boolean[Configuration.GAME_GRID_ROW_COUNT][Configuration.GAME_GRID_COL_COUNT];

        for (int i = 0; i < Configuration.GAME_GRID_ROW_COUNT; i++) {
            for (int j = 0; j < Configuration.GAME_GRID_COL_COUNT; j++) {
                if (grid[i][j].isBlocking() == false) {
                    matrix[i][j] = true;
                } else {
                    matrix[i][j] = false;
                }
            }
        }

        return matrix;
    }
}