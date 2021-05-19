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
                            <li class="  active">Manage Post</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content col-md-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title mt-2">All Posts</h3>
                    <div class="card-tools">
                        <router-link to="/post/add" class="btn btn-block btn-info"><i class="fa fa-plus-circle"></i> Add Post</router-link>
                    </div>
                </div>
                <div class="row">
                    <div id="filter-panel" class="collapse filter-panel m-auto">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-inline" role="form">
                                    <div class="form-group p-1">
                                        <label class="filter-col" style="margin-right:5px;" for="pref-perpage">Rows per page:</label>
                                        <select id="pref-perpage" class="form-control">
                                            <option value="2">2</option>
                                        </select>
                                    </div> <!-- form group [rows] -->
                                    <div class="form-group p-1">
                                        <label class="filter-col" style="margin-right:5px;" for="pref-search">Search:</label>
                                        <input type="text" @keyup="SearchPost" v-model="Search" placeholder="Search Post" class="form-control input-sm" id="pref-search">
                                    </div><!-- form group [search] -->
                                    <div class="form-group p-1">
                                        <label class="filter-col" style="margin-right:5px;" for="pref-orderBy">Order by:</label>
                                        <select id="pref-orderBy" @change="postOrderBy" v-model="orderBy" class="form-control">
                                            <option value="ascending">Ascending</option>
                                            <option value="descendent">Descendent</option>
                                        </select>
                                    </div> <!-- form group [order by] -->
                                    <div class="form-group p-1">
                                        <label class="filter-col" style="margin-right:5px;" for="category">Category:</label>
                                        <select id="category" @change="searchCategoryPost" v-model="categoryWaysPostName" class="form-control">
                                            <option selected style="display: none">Select</option>
                                            <option value="All-category">All Category Post</option>
                                            <option v-for="(category ,index) in RenderAllCategory" :value="category.id">{{ category.name }}</option>
                                        </select>
                                    </div> <!-- form group [order by] -->
                                    <div class="form-group p-1">
                                        <div class="checkbox" style="margin-left:10px; margin-right:10px;">
                                            <label><input type="checkbox"> Remember parameters</label>
                                        </div>
                                        <button type="submit" class="btn btn-default filter-col">
                                            <span class="fas fa-record-vinyl"></span> Save Settings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default advance-search" data-toggle="collapse" data-target="#filter-panel">
                        <span class="fas fa-sliders-h"></span> Advanced Search
                    </button>
                </div>

                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="icheck-info d-inline">
                                        <input type="checkbox" id="checkAll" @click="SelectedAll" v-bind:disabled="isEmptyData(GetRenderAllPosts)" v-model="SelectAll">
                                        <label for="checkAll"></label>
                                    </div>
                                </th>
                                <th>SI.NO</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Create By</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="TableShow">
                            <tr v-for="(row, index) in GetRenderAllPosts" :key="index">
                                <td>
                                    <div class="icheck-info d-inline">
                                        <input type="checkbox" name="checked" :checked="SelectAll" :id="index" :value="row.id" v-model="selected">
                                        <label :for="index"></label>
                                    </div>
                                </td>
                                <td>{{ index + 1 }}</td>
                                <td><img width="60px" :src="row.image" alt=""></td>
                                <td>{{ row.title }}</td>
                                <td>{{ row.category.name }}</td>
                                <td>{{ row.user.name }}</td>
                                <td>{{ row.description | subString(30) }}</td>
                                <td><span class="badge " :class="StatusColorType(row.status)">{{ row.status | StatusType }}</span></td>
                                <td class="d-flex">
                                    <router-link to="null" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i></router-link>
                                    <button type="button" @click="removePost(row.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr v-if="isEmptyData(GetRenderAllPosts)">
                                <td colspan="10" class="text-danger text-center text-bold">Data Not Found!.</td>
                            </tr>
                            <tr v-if="selected.length > 0 ? true:false">
                                <td colspan="10">
                                    <div>
                                        <button :disabled="!SelectAll" v-bind:disabled="selected.length < 1 ? true:false" type="button" class="btn btn-default dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-expanded="false">Action
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <button class="dropdown-item" @click="ActiveInactiveItems(selected, 'active')">Active</button>
                                            <button class="dropdown-item" @click="ActiveInactiveItems(selected, 'inactive')">Inactive</button>
                                            <button @click="removePost(selected)" class="dropdown-item">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-if="!TableShow">
                            <tr v-for="(row, index) in FilterPost" :key="index">
                                <td>
                                    <div class="icheck-info d-inline">
                                        <input type="checkbox" name="checked" :checked="SelectAll" :value="row.id" :id="index" v-model="selected">
                                        <label :for="index"></label>
                                    </div>
                                </td>
                                <td>{{ index + 1 }}</td>
                                <td><img width="60px" :src="row.image" alt=""></td>
                                <td>{{ row.title }}</td>
                                <td>{{ row.category.name }}</td>
                                <td>{{ row.user.name }}</td>
                                <td>{{ row.description | subString(30) }} ...</td>
                                <td class="d-flex">
                                    <router-link to="null" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i></router-link>
                                    <button type="button" @click="removePost(row.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr v-if="isEmptyData(FilterPost)">
                                <td colspan="10" class="text-danger text-center text-bold">Data Not Found!.</td>
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
    name: "ManagePostComponent",
    data() {
        return {
            selected: [],
            categoryWaysPostName: null,
            TableShow: true,
            FilterPost: [],
            Search: null,
            orderBy: null,
            SelectAll: false,
        }
    },
    mounted() {
        this.$store.dispatch('RenderAllPost');
        this.$store.dispatch('RenderAllCategories');
    },
    computed: {
        GetRenderAllPosts() {
            return this.$store.getters.RenderAllPost;
        },
        RenderAllCategory() {
            return this.$store.getters.RenderCategories;
        }
    },
    watch: {
        SelectAllTRUE() {
            return this.SelectAll = (this.selected.length === this.GetRenderAllPosts.length);
        }
    },
    methods: {
        StatusColorType(type) {
            const ColorType = {
                'active': 'bg-success',
                'inactive': 'bg-danger',
            }
            return ColorType[type]
        },
        removePost(id) {
            const thiWindow = this
            this.confirm(function () {
                axios.post('/post/destroy', { items: [id] }).then(function (response) {
                    toastr.success(response.data.success);
                    thiWindow.SelectAll = false;
                    thiWindow.$store.dispatch('RenderAllPost');
                });
            });
        },
        SelectedAll(event) {
            if (event.target.checked == false) {
                this.selected = [];
            } else {
                this.GetRenderAllPosts.forEach(post => {
                    this.selected.push(post.id);
                });
            }
        },
        postOrderBy() {
            const thisWindow = this;
            axios.post('/post/filter', { orderby: this.orderBy }).then(response => {
                thisWindow.TableShow = false;
                thisWindow.FilterPost = [];
                response.data.post.forEach(post => {
                    thisWindow.FilterPost.push(post)
                });
                return thisWindow.FilterPost;
            });
        },
        searchCategoryPost() {
            const thisWindow = this;
            axios.post('/post/filter', { category: this.categoryWaysPostName }).then(response => {
                thisWindow.TableShow = false;
                thisWindow.FilterPost = [];
                response.data.post.forEach(post => {
                    thisWindow.FilterPost.push(post)
                });
                return thisWindow.FilterPost;
            });
        },
        SearchPost() {
            const thisWindow = this;
            if (this.Search.length) {
                axios.post('/post/filter', { search: this.Search }).then((response) => {
                    thisWindow.TableShow = false;
                    thisWindow.FilterPost = [];
                    response.data.post.forEach(post => {
                        thisWindow.FilterPost.push(post)
                    })
                    return thisWindow.FilterPost;
                })
            } else {
                thisWindow.TableShow = true;
                thisWindow.FilterPost = [];
            }

        },
        ActiveInactiveItems(values, type) {
            const thiWindow = this;
            axios.post('/post/status', { items: [values], type: type }).then(function (response) {
                toastr.success(response.data.success);
                thiWindow.SelectAll = false;
                thiWindow.$store.dispatch('RenderAllPost');
            });
        },
        isEmptyData(data) {
            return (data.length < 1);
        },
    }

}
</script>

<style scoped>
.advance-search {
    margin-top: 5px;
    margin-left: 1150px;
}

.filter-panel {
    margin: 12px 0 3px 13px;
}
</style>
