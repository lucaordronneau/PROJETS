package fr.cyu.cyfight.javafx.builder;

import fr.cyu.cyfight.config.Configuration;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 * The BaseSceneBuilder is the base class for all scene builders. It exposes methods to help
 * building scenes. Inheriters must implement the build() method to define their own logic.
 *
 * @author Mika INISAN
 */
public abstract class BaseSceneBuilder implements SceneBuilder {
    /**
     * Build a scene for a specific stage.
     *
     * @param stage the stage
     * @return the new scene
     * @author Mika INISAN
     */
    @Override
    public abstract Scene build(Stage stage);

    /**
     * Utility method to build a scene.
     *
     * @param stage          the stage
     * @param sceneFXMLPath  the path of the scene's FXML file
     * @param stylesFXMLPath the path of the scene's styles
     * @return the new scene
     * @author Mika INISAN
     */
    protected Scene setUpStage(Stage stage, String sceneFXMLPath, String stylesFXMLPath) {
        Scene scene = null;

        try {
            Parent node = FXMLLoader.load(getClass().getResource(Configuration.PACKAGE_ROOT + sceneFXMLPath));
            scene = new Scene(node, 1600, 900);
            scene.getStylesheets().add(getClass().getResource(Configuration.PACKAGE_ROOT + stylesFXMLPath).toExternalForm());

            stage.setTitle("Cyfight");
            stage.setResizable(false);
        } catch (Exception e) {
            e.printStackTrace();
        }

        return scene;
    }
}
