<template>
    <div id="table">
        <b-input-group class="mt-3 mb-3" size="sm">
            <b-form-input v-model="keyword" placeholder="Search" type="text"></b-form-input>
            <b-input-group-text slot="append">
                <b-btn class="p-0" :disabled="!keyword" variant="link" size="sm" @click="keyword = ''">
                    <i class="fa fa-trash"></i>
                </b-btn>
            </b-input-group-text>
        </b-input-group>
        <b-table :fields="fields" :items="items" :keyword="keyword" :tbody-tr-class="rowClass">
            <template  v-slot:cell(actions)="row">
                <b-button @click="DeleteRow(row.item)" title="Delete Row">
                    <span>
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </span>
                </b-button>
            </template>
        </b-table>
        <b-input-group class="mt-12 mb-12" size="sm">
            <b-button @click="createModalWindow">Create New Transaction</b-button>
        </b-input-group>
        <b-modal :id="createModal.id" :title="createModal.title" ok-only @hide="resetCreateModal">
            <form action="" @submit="createTransaction">
                <h4 class="text-center font-weight-bold">Post creation form</h4>
                <div class="form-group">
<!--                    should match existing username if time todo with select-->
                    <input type="text" placeholder="Name" v-model="name" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Amount" v-model="amount" class="form-control">
                </div>
                <div class="form-group">
                    <!--                    should match existing type if time todo with select-->
                    <input type="text" placeholder="Type" v-model="type" class="form-control">
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" @click.prevent="createTransaction">Submit
                    </button>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: 'TransactionsTalbe',
    data () {
        return {
            keyword: '',
            dataArray: [],
            fields: [
                {key: 'id', label: 'ID', sortable: true},
                {key: 'user_balance', label: 'User(Balance)', sortable: true},
                {key: 'type', label: 'Type', sortable: true},
                {key: 'amount', label: 'Amount', sortable: true},
                {key: 'actions', label: 'Actions' },
            ],
            createModal: {
                id: 'create-modal',
                title: '',
                content: ''
            }
        }
    },
    mounted () {
        this.reloadTable();
    },
    computed: {
        items () {
            //Search is case sensitive
            return this.keyword
                ? this.dataArray.filter(item =>
                    item.id.toString().includes(this.keyword) ||
                    item.user_balance.toString().includes(this.keyword) ||
                    item.type.includes(this.keyword) ||
                    item.amount.toString().includes(this.keyword))
                : this.dataArray
        },
        //Todo with store actions
        ...mapGetters([
            'transactions'
        ])
    },
    methods: {
        rowClass(item, type) {
            if (!item || type !== 'row') return
            if (item.type === 'Debit Card') return 'table-success'
            if (item.type === 'Credit Card') return 'table-danger'
        },
        DeleteRow(transaction) {
            axios.delete(`/api/transactions/${transaction.id}`)
                .then(res => {
                    if (res.status === 204)
                        this.reloadTable();
                        console.log('deleted')
                }).catch(err => {
                console.log(err);
            })
        },
        reloadTable() {
            axios
                .get('http://127.0.0.1:8000/api/transactions')
                .then(response => {
                    this.dataArray = response.data
                })
        },
        createTransaction(){
            let name = this.name;
            let type = this.type;
            let amount = this.amount;

            axios.post('/api/transactions',{
                name: name,
                type:type,
                amount:amount
            })
                .then(res => {
                    if (res.status === 201)
                        this.resetCreateModal();
                        this.$root.$emit('bv::hide::modal', this.createModal.id);
                        this.reloadTable();
                        console.log('created')
                }).catch(err => {
                console.log(err)
            })
        },
        createModalWindow(){
                this.createModal.title = 'createTransaction'
                this.createModal.content = Vue.component('CreateTransaction');
                this.$root.$emit('bv::show::modal', this.createModal.id);
        },
        resetCreateModal(){
                this.createModal.title = '';
        }
    }
}
</script>
