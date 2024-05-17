<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 text-center mb-5">
                <h1 class="header-bg py-4 text-white header-text">Spot Test Indexed DB</h1>
            </div>
        </div>

        <form class="mb-5">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputEmail1">Email address</label>
                    <input
                        type="email"
                        class="form-control"
                        id="inputEmail1"
                        placeholder="Enter email"
                        v-model="models.email"
                    />
                    <small v-if="inputErrors.email" class="form-text text-danger">{{inputErrors.email}}</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputFirstName">First Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="inputFirstName"
                        placeholder="Enter first name"
                        v-model="models.first_name"
                    />
                    <small class="form-text text-danger">{{inputErrors.first_name}}</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputLastName">Last Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="inputLastName"
                        placeholder="Enter last name"
                        v-model="models.last_name"
                    />
                    <small class="form-text text-danger">{{inputErrors.last_name}}</small>
                </div>
            </div>
            <button type="button" class="btn btn-primary" @click="saveData">Submit</button>
        </form>

        <div>
            <table class="table table-hover" id="usersTable">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items" :key="item.id">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.email }}</td>
                    <td>{{ item.first_name }}</td>
                    <td>{{ item.last_name }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { openDB } from 'idb';
import "datatables.net";
import "datatables.net-dt/css/dataTables.dataTables.css";
import $ from "jquery";

export default {
    data() {
        return {
            models: {
                email: '',
                first_name: '',
                last_name: '',
            },
            items: [],
            db: '',
            inputErrors: {
                email: '',
                first_name: '',
                last_name: '',
            },
        };
    },
    async created() {
        await this.openDatabase();
        await this.loadItems();

        this.$nextTick(() => {
            $("#usersTable").DataTable();
        });
    },
    methods: {
        async openDatabase() {
            this.db = await openDB('spot_test_db', 1, {
                upgrade(db) {
                    db.createObjectStore('user_store', {
                        keyPath: 'id',
                        autoIncrement: true,
                    });
                },
            });
        },
        async saveData() {
            this.resetErrors();
            let validationPassed = this.validateInputs();
            if (!validationPassed) {
                await this.db.add('user_store', this.models);
                await this.openDatabase();
                await this.loadItems();
                await this.reInitializedDataTable();
                this.resetInputs();
            }
        },
        async getAllData() {
            return await this.db.getAll('user_store');
        },
        async loadItems() {
            this.items = await this.getAllData();
        },
        resetInputs() {
            this.models.email = '';
            this.models.first_name = '';
            this.models.last_name = '';
        },
        validateInputs() {
            let error = false;
            if (this.models.email === '') {
                this.inputErrors.email = 'Enter email';
                error = true;
            }
            if (this.models.first_name === '') {
                this.inputErrors.first_name = 'Enter first name';
                error = true;
            }
            if (this.models.last_name === '') {
                this.inputErrors.last_name = 'Enter last name';
                error = true;
            }
            return error;
        },
        resetErrors() {
            this.inputErrors.email = '';
            this.inputErrors.first_name = '';
            this.inputErrors.last_name = '';
        },
        async reInitializedDataTable() {
            this.$nextTick(() => {
                $("#usersTable").DataTable().destroy();
                $("#usersTable").DataTable();
            });
        }
    },
};
</script>

<style scoped>
.header-bg {
    background-color: #212529;
}
</style>
