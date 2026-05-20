document.addEventListener("click", async function (e) {

    /* NOTIFICACIONES */
    const botonNotif = document.querySelector(".notificaciones");
    const menuNotif = document.querySelector(".menu-notificaciones");
    const contadorNotif = document.querySelector(".notificaciones-numero");

    if (botonNotif && botonNotif.contains(e.target)) {

        const estabaOculto = menuNotif.classList.contains("hidden");
        menuNotif.classList.toggle("hidden");

        if (estabaOculto) {
            let respuesta = await fetch(RUTA_URL + "/notificaciones/marcarLeidas");
            if (respuesta.ok && contadorNotif) contadorNotif.remove();
        }

    } else if (!e.target.closest(".menu-notificaciones")) {
        if (menuNotif) menuNotif.classList.add("hidden");
    }

    /* ADMIN */
    const adminBtn = document.querySelector(".admin-menu");
    const adminMenu = document.querySelector(".menu-admin");

    if (adminBtn && adminBtn.contains(e.target)) {
        adminMenu.classList.toggle("hidden");
    } else if (!e.target.closest(".menu-admin")) {
        if (adminMenu) adminMenu.classList.add("hidden");
    }

});
