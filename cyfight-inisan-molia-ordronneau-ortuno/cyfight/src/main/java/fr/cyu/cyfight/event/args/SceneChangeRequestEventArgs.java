package fr.cyu.cyfight.event.args;

import java.lang.reflect.Type;

/**
 * The SceneChangeRequestEventArgs class carries information required when a scene is about to change.
 *
 * @author Mika INISAN
 * @see fr.cyu.cyfight.event.listener.SceneChangeRequestEventListener
 */
public class SceneChangeRequestEventArgs implements EventArgs {
	// ---
	// ATTRIBUTES
	// ---

	/**
	 * Type of the SceneBuilder to use for the requested scene
	 */
	private Type sceneBuilderType;

	// ---
	// CONSTRUCTORS
	// ---

	/**
	 * Constructs a new information object that carries the SceneBuilder required to build the requested scene.
	 *
	 * @param sceneBuilderType type of the SceneBuilder
	 * @author Mika INISAN
	 */
	public SceneChangeRequestEventArgs(Type sceneBuilderType) {
		this.sceneBuilderType = sceneBuilderType;
	}

	// ---
	// METHODS
	// ---

	/**
	 * Retrieves the type of the builder to use for to construct the requested scene
	 *
	 * @return type of the SceneBuilder
	 * @author Mika INISAN
	 */
	public Type getSceneBuilderType() {
		return sceneBuilderType;
	}
}