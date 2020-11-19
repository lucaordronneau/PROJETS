module cyfight {
    requires javafx.controls;
    requires javafx.fxml;

    opens fr.cyu.cyfight to javafx.fxml;
    opens fr.cyu.cyfight.javafx.controller to javafx.fxml;
    exports fr.cyu.cyfight;
    exports fr.cyu.cyfight.javafx.controller;
    exports fr.cyu.cyfight.event.args;
}