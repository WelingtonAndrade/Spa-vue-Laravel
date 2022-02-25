<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Categories |     <Button @click="addModal=true"><Icon type="md-add" /> Add Catefory</Button>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>Id</th>
                                <th>Categoria</th>
                                <th>Imagem</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                                <td>{{ category.id}}</td>
                                <td class="category_name">{{ category.categoryName }}</td>
                                <td><img style="max-width: 50px; max-height: 50px" :src="category.iconImage"></td>
                                <td>
                                    <Button @click="showEditModal(category, i)" type="info" size="small"><Icon size="15" type="ios-create" />Edit</Button>
                                    <Button @click="showDeletingModal(category ,i)" :loading="category.isDeleting" type="error" size="small"><Icon type="md-trash" />Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <Page :total="100" />
                <Modal
                    v-model="addModal"
                    title="Adicionar Categorias"
                    :mask-closable="false"
                    :closable="false">
                    <Input class="my-1" v-model="data.categoryName" placeholder="Insira o Nome da Categoria" />
                    <Upload
                        v-model="data.iconImage"
                        ref="uploads"
                        type="drag"
                        action="/app/category/imageUpload"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With': 'XMLHttpRequest'}"
                        :format="['jpg','jpeg','png']"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        name="iconImage">
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Insira a Imagem aqui</p>
                        </div>
                    </Upload>
<!--                    <div class="image_thumb" v-if="data.iconImage">-->
<!--                        <img :src="`/uploads/${data.iconImage}`"/>-->
<!--                    </div>-->
                    <div class="demo-upload-list" v-if="data.iconImage">
                            <img  :src="`/uploads/category/${data.iconImage}`">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteImagem"></Icon>
                            </div>
                    </div>
                    <div slot="footer">
                        <Button @click="addModal=false" type="default">Cancel</Button>
                        <Button @click="addCategory" :disabled="loading" :loading="loading">{{ loading ? 'Cadastrando...' : 'Cadastrar' }}</Button>
                    </div>
                </Modal>
                <Modal
                    v-model="editModal"
                    title="Editar Categoria"
                    :mask-closable="false"
                    :closable="false"
                    name="iconImage">
                    <Input class="my-1" v-model="editData.categoryName" placeholder="Insira o Nome da Categoria" />
                    <Upload
                        v-model="editData.iconImage"
                        ref="update"
                        type="drag"
                        action="/app/category/imageUpload"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With': 'XMLHttpRequest'}"
                        :format="['jpg','jpeg','png']"
                        name="iconImage"
                    >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
