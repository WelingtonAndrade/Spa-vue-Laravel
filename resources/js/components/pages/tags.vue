<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags |     <Button @click="addModal=true"><Icon type="md-add" /> Add Tag</Button>

					<div class="_overflow _table_div">
						<table class="_table">
							<tr>
								<th>Id</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{ tag.id}}</td>
								<td class="tag_name">{{ tag.tagName }}</td>
								<td>{{ tag.created_at }}</td>
								<td>
                                    <Button @click="showEditModal(tag, i)" type="info" size="small"><Icon size="15" type="ios-create" />Edit</Button>
                                    <Button @click="showDeletingModal(tag ,i)" :loading="tag.isDeleting" type="error" size="small"><Icon type="md-trash" />Delete</Button>
								</td>
							</tr>
						</table>
					</div>
				</div>
				 <Page :total="100" />
                <Modal
                    v-model="addModal"
                    title="Adicionar tags"
                    :mask-closable="false"
                    :closable="false">
                    <Input v-model="data.tagName" placeholder="Insira o Nome da Tag" />
                    <div slot="footer">
                        <Button @click="addModal=false" type="default">Cancel</Button>
                        <Button @click="addTag" :disabled="loading" :loading="loading">{{ loading ? 'Cadastrando...' : 'Cadastrar' }}</Button>
                    </div>
                </Modal>
                <Modal
                    v-model="editModal"
                    title="Adicionar tags"
                    :mask-closable="false"
                    :closable="false">
                    <Input v-model="editData.tagName" placeholder="Insira o Nome da Tag" />
                    <div slot="footer">
                        <Button @click="editModal=false" type="default">Cancel</Button>
                        <Button @click="editTag(editData)" :disabled="loading" :loading="loading">{{ loading ? 'Editando...' : 'Editar' }}</Button>
                    </div>
                </Modal>
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Apos confirmação não poderá haver restauração.</p>
                        <p>Tem certeza que quer deletar esta Tag?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long  @click="deleteTag()">Delete</Button>
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
              tagName: ''
          },
          addModal: false,
          loading: false,
          editModal: false,
          tags: [],
          editData: {
              tagName: ''
          },
          index: -1,
          showDeleteModal: false,
          deleteItem: {},
          deleteI: -''
      }
    },
    methods: {
        async addTag(){
            this.loading = true;
            if (this.data.tagName.trim()==''){
                this.loading = false
                return this.error('Ops !','Insira o Nome da Tag', 3)
            }
            let res = await this.callApi('post', '/app/tag', this.data);
            if (res.status === 201){
                this.tags.unshift(res.data)
                this.addModal = false
                this.loading = false
                return this.success('Oba !','Tag criada com Sucesso', 3)
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
            }
        },
        async deleteTag(){
                let res = await this.callApi('delete', '/app/tag/' + this.deleteItem);
                if (res.status === 200){
                    this.tags.splice(this.deleteI,1)
                    this.showDeleteModal = false;
                    return this.success('Oba !','Tag deletada com Sucesso', 3);
            }
        },
        showDeletingModal(tag, i){
            console.log('teste');
            this.deleteItem = tag;
            this.deleteI = i;
            this.showDeleteModal = true;
        },
        async editTag(editData){
            this.loading = true;
            let res = await this.callApi('patch', '/app/tag/' + editData.id, editData);
            if (res.status === 200){
                this.addModal = false;
                this.loading = false;
                this.tags[this.index].tagName = this.editData.tagName;
                return this.success('Oba !','Tag editada com Sucesso', 3);
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
        showEditModal(item, i){
            let obj = {
                id: item.id,
                tagName: item.tagName
            };
            this.editData = obj;
            this.editModal = true;
            this.index = i;
        }
    },
    async created(){
        let res = await this.callApi('get','/app/tag')
        if (res.status === 200){
            console.log(res.data)
            this.tags = res.data
        }
        else{
            this.swr()
        }
    }
}
</script>
