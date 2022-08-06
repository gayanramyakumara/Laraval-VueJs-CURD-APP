const Welcome = () => import("./components/Welcome.vue");

const OrderHistoryRequest = () => import("./components/Order/Add.vue");

const OrderHistoryList = () => import("./components/Order/List.vue");

export const routes = [
    {
        name: "home",
        path: "/",
        component: OrderHistoryRequest,
    },
    {
        name: "OrderHistoryList",
        path: "/order-history",
        component: OrderHistoryList,
    },
];
