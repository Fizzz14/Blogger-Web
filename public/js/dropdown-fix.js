// // Fix  menu positioning
// document.addEventListener("DOMContentLoaded", function() {
//     const dropdownToggle = document.getElementById("navbarDropdown");
//     const dropdownMenu = document.getElementById("settings-dropdown");

//     if (dropdownToggle && dropdownMenu) {
//         // Initialize with fixed position
//         dropdownMenu.style.position = "fixed";
//         dropdownMenu.style.visibility = "hidden";
//         dropdownMenu.style.opacity = "0";
//         dropdownMenu.style.zIndex = "999999";

//         // Get the actual height of the dropdown, but cap it at max-height
//         const actualMenuHeight = dropdownMenu.offsetHeight;
//         const menuHeight = Math.min(actualMenuHeight, 300); // Use max-height value

//         dropdownToggle.addEventListener("click", function(e) {
//             e.preventDefault();
//             e.stopPropagation();

//             // Toggle visibility if already open
//             if (dropdownMenu.style.visibility === "visible") {
//                 dropdownMenu.style.visibility = "hidden";
//                 dropdownMenu.style.opacity = "0";
//                 return;
//             }

//             // Get the position of the dropdown toggle
//             const toggleRect = dropdownToggle.getBoundingClientRect();
//             const windowHeight = window.innerHeight;
//             const windowWidth = window.innerWidth;

//             // Position the dropdown
//             dropdownMenu.style.position = "fixed";
//             dropdownMenu.style.left = "auto";
//             dropdownMenu.style.right = (windowWidth - toggleRect.right) + "px";
//             dropdownMenu.style.zIndex = "999999";

//             // Check if dropdown would go beyond the viewport
//             if (toggleRect.bottom + menuHeight > windowHeight) {
//                 // Position dropdown above the toggle
//                 dropdownMenu.style.top = (toggleRect.top - menuHeight - 5) + "px";
//             } else {
//                 // Position dropdown below the toggle
//                 dropdownMenu.style.top = (toggleRect.bottom + 5) + "px";
//             }

//             // Make dropdown visible
//             dropdownMenu.style.visibility = "visible";
//             dropdownMenu.style.opacity = "1";
//             dropdownMenu.style.zIndex = "999999";
//             dropdownMenu.style.display = "block";
//         });

//         // Close dropdown when clicking outside
//         document.addEventListener("click", function(e) {
//             if (e.target !== dropdownToggle && !dropdownMenu.contains(e.target)) {
//                 dropdownMenu.style.visibility = "hidden";
//                 dropdownMenu.style.opacity = "0";
//             }
//         });
//     }
// });
