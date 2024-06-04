$(document).ready(function () {
	// Sidebar dropdown
	$(document).on("click", ".sub-btn", function () {
		$(this).next(".sub-menu").slideToggle();
		$(this).find(".fa-angle-right").toggleClass("rotate");
	});
});

document.addEventListener("DOMContentLoaded", function () {
	const menu = document.getElementById("menu-label");
	const sidebar = document.getElementsByClassName("sidebar")[0];

	menu.addEventListener("click", function () {
		sidebar.classList.toggle("hide");
	});
});

document.addEventListener("DOMContentLoaded", function () {
	const menuCheckbox = document.getElementById("menu-checkbox");
	const sidebarLinks = document.querySelectorAll(".sidebar a");

	sidebarLinks.forEach((link) => {
		link.addEventListener("click", () => {
			if (window.innerWidth <= 768) {
				// Hanya pada perangkat mobile
				menuCheckbox.checked = false;
			}
		});
	});
});
