package fr.cyu.cyfight.javafx.controller;

import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener;
import fr.cyu.cyfight.game.base.GameConfiguration;
import fr.cyu.cyfight.game.entity.LivingEntityType;
import fr.cyu.cyfight.javafx.builder.GameSceneBuilder;
import fr.cyu.cyfight.javafx.builder.MenuSceneBuilder;
import javafx.animation.KeyFrame;
import javafx.animation.Timeline;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Group;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.input.MouseEvent;
import javafx.util.Duration;

/**
 * Controller for the "character selection" scene.
 *
 * @author Mika INISAN
 */
public class CharacterSelectionSceneController {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * Timeline for character animation
     */
    private Timeline timeline;

    /**
     * Current index of an image in the timeline
     */
    private int imageIndex = 0;

    /**
     * The group of images related to the "strong character"
     */
    @FXML
    private Group characterStrong;

    /**
     * The group of images related to the "smart character"
     */
    @FXML
    private Group characterSmart;

    /**
     * The group of images related to the "fast character"
     */
    @FXML
    private Group characterFast;

    /**
     * Back button (returns to the main menu)
     *
     * @param actionEvent the event
     * @author Mika INISAN
     */
    @FXML
    protected void backButtonAction(ActionEvent actionEvent) {
        try {
            EventDispatcher.getInstance().dispatchEvent(this,
                    SceneChangeRequestEventListener.class,
                    new SceneChangeRequestEventArgs(MenuSceneBuilder.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Select a character class (or "entity type") and store it in the game configuration
     *
     * @param actionEvent the event
     * @author Mika INISAN
     */
    @FXML
    protected void classAction(ActionEvent actionEvent) {
        Button classButton = (Button) actionEvent.getSource();

        switch (classButton.getId()) {
            case "classStrong":
                GameConfiguration.getInstance().setPlayerClass(LivingEntityType.STRONG);
                break;
            case "classSmart":
                GameConfiguration.getInstance().setPlayerClass(LivingEntityType.SMART);

                break;
            case "classFast":
                GameConfiguration.getInstance().setPlayerClass(LivingEntityType.FAST);
                break;
        }

        try {
            EventDispatcher.getInstance().dispatchEvent(this,
                    SceneChangeRequestEventListener.class,
                    new SceneChangeRequestEventArgs(GameSceneBuilder.class));
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /**
     * Starts character animation when the mouse is hovering a character image
     *
     * @param mouseEvent the mouse event
     * @author Mika INISAN
     */
    @FXML
    public void characterHover(MouseEvent mouseEvent) {
        if (mouseEvent.getSource() instanceof Group) {
            setCharacterAnimation((Group) mouseEvent.getSource());
        }

        if (mouseEvent.getSource() instanceof Button) {
            Button button = (Button) mouseEvent.getSource();
            switch (button.getId()) {
                case "classStrong":
                    setCharacterAnimation(characterStrong);
                    break;
                case "classSmart":
                    setCharacterAnimation(characterSmart);

                    break;
                case "classFast":
                    setCharacterAnimation(characterFast);
                    break;
            }
        }
    }

    /**
     * Stop the animation when the mouse exits an image
     *
     * @param mouseEvent the event
     * @author Mika INISAN
     */
    @FXML
    public void characterExited(MouseEvent mouseEvent) {
        resetTimeline();
    }

    /**
     * Reset timeline animation
     *
     * @author Mika INISAN
     */
    private void resetTimeline() {
        if (timeline != null) timeline.stop();
        timeline = null;
    }

    /**
     * Define character animation (timeline).
     *
     * @param group the group of ImageViews related to a character
     * @author Mika INISAN
     */
    private void setCharacterAnimation(Group group) {
        if (timeline != null) resetTimeline();

        imageIndex = 0;
        ObservableList<Node> nodes = group.getChildren();
        for (int i = 0; i < nodes.size(); i++) {
            nodes.get(i).setVisible(i == imageIndex);
        }

        // Animation
        timeline = new Timeline();
        timeline.setCycleCount(Timeline.INDEFINITE);
        timeline.getKeyFrames().add(new KeyFrame(
                Duration.millis(150),
                e -> {
                    nodes.get(imageIndex).setVisible(false);
                    imageIndex++;
                    if (imageIndex >= nodes.size()) imageIndex = 0;
                    nodes.get(imageIndex).setVisible(true);
                }
        ));
        timeline.play();
    }
}