<!--                    <div class="image_thumb" v-if="data.iconImage">-->
<!--                        <img :src="`/uploads/${data.iconImage}`"/>-->
<!--                    </div>-->
                    <div class="demo-upload-list" v-if="editData.iconImage">
                            <img  :src="editData.iconImage">
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-trash-outline" @click="deleteImagem(false)"></Icon>
                            </div>
                    </div>
                    <div slot="footer">
                        <Button @click="editModal=false" type="default">Cancel</Button>
                        <Button @click="editItem(editData)" :disabled="loading" :loading="loading">{{ loading ? 'Editando...' : 'Editar' }}</Button>
                    </div>
                </Modal>
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Apos confirmação não poderá haver restauração.</p>
                        <p>Tem certeza que quer deletar esta Categoria?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" :loading="isDeliting" @click="deleteItem(deleteData)">Delete</Button>
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            data: {
                iconImage: '',
                categoryName: ''
            },
            addModal: false,
            loading: false,
            editModal: false,
            categories: [],
            editData: {
                iconImage: '',
                categoryName: ''
            },
            index: -1,
            showDeleteModal: false,
            deleteData: {},
            deleteI: -'',
            isDeliting: false,
            token: '',
            isIconImageNew: false,
            isEditing: false
        }
    },
    methods: {
        handleSuccess(res, file){
            if (!this.isEditing){
                this.data.iconImage = res;
            } else {
                this.editData.iconImage = `/uploads/category/${res}`;
            }

        },

        handleFormatError(file){
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'FIle format of ' + file.name + ' is incorrect, please select jpg or png or jpeg.'
            })
        },
        handleError(file, res){

            this.$Notice.error({
                title: 'Image upload Error',
                desc: `${res.errors.iconImage.length ? res.errors.iconImage[0] : 'Something went wrong' }`
            })
        },
        handleMaxSize(file){
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File     ' + file.name + 'is too large, no more than 2mb is permited.'
            })
        },
        async deleteImagem (isAdd=true) {
            if(!isAdd) {
                this.isIconImageNew = true;
                var image = this.editData.iconImage;
                this.editData.iconImage = '';
                this.$refs.update.clearFiles();
            }else {
                var image = this.data.iconImage;
                this.data.iconImage = '';
                this.$refs.uploads.clearFiles();
            }

            const res = await this.callApi('post', '/app/category/delete_image', {imageName: image})
            if(res.status !== 200){
                this.data.iconImage = image;
            }
        },
        async addCategory(){
            this.loading = true;
            if (this.data.categoryName.trim() === '') return this.error('Ops !','Insira o Nome da Categoria', 3);
            if (this.data.iconImage.trim() === '') return this.error('Ops !','Insira a imagem da Categoria', 3);
            this.data.iconImage = `/uploads/category/${this.data.iconImage}`
            let res = await this.callApi('post', '/app/category', this.data);
            if (res.status === 201){
                this.categories.unshift(res.data)
                this.data.categoryName = ''
                this.data.iconImage = ''
                this.addModal = false
                this.loading = false
                this.$refs.uploads.clearFiles();
                return this.success('Oba !','Categoria criada com Sucesso', 3)
            }
            else if (res.status === 422){
                if (res.data.errors) {
                    for (var item in res.data.errors) {
                        this.error('Ops !',res.data.errors[item])
                        this.loading = false
                    }
                }
            }
            else {
                console.log(res)
                this.loading = false
            }
        },
        async deleteItem(deleteData){
            this.isDeliting = true;
            console.log(deleteData.id);
            let res = await this.callApi('delete', '/app/category/' + deleteData.id);
            if (res.status === 200){
                this.categories.splice(this.deleteI,1)
                this.showDeleteModal = false;
                this.isDeliting = false

                return this.success('Oba !','Sucesso ao deletar a Categoria !', 5);
            }
            else {
                setTimeout(() => {
                    this.isDeliting = false
                    this.showDeleteModal = false;
                    return this.error('Ops !','Erro ao deletar a Categoria !', 5);
                }, 1000)
            }
        },
        showDeletingModal(category, i){
            this.deleteData = category;
            this.deleteI = i;
            this.showDeleteModal = true;
        },
        async editItem(categoryData){
            this.loading = true;
            let res = await this.callApi('patch', '/app/category/' + categoryData.id, categoryData);
            if (res.status === 200){
                this.addModal = false;
                this.loading = false;
                this.categories[this.index].categoryName = this.editData.categoryName;
                return this.success('Oba !','Categoria editada com Sucesso', 3);
            }
            else if (res.status === 422){
                if (res.data.errors) {
                    for (var item in res.data.errors) {
                        this.error('Ops !',res.data.errors[item])
                    }
                    this.loading = false;
                }
            }
            else {
                console.log(res)
            }
        },
        showEditModal(category, index){
            this.editData = category;
            this.editModal = true;
            this.index = index
            this.isEditing = true;
        }
    },
    async created(){
        this.token = window.Laravel.csrfToken;
        let res = await this.callApi('get','/app/category');

        if (res.status === 200){
            this.categories = res.data;
            console.log(this.categories);
        }
        else{
            this.swr();
        }
    }
}
</script>
<style>
.demo-upload-list{
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
}
.demo-upload-list img{
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover{
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,.6);
}
.demo-upload-list:hover .demo-upload-list-cover{
    display: block;
}
.demo-upload-list-cover i{
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
