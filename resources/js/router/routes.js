const routes = [
    {
        path: '/reports/produced/month',
        component: () => import('../components/reports/ProductionMonth'),
        name: 'producedMonth'
    },
    // {
    //     path: 'produced/year',
    //     component: () => import(),
    //     name: 'producedYear'
    // },
]

export default routes;
