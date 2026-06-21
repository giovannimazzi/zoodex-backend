import "./bootstrap";
/* import '~resources/scss/app.scss'; */
import "~icons/bootstrap-icons.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

window.rememberCollapse = function (collapseId, storageKey) {
    const panel = document.getElementById(collapseId);

    if (!panel) return;

    const savedState = localStorage.getItem(storageKey);

    if (savedState === "true") {
        panel.classList.add("show");
    }

    panel.addEventListener("shown.bs.collapse", function () {
        localStorage.setItem(storageKey, "true");
    });

    panel.addEventListener("hidden.bs.collapse", function () {
        localStorage.setItem(storageKey, "false");
    });
};
