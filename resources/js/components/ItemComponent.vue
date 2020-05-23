<template>
    <b-container fluid>
        <b-row>
            <b-col>
            <h2>create an item</h2>
                <form>
                    <b-form-group id="imageGroup" label-for="image">
                        <b-form-file
                            id="image"
                            accept="image/*"
                            v-model="form.itemImage"
                            placeholder="Choose an image..."
                            @change="onImageChange"/>

                        <b-col cols="6" offset="3" style="margin-top: 1rem;">
                            <img v-if="form.url" :src="form.url" width="420" alt="uploaded image">
                        </b-col>
                    </b-form-group> 

                    <div class="form-group" >
                        <label for="itemName" >Name </label>
                        <input v-model="form.itemName" type="text"  class="form-control" >
                    </div> 
                    <div class="form-group" >
                        <label for="description" >Description </label>
                        <input v-model="form.itemDescription" type="text" id="description" class="form-control" >
                    </div>
                    
                    <div class="form-group" >
                        <label for="price" >Price </label>
                        <input v-model="form.itemPrice" type="text" id="itemPrice" class="form-control" >
                    </div> 
                    <div class="form-group" >
                        <label for="numberAvailable" >Number Available </label>
                         <input v-model="form.numberAvailable" type="number">
                    </div>

                     <button @click.prevent="createItem" class="btn btn-primary">Submit</button>
                </form>
             </b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        data(){
            return{
                form:{
                    itemName:'',
                    itemDescription:'',
                    itemImage:null,
                    itemPrice:'',
                    numberAvailable:'',
                    itemSize:'',
                    url:null,
                    sent:false
                },
            }
        },
        methods:{
            createItem(){

                console.log("INSIDE CREATE ITEM");
                // this.$v.form.$touch();

                // if (this.$v.form.$invalid) {
                    let formData = new FormData();

                    Object.keys(this.form).forEach(key => {
                        formData.append(key, this.form[key])
                    })

                    // this.$store.dispatch('formSubmit');
                    
                    axios.post("/api/items", formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(({data}) => {

                        console.log("AXIOS CALL SUCCESSFULL");
                        // this.$store.dispatch('formSuccess')
                        this.resetForm()

                    }).catch((error) => {

                        console.log("ERROR: " + error);
                        // this.$store.dispatch('formError')
                    })
                // }
            },
            resetForm() {
                /* Reset our form values */
                this.form.itemName = ''
                this.form.itemDescription = ''
                this.form.itemSize = ''
                this.form.itemPrice = ''
                this.form.numberAvailable = ''
                this.form.itemImage = null
                this.form.url = null
                

                /* reset/clear native browser form validation state */
                this.show = false
                this.$nextTick(() => {
                    this.show = true;
                    this.$router.push('/');
                })
            },
            onImageChange(e){
                const file = e.target.files[0];
                this.form.url = URL.createObjectURL(file);
                this.form.image = file;            },

        },
        mounted() {
            
        }
    }
</script>
