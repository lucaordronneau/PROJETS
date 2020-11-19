package fr.cyu.cyfight.javafx.builder;

import javafx.scene.Scene;
import javafx.stage.Stage;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Type;

/**
 * The SceneManager helps building scenes by calling the associated SceneBuilder.
 *
 * @author Mika INISAN
 * @see BaseSceneBuilder
 */
public class SceneManager {
    // ---
    // METHODS
    // ---

    /**
     * Build a scene by calling a SceneBuilder
     *
     * @param stage            the stage
     * @param sceneBuilderType the class of the SceneBuilder
     * @return the new scene
     * @author Mika INISAN
     */
    public static Scene getScene(Stage stage, Type sceneBuilderType) {
        Scene scene = null;

        try {
            SceneBuilder sceneBuilder = (SceneBuilder) Class.forName(sceneBuilderType.getTypeName()).getConstructor().newInstance();
            scene = sceneBuilder.build(stage);
        } catch (ClassNotFoundException
                | InstantiationException
                | IllegalAccessException
                | InvocationTargetException
                | NoSuchMethodException e) {
            e.printStackTrace();
        }

        return scene;
    }
}
