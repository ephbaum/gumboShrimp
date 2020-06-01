<template>
    <b-container fluid>
        <div class="spacer" style="margin: 100px;"></div>
        <h1 class="brandName" style="color:green; text-align: center;" ><i class="fas fa-shopping-cart" ></i> ChangoCart</h1>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="">Cart ({{ $store.state.cartCount }})</a>
            <div v-if="$store.state.cart.length > 0" class="navbar-dropdown is-boxed is-right">
                <a v-for="item in $store.state.cart"
                    :key="item.id"
                    class="navbar-item"
                    href="">
                    {{ item.item_name }} x{{ item.quantity }} - ${{ item.totalPrice }}</a>

                <a class="navbar-item" href="">
                    Total: ${{ totalPrice }}
                </a>

                <hr class="navbar-divider">

                <a class="navbar-item" href="">
                    Checkout
                </a>
            </div>

            <div v-else class="navbar-dropdown is-boxed is-right">
                <a class="navbar-item" href="">Cart is empty</a>
            </div>
            </div>
            <h6>Items in {{ currentUser }}'s Cart: </h6>
        <b-row>
            <b-input-group class="mt-3">
                <template v-slot:append>
                    <b-button class="btn btn-success"><li class="fa fa-search"></li></b-button>
                </template>
                <b-form-input v-model="search" placeholder="search for your item..." ></b-form-input>
            </b-input-group>
        </b-row>
        <br>

        <b-row>
            <b-col xl="2" lg="3" md="4" sm="6" v-for="item in filteredItems" :key="item.id">
                <b-card v-if="item.image" :img-src="item.image" img-alt="Item image" img-height="300" img-width="300" :title="item.item_name">
                    
                    <b-row class="text-center">
                        <b-col>
                            <b-card-text style="font-size: .7em"> {{ item.description }} </b-card-text>
                        </b-col>
                    </b-row>

                    <b-row class="text-center bottom">
                        <b-col>
                            <b-card-text> ${{ item.price }} </b-card-text>
                        </b-col>
                    </b-row>
                    
                    <b-card-footer>
                        <b-row>
                            <b-col v-if="isAuthenticated">
                                <b-button v-b-popover.hover.top="'Click here to edit item'" title="EDIT ITEM" @click.prevent="showUpdateItemModal(item)" style="color: white;"><i class="far fa-edit"></i></b-button>
                            </b-col>
                        
                            <b-col v-if="isAuthenticated">
                                <b-button v-b-popover.hover.top="'Click here to DELETE item. You cannot undo this.'" title="DELETE ITEM" @click.prevent="deleteItem(item.id, item.item_name)" style="color: white;"><i class="far fa-trash-alt"></i></b-button>
                            </b-col>

                            <b-col v-if="!isAuthenticated">
                                <b-button v-b-popover.hover.top="'Click here to add this item to your cart.'" title="Add Item" @click="addToCart(item)" class="btn btn-link" style="color: white;"><i class="fas fa-shopping-cart"></i></b-button>
                            </b-col>
                        </b-row>
                    </b-card-footer>

                </b-card>
            </b-col>
        </b-row>

        
            



        <!-- View update Item Modal -->
        <b-modal id="editModal" hide-footer no-close-on-backdrop>
            <form>
                <div class="form-group">
                <label for="image" class="col-sm-2 control-label">Image</label>
                <b-form-file
                    id="image"
                    accept="image/*"
                    v-model="updateItem.itemImage"
                    placeholder="Choose an image..."
                    @change="onImageChange"/>
                </div> 

                <b-col cols="6" style="margin-top: 1rem;">
                    <img v-if="url" :src="url" width="420" alt="uploaded image">
                </b-col>

                <div class="form-group">
                    <label for="name">Item</label>
                    <input v-model="updateItem.itemName" type="text" class="form-control" id="name" />
                </div> 
                <div class="form-group">
                    <label for="price">price</label>
                    <input v-model="updateItem.itemPrice" type="text" class="form-control" id="price" />
                </div>

                <div class="form-group">
                    <label for="description">Item Description</label>
                    <input v-model="updateItem.itemDescription" type="text" class="form-control" id="description" />
                </div>
                <div class="form-group">
                    <label for="number_available">Number Available</label>
                    <input v-model="updateItem.numberAvailable" type="number" class="form-control" id="numberAvailable" />
                </div>
                <div class="form-group" v-if="updateItem.size">
                    <label for="size">Size</label>
                    <input v-model="updateItem.itemSize" type="text" class="form-control" id="size" />
                </div>
                <b-button class="mt-3" block @click.prevent="editItem">Edit Item</b-button>
            </form>
        </b-modal>
