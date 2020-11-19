package fr.cyu.cyfight.javafx.controller;

import fr.cyu.cyfight.config.Configuration;
import fr.cyu.cyfight.event.args.*;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.*;
import fr.cyu.cyfight.game.base.Game;
import fr.cyu.cyfight.game.base.Grid;
import fr.cyu.cyfight.game.base.MoveDirection;
import fr.cyu.cyfight.game.cell.Cell;
import fr.cyu.cyfight.game.entity.Enemy;
import fr.cyu.cyfight.game.entity.Entity;
import fr.cyu.cyfight.game.entity.Item;
import fr.cyu.cyfight.game.entity.Player;
import fr.cyu.cyfight.javafx.builder.MenuSceneBuilder;
import fr.cyu.cyfight.javafx.util.Utility;
import javafx.animation.*;
import javafx.fxml.FXML;
import javafx.geometry.Point2D;
import javafx.geometry.Pos;
import javafx.scene.Group;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyCode;
import javafx.scene.input.KeyEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.HBox;
import javafx.scene.paint.Color;
import javafx.scene.shape.LineTo;
import javafx.scene.shape.MoveTo;
import javafx.scene.shape.Path;
import javafx.scene.shape.Polygon;
import javafx.scene.text.Text;
import javafx.scene.text.TextAlignment;
import javafx.util.Duration;

import java.util.Collection;
import java.util.Iterator;

