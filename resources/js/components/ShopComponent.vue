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
            <div class="col-md-3" v-for="(item, index) in items" :key="item.id" style="padding-bottom: 20px">
                <div v-if="item.number_available > 0" class="card" cols='3'>
                    <div class="card-body">
                        <img v-if="item.image" :src="item.image" class="card-img-top" alt="Profile Picture"  height="300px" width="300px">
                        <h5 class="card-title">{{item.item_name}}<button class="btn btn-link"><i class="fas fa-plus"></i><i class="fas fa-shopping-cart"></i></button> </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><h5>${{item.price}}</h5></li>
                            <li class="list-group-item">{{item.description}}</li>
                            <li v-if="item.size" class="list-group-item">Size: {{item.size}}</li>
                        </ul>
                    <button v-if="isAuthenticated" @click="showUpdateItemModal(index)" class="btn btn-link" style="width:90px"><i class="far fa-edit"></i> Edit</button>
                    <button v-if="isAuthenticated" @click="deleteItem(item.id)" class="btn btn-link" style="color: red;"><i class="far fa-trash-alt"> Remove</i></button>
                    </div>
                </div>
            </div>
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
                            <input type="file" @change="updateProfile" name="image" class="form-input">
                            </div> 

                             <div class="form-group">
                                <label for="name">Item</label>
                                <input v-model="updateItem.item_name" type="text" class="form-control" name="name" id="name" />
                            </div> 
                            <div class="form-group">
                                <label for="price">price</label>
                                <input v-model="updateItem.price" type="text" class="form-control" name="name" id="price" />
                            </div>

                            <div class="form-group">
                                <label for="description">Item Description</label>
                                <input v-model="updateItem.description" type="text" class="form-control" name="description" id="description" />
                            </div>
                            <div class="form-group">
                                <label for="number_available">Number Available</label>
                                <select v-model="updateItem.number_available" class="custom-select mr-sm-2" id="numberAvailable">
                                    <option selected>Choose...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="size">Size</label>
                                <select v-model="updateItem.size" class="custom-select mr-sm-2" id="numberAvailable">
                                    <option selected>Choose...</option>
                                    <option value="sm">SM</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                                    <option value="1">size 1</option>
                                    <option value="1.5">size 1.5</option>
                                    <option value="2">size 2</option>
                                    <option value="2.5">size 2.5</option>
                                    <option value="3">size 3</option>
                                    <option value="3.5">size 3.5</option>
                                    <option value="4">size 4</option>
                                    <option value="4.5">size 4.5</option>
                                    <option value="5">size 5</option>
                                    <option value="5.5">size 5.5</option>
                                    <option value="6">size 6</option>
                                    <option value="6.5">size 6.5</option>
                                    <option value="7">size 7</option>
                                    <option value="7.5">size 7.5</option>
                                    <option value="8">size 8</option>
                                    <option value="8.5">size 8.5</option>
                                    <option value="9">size 9</option>
                                    <option value="9.5">size 9.5</option>
                                    <option value="10">sizen 10</option>
                                    <option value="10.5">size 10.5</option>
                                    <option value="11">size 11</option>
                                </select>
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
                updateItem:[]
                }
        },

        methods:{
            loadItems(){
                axios.get('/api/items/')
                .then(response =>{
                    this.items = response.data.data;
                    console.log(this.items);
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            showUpdateItemModal(index){
                // console.log(id);

                this.updateItem = [];
                $("#viewUpdateItemModal").modal("show");
                this.updateItem = this.items[index];
                console.log(this.updateItem);
                return this.updateItem;
            },
            editItem(){
                console.log(this.updateItem.id);
                axios.patch('/api/items/' + this.updateItem.id, { itemName:this.updateItem.item_name, itemDescription:this.updateItem.description, itemPrice:this.updateItem.price, itemImage:this.updateItem.image, numberAvailable:this.updateItem.number_available, itemSize:this.updateItem.size
                })
                .then(response=>{
                $("#viewUpdateItemModal").modal("hide");
                    this.loadItems();
                })
                .catch(error=>{
                    if(error.response.data.errors.name){
                        this.errors.push(error.response.data.errors.name[0]);
                    }
                    if(error.response.data.errors.body){
                        this.errors.push(error.response.data.errors.body[0]);
                    }
                });

            },
            deleteItem(id){
                if(confirm('Are you sure?')){
                axios.delete('/api/items/' + id) 
                .then(response => {
                    
                    this.$router.go()
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
</style>
