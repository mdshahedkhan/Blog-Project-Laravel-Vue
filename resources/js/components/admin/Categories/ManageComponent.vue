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
                    <h3 class="card-title mt-2">All Categories</h3>
                    <div class="card-tools">
                        <router-link to="/add-category" class="btn btn-block btn-info"><i class="fa fa-plus-circle"></i> Add Category</router-link>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" v-bind:disabled="DataEmpty()" :checked="selected.length < 1 ? true:false" @click="selectedAll" v-model="SelectAll" id="checkboxSuccess1">
                                        <label for="checkboxSuccess1">
                                        </label>
                                    </div>
                                </th>
                                <th style="width: 10px">#Sl</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in GetCategory" :key="index">
                                <td>
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" :checked="SelectAll" :id="category.id" :value="category.id" v-model="selected">
                                        <label :for="category.id">
                                        </label>
                                    </div>
                                </td>
                                <td>{{ index + 1 }}.</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.name | slug }}</td>
                                <td>
                                    <span class="badge" :class="StatusColorType(category.status)">{{ category.status }}</span>
                                    <input type="checkbox" :checked="category.status == 'Active' ? true:false" @click="statusChange(category.id)">
                                </td>
                                <td class="text-capitalize">{{ category.created_at | timeMoment }} / {{ category.created_at | time }}</td>
                                <td class="d-flex">
                                    <router-link :to="{ name: 'category_update', params: { slug: category.slug }}" class="btn btn-outline-info btn btn-xs mr-1"><i class="fas fa-edit"></i></router-link>
                                    <a href="javascript:" v-on:click="removeTask(category.id)" class="btn btn-outline-danger btn btn-xs"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr v-if="!DataEmpty()">
                                <td colspan="7">
                                    <div>
                                        <button :disabled="!SelectAll" v-bind:disabled="selected.length < 1 ? true:false" type="button" class="btn btn-default dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">Action
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <button class="dropdown-item" @click="ActiveItems(selected)">Active</button>
                                            <button class="dropdown-item" @click="InactiveItems(selected)">Inactive</button>
                                            <button @click="removeItems(selected)" class="dropdown-item">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="DataEmpty()">
                                <td colspan="7" class="text-danger text-center">Data Not Found!</td>
                            </tr>
                        </tbody>
                    </table>
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
    name: "ManageComponent",
    data() {
        return {
            selected: [],
            SelectAll: false,
        }
    },
    methods: {
        selectedAll() {
            if (event.target.checked == false) {
                this.selected = [];
            } else {
                this.GetCategory.forEach((category) => {
                    this.selected.push(category.id);
                })
            }
        },
        goBack() {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
        },
        StatusTypeName: (status) => {
            const StatusType = {
                'Active': "bg-info",
                'Inactive': "bg-danger",
            }
            return StatusType[status];
        },
        inputBoxChecked: function () {
            this.checked = true
        },
        categoriesIdLength(categoriesIds) {
            return (categoriesIds.length > 0 ? true : false);
        },
        DataEmpty() {
            return (this.GetCategory.length < 1);
        },
        removeTask: function (id) {
            const thisWindow = this;
            this.confirm(() => {
                axios.post('/category/delete', { items: [id] }).then(function (response) {
                    if (response.status == 200) {
                        thisWindow.GetCategories();
                        toastr.success('Your category has been deleted.');
                    }
                });
            })
        },
        StatusColorType: (status) => {
            const ColorType = {
                'Active': "bg-info",
                'Inactive': "bg-danger",
            }
            return ColorType[status];
        },
        GetCategories() {
            return this.$store.dispatch('RenderAllCategories');
        },
        statusChange(id) {
            axios.post('category/status/' + id).then((response) => {
                if (response.status == 200) {
                    toastr.success("Yah! a category has been successfully deleted.");
                    this.GetCategories();
                }
            });
        },
        removeItems(inputValues) {
            const thisWindow = this;
            this.confirm(() => {
                axios.post('/category/delete', { items: inputValues }).then((res) => {
                    toastr.success(res.data.success);
                    thisWindow.BlankValued()
                })
            })
        },
        ActiveItems(inputValues) {
            const thisWindow = this;
            axios.post('/category/active', { items: inputValues }).then((res) => {
                toastr.success(res.data.success);
                thisWindow.BlankValued()
            });
        },
        InactiveItems(inputValues) {
            const thisWindow = this;
            axios.post('/category/inactive', { items: inputValues }).then((res) => {
                toastr.success(res.data.success);
                thisWindow.BlankValued()
            });
        },
        BlankValued() {
            this.selected = [];
            this.SelectAll = false;
            this.GetCategories();
        }
    },
    mounted() {
        this.$store.dispatch('RenderAllCategories');
    },
    watch: {
        selected: function (selected) {
            this.SelectAll = (selected.length === this.GetCategory.length);
        }
    },
    computed: {
        GetCategory: function () {
            return this.$store.getters.RenderCategories;
        }
    }
}
</script>

<style scoped>

</style>
