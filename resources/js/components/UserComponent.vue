<template>
    <b-container>
        <b-row>
            <b-col v-if="currentUser.role === 'admin'">
                <b-table striped hover :items="users" :fields="fields"></b-table>
            </b-col>
        </b-row>

        <b-row>
            <b-col v-if="currentUser">
                <router-link v-if="currentUser.role==='admin'" to="add-item">Add Item</router-link>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    
    import { mapActions, mapGetters } from "vuex";

    export default {
        name: 'dashboard',
        components: {
            
        },
        data() {
            return {
                users: [],

                fields: [
                    {
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'role',
                        sortable: true
                    },
                    {
                        key: 'email',
                        sortable: true
                    },
                ]
            }
        },

        computed: {
            isCurrentUser() {
            if (isAuthenticated) {
                return true;
            }

            return false;
        },
        ...mapGetters(['isAuthenticated', 'currentUser'])
        },
        methods: {
            init() {
                
            },
        },
        created() {
            axios.get('/api/users').then((response) => {
                this.users = response.data.data;
            });

            // this.$store.dispatch('refreshUserData');
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../sass/_variables.scss";   
</style>