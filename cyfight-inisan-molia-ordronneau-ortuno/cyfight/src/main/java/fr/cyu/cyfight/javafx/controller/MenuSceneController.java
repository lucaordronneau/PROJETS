package fr.cyu.cyfight.javafx.controller;

import fr.cyu.cyfight.event.args.EmptyEventArgs;
import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.GameExitRequestEventListener;
import fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener;
import fr.cyu.cyfight.javafx.builder.CharacterSelectionSceneBuilder;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;

/**
 * The MenuSceneController class manages the application main menu.
 *
 * @author Mika INISAN
 */
public class MenuSceneController {

    /**
     * Button to load the character selection scene
     */
    @FXML
    private Button startButton;

    /**
     * Button to quit the game
     */
    @FXML
    private Button quitButton;

    /**
     * Manage a menu action
     *
     * @param actionEvent the action event raised by the view associated to this controller
     * @author Mika INISAN
     */
    @FXML
    protected void menuAction(ActionEvent actionEvent) {
        Button menuButton = (Button) actionEvent.getSource();

        if(menuButton == startButton) {
            EventDispatcher.getInstance().dispatchEvent(this,
                    SceneChangeRequestEventListener.class,
                    new SceneChangeRequestEventArgs(CharacterSelectionSceneBuilder.class));
        } else if(menuButton == quitButton) {
            EventDispatcher.getInstance().dispatchEvent(this,
                    GameExitRequestEventListener.class,
                    new EmptyEventArgs());
        }
    }
}