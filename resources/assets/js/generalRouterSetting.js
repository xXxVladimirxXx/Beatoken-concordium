export function initialize(store, router) {
    router.beforeEach((to, from, next) => {

        const currentUser = store.state.users.currentUser;
        const token = store.state.users.token;

        if(to.meta.requireAuth && (!token || !currentUser.id)) {
            next('/login');
        } else if((to.name == 'signup' || to.name == 'login') && (token && currentUser.id)) {
            next('/');
        } else {
            if (to.meta.suitableRoles && currentUser.role) {
                const role = currentUser.role.name;

                // Checking if a currentUser has a suitable role
                if (!to.meta.suitableRoles.find(el => el == role)) {
                    next('/login');
                }
            }
        }

        next();
    });

    axios.interceptors.response.use(null, (error) => {
        if (401 === error.response.status || (400 === error.response.status && 444 === error.response.data.status)) {
            store.dispatch('users/logout');
            window.location.href = "/login";
        } else if (424 === error.response.status) {
            router.push('/verification')
        } else if (426 === error.response.status) {
            router.push('/fill-user-info')
        } else {
            store.state.AppActiveUser = store.state.users.currentUser;
        }

        return Promise.reject(error);
    });
}
