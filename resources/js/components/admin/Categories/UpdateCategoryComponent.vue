<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/home">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Category Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content col-md-8 offset-md-2">

            <!-- Default box -->
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title mt-2">Update Category Form</h3>
                    <div class="card-tools">
                        <router-link to="/categories" class="btn btn-block btn-info"><i class="fas fa-list"></i> Categories</router-link>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <form class="form-horizontal" method="post" v-on:submit.prevent="UpdateData">
                        <div class="card-body col-md-10">
                            <div class="form-group row">
                                <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="categoryName" v-model="form.name" :class="form.errors.has('name') ? 'is-invalid':''" placeholder="Update Category Name">
                                    <div v-if="form.errors.has('name')" class="text-danger" v-html="form.errors.get('name')"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10 text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" :class="form.errors.has('status') ? 'is-invalid':''" name="status" v-model="form.status" checked type="radio" id="Active" value="Active">
                                        <label class="form-check-label" for="Active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="status" :class="form.errors.has('status') ? 'is-invalid':''" v-model="form.status" type="radio" id="Inactive" value="Inactive">
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
                                <div v-else><i class="fa fa-plus"></i> Update</div>
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
    name: "UpdateCategoryComponent",
    data() {
        return {
            form: new VForm({
                id: "",
                name: "",
                status: ''
            })
        }
    },
    methods: {
        getCategory() {
            axios.post('/category-update/' + this.$route.params.slug).then((res) => {
                this.form.fill(res.data.category);
            }).catch(Error => {
                console.log(Error);
            });
        },
        UpdateData() {
            axios.post('/category-update', this.form).then((res) => {
                toastr.success(res.data.success)
                return this.$router.push('/categories')
            })
        }
    },
    mounted() {
        this.getCategory();
    }
}
</script>

<style scoped>

</style>
