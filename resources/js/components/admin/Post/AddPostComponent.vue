<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Post Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/home">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Post Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content col-md-10 offset-md-1">

            <!-- Default box -->
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title mt-2">Create New Post Form</h3>
                    <div class="card-tools">
                        <router-link :to="{ name:'post.all'}" class="btn btn-block btn-info"><i class="fas fa-list"></i> All Posts</router-link>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <form class="form-horizontal" method="post" v-on:submit.prevent="storeData" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="category" class="col-sm-3 col-form-label">Category</label>
                                <div class="col-sm-9">
                                    <select name="category" id="category" v-model="form.category" class="form-control" :class="form.errors.has('category') ? 'is-invalid':''">
                                        <option value="" selected>Select Category</option>
                                        <option v-for="(category, index) in RenderAllCategory" :key="index" :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <div v-if="form.errors.get('category')" class="text-danger" v-html="form.errors.get('category')" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" v-model="form.title" :class="form.errors.has('title') ? 'is-invalid':''" placeholder="Enter Post Title">
                                    <div v-if="form.errors.has('title')" class="text-danger" v-html="form.errors.get('title')"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Sub_title" class="col-sm-3 col-form-label">Sub Title</label>
                                <div class="col-sm-9">
                                    <input type="text" v-model="form.sub_title" id="Sub_title" :class="form.errors.has('sub_title') ? 'is-invalid':''" placeholder="Enter Sub Title" class="form-control">
                                    <div v-if="form.errors.has('sub_title')" class="text-danger" v-html="form.errors.get('sub_title')"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label" style="margin-top: 100px">Description</label>
                                <div class="cal-sm-9 ml-2">
                                    <ckeditor v-model="form.description" :config="editorconfig"></ckeditor>
                                    <div v-if="form.errors.has('description')" class="text-danger" v-html="form.errors.get('description')"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Thumbnail" style=" margin-top: 50px" class="col-form-label col-sm-3">Thumbnail</label>
                                <div style="width: 100px; margin-top: 50px">
                                    <input type="file" class="btn btn-success col fileinput-button dz-clickable" name="thumbnail" @change="loadThumbnail($event)">
                                </div>
                                <div class="col-md-3" style="margin-left: 20px">
                                    <img src="https://via.placeholder.com/150/92c952" style="width: 150px; height: 150px" class="img-fluid mb-2 LoadThumbnail"  alt="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10 text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" :class="form.errors.has('status') ? 'is-invalid':''" name="status" v-model="form.status" checked type="radio" id="Active" value="active">
                                        <label class="form-check-label" for="Active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="status" :class="form.errors.has('status') ? 'is-invalid':''" v-model="form.status" type="radio" id="Inactive" value="inactive">
                                        <label class="form-check-label" for="Inactive">Inactive</label>
                                    </div>
                                    <div v-if="form.errors.has('status')" class="text-danger" v-html="form.errors.get('status')"/>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-gray-light">
                            <button type="submit" class="btn btn-info" v-bind:disabled="form.busy">
                                <div v-if="form.busy">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div v-else><i class="fa fa-plus-circle"></i> Create</div>
                            </button>
                            <button type="reset" class="btn btn-default float-right">Reset</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script>

export default {
    name: "AddPostComponent",
    data() {
        return {
            form: new VForm({
                title: "",
                sub_title: null,
                category: null,
                thumbnail : null,
                description: null,
                status: 'active'
            }),
            editorconfig: {
                height:150,
                width:785
            }
        }
    },
    methods: {
        storeData() {
            const thisWindow = this;
            this.form.post('/post/add-post', this.form).then(response=>{
                if (response.status === 200) {
                    this.form.reset();
                    toastr.success(response.data.success);
                    this.form.description = '';
                    document.querySelector('.LoadThumbnail').src = 'https://via.placeholder.com/150/92c952';
                }
            }).catch(error => {
                let allError = this.form.errors;
            });
        },
        loadThumbnail(event){
            const Preview = document.querySelector('.LoadThumbnail');
            const thisWindow = this;
            const alloweExt = ['jpg','png', 'jpeg', 'gif'];
            const FileExt = event.target.files[0].type.split('/')[1];
            if (alloweExt.includes(FileExt)) {
                if (event.target.files) {
                    const Reader = new FileReader();
                    Reader.onload = event=> {
                        thisWindow.form.thumbnail = event.target.result;
                        Preview.src = event.target.result;
                    }
                    return Reader.readAsDataURL(event.target.files[0])
                }
            }else{
                toastr.error('You are allowed with only Jpg png jpeg and gif')
                document.querySelector('.LoadThumbnail').src = 'https://via.placeholder.com/150/92c952';
            }
        }
    },
    mounted(){
        this.$store.dispatch('RenderAllCategories');
    },
    computed: {
        RenderAllCategory(){
            return this.$store.getters.RenderCategories
        }
    }
}
</script>

<style scoped>
.fileinput-button::-webkit-file-upload-button {
    visibility: hidden;
    display: none;
}
.fileinput-button::before{
    content: 'Select Files';
}
</style>
