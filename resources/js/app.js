import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("mobile-menu-button");
    const menu = document.getElementById("mobile-menu");
    const mobileLinks = document.querySelectorAll(".mobile-link");

    if (btn && menu) {
        btn.addEventListener("click", () => {
            if (menu.classList.contains("hidden")) {
                menu.classList.remove("hidden");
                menu.classList.add("flex");
            } else {
                menu.classList.remove("flex");
                menu.classList.add("hidden");
            }
        });
    }

    mobileLinks.forEach((link) => {
        link.addEventListener("click", () => {
            menu.classList.add("hidden");
            menu.classList.remove("flex");
        });
    });
});

// expand / collapse FAQ
document.addEventListener("DOMContentLoaded", () => {
    const faqCards = document.querySelectorAll(".faq-card-container");

    faqCards.forEach((card) => {
        card.addEventListener("click", function () {
            const content = this.querySelector(".faq-content");
            const icon = this.querySelector(".faq-icon");

            if (content.style.gridTemplateRows === "1fr") {
                content.style.gridTemplateRows = "0fr";
                icon.classList.remove("rotate-180");
            } else {
                content.style.gridTemplateRows = "1fr";
                icon.classList.add("rotate-180");
            }
        });
    });
});

window.switchTab = function (tab) {
    const tabReservasi = document.getElementById("tabReservasi");
    const tabTransaksi = document.getElementById("tabTransaksi");
    const tipePencarian = document.getElementById("tipePencarian");
    const inputField = document.getElementById("inputField");

    const iconTransaksi = document.getElementById("iconTransaksi");
    const iconReservasi = document.getElementById("iconReservasi");

    if (!tabReservasi || !tabTransaksi || !tipePencarian || !inputField) return;

    const activeClasses = ["bg-ajeng-pink", "text-white", "shadow-sm"];
    const inactiveClasses = ["text-slate-500", "hover:text-slate-700"];

    if (tab === "reservasi") {
        tabReservasi.classList.add(...activeClasses);
        tabReservasi.classList.remove(...inactiveClasses);
        tabReservasi.setAttribute("aria-selected", "true");

        tabTransaksi.classList.remove(...activeClasses);
        tabTransaksi.classList.add(...inactiveClasses);
        tabTransaksi.setAttribute("aria-selected", "false");

        inputField.placeholder = "Masukkan nomor telepon WhatsApp";
        inputField.type = "number";

        if (iconTransaksi && iconReservasi) {
            iconTransaksi.classList.add("hidden");
            iconTransaksi.classList.remove("block");

            iconReservasi.classList.remove("hidden");
            iconReservasi.classList.add("block");
        }
    } else {
        tabTransaksi.classList.add(...activeClasses);
        tabTransaksi.classList.remove(...inactiveClasses);
        tabTransaksi.setAttribute("aria-selected", "true");

        tabReservasi.classList.remove(...activeClasses);
        tabReservasi.classList.add(...inactiveClasses);
        tabReservasi.setAttribute("aria-selected", "false");

        inputField.placeholder = "Invoice ID pesanan kamu";
        inputField.type = "text";

        if (iconTransaksi && iconReservasi) {
            iconReservasi.classList.add("hidden");
            iconReservasi.classList.remove("block");

            iconTransaksi.classList.remove("hidden");
            iconTransaksi.classList.add("block");
        }
    }

    tipePencarian.value = tab;
};

document.addEventListener("DOMContentLoaded", () => {
    const tipePencarian = document.getElementById("tipePencarian");
    if (tipePencarian) {
        window.switchTab(tipePencarian.value);
    }
});
