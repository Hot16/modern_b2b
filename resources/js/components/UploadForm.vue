<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Загрузка цен</div>

                    <div class="card-body">
                        <div v-if="message!=''" class="alert alert-success" role="alert">
                            {{ message }}
                            <button v-if="message=='Загрузка завершена'" v-on:click="importPrice()">Импортировать данные</button>
                        </div>

                        <div v-if="error!=''" class="alert alert-danger" role="alert">
                            { error }
                        </div>
                        <div v-if="message==''">
                       <input type="file" id="file" ref="file" v-on:change="handleFileUpload()">
                        <button v-on:click="submitFile()">Загрузить</button>
                        </div>
                        <div v-if="message=='Импорт завершен'">
                            <p>Позиций в файле {{ summary.total_str }}</p>
                            <p>Импортировано позиций {{ summary.total_imported }}</p>
                            <p>Нет артикулов {{ summary.not_articul }}</p>
                            <p>Нет цен {{ summary.not_price }}</p>
                            <p>Дублирование артикулов {{ summary.doubled }}</p>
                            <p>Дублирующиеся строки</p>
                            <ul v-for="d_item in summary.doubled_items">
                                <li>{{ d_item }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UploadForm",
        data() {
            return{
                file:'',
                error:'',
                message:'',
                summary:'',
                progress_bar:false,
                progress_bar_percent: 0
            }

        },
        methods: {
            handleFileUpload: function () {
                this.file = this.$refs.file.files[0];
            },
            submitFile: function () {
                var formData = new FormData();
                var upload_form = this;
                formData.append('price', this.file);
                axios.post('/api/upload',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                        }
                    }
                ).then(function (msg) {
                    upload_form.message = msg.data.status;
                    console.log('msg', msg);
                }).catch(function (msg) {

                    console.log('FAILURE!! msg', msg);
                });
            },

            importPrice: function () {
                var upload_form = this;
                this.message = 'Идет импорт';
                axios.get('/api/import')
                    .then(function (msg) {

                        upload_form.progress_bar = false;
                        upload_form.message = msg.data.status;
                        upload_form.summary = msg.data.summary;
                    })
                    .catch(function () {
                        
                    })
            }
        }
    }
</script>

<style scoped>

</style>
