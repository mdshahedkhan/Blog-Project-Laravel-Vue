<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category Page</h1>
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
                    <h3 class="card-title mt-2">Create New Category Form</h3>
                    <div class="card-tools">
                        <router-link to="/categories" class="btn btn-block btn-info"><i class="fas fa-list"></i> Categories</router-link>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <form class="form-horizontal" method="post" v-on:submit.prevent="storeData">
                        <div class="card-body col-md-10">
                            <div class="form-group row">
                                <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="categoryName" v-model="form.name" :class="form.errors.has('name') ? 'is-invalid':''" placeholder="Enter Category Name">
                                    <div v-if="form.errors.has('name')" class="text-danger" v-html="form.errors.get('name')"/>
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
    name: "Add-CategoryComponent",
    data() {
        return {
            name: "Shahed Khan",
            form: new VForm({
                name: "",
                status: 'active'
            })
        }
    },
    methods: {
        storeData() {
            this.form.post('/add-category')
                .then((res) => {
                    console.log(res)
                    Toast.fire({
                        icon: 'success',
                        title: res.data.messages
                    });
                    this.form.name = null
                    toastr.success(res.data.messages)

                });
        }
    }
}
</script>

<style scoped>

</style>
