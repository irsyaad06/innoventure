import { createRouter, createWebHistory } from "vue-router";
import MainLayout from "../layouts/MainLayout.vue";
import BerandaPage from "../pages/BerandaPage.vue";
// import CabangLombaPage from "../pages/CabangLombaPage.vue";
// import TestTailwindPage from "../pages/TestTailwindPage.vue";

const routes = [
    {
        path: "/",
        component: MainLayout,
        children: [
            { path: "beranda", component: BerandaPage },
            // {
            //     path: "/kompetisi/:slug",
            //     component: CabangLombaPage,
            //     props: true,
            // },
            // { path: "/test-tailwind", component: TestTailwindPage },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
