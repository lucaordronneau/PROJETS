package fr.cyu.cyfight.javafx.builder;

import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 * Build a scene for character selection.
 *
 * @author Mika INISAN
 */
public class CharacterSelectionSceneBuilder extends BaseSceneBuilder {
    /**
     * {@inheritDoc}
     */
    @Override
    public Scene build(Stage stage) {
        return setUpStage(stage, "scene/character-selection-scene.fxml", "style/styles.css");
    }
}
