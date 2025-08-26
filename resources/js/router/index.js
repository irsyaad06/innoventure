import { createRouter, createWebHistory } from "vue-router";
import { useJuriStore } from "../stores/juriStore";
import MainLayout from "../layouts/MainLayout.vue";
import BerandaPage from "../pages/BerandaPage.vue";
import MobileLegendPage from "../pages/MobileLegendPage.vue";
import WebDevelopmentPage from "../pages/WebDevelopmentPage.vue";
import Kompetisi from "../pages/Kompetisi.vue";
import GameOn from "../pages/GameOnPage.vue";
import Seminar from "../pages/SeminarPage.vue";
import DaftarSeminar from "../pages/DaftarSeminar.vue";
import SubmissionPage from "../pages/SubmissionPage.vue";
import StatusUndianPage from "../pages/StatusUndianPage.vue";
import DaftarLomba from "../pages/DaftarLomba.vue";
import DetailWebDev from "../pages/DetailWebDev.vue";
import JuriLogin from "../pages/LoginJuri.vue";
import InfoJuri from "../pages/InfoJuri.vue";

const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            {
                path: "/",
                component: BerandaPage,
            },

            {
                path: "/kompetisi",
                component: Kompetisi,
            },

            {
                path: "/kompetisi/mobile-legend",
                component: MobileLegendPage,
            },

            {
                path: "/kompetisi/web-development",
                component: WebDevelopmentPage,
            },

            {
                path: "/game-on",
                component: GameOn,
            },

            {
                path: "/detail-web/:id",
                component: DetailWebDev,
            },

            {
                path: "/seminar",
                component: Seminar,
            },
            {
                path: "/seminar/daftar",
                component: DaftarSeminar,
            },
            {
                path: "/seminar/:kode_absen",
                name: "StatusUndian",
                component: StatusUndianPage,
            },
            {
                path: "/submission",
                component: SubmissionPage,
            },
            {
                path: "/daftar",
                component: DaftarLomba,
            },

            {
                path: "/login",
                name: "Login",
                component: JuriLogin,
            },
            {
                path: "/info-juri",
                name: "InfoJuri",
                component: InfoJuri,
                meta: { requiresAuth: true },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const juriStore = useJuriStore();

    // Wait for initial session check to complete
    await juriStore.waitForInitialization();

    // Check if route requires authentication
    if (to.meta.requiresAuth) {
        if (!juriStore.isAuthenticated) {
            // Redirect to login if not authenticated
            next({ name: "Login" });
            return;
        }
    } else if (to.name === "Login" && juriStore.isAuthenticated) {
        // Redirect to info-juri if already logged in and trying to access login
        next({ name: "InfoJuri" });
        return;
    }

    // Continue navigation
    next();
});
export default router;
