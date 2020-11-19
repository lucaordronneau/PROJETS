package fr.cyu.cyfight;

import fr.cyu.cyfight.event.args.EventArgs;
import fr.cyu.cyfight.event.listener.GameExitRequestEventListener;
import fr.cyu.cyfight.event.manager.*;
import fr.cyu.cyfight.javafx.builder.MenuSceneBuilder;
import fr.cyu.cyfight.javafx.builder.SceneManager;
import fr.cyu.cyfight.event.args.SceneChangeRequestEventArgs;
import fr.cyu.cyfight.event.base.EventDispatcher;
import fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener;
import javafx.application.Application;
import javafx.application.Platform;
import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 * Main application launcher.
 *
 * @author Mika INISAN
 */
public class MainApp extends Application implements SceneChangeRequestEventListener, GameExitRequestEventListener {
    // ---
    // ATTRIBUTES
    // ---

    /**
     * The main stage
     */
    private Stage stage;

    // ---
    // METHODS
    // ---

    /**
     * Start the JavaFX graphic loop
     *
     * @param stage the stage
     * @author Mika INISAN
     */
    @Override
    public void start(Stage stage) {
        // Initialize main stage
        this.stage = stage;
        this.stage.setOnCloseRequest(event -> {
            Platform.exit();
            System.exit(0);
        });

        // Register event managers
        EventDispatcher.getInstance()
                .register(new SceneChangeRequestEventManager())
                .register(new LevelChangeRequestEventManager())
                .register(new LevelChangeEventManager())
                .register(new PlayerMoveEventManager())
                .register(new ItemPickedUpEventManager())
                .register(new FightStartEventManager())
                .register(new GameExitRequestEventManager())
                .register(new AttackerChangeEventManager())
                .register(new FightEndEventManager())
                .register(new EntityUpdateStatisticsEventManager());

        // Subscribe to scene change events
        EventDispatcher.getInstance()
                .subscribe(SceneChangeRequestEventListener.class, this)
                .subscribe(GameExitRequestEventListener.class, this);

        // Setup default scene (menu)
        Scene scene = SceneManager.getScene(stage, MenuSceneBuilder.class);
        stage.setScene(scene);
        stage.show();
    }

    /**
     * Start the application.
     *
     * @param args Optional arguments
     * @author Mika INISAN
     */
    public static void main(String[] args) {
        launch(args);
    }

    /**
     * Manage scene changes.
     *
     * @param sender    the object that requested a scene change
     * @param eventArgs information about the scene change
     * @author Mika INISAN
     */
    @Override
    public void onSceneChangeRequest(Object sender, SceneChangeRequestEventArgs eventArgs) {
        Scene scene = SceneManager.getScene(stage, eventArgs.getSceneBuilderType());
        stage.setScene(scene);
        stage.show();
    }

    /**
     * Manage application exit.
     *
     * @param sender    the object that was responsible for the exit request
     * @param eventArgs empty information
     * @author Mika INISAN
     */
    @Override
    public void onGameExit(Object sender, EventArgs eventArgs) {
        stage.close();
    }
}