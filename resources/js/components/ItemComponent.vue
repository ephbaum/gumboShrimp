<template>
    <div class="container">
        <div class="row">
             <div class="col-md-6 col-md-offset-3">
            <h2>create an item</h2>
                <form >
                    <div class="form-group" >
                        <label for="itemName" >Name </label>
                        <input v-model="item.itemName" type="text"  class="form-control" >
                    </div> 
                    <div class="form-group" >
                        <label for="description" >Description </label>
                        <input v-model="item.itemDescription" type="text" id="description" class="form-control" >
                    </div>
                    <!-- <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Image</label>
                            <input type="file" @change="updateProfile" name="image" class="form-input">
                    </div>  -->
                    <div class="form-group" >
                        <label for="price" >Price </label>
                        <input v-model="item.itemPrice" type="text" id="price" class="form-control" >
                    </div> 
                    <div class="form-group" >
                        <label for="numberAvailable" >Number Available </label>
                         <select v-model="item.numberAvailable" class="custom-select mr-sm-2" id="numberAvailable">
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
                    <div class="form-group" >
                        <label for="size" >Size </label>
                         <select v-model="item.itemSize" class="custom-select mr-sm-2" id="numberAvailable">
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
                     <button @click="createItem" class="btn btn-primary">Submit</button>
                </form>
             </div>
        </div>


    </div>
</template>

<script>
    export default {
        data(){
            return{
                item:{
                    itemName:'',
                    itemDescription:'',
                    itemImage:null,
                    itemPrice:'',
                    numberAvailable:'',
                    itemSize:''
                },
                items:[],
                url:'http://localhost:8000/api/items/',
            }
        },
        methods:{
            createItem(){
                axios.post(this.url, {
                    iteName:this.item.ItemName, itemDescription:this.item.itemDescription, itemImage:this.item.itemImage, itemPrice:this.item.itemPrice, numberAvailable:this.item.numberAvailable, itemSize:this.item.itemSize})
                .then(response=>{
                    this.items.push(response.data);
                }).catch(error=>{
                    console.log(error);
                });
            },
            resetItemForm(){
                this.item.itemName = '',
                this.item.itemDescription = '',
                this.item.itemPrice = '',
                this.item.numberAvailable = '',
                this.item.itemPize = ''
            }

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
