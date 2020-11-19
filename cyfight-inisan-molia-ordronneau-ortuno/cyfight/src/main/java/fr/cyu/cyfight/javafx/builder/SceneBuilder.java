package fr.cyu.cyfight.javafx.builder;

import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 * The SceneBuilder interface defines methods that must be implemented by all scene builders in the application.
 *
 * @author Mika INISAN
 */
public interface SceneBuilder {
    Scene build(Stage stage);
}
