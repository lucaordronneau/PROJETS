package fr.cyu.cyfight.javafx.builder;

import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;

import java.util.Stack;

public class GameOverSceneBuilder extends BaseSceneBuilder {
    @Override
    public Scene build(Stage stage) {
        Scene scene = setUpStage(stage, "scene/game-over-scene.fxml", "style/styles.css");

        StackPane stackPane = (StackPane) scene.getRoot();
        stackPane.requestFocus();
        stackPane.setAlignment(Pos.CENTER);

        return scene;
    }
}
