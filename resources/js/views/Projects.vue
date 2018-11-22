<template>
        <div class="projects">
                <div v-if="error" class="error">
                        {{ error }}
                </div>

                <button id="show-modal" @click="showAddProjectModal = true">Add Project</button>
                <!-- use the modal component, pass in the prop -->
                <modal v-if="showAddProjectModal" @close="showAddProjectModal = false">
                        <h3 slot="header">Create project</h3>
                        <div slot="body">

                                <label for="project_name"> Project name </label>
                                <input type="text" id="project_name" name="project_name" v-model="projectName">

                                <label for="customer-list"> Customer </label>
                                <v-select v-model="selectedCustomer" placeholder="Search customer" :onSearch="searchCustomers" :options="customers" label="name">
                                        <!--<div class="spinner" v-show="spinner">Loading...</div>-->
                                        <template slot="customer" slot-scope="customer">
                                                {{ customer.name }}
                                        </template>
                                </v-select>

                        </div>
                        <div slot="footer">
                                <button @click="showAddProjectModal = false">Back</button>
                                <button @click="addProject">Save</button>
                        </div>
                </modal>

                <modal v-if="showEditProjectModal" @close="showEditProjectModal = false">
                        <h3 slot="header">Create customer</h3>
                        <div slot="body">
                                <label for="project_name"> Customer name </label>
                                <input type="text" id="projectName" name="projectName" v-model="editProjectName">
                        </div>
                        <div slot="footer">
                                <button @click="showEditProjectModal = false">Back</button>
                                <button @click="saveCustomer(editCustomerId, editCustomerName)">Save</button>
                        </div>
                </modal>
                <ul v-if="projects">
                        <li v-for="project in projects">
                                <button @click="deleteProject(project.id)"> X </button>
                                <button @click="showProjectEditModal(project.id)"> E </button>
                                <strong>Name:</strong> {{ project.name }}
                                ( Klant: {{ project.customer.name }} )
                        </li>
                </ul>
        </div>
</template>
<script>

    import echo from '../mixins/echo'
    import vSelect from 'vue-select'
    import Modal from '../atoms/Modal.vue'

    export default {
        name: 'Projects',
        components: {
            Modal,
            vSelect,
        },
        mixins: [echo],
        data() {
            return {
                error: '',
                showAddProjectModal: false,
                showEditProjectModal: false,
                projects: [],
                customers: [],

                projectName: '',
                selectedCustomer: '',

                editProjectName: '',
                editProjectId: '',
                editProjectCustomerId: '',

                searchTimeout: null,
            };
        },
        created() {
            this.getProjects();
        },
        methods: {

            getProjects() {
                this.$http
                    .get('/api/projects')
                    .then(response => {
                        this.projects = response.data
                    });
            },

            addProject() {
                this.$http
                    .post('/api/projects/create', {
                        name: this.projectName,
                        customer_id: this.selectedCustomer.id
                    })
                    .then(() => {
                        this.showAddProjectModal = false;
                    })
                    .catch(errors => console.log(errors.errors))
            },

            deleteProject(project_id) {
                this.$http
                    .post('/api/projects/delete', {project_id: project_id})
                    .then()
                    .catch(error => console.log(error));
            },

            showProjectEditModal(project_id) {
                let editProjects = this.projects.filter(project => project.id === project_id);
                if(editProjects.length > 0){
                    this.editProjectId = editProjects[0].id
                    this.editProjectName = editProjects[0].name;
                    this.editProjectCustomerId = editProjects[0].customer.id;
                }
                this.showEditCustomerModal = true;
            },

            saveProject(project_id){

                this.$http.patch('/api/projects/' + project_id, {
                    name: this.editProjectName,
                    customer_id: this.editProjectCustomerId,
                }).then(() => this.showEditCustomerModal = false).catch(error => console.log(error));
            },

            getEventHandlers() {
                return {
                    'Project\\ProjectAdded': response => {
                        this.projects.push(response.project);
                    },
                    'Project\\ProjectDeleted': response => {
                        console.log(response);
                        this.projects = this.projects.filter(project => project.id !== response.project_id);
                    },
                    'Project\\ProjectUpdated': response => {
                        let projectIndex = this.projects.findIndex(project => project.id === response.project.id)
                        if (projectIndex >= 0){
                            this.projects[projectIndex] = response.project;
                        }
                    },
                };
            },
            searchCustomers(query, loading) {
                loading(true)
                if (this.searchTimeout) clearTimeout(this.searchTimeout)
                let _this = this;
                this.searchTimeout = setTimeout(function() {
                    _this.$http
                        .post('api/customers/search', {
                            search_query: query,
                        })
                        .then(response => {
                            _this.customers = response.data;
                            loading(false);
                        })
                        .catch(response => loading(false))
                }, 300);
            }
        }
    }
</script>