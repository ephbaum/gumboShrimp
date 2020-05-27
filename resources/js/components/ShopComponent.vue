<template>
    <b-container fluid>
        <div>
            <h1 class="brandName" style="color:green" ><i class="fas fa-shopping-cart" ></i> changocart</h1>
            <b-container fluid class="search">
                <b-input-group class="mt-3">
                    <template v-slot:append>
                    <button type="button" class="btn btn-success"><li class="fa fa-search"></li></button>
                    </template>
                    <b-form-input placeholder="search for your item..." ></b-form-input>
                </b-input-group>
            </b-container>
            <br>
        </div>

        <b-row>
            <b-col xl="3" lg="4" md="6" sm="12" v-for="item in items" :key="item.id" style="padding-bottom: 20px">
                <div v-if="item.number_available > 0" class="card" height="700">
                    <div class="card-body">
                        <img v-if="item.image" :src="item.image" class="card-img-top" alt="Profile Picture"  height="300px" width="300px">
                        <h5 class="card-title">{{item.item_name}}<button class="btn btn-link"><i class="fas fa-plus"></i><i class="fas fa-shopping-cart"></i></button> </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><h5>${{item.price}}</h5></li>
                            <li class="list-group-item">{{item.description}}</li>
                            <li v-if="item.size" class="list-group-item">Size: {{item.size}}</li>
                        </ul>
                    <button v-if="isAuthenticated" @click="showUpdateItemModal(item)" class="btn btn-link" style="width:90px"><i class="far fa-edit"></i> Edit</button>
                    <button v-if="isAuthenticated" @click="deleteItem(item.id, item.item_name)" class="btn btn-link" style="color: red;"><i class="far fa-trash-alt"> Remove</i></button>
                    </div>
                </div>
            </b-col>
        </b-row>

        <!-- View update Item Modal -->
        <div class="modal fade" id="viewUpdateItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            
                            Item: {{ updateItem.item_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Image</label>
                            <b-form-file
                                id="image"
                                accept="image/*"
                                v-model="updateItem.image"
                                placeholder="Choose an image..."
                                @change="onImageChange"/>
                            </div> 

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
                                <input v-model="updateItem.itemDescription" type="text" class="form-control" name="description" id="description" />
                            </div>
                            <div class="form-group">
                                <label for="number_available">Number Available</label>
                            </div>
                            <div class="form-group">
                                <label for="size">Size</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button @click="editItem" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> 
<!--  -->
    </b-container>
</template>

<script>
import { mapActions, mapGetters} from "vuex"


    export default {
        name: 'shop',
        components:{


        },
        computed: mapGetters(['isAuthenticated', 'currentUser']),
        isCurrentUser() {
            if (isAuthenticated) {
                return currentUser
            }

            return false;
        },
        data(){
            return {
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

                this.updateItem.itemName = item.item_name;
                this.updateItem.itemPrice = item.price;
                this.updateItem.numberAvailable = item.number_available;
                this.updateItem.itemDescription = item.description;
                this.updateItem.id = item.id;


                // this.updatedItem.itemDescription = item.itemDescription;

                $("#viewUpdateItemModal").modal("show");
                
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
                    $("#viewUpdateItemModal").modal("hide");
                    
                    setTimeout(this.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Success!',
                        text: "Item sucessfully updated.",
                        duration: '15000',
                        width: '100%'
                    }), 15000);
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
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'you are updloading a large file'
                    })
                }
            },
            onImageChange(e){
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
                this.updateItem.image = file;            
            },
        },
        mounted() {
            this.loadItems();
            console.log('Component mounted.')
        }
    }
</script>
<style >
    .brandName{
        color: white;
    }

    .card-body {
        height: 700px !important;
    }
</style>
