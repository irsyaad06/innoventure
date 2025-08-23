import { createRouter, createWebHistory } from "vue-router";
import MainLayout from "../layouts/MainLayout.vue";
import BerandaPage from "../pages/BerandaPage.vue";
import MobileLegendPage from "../pages/MobileLegendPage.vue";
import WebDevelopmentPage from "../pages/WebDevelopmentPage.vue";
import Kompetisi from "../pages/Kompetisi.vue";
import GameOn from "../pages/GameOnPage.vue"
import Seminar from "../pages/SeminarPage.vue"
import DaftarSeminar from "../pages/DaftarSeminar.vue"
import SubmissionPage from "../pages/SubmissionPage.vue";

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
                path: "/seminar",
                component: Seminar,
            },
            {
                path: "/seminar/daftar",
                component: DaftarSeminar,
            },
            {
                path: "/submission",
                component: SubmissionPage,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
