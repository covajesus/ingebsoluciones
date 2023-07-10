import { createWebHistory, createRouter } from "vue-router";
import Account from './components/Account.vue'
import Home from './components/Home.vue'
import BranchOffice from './components/BranchOffice.vue'
import Cashier from './components/Cashier.vue'
import Setting from './components/Setting.vue'
import AddBranchOffice from './components/AddBranchOffice.vue'
import AddCashier from './components/AddCashier.vue'
import EditBranchOffice from './components/EditBranchOffice.vue'
import EditCashier from './components/EditCashier.vue'
import Collection from './components/Collection.vue'
import ShowDte from './components/ShowDte.vue'

const routes = [
    {
        name:'administrator',
        path:'/administrator',
        component: Account
    },
    {
        name:'show_dte',
        path:'/dte/show/:branch_office_id/:cashier_id/:date',
        component: ShowDte
    },
    {
        name:'collection',
        path:'/collection',
        component: Collection
    },
    {
        name:'/a',
        path:'/a',
        component: Home
    },
    {
        name:'branch_office',
        path:'/branch_office',
        component: BranchOffice
    },
    {
        name:'edit_branch_office',
        path:'/branch_office/edit/:id',
        component: EditBranchOffice
    },
    {
        name:'add_branch_office',
        path:'/add_branch_office',
        component: AddBranchOffice
    },
    {
        name:'cashier',
        path:'/cashier',
        component: Cashier
    },
    {
        name:'edit_cashier',
        path:'/cashier/edit/:id',
        component: EditCashier
    },
    {
        name:'add_cashier',
        path:'/add_cashier',
        component: AddCashier
    },
    {
        name:'setting',
        path:'/setting',
        component: Setting
    },
    {
        name:'security',
        path:'/security',
        component: Home
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router