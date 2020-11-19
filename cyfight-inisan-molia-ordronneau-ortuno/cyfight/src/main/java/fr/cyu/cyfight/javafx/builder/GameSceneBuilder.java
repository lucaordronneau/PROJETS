package fr.cyu.cyfight.javafx.builder;

import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;

/**
 * Build a game scene.
 *
 * @author Mika INISAN
 */
public class GameSceneBuilder extends BaseSceneBuilder {
    /**
     * {@inheritDoc}
     */
    @Override
    public Scene build(Stage stage) {
        Scene scene = setUpStage(stage, "scene/game-scene.fxml", "style/styles.css");

        AnchorPane anchorPane = (AnchorPane) scene.getRoot();
        anchorPane.requestFocus();

        return scene;
    }
}
