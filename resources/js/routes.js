const Welcome = () =>
    import(
        "./components/Welcome.vue"
    );

const SalesTeamList = () =>
    import(
        "./components/SalesTeam/List.vue"
    );

const SalesTeamEdit      = () =>
    import(
        "./components/SalesTeam/Edit.vue"
    );

export const routes = [
    {
        name: "home",
        path: "/",
        component: Welcome,
    },
    {
        name: "SalesTeamList",
        path : "/sales-team",
        component: SalesTeamList,
    },
    {
        name: "SalesTeamEdit",
        path: "/sales-team/:id/edit",
        component: SalesTeamEdit,
    },
];
