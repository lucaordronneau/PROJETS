package fr.cyu.cyfight.javafx.builder;

import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 * Build a main menu scene.
 *
 * @author Mika INISAN
 */
public class MenuSceneBuilder extends BaseSceneBuilder {
    /**
     * {@inheritDoc}
     */
    @Override
    public Scene build(Stage stage) {
        return setUpStage(stage, "scene/menu-scene.fxml", "style/styles.css");
    }
}