<!--  -->
    </b-container>
</template>

<script>
    import { mapGetters, mapActions } from "vuex";

    export default {
        name: 'shop',
        data(){
            return {
                search: '',
                items:[],
                updateItem:{
                    itemName:'',
                    itemDescription:'',
                    itemImage:null,
                    itemPrice:'',
                    numberAvailable:'',
                    itemSize:'',
                    sent:false
                },

                url:null,
            }
        },

        methods:{
            loadItems(){
                axios.get('/api/items')
                .then(response =>{
                    this.items = response.data.data;
                    console.log(this.items);
                    console.log("Items have successfully loaded");
                })
                .catch(error => {
                    console.log("ERROR ON LOAD ITEMS. Error-->");
                    console.log(error);
                }); 
            },
            showUpdateItemModal(item){

                this.url = item.itemImage;
                this.updateItem.itemImage = item.itemImage;
                this.updateItem.itemName = item.item_name;
                this.updateItem.itemPrice = item.price;
                this.updateItem.numberAvailable = item.number_available;
                this.updateItem.itemDescription = item.description;
                this.updateItem.id = item.id;

                this.$bvModal.show('editModal');
                
            },
            editItem(){
                console.log(this.updateItem.id);

                let formData = new FormData();

                Object.keys(this.updateItem).forEach(key => {
                    formData.append(key, this.updateItem[key])
                })
                
                formData.append('_method', 'PUT');

                let self = this;
                axios.post('/api/items/' + this.updateItem.id, formData)
                
                .then(response=>{
                    this.$bvModal.hide('editModal');
                    
                    setTimeout(this.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Success!',
                        text: "Item sucessfully updated.",
                        duration: '15000',
                        width: '100%'
                    }), 9000);
                    this.loadItems();
                })
                .catch(error=>{
                    console.log(error);
                });

            },
            deleteItem(id, name){
                if(confirm("are you sure you want to delete " + name + "?")) {
                    axios.delete('/api/items/' + id) 
                .then(({data}) => {
                    
                    setTimeout(this.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Success!',
                        text: name + " sucessfully deleted.",
                        duration: '15000',
                        width: '100%'
                    }), 15000);
                
                    this.loadItems();
                    
                })
                .catch(error =>{
                    console.log(error);
                });
                }
            },
            addToCart(item){    
                this.$store.dispatch('addToCart', item);
            },
            removeFromCart(item){
                this.$store.commit('removeFromCart', item);
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend = (file) =>{
                        this.updateItem.image = reader.result;
                        console.log(this.updateItem.image);
                        console.log("IMAGE;");
                        
                    }
                    reader.readAsDataURL(file);
                } else{
                    this.$notify({
                        group: 'notifications',
                        type: 'warning',
                        title: 'Failure',
                        text: 'File too large',
                        duration: '15000',
                        width: '100%'
                    });
                }
            },
            onImageChange(e){
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
                this.updateItem.image = file;            
            },
        },
        computed: {
            totalPrice(){
                let total = 0;
                for(let item of this.$store.state.cart){
                    total += item.totalPrice;
                    console.log(total);
                }
                return total.toFixed(2);
            },
            // cartLength(){
            //     return this.cart.length;
            // },
            filteredItems() {
                let self=this;

                if (this.search) {
                    return this.items.filter(item => item.item_name.toLowerCase().indexOf(self.search.toLowerCase())>=0);
                }
        
                return this.items;  
                
            },...mapGetters(['isAuthenticated', 'currentUser', 'cart']),
            
        },
        mounted() {
            this.loadItems();
            console.log('Shop Component mounted.')
        }
    }
</script>
<style >
    .bottom {
        position: sticky;
        top: 10;
        left: 0;
        right: 0;
    }

    .brandName {
        color: white;
    }

    .card-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .modal-backdrop {
        opacity:0; transition:opacity .8s;
    }

    .modal-backdrop.in {
        opacity:.7;
    }

    .card-body {
        flex: 1 1 auto;
        height: 300px !important;
        padding: 1.25rem;
    }
</style>
