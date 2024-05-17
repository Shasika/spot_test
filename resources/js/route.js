import Vue from 'vue';
import VueRouter from 'vue-router';
import AdminDashboard from "./components/dashboards/AdminDashboard";
import Welcome from "./components/Welcome";

Vue.use(VueRouter);

export default new VueRouter({
    routes :[
        {
            name: 'AdminDashboard',
            path:'/user-dashboard' ,
            component : AdminDashboard
        },
        {
            name: 'Welcome',
            path:'/' ,
            component : Welcome,
        },
    ],

    mode:'history'
});
