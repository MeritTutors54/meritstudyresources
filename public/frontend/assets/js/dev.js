/* jshint esversion: 6 */
console.log('running from dev.script');

// All-Resources Page Left site Dropdown
document.addEventListener('DOMContentLoaded', function () {
    const menuLinks = document.querySelectorAll('.rplc_dropdown > li > a');
    const activeLink = document.querySelector('.rplc_dropdown > li > a.active');
    if (activeLink) {
        let parentLi = activeLink.parentElement;
        let dropdown = parentLi.querySelector('.rplc_dropdown_items');

        if (dropdown && dropdown.querySelector('li')) {
            dropdown.classList.add('show');
        }
    }
    menuLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            if (!e.target.matches('a.link')) {
                e.preventDefault();
                const currentDropdown = this.nextElementSibling;

                if (currentDropdown && currentDropdown.classList.contains('rplc_dropdown_items')) {
                    if (currentDropdown.classList.contains('show')) {
                        currentDropdown.classList.remove('show');
                        this.classList.remove('active');
                    } else {
                        document.querySelectorAll('.rplc_dropdown_items').forEach(ul => ul.classList.remove('show'));
                        document.querySelectorAll('.rplc_dropdown > li > a').forEach(a => a.classList.remove('active'));

                        currentDropdown.classList.add('show');
                        this.classList.add('active');
                    }
                } else {
                    document.querySelectorAll('.rplc_dropdown_items').forEach(ul => ul.classList.remove('show'));
                    document.querySelectorAll('.rplc_dropdown > li > a').forEach(a => a.classList.remove('active'));
                    // this.classList.add('active');
                }
            }
        });
    });
});

// Manipulating accordions

// document.addEventListener('DOMContentLoaded', function () {
//     const accordionDivs = document.querySelectorAll('.merit-menu-box > .merit-menu-item');
//
//     accordionDivs.forEach(accordion => {
//         accordion.addEventListener('click', function () {
//             let id = accordion.querySelector('.menu-button').getAttribute('data-area-id');
//             document.getElementById(id).classList.add('show');
//
//             document.querySelectorAll('.merit-menu-item').forEach(c => {
//                 if (c !== accordion) {
//                     c.querySelector('.merit-menu-header > button').classList.remove('active');
//                     c.querySelector('.merit-menu-dropdown-box').classList.remove('show');
//                 }
//             });
//
//         });
//     });
//
//     // console.log(accordionDivs);
// });

// document.addEventListener('DOMContentLoaded', function () {
//     const accordionGroups = document.querySelectorAll('.merit-menu-box');
//
//     console.log('dom loaded');
//
//     accordionGroups.forEach(group => {
//         const accordionItems = group.querySelectorAll('.merit-menu-item');
//
//         accordionItems.forEach(item => {
//             item.addEventListener('click', function () {
//
//                 console.log('this has a click');
//
//                 accordionItems.forEach(c => {
//                     const dropdown = c.querySelector('.merit-menu-dropdown-box');
//                     const button = c.querySelector('.merit-menu-header > button');
//
//                     if (c === item) {
//                         const isVisible = dropdown.classList.contains('show');
//                         dropdown.classList.toggle('show', !isVisible);
//                         button.classList.toggle('active', !isVisible);
//                     } else {
//                         dropdown.classList.remove('show');
//                         button.classList.remove('active');
//                     }
//                 });
//             });
//
//             const dropdown = item.querySelector('.merit-menu-dropdown-box');
//             dropdown.addEventListener('click', function (e) {
//                 e.stopPropagation();
//             });
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    console.log('dom loaded');

    document.querySelectorAll('.merit-menu-box').forEach(group => {
        group.addEventListener('click', function (e) {
            // Only toggle if a menu-button was clicked
            const button = e.target.closest('.menu-button');
            if (!button) return;

            const item = button.closest('.merit-menu-item');
            if (!item || !group.contains(item)) return;

            console.log('item clicked:', item);

            const accordionItems = group.querySelectorAll('.merit-menu-item');

            accordionItems.forEach(c => {
                const dropdown = c.querySelector('.merit-menu-dropdown-box');
                const btn = c.querySelector('.merit-menu-header > button');

                if (c === item) {
                    const isVisible = dropdown.classList.contains('show');
                    dropdown.classList.toggle('show', !isVisible);
                    btn.classList.toggle('active', !isVisible);
                } else {
                    dropdown.classList.remove('show');
                    btn.classList.remove('active');
                }
            });
        });

        // Stop clicks inside dropdowns from toggling the accordion
        group.querySelectorAll('.merit-menu-dropdown-box').forEach(dropdown => {
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    });
});

document.addEventListener('click', function (e) {
    if (e.target.matches('.btn-expend')) {
        console.log('Dynamic button clicked:', e.target);

        const items = document.querySelectorAll('.dynamic-base > .merit-menu-header > button');
        items.forEach((elm) => {
            elm.classList.add('active');
        });

        const dropdowns = document.querySelectorAll('.dynamic-base > .merit-menu-dropdown-box');
        console.log('box: ', dropdowns);
        dropdowns.forEach((elm) => {
            elm.classList.add('show');
        });
    }
});





