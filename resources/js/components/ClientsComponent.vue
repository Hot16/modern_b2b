<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a class="btn btn-outline-success" href="" @click="nulledC" data-toggle="modal" data-target="#addClient">Добавить клиента</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Логин</th>
                        <th scope="col">Email</th>
                        <th scope="col">Цены</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client in clients">
                        <th scope="row">{{ client.id }}</th>
                        <td>{{ client.name }}</td>
                        <td>{{ client.login }}</td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.price_level }}</td>
                        <td><a href="" style="margin-left: 2px" @click="getClient(client.id)" data-toggle="modal" data-target="#addClient"><i class="far fa-edit"></i></a>  <a href="" @click.prevent="deleteClient(client.id)"><i class="far fa-trash-alt text-danger"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal" v-bind:class="{ 'show': modal_show}"  id="addClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Новый клиент</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" id="name" class="form-control" v-model="c.name">
                        </div>
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" id="login" class="form-control" v-model="c.login">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" v-model="c.email">
                        </div>
                        <div class="form-group">
                            <label for="pass">Пароль</label>
                            <input type="text" id="pass" class="form-control" v-model="c.password">
                        </div>
                        <div class="form-group">
                            <label for="price_level">Уровень цен</label>
                            <select id="price_level" class="form-control" v-model="c.price_level">
                                <option v-for="i in [0, 1, 2, 3, 4, 5, 6]">{{ i }}</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div v-bind:class="{'alert-danger': hasError}">{{message}}</div>
                        <button type="button" class="btn btn-primary" @click="addClient('CreateUser')">Сохранить</button>
                        <button type="button" class="btn btn-primary" v-bind:class="{'d-none': !hasError}" @click="addClient('UpdateUser')">Обновить на modern-it</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ClientsComponent",
        data(){
            return {
                c:{
                    id: '',
                    name: '',
                    login: '',
                    email:'',
                    password:'',
                    price_level: '',
                    action:''
                },
                clients: [],
                message: '',
                modal_show: false,
                hasError: false
             }
        },
        mounted() {
            this.getList();
        },
        methods: {
            getList() {
                var clients_component = this;
                axios.get('api/showClients').then(function (response) {
                    console.log(response);
                    clients_component.clients = response.data;
                })
            },
            addClient(action){
                var clients_component = this;
                this.message = '';
                this.c.action = action;
                if(this.c.action=='UpdateUser'){
                    confirm('Это действие найдет на modern-it пользователя по email и перезапишет его данные. Уверены?');
                }
                axios.post('/api/addClient',
                    this.c,
                    /*{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                        }
                    }*/
                ).then(function (msg) {
                    clients_component.message = msg.data.status_msg;
                    if (msg.data.status == 'ok'){
                        clients_component.getList();
                        clients_component.nulledC();
                        clients_component.hasError = false;
                        clients_component.modal_show = false;
                    } else {
                        clients_component.hasError = true;
                    }

                }).catch(function (msg) {

                    console.log('FAILURE!! msg', msg);
                });
            },
            deleteClient(id){
                var clients_component = this;
                axios.post('/api/deleteClient',
                    {
                        id: id
                    }
                ).then(function (msg) {
                    clients_component.message = msg.data.status;
                    clients_component.getList();
                }).catch(function (msg) {

                    console.log('FAILURE!! msg', msg);
                });
            },
            getClient(id){
                this.nulledC();
                var clients_component = this;
                axios.post('/api/getClient',
                    {
                        id: id
                    }
                ).then(function (response) {
                    console.log(response);
                    clients_component.c.id = response.data[0].id;
                    clients_component.c.name = response.data[0].name;
                    clients_component.c.login = response.data[0].login;
                    clients_component.c.email = response.data[0].email;
                    clients_component.c.price_level = response.data[0].price_level;
                }).catch(function (msg) {

                    console.log('FAILURE!! msg', msg);
                });
            },
            nulledC(){
                this.c.id = '';
                this.c.name = '';
                this.c.login = '';
                this.c.email = '';
                this.c.price_level = '';
                this.c.password = '';
                this.hasError = false;
                this.message = '';
            }
        }
    }
</script>

<style scoped>

</style>
