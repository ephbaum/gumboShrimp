<template>
    <div class="container">
        <div>
            <h1>CB Store</h1>
            <form role="search" action="." data-radium="true" style="display: flex; flex-wrap: nowrap; border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.16) 0px 0px 0px 1px;"><input autocorrect="off" autocapitalize="off" type="search" placeholder="search for your item..." aria-controls="dropdown-container" aria-autocomplete="both" data-radium="true" value="" style="border-radius: 5px 0px 0px 5px; flex-grow: 1; height: 36px; margin-bottom: 0px; font-size: 16px; background-color: rgb(247, 247, 247); -webkit-appearance: none; line-height: normal;"><button  data-radium="true" style="touch-action: manipulation; cursor: pointer; border: 1px solid transparent; border-radius: 0px 5px 5px 0px; font-weight: 600; white-space: nowrap; user-select: none; -webkit-font-smoothing: antialiased; background-image: none; display: inline-flex; align-items: center; padding-left: 16px; padding-right: 16px; font-size: 16px; height: 36px; background-color: rgb(67, 176, 42); color: rgb(255, 255, 255); width: 50px;"><i aria-hidden="true" data-radium="true" style="font-size: 16px; position: relative; font-family: ic-icons; font-style: normal; font-weight: normal; font-variant: normal; text-transform: none; speak: none; line-height: 1;"></i><span data-radium="true" style="margin-right: 8px;"></span></button></form>
            <br>
        </div>
        <div class="row" >
            <div class="col-md-4 " v-for="item in items" :key="item.id" style="padding-bottom: 20px" >
                <div class="card" cols='3' >
                    <div class="card-body"  >
                        <img :src="item.image" class="card-img-top" alt="Profile Picture"  height="300px" width="300px">
                        <h5 class="card-title">{{item.item_name}}<button class="btn btn-link"><i class="fas fa-plus"></i><i class="fas fa-shopping-cart"></i></button> </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><h5>Price:${{item.price}}</h5></li>
                            <li class="list-group-item">Item Description: {{item.description}}</li>
                            <li class="list-group-item">Number Available: {{item. number_available}}</li>
                            <li class="list-group-item">Size: {{item.size}}</li>
                            <li class="list-group-item">item id: {{item.id}}</li>
                        </ul>

                    <button @click="showUpdateItemModal(item.id)" class="btn btn-link" style="width:90px"><i class="far fa-edit"  ></i> Edit</button>
                    <button @click="deleteItem(item.id)" class="btn btn-link" style="color: red;"><i class="far fa-trash-alt"> Remove</i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View update Item Modal -->
        <div class="modal fade" id="viewUpdateItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Item: {{ updateItem.item_name }}</h5>
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                items:[],
                url:'http://localhost:8000/api/items/',
                updateItem:[]
                }
        },

        methods:{
            loadItems(){
                axios.get(this.url)
                .then(response =>{
                    this.items = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                }); 
            },
            showUpdateItemModal(index){
                // console.log(id);
                this.updateItem = [];
                $("#viewUpdateItemModal").modal("show");
                this.updateItem = this.items[index -1];
            },
            editItem(){

            },
            deleteItem(index){
                axios.delete('http://localhost:8000/api/items/' + this.items[index -1].id) 
                .then(response =>{
                    this.$delete(this.items, index);
                    this.loadItems();
                })
                .catch(error =>{
                    console.log(error);
                });

            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend = (file) =>{
                        this.updateItem.image = reader.result;
                        console.log(this.updateItem.image);
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

</style>
