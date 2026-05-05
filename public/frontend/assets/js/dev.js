/* jshint esversion: 6 */
console.log("running from dev.script");

// All-Resources Page Left site Dropdown
document.addEventListener("DOMContentLoaded", function () {
    const menuLinks = document.querySelectorAll(".rplc_dropdown > li > a");
    const activeLink = document.querySelector(".rplc_dropdown > li > a.active");
    if (activeLink) {
        let parentLi = activeLink.parentElement;
        let dropdown = parentLi.querySelector(".rplc_dropdown_items");

        if (dropdown && dropdown.querySelector("li")) {
            dropdown.classList.add("show");
        }
    }
    menuLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            if (!e.target.matches("a.link")) {
                e.preventDefault();
                const currentDropdown = this.nextElementSibling;

                if (
                    currentDropdown &&
                    currentDropdown.classList.contains("rplc_dropdown_items")
                ) {
                    if (currentDropdown.classList.contains("show")) {
                        currentDropdown.classList.remove("show");
                        this.classList.remove("active");
                    } else {
                        document
                            .querySelectorAll(".rplc_dropdown_items")
                            .forEach((ul) => ul.classList.remove("show"));
                        document
                            .querySelectorAll(".rplc_dropdown > li > a")
                            .forEach((a) => a.classList.remove("active"));

                        currentDropdown.classList.add("show");
                        this.classList.add("active");
                    }
                } else {
                    document
                        .querySelectorAll(".rplc_dropdown_items")
                        .forEach((ul) => ul.classList.remove("show"));
                    document
                        .querySelectorAll(".rplc_dropdown > li > a")
                        .forEach((a) => a.classList.remove("active"));
                    // this.classList.add('active');
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".merit-menu-box").forEach((group) => {
        group.addEventListener("click", function (e) {
            // Only toggle if a menu-button was clicked
            const button = e.target.closest(".menu-button");
            if (!button) return;

            const item = button.closest(".merit-menu-item");
            if (!item || !group.contains(item)) return;

            const accordionItems = group.querySelectorAll(".merit-menu-item");

            accordionItems.forEach((c) => {
                let accordionDom = document.getElementById(
                    "past-paper-accordion",
                );
                if (accordionDom) {
                    const expandBtn = accordionDom.querySelector(".btn-expend");
                    if (expandBtn) {
                        expandBtn.textContent = "Expand All";
                    }
                }

                const dropdown = c.querySelector(".merit-menu-dropdown-box");
                const btn = c.querySelector(".merit-menu-header > button");

                if (c === item) {
                    const isVisible = dropdown.classList.contains("show");
                    dropdown.classList.toggle("show", !isVisible);
                    btn.classList.toggle("active", !isVisible);
                } else {
                    dropdown.classList.remove("show");
                    btn.classList.remove("active");
                }
            });
        });

        // Stop clicks inside dropdowns from toggling the accordion
        group
            .querySelectorAll(".merit-menu-dropdown-box")
            .forEach((dropdown) => {
                dropdown.addEventListener("click", function (e) {
                    e.stopPropagation();
                });
            });
    });
});

document.addEventListener("click", function (e) {
    if (e.target.matches(".btn-expend")) {

        const button = e.target;

        const items = document.querySelectorAll(
            ".dynamic-base > .merit-menu-header > button",
        );
        const dropdowns = document.querySelectorAll(
            ".dynamic-base > .merit-menu-dropdown-box",
        );

        const isOpen = button.textContent.trim() === "Close All";

        if (isOpen) {
            // --- CLOSE ALL ---
            button.textContent = "Expand All";

            items.forEach((elm) => elm.classList.remove("active"));
            dropdowns.forEach((elm) => elm.classList.remove("show"));
        } else {
            // --- EXPAND ALL ---
            button.textContent = "Close All";

            items.forEach((elm) => elm.classList.add("active"));
            dropdowns.forEach((elm) => elm.classList.add("show"));
        }
    }
});
