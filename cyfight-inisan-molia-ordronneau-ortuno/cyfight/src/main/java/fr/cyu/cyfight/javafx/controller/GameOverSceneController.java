package fr.cyu.cyfight.javafx.controller;

import fr.cyu.cyfight.event.args.EmptyEventArgs;
import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.GameExitRequestEventListener;
import fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener;
import fr.cyu.cyfight.javafx.builder.CharacterSelectionSceneBuilder;
import fr.cyu.cyfight.javafx.builder.MenuSceneBuilder;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.input.KeyCode;
import javafx.scene.input.KeyEvent;

/**
 * The MenuSceneController class manages the application main menu.
 *
 * @author Mika INISAN
 */
public class GameOverSceneController {
    @FXML
    protected void onKeyPressed(KeyEvent keyEvent) {
        if(keyEvent.getCode() == KeyCode.ESCAPE) {
            EventDispatcher.getInstance().dispatchEvent(this,
                    SceneChangeRequestEventListener.class,
                    new SceneChangeRequestEventArgs(MenuSceneBuilder.class));
        }
    }
}