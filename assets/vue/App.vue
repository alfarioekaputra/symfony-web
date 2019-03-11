<template>
    <b-container fluid>
        <b-navbar toggleable="lg" type="darkest" variant="info">
            <b-navbar-brand href="#" class="text-white">NavBar</b-navbar-brand>
            <b-navbar-toggle target="nav_collapse" />
                <b-collapse is-nav id="nav_collapse">
                    <b-navbar-nav>
                        <router-link class="nav-item" tag="li" to="/home" active-class="active">
                            <a class="nav-link text-white">Home</a>
                        </router-link>
                        <b-nav-item-dropdown text="Posts">
                            <b-dropdown-item>
                                <router-link class="nav-item" tag="li" to="/posts" active-class="active">
                                    <a class="nav-link">Index</a>
                                </router-link>
                                <router-link class="nav-item" tag="li" to="/post/create" active-class="active">
                                    <a class="nav-link">Create</a>
                                </router-link>
                            </b-dropdown-item> 
                        </b-nav-item-dropdown>
                        
                    </b-navbar-nav>

                    <!-- Right aligned nav items -->
                    <b-navbar-nav class="ml-auto">
                        
                        <b-nav-item-dropdown right v-if="isAuthenticated">
                            <!-- Using button-content slot -->
                            <template slot="button-content"><em>{{email}}</em></template>
                            <b-dropdown-item href="#">Profile</b-dropdown-item>
                            <b-dropdown-item href="/api/security/logout">Signout</b-dropdown-item>
                        </b-nav-item-dropdown>
                    </b-navbar-nav>
                </b-collapse>
        </b-navbar>
        
        <router-view></router-view>
    </b-container>
</template>

<script>
    import axios from 'axios';
    
    export default {
        name: 'app',
        created () {
            let isAuthenticated = JSON.parse(this.$parent.$el.attributes['data-is-authenticated'].value),
                roles = JSON.parse(this.$parent.$el.attributes['data-roles'].value);

            let payload = { isAuthenticated: isAuthenticated, roles: roles };
            this.$store.dispatch('security/onRefresh', payload);

            axios.interceptors.response.use(undefined, (err) => {
                return new Promise(() => {
                    if (err.response.status === 403) {
                        this.$router.push({path: '/login'})
                    } else if (err.response.status === 500) {
                        document.open();
                        document.write(err.response.data);
                        document.close();
                    }
                    throw err;
                });
            });
        },
        computed: {
            isAuthenticated () {
                return this.$store.getters['security/isAuthenticated']
            },
            email () {
                return localStorage.getItem('email');
            }
        },
    }
</script>