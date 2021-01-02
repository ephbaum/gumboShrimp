<template>
 <b-container fluid class="container-box">
<b-row id="card-body">
            <b-col lg="3" md="4" sm="6" v-for="order in orders" :key="order.id">
                <b-card class="fadeIn">
                    
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em"> Order Id: {{ order.id }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em">Name: {{ order.name }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em">Email: {{ order.email }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em"> Address: {{ order.address }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em"> City: {{ order.city }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em"> State: {{ order.state }} </b-card-text>
                        </b-col>
                    </b-row>
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em">Zip: {{ order.zip }} </b-card-text>
                        </b-col>
                    </b-row>

                    <b-row class="text-center bottom">
                        <b-col>

                            <b-card-text>amount: {{ order.amount }} </b-card-text>

                            
                        </b-col>
                    </b-row>
                    
                    <b-card-footer>

                    </b-card-footer>
                </b-card>
            </b-col>
        </b-row>

</b-container>
    
</template>


<script>
    import { mapGetters, mapActions } from "vuex";
    export default {
        data(){
            return {
                orders:[]
            }
        },

        methods: {
            loadOrders(){
                axios.get('/api/orders')
                .then(response =>{
                    this.orders = response.data.data;
                    console.log(this.orders);
                })
                .catch(error =>{
                    console.log(error);
                });
            }
        },

        computed: {
            

        },
        mounted() {
            this.loadOrders();
            console.log('shop component mounted');
        }

    
}
</script>