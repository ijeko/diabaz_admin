const routes = [

    {
        path: '/reports/',
        component: () => import('../components/reports/ReportsPage'),
        name: 'reportsPage'
    },
    {
        path: '/reports/produced/month',
        component: () => import('../components/reports/ProductionMonth'),
        name: 'producedMonth'
    },
    {
        path: '/reports/product/upload',
        component: () => import('../components/reports/ProductUploadReport'),
        name: 'productUpload'
    },
    // {
    //     path: 'produced/year',
    //     component: () => import(),
    //     name: 'producedYear'
    // },
]

export default routes;
