import DashboardComponent from "../components/admin/DashboardComponent";
import ManageComponent from "../components/admin/Categories/ManageComponent";
import AddCategoryComponent from '../components/admin/Categories/AddCategoryComponent';
import UpdateCategoryComponent from '../components/admin/Categories/UpdateCategoryComponent';

// Post Component Import Start
import ManagePostComponent from "../components/admin/Post/ManagePostComponent";
import AddPostComponent from "../components/admin/Post/AddPostComponent.vue";
// End Post Component Import

export const Routes = [
    { path: "/home", name: "Dashboard", component: DashboardComponent },
    { path: "/categories", name: "manage_category", meta: { title: "Manage Category" }, component: ManageComponent },
    { path: "/add-category", name: "add_category", meta: { title: "Add Categories" }, component: AddCategoryComponent },
    { path: "/update-category/:slug", name: "category_update", meta: { title: "Update Category" }, component: UpdateCategoryComponent },

    // POST Route Define
    { path: '/posts', name: "post.all", meta: {title: 'Manage All Post'}, component: ManagePostComponent },
    { path: "/add-post", name: "add-post", meta: {title: "Add New Post"}, component: AddPostComponent}
]
