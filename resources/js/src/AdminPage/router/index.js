import Vue from 'vue'
import VueRouter from 'vue-router'
/* Layouts */
const VerticleLayout = () => import('../layouts/VerticleLayout')
const Default = () => import('../layouts/BlankLayout')
const AuthLayout = () => import('../layouts/AuthLayouts/AuthLayout')
const HorizantalLayout = () => import('../layouts/HorizantalLayout')

/* Simplistic*/
const SignInComponent = () => import('../views/AuthPages/Simplistic/SignIn')
const SignUpComponent = () => import('../views/AuthPages/Simplistic/SignUp')
const RecoverPassword1 = () => import('../views/AuthPages/Simplistic/RecoverPassword1')
const LockScreen1 = () => import('../views/AuthPages/Simplistic/LockScreen1')
const ConfirmMail1 = () => import('../views/AuthPages/Simplistic/ConfirmMail1')
const Callback = () => import('../views/AuthPages/Simplistic/Callback')

/* 
const Dashboard2 = () => import('../views/Dashboards/Dashboard2.vue')
Dashboards View */
//const Dashboard1 = () => import('../views/AdminClient/Dashboards/Dashboard1.vue')
const Dashboard1 = () => import('../views/Dashboards/Dashboard1.vue')
const Dashboard2 = () => import('../views/Dashboards/Dashboard2.vue')
const Dashboard3 = () => import('../views/Dashboards/Dashboard3')
const Dashboard4 = () => import('../views/Dashboards/Dashboard4')
const Dashboard5 = () => import('../views/Dashboards/Dashboard5')
const Dashboard6 = () => import('../views/Dashboards/Dashboard6')


/* Users */
const Users = () => import('../views/Users/List.vue')
const UserElement = () => import('../views/Users/Element.vue')


/* Tables Views */
const TablesBasic = () => import('../views/Tables/TablesBasic')
const EditableTable = () => import('../views/Tables/EditableTable')
/* Charts View */
const ApexCharts = () => import(/* webpackPrefetch: true */ /* webpackChunkName: "ApexChart" */ '../views/Charts/ApexCharts')
const AmCharts = () => import(/* webpackPrefetch: true */ /* webpackChunkName: "AmCharts" */'../views/Charts/AmCharts')
const HighCharts = () => import(/* webpackPrefetch: true */ /* webpackChunkName: "HighCharts" */'../views/Charts/HighCharts')

/* Form View */
const FormLayout = () => import('../views/Forms/FormLayout')
const FormValidates = () => import('../views/Forms/FormValidates')
const FormSwitches = () => import('../views/Forms/FormSwitches')
const FormRadios = () => import('../views/Forms/FormRadios')
const FormCheckboxes = () => import('../views/Forms/FormCheckboxes')
 

Vue.use(VueRouter)

const childRoutes = (prop) => [
  /**/
  {
    path: '/home-1',
    name: prop + '.home-1',
    meta: { auth: false, name: 'Home 1', layout: 'mini-sidebar-right-fix' },
    component: Dashboard1
  },
  {
    path: 'dashboard-clients',
    name: prop + '.dashboard-clients',
    meta: { auth: false, name: 'dashboard-clients' },
    component: Dashboard2 
  },
  /**/
  {
    path: 'home-5',
    name: prop + '.home-5',
    meta: { auth: false, name: 'Home 5', layout: 'two-sidebar' },
    component: Dashboard5
  },
  {
    path: 'home-6',
    name: prop + '.home-6',
    meta: { auth: false, name: 'Home 6', layout: 'icon-with-text' },
    component: Dashboard6
  }
]
const dashboardChildRoutes = (prop) => [
  /**/
  {
    path: '/dashboard-sales',
    name: prop + '.dashboard-sales',
    meta: { auth: false, name: 'dashboard Sales', layout: 'mini-sidebar-right-fix' },
    component: Dashboard2
  },
  {
    path: '/dashboard-clients',
    name: prop + '.dashboard-clients',
    meta: { auth: false, name: 'dashboard  Clients' },
    component: Dashboard5
  },
]



/* */
const horizontalRoute = (prop) => [
  {
    path: 'home-3',
    name: prop + '.home-3',
    meta: { auth: false, name: 'Home 3', layout: 'nav-with-menu' },
    component: Dashboard3
  },
  {
    path: 'home-4',
    name: prop + '.home-4',
    meta: { auth: false, name: 'Home 4', layout: 'nav-bottom-menu' },
    component: Dashboard4
  }
]

const tableChildRoute = (prop) => [
  {
    path: 'tables-basic',
    name: prop + '.basic',
    meta: { auth: true, name: 'Basic' },
    component: TablesBasic
  },
  {
    path: 'editable',
    name: prop + '.editable',
    meta: { auth: true, name: 'Editable' },
    component: EditableTable
  }
]

const authChildRoutes = (prop) => [
  {
    path: 'login',
    name: prop + '.login',
    meta: { auth: true },
    component: SignInComponent
  },
  {
    path: 'sign-up',
    name: prop + '.sign-up',
    meta: { auth: true },
    component: SignUpComponent
  },
  {
    path: 'password-reset1',
    name: prop + '.password-reset1',
    meta: { auth: true },
    component: RecoverPassword1
  },
  {
    path: 'lock-screen1',
    name: prop + '.lock-screen1',
    meta: { auth: true },
    component: LockScreen1
  },
  {
    path: 'confirm-mail1',
    name: prop + '.confirm-mail1',
    meta: { auth: true },
    component: ConfirmMail1
  }
]

const userChildRoute = (prop) => [
  {
    path: 'users-list',
    name: prop + '.users-list',
    meta: { auth: true, name: 'Lista de Usuarios' },
    component: Users
  },
  {
    path: 'user-element',
    name: prop + '.user-element',
    meta: { auth: true, name: 'Usuarios' },
    component: UserElement 
  },
  
]


const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: VerticleLayout,
    meta: { auth: true },
    children: childRoutes('dashboard')
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: VerticleLayout,
    meta: { auth: true },
    children: dashboardChildRoutes('dashboard')
  },

  {
    path: '/menu-design',
    name: 'horizontal-dashboard',
    component: HorizantalLayout,
    meta: { auth: true },
    children: horizontalRoute('dashboard')
  },
  
  {
    path: '/table',
    name: 'table',
    component: VerticleLayout,
    meta: { auth: true },
    children: tableChildRoute('table')
  },
  
  {
    path: '/auth',
    name: 'auth',
    component: AuthLayout,
    meta: { auth: true },
    children: authChildRoutes('auth')
  },
  
  {
    path: '/user',
    name: 'user',
    component: VerticleLayout,
    meta: { auth: true },
    children: userChildRoute('users')
  },
  
 
  
  {
    path: '/callback',
    name: 'callback',
    meta: { auth: false },
    component: Callback
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.MIX_SENTRY_DSN_ADMIN,
  routes
})

router.beforeEach((to, from, next) => {
  const publicPages = ['/auth/login', '/auth/sign-up', '/dark/auth/sign-in1', '/dark/auth/sign-up']
  if (publicPages.includes(to.path)) {
    localStorage.removeItem('user')
    localStorage.removeItem('access_token')
  }
  const authRequired = !publicPages.includes(to.path)
  const loggedIn = localStorage.getItem('user')
  if (to.meta.auth) {
    if (authRequired && loggedIn === null) {
      return next('/auth/login')
    } else if (to.name === 'dashboard' || to.name === 'mini.dashboard') {
      return next('/user/users-list')
      //return next('/dashboard-sales')
      //return next('/dashboard/dashboard-sales')
    }
  } 
  next()
})

export default router