public class GameSceneController implements PlayerMoveEventListener,
        LevelChangeEventListener,
        ItemPickedUpEventListener,
        FightStartEventListener,
        AttackerChangeEventListener,
        FightEndEventListener,
        EntityStatisticsUpdateEventListener { // TODO Refactor
    // ---
    // ATTRIBUTES
    // ---

    private Game game;
    private boolean fight;
    private ParallelTransition playerTransition;

    // Global nodes
    @FXML private AnchorPane anchorPane;
    private HBox playerBagDisplayHBox;
    private Text levelDisplayText;
    private Text playerlifeDisplayText;

    // Game nodes
    private Group[][] displayGrid;
    private Group gridGroup;

    // Fight nodes
    private ImageView playerFightingImageView;
    private ImageView enemyFightingImageView;

    private Button attackButton;
    private Button useItemButton;

    private Text enemyFightingLifeDisplayText = new Text();

    // ---
    // METHODS
    // ---

    @FXML
    protected void initialize() {
        subscribeEvents();

        displayGrid = new Group[Configuration.GAME_GRID_ROW_COUNT][Configuration.GAME_GRID_COL_COUNT];

        // Display level
        levelDisplayText = new Text("LEVEL 1");
        levelDisplayText.setId("level-display-text");
        levelDisplayText.setTextAlignment(TextAlignment.CENTER);
        AnchorPane.setTopAnchor(levelDisplayText, 32.0);
        AnchorPane.setLeftAnchor(levelDisplayText, 32.0);
        anchorPane.getChildren().add(levelDisplayText);

        // Display bag
        playerBagDisplayHBox = new HBox();
        playerBagDisplayHBox.setAlignment(Pos.CENTER_RIGHT);
        AnchorPane.setTopAnchor(playerBagDisplayHBox, 0.0);
        AnchorPane.setRightAnchor(playerBagDisplayHBox, 32.0);
        anchorPane.getChildren().add(playerBagDisplayHBox);

        // Display health points
        playerlifeDisplayText = new Text();
        playerlifeDisplayText.setId("player-life-display-text");
        playerlifeDisplayText.setTextAlignment(TextAlignment.LEFT);
        AnchorPane.setLeftAnchor(playerlifeDisplayText, 32.0);
        AnchorPane.setTopAnchor(playerlifeDisplayText, 96.0);
        anchorPane.getChildren().add(playerlifeDisplayText);

        // Start the game
        game = new Game();
    }

    private void subscribeEvents() {
        EventDispatcher.getInstance()
                .subscribe(PlayerMoveEventListener.class, this)
                .subscribe(LevelChangeEventListener.class, this)
                .subscribe(ItemPickedUpEventListener.class, this)
                .subscribe(FightStartEventListener.class, this)
                .subscribe(AttackerChangeEventListener.class, this)
                .subscribe(FightEndEventListener.class, this)
                .subscribe(EntityStatisticsUpdateEventListener.class, this);
    }

    private void unsubscribeEvents() {
        game.unsubscribeEvents();

        EventDispatcher.getInstance()
                .unsubscribe(PlayerMoveEventListener.class, this)
                .unsubscribe(LevelChangeEventListener.class, this)
                .unsubscribe(ItemPickedUpEventListener.class, this)
                .unsubscribe(FightStartEventListener.class, this)
                .unsubscribe(AttackerChangeEventListener.class, this)
                .unsubscribe(FightEndEventListener.class, this)
                .unsubscribe(EntityStatisticsUpdateEventListener.class, this);
    }

    @FXML
    protected void onKeyPressed(KeyEvent keyEvent) {
        // Escape to quit game and go back to main menu
        if (keyEvent.getCode() == KeyCode.ESCAPE) {
            unsubscribeEvents();

            EventDispatcher.getInstance().dispatchEvent(this,
                    SceneChangeRequestEventListener.class,
                    new SceneChangeRequestEventArgs(MenuSceneBuilder.class));
        }

        if (!fight) {
            game.play(keyEvent.getCode());
        }
    }

    @Override
    public void onPlayerMove(Object sender, PlayerMoveEventArgs eventArgs) {
        // Stop current player transition if any
        if (playerTransition != null) playerTransition.stop();

        // Calculate coordinates
        Player player = eventArgs.getMovingPlayer();
        Point2D previousCoordinates = new Point2D(player.getX(), player.getY());
        Point2D nextCoordinates = new Point2D(eventArgs.getPlayerNextX(), eventArgs.getPlayerNextY());
        Point2D realPreviousCoordinates = toRealCoordinates(previousCoordinates);
        Point2D realNextCoordinates = toRealCoordinates(nextCoordinates);

        Collection<Node> previousCellNodes = displayGrid[(int) previousCoordinates.getY()][(int) previousCoordinates.getX()].getChildren();
        Collection<Node> nextCellNodes = displayGrid[(int) nextCoordinates.getY()][(int) nextCoordinates.getX()].getChildren();

        Iterator<Node> iterator = previousCellNodes.iterator();
        Node playerNode = null;

        while (iterator.hasNext() && playerNode == null) {
            Node node = iterator.next();

            if (node.getId() != null && node.getId().equals("playerGroup")) {
                playerNode = node;
            }
        }

        // Player animation
        Group playerGroup = (Group) playerNode;
        if (playerGroup == null || playerGroup.getChildren().size() == 0) return;

        // Create a parallel transition and add a PathTransition and a Timeline
        playerTransition = new ParallelTransition();
        playerTransition.getChildren().add(getPlayerMoveAnimation(playerGroup, realPreviousCoordinates, realNextCoordinates));
        playerTransition.getChildren().add(getPlayerAnimation(playerGroup, player.getOrientation()));
        playerTransition.play();

        // Move player to right cell
        previousCellNodes.remove(playerNode);
        nextCellNodes.add(playerNode);
    }


    private PathTransition getPlayerMoveAnimation(Group playerGroup, Point2D realPreviousCoordinates, Point2D realNextCoordinates) {
        Path path = new Path();
        //path.getElements().add(new MoveTo(playerImageView.getX(), playerImageView.getY()));
        //path.getElements().add(new MoveTo(translateInGrid(realPreviousCoordinates).getX(), translateInGrid(realPreviousCoordinates).getY()));
        path.getElements().add(new MoveTo(realPreviousCoordinates.getX() + 16, realPreviousCoordinates.getY() - 16));
        //path.getElements().add(new LineTo(translateInGrid(realNextCoordinates).getX(), translateInGrid(realNextCoordinates).getY()));
        path.getElements().add(new LineTo(realNextCoordinates.getX() + 16, realNextCoordinates.getY() - 16));
        // path.getElements().add(new LineTo(playerImageView.getX(), playerImageView.getY()));

        PathTransition pathTransition = new PathTransition();
        pathTransition.setDuration(Duration.millis(500));
        pathTransition.setPath(path);
        pathTransition.setNode(playerGroup);

        return pathTransition;
    }

    private Timeline getPlayerAnimation(Group playerGroup, MoveDirection direction) {
        // Index of images in group
        int index = 0;
        switch (direction) {
            case Right:
                break;
            case Left:
                index = 2;
                break;
            case Up:
                index = 4;
                break;
            case Down:
                index = 6;
                break;
        }
        final int startIndex = index;

        // Hide all images by default, except the first in the moving direction
        for (int i = 0; i < playerGroup.getChildren().size(); i++) {
            playerGroup.getChildren().get(i).setVisible(i == startIndex);
        }

        // Build timeline
        Timeline timeline = new Timeline();
        timeline.setCycleCount(3);
        timeline.getKeyFrames().add(new KeyFrame(
                Duration.millis(200),
                e -> {
                    playerGroup.getChildren().get(startIndex).setVisible(false);
                    playerGroup.getChildren().get(startIndex + 1).setVisible(true);
                }
        ));

        timeline.getKeyFrames().add(new KeyFrame(
                Duration.millis(250),
                e -> {
                    playerGroup.getChildren().get(startIndex).setVisible(true);
                    playerGroup.getChildren().get(startIndex + 1).setVisible(false);
                }

        ));
        return timeline;
    }

    private Point2D toRealCoordinates(Point2D virtualCoordinates) {
        int rowCount = Configuration.GAME_GRID_ROW_COUNT;
        int yOffset = Configuration.GAME_GRID_Y_OFFSET;
        int xOffset = Configuration.GAME_GRID_X_OFFSET;
        int yStart = Configuration.GAME_GRID_Y_START;
        int xStart = Configuration.GAME_GRID_X_START;

        double virtualY = virtualCoordinates.getY();
        double virtualX = virtualCoordinates.getX();

        return new Point2D(((rowCount - virtualY) * (xOffset / 2) + xOffset * virtualX) + xStart,
                (virtualY * yOffset) + yStart);
    }

    private ImageView generateImageView(String filePath, Point2D coordinates) {
        ImageView imageView = null;

        try {
            Image image = new Image(getClass().getResourceAsStream(filePath));
            imageView = new ImageView(image);

            Point2D translatedCoordinates = translateInGrid(coordinates);

            imageView.setY(translatedCoordinates.getY());
            imageView.setX(translatedCoordinates.getX());
        } catch (Exception e) {
            System.err.println("Image file not found: " + filePath);
        }

        return imageView;
    }

    private Point2D translateInGrid(Point2D point2D) {
        return new Point2D(point2D.getX() - Configuration.GAME_GRID_Y_OFFSET,
                point2D.getY() - 2 * Configuration.GAME_GRID_Y_OFFSET);
    }

    private void displayGame(Grid gameGrid) {
        int rowCount = Configuration.GAME_GRID_ROW_COUNT;
        int colCount = Configuration.GAME_GRID_COL_COUNT;
        int yOffset = Configuration.GAME_GRID_Y_OFFSET;
        int xOffset = Configuration.GAME_GRID_X_OFFSET;

        Group previousGridGroup = null;

        // Remove previous display
        for (Node node : anchorPane.getChildren()) {
            if (node.getId() != null && node.getId().equals("grid-group")) {
                previousGridGroup = (Group) node;
            }
        }

        anchorPane.getChildren().remove(previousGridGroup);

        gridGroup = new Group();
        gridGroup.setId("grid-group");

        for (int row = 0; row < rowCount; row++) {
            for (int col = 0; col < colCount; col++) {
                Point2D point2D = toRealCoordinates(new Point2D(col, row));

                double y = point2D.getY();
                double x = point2D.getX();

                Group group = new Group();
                displayGrid[row][col] = group;
                gridGroup.getChildren().add(group);

                // Display cell
                Polygon polygon = new Polygon();

                polygon.getPoints().addAll(
                        x, y,
                        x + xOffset, y,
                        x + yOffset, y + yOffset,
                        x - yOffset, y + yOffset);

                polygon.setFill(null);
                polygon.setStroke(Color.rgb(255, 255, 255, 0.1));
                polygon.getStrokeDashArray().addAll(5.0, 54.0, 10.0, 35.254833996, 10.0, 54.0, 10.0, 35.254833996, 5.0);

                group.getChildren().add(polygon);

                // Display terrain
                Cell cell = gameGrid.getGrid()[row][col];

                if (cell.isBlocking()) {
                    group.getChildren().add(generateImageView(Configuration.PACKAGE_ROOT + "image/terrain/wall.png",
                            new Point2D(x, y)));
                }

                if (cell.isEntry()) {
                    group.getChildren().add(generateImageView(Configuration.PACKAGE_ROOT + "image/terrain/entry.png",
                            new Point2D(x, y)));
                }

                if (cell.isExit()) {
                    group.getChildren().add(generateImageView(Configuration.PACKAGE_ROOT + "image/terrain/exit.png",
                            new Point2D(x, y)));
                }

                // Display entities
                for (Entity entity : cell.getEntities()) {
                    if (entity instanceof Player) {
                        group.getChildren().add(buildPlayerGroup((Player) entity, x, y));
                        /*ImageView imageView = generateImageView(Configuration.PACKAGE_ROOT + Utility.getEntityImagePath((Player) entity, "front", 0),
                                new Point2D(x, y));
                        imageView.setId("playerImageView");
                        group.getChildren().add(imageView);*/
                    } else if (entity instanceof Item) {
                        Item item = (Item) entity;

                        ImageView imageView = generateImageView(Configuration.PACKAGE_ROOT + Utility.getItemImagePath(item.getId()) + ".png",
                                new Point2D(x, y));
                        imageView.setId("item-image-view-" + item.getId());
                        group.getChildren().add(imageView);
                    } else if (entity instanceof Enemy) {
                        ImageView imageView = generateImageView(Configuration.PACKAGE_ROOT + Utility.getEntityImagePath((Enemy) entity, "front", 0),
                                new Point2D(x, y));
                        imageView.setId("enemy-image-view-" + entity.hashCode());

                        group.getChildren().add(imageView);
                    }
                }
            }
        }

        AnchorPane.setBottomAnchor(gridGroup, 32.0);
        anchorPane.getChildren().add(gridGroup);
    }

    /**
     * Build player group node.
     *
     * @param player the player
     * @param x      x coordinate of the player on the grid
     * @param y      y coordinate of the player on the grid
     * @return Group node containing all images required for player animation
     */
    private Group buildPlayerGroup(Player player, double x, double y) {
        Group playerGroup = new Group();
        playerGroup.setId("playerGroup");

        try {
            String[] sides = new String[]{"right-profile", "left-profile", "back", "front"};
            for (String side : sides) {
                for (int state = 1; state <= 2; state++) {
                    String imagePath = Utility.getEntityFullImagePath(player, side, state);
                    ImageView imageView = generateImageView(imagePath, new Point2D(x, y));
                    imageView.setVisible(false);
                    playerGroup.getChildren().add(imageView);
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        // First imageView
        playerGroup.getChildren().get(0).setVisible(true);
        playerGroup.getChildren().get(0).setId("playerImageView");
        return playerGroup;
    }

    @Override
    public void onLevelChange(Object sender, LevelChangeEventArgs eventArgs) {
        displayGame(eventArgs.getNewGrid());
        levelDisplayText.setText("LEVEL " + eventArgs.getLevel());
    }

    @Override
    public void onItemPickUp(Object sender, ItemPickedUpEventArgs eventArgs) {
        ImageView itemImageView = (ImageView) displayGrid[eventArgs.getY()][eventArgs.getX()].lookup("#item-image-view-" + eventArgs.getPickedUpItem().getId());

        displayGrid[eventArgs.getY()][eventArgs.getX()].getChildren().remove(itemImageView);
        playerBagDisplayHBox.getChildren().add(itemImageView);

        ScaleTransition scaleTransition = new ScaleTransition(
                Duration.millis(300),
                itemImageView);
        scaleTransition.setCycleCount(2);
        scaleTransition.setByX(2f);
        scaleTransition.setByY(2f);
        scaleTransition.setAutoReverse(true);
        scaleTransition.setOnFinished(
                event -> {
                    itemImageView.setOpacity(.5);
                    if (((Player) eventArgs.getEntity()).getItemInHand().equals(eventArgs.getPickedUpItem())) {
                        itemImageView.setOpacity(1.0);
                    }
                }
        );
        scaleTransition.play();
    }

    @Override
    public void onFightStart(Object sender, FightStartEventArgs eventArgs) {
        fight = true;

        /*System.out.printf("Fade start");
        FadeTransition ft = new FadeTransition(Duration.millis(1000), gridGroup);
        ft.setFromValue(1.0);
        ft.setToValue(0.0);
        ft.setCycleCount(1);
        ft.play();

        ft.setOnFinished(transitionFinished -> {*/

            displayGrid[eventArgs.getPlayerFighting().getY()][eventArgs.getPlayerFighting().getX()].getChildren().remove(
                displayGrid[eventArgs.getPlayerFighting().getY()][eventArgs.getPlayerFighting().getX()].lookup("#enemy-image-view-" + eventArgs.getEnemyFighting().hashCode()));

            gridGroup.setVisible(false);

            // Position player
            playerFightingImageView = new ImageView(new Image(getClass().getResourceAsStream(Configuration.PACKAGE_ROOT +
                    Utility.getEntityImagePath(eventArgs.getPlayerFighting(), "front", 0))));
            playerFightingImageView.setId("player-fighting-image-view");

            Point2D point2D = new Point2D(
                    (double) ((int) ((Configuration.GAME_GRID_COL_COUNT - 1) / 2)),
                    (double) ((int) (Configuration.GAME_GRID_ROW_COUNT / 2) + 1)
            );

            Point2D realCoordinates = toRealCoordinates(point2D);
            AnchorPane.setLeftAnchor(playerFightingImageView, translateInGrid(realCoordinates).getX());
            AnchorPane.setTopAnchor(playerFightingImageView, translateInGrid(realCoordinates).getY());
            anchorPane.getChildren().add(playerFightingImageView);

            // Position enemy
            enemyFightingImageView = new ImageView(new Image(getClass().getResourceAsStream(Configuration.PACKAGE_ROOT +
                    Utility.getEntityImagePath(eventArgs.getEnemyFighting(), "front", 0))));
            enemyFightingImageView.setId("enemy-fighting-image-view");

            point2D = new Point2D(
                    (double) ((int) ((Configuration.GAME_GRID_COL_COUNT - 1) / 2)),
                    (double) ((int) (Configuration.GAME_GRID_ROW_COUNT / 2) - 2)
            );

            realCoordinates = toRealCoordinates(point2D);
            AnchorPane.setLeftAnchor(enemyFightingImageView, translateInGrid(realCoordinates).getX());
            AnchorPane.setTopAnchor(enemyFightingImageView, translateInGrid(realCoordinates).getY());
            anchorPane.getChildren().add(enemyFightingImageView);

            // Display enemy health points
            enemyFightingLifeDisplayText = new Text("||||||||||||||||||||");
            enemyFightingLifeDisplayText.setId("enemy-fighting-life-display-text");
            enemyFightingLifeDisplayText.setTextAlignment(TextAlignment.RIGHT);
            AnchorPane.setRightAnchor(enemyFightingLifeDisplayText, 32.0);
            AnchorPane.setTopAnchor(enemyFightingLifeDisplayText, 96.0);
            anchorPane.getChildren().add(enemyFightingLifeDisplayText);

            // Position buttons
            attackButton = new Button();
            attackButton.setId("attack-button");

            attackButton.setText("ATTACK");
            attackButton.setOnMouseClicked(attackButtonClicked -> {
                game.combat(eventArgs.getPlayerFighting(), eventArgs.getEnemyFighting());
            });

            useItemButton = new Button();
            useItemButton.setId("use-item-button");
            useItemButton.setText("USE");
            useItemButton.setOnMouseClicked(attackButtonClicked -> {
                if(playerBagDisplayHBox.getChildren().size() > 2) {
                    playerBagDisplayHBox.getChildren().remove(playerBagDisplayHBox.getChildren().get(0));
                    playerBagDisplayHBox.getChildren().get(0).setOpacity(1.0);

                    game.useItem(eventArgs.getPlayerFighting(), eventArgs.getEnemyFighting());
                } else {
                    for(Node node : playerBagDisplayHBox.getChildren()) {
                        if(node.getId() == "use-item-button") {
                            node.setVisible(false);
                        }
                    }
                }
            });

            playerBagDisplayHBox.getChildren().addAll(attackButton, useItemButton);

            // Position bag
            playerBagDisplayHBox.setVisible(false);
            AnchorPane.setRightAnchor(playerBagDisplayHBox, 350.0); // TODO Remove magic number
            AnchorPane.setTopAnchor(playerBagDisplayHBox, (double) Configuration.GAME_GRID_Y_START + 6 * Configuration.GAME_GRID_Y_OFFSET);
        /*});*/
    }

    @Override
    public void onAttackerChange(Object sender, AttackerChangeEventArgs eventArgs) {
        if(eventArgs.getAttacker() instanceof Player)  {
            playerBagDisplayHBox.setVisible(true);
        } else if(eventArgs.getAttacker() instanceof Enemy) {
            playerBagDisplayHBox.setVisible(false);
        }
    }

    @Override
    public void onFightEnd(Object sender, FightEndEventArgs eventArgs) {
        AnchorPane.setTopAnchor(playerBagDisplayHBox, 0.0);
        AnchorPane.setRightAnchor(playerBagDisplayHBox, 32.0);

        anchorPane.getChildren().removeAll(enemyFightingImageView,
                                            playerFightingImageView,
                                            enemyFightingLifeDisplayText);

        playerBagDisplayHBox.getChildren().removeAll(attackButton,
                                                        useItemButton);

        gridGroup.setVisible(true);
        anchorPane.requestFocus();
        fight = false;
    }

    @Override
    public void onStatisticsUpdate(Object sender, EntityStatisticsUpdateEventArgs eventArgs) {
        String text = "";

        int displayLife = (int) Math.floor(20 *
                ((Player) eventArgs.getPlayer()).getHp() /
                ((Player) eventArgs.getPlayer()).getHpMax());

        for(int i = 0; i < displayLife; i ++) {
            text += "|";
        }

        playerlifeDisplayText.setText(text);

        text = "";

        for(int i = 0; i < ((Enemy) eventArgs.getOpponent()).getHp(); i ++) {
            text += "|";
        }

        enemyFightingLifeDisplayText.setText(text);
    }
}