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

window.initColorBadge = function () {
    const colorInput = document.getElementById("color");
    const colorValue = document.getElementById("color-value");

    if (!colorInput || !colorValue) {
        return;
    }

    function updateColorBadge() {
        colorValue.textContent = colorInput.value;
        colorValue.style.backgroundColor = colorInput.value;
    }

    window.addEventListener("pageshow", updateColorBadge);

    colorInput.addEventListener("input", updateColorBadge);
};
