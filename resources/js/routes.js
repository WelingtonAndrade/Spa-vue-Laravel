const Hooks = () =>import("../components/basics/Hooks");

const Home = () => import('../components/pages/Home')




export const routes = [
    {
        name: 'home',
        path: '/home',
        component: Home
    },
    //
    {
        name: 'hooks',
        path: '/hooks',
        component: Hooks
    },
]
