<template>
    <div id="table">
        <b-input-group class="mt-3 mb-3" size="sm">
            <b-form-input v-model="keyword" placeholder="Search" type="text"></b-form-input>
            <b-input-group-text slot="append">
                <b-btn class="p-0" :disabled="!keyword" variant="link" size="sm" @click="keyword = ''">
                    <i class="fa fa-window-close"></i>
                </b-btn>
            </b-input-group-text>
        </b-input-group>
        <b-table :fields="fields" :items="items" :keyword="keyword" :tbody-tr-class="rowClass">
            <template v-slot:cell(id)="row" >
                <span>{{ row.item.id.value }}</span>
            </template>
            <template v-slot:cell(user_balance)="row">
                <div  v-show = "row.item.name.edit === false" >
                    <span @dblclick = "row.item.name.edit = true">{{ row.item.name.value + ' (' + row.item.balance.value + ')$' }} </span>
                </div>
                <div  v-show = "row.item.name.edit === true">
                    <b-input-group>
                        <b-input v-model="row.item.name.value"></b-input>
                        <span @click = "UpdateCell(row.item.id.value, row.item.name.value, 'name')">
                            <i class="fa fa-check-circle"></i>
                        </span>
                        <span @click = "row.item.name.edit = false">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </b-input-group>
                    <b-input-group>
                        <b-input v-model="row.item.balance.value"></b-input>
                        <span @click = "UpdateCell(row.item.id.value, row.item.balance.value, 'balance')">
                            <i class="fa fa-check-circle"></i>
                        </span>
                        <span @click = "row.item.name.edit = false">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </b-input-group>
                </div>
            </template>
            <template v-slot:cell(type)="row" >
                <div  v-show = "row.item.type.edit === false" >
                    <span @dblclick = "row.item.type.edit = true">{{ row.item.type.value }} </span>
                </div>
                <div  v-show = "row.item.type.edit === true">
                    <b-input-group>
                        <b-input v-model="row.item.type.value"></b-input>
                        <span @click = "row.item.type.edit === true && UpdateCell(row.item.id.value, row.item.type.value, 'type')">
                            <i class="fa fa-check-circle"></i>
                        </span>
                        <span @click = "row.item.type.edit = false">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </b-input-group>
                </div>
            </template>
            <template v-slot:cell(amount)="row" >
                <div  v-show = "row.item.amount.edit === false" >
                    <span @dblclick = "row.item.amount.edit = true">{{ row.item.amount.value }} </span>
                </div>
                <div  v-show = "row.item.amount.edit === true">
                    <b-input-group>
                        <b-input v-model="row.item.amount.value"></b-input>
                        <span @click = "UpdateCell(row.item.id.value, row.item.amount.value, 'amount')">
                            <i class="fa fa-check-circle"></i>
                        </span>
                        <span @click = "row.item.amount.edit = false">
                            <i class="fa fa-window-close"></i>
                        </span>
                    </b-input-group>
                </div>
            </template>

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
        <b-modal :id="createModal.id" :title="createModal.title" ok-only>
            <form action="" @submit="createTransaction">
                <h4 class="text-center font-weight-bold">Transaction creation form</h4>
                <div class="form-group">
<!--                    should match existing username if time todo with select-->
                    <input type="text" placeholder="Name" v-model="create.name" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Amount" v-model="create.amount" class="form-control">
                </div>
                <div class="form-group">
                    <!--                    should match existing type if time todo with select-->
                    <input type="text" placeholder="Type" v-model="create.type" class="form-control">
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
                {key: 'user_balance',
                    sortable: true,
                    sortByFormatted: true,
                    formatter: (value, key, item) => {
                        return item.name ;
                    }
                },
                // {key: 'user_balance', label: 'User(Balance)', sortable: true},
                {key: 'type', label: 'Type', sortable: true},
                {key: 'amount', label: 'Amount', sortable: true},
                {key: 'actions', label: 'Actions'},
            ],
            createModal: {
                id: 'create-modal',
                title: 'createTransaction',
            },
            dblClicked: false,
            create: {
                name: '',
                type: '',
                amount: '',
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
                    item.id.value.toString().includes(this.keyword) ||
                    item.name.value.toString().includes(this.keyword) ||
                    item.balance.value.toString().includes(this.keyword) ||
                    item.type.value.includes(this.keyword) ||
                    item.email.value.includes(this.keyword) ||
                    item.amount.value.toString().includes(this.keyword))
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
            if (item.type.value === 'Debit Card') return 'table-success'
            if (item.type.value === 'Credit Card') return 'table-danger'
        },
        DeleteRow(transaction) {
            axios.delete(`/api/transactions/${transaction.id.value}`)
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
            axios.post('/api/transactions',{
                name: this.create.name,
                type:this.create.type,
                amount:this.create.amount
            })
                .then(res => {
                    if (res.status === 201)
                        this.hideModalWindow();
                        this.reloadTable();
                        console.log('created')
                }).catch(err => {
                console.log(err)
            })
        },
        createModalWindow(){
            this.$root.$emit('bv::show::modal', this.createModal.id);
        },
        hideModalWindow(){
            this.$root.$emit('bv::hide::modal', this.createModal.id);
        },
        UpdateCell(transactionId, newValue, typeOfCell){
            axios.patch(`/api/transactions/${transactionId}`, {
                type: typeOfCell,
                value: newValue
            })
                .then(res => {
                    if (res.status === 200 && res.data === "ok")
                        this.reloadTable();
                    console.log('deleted')
                }).catch(err => {
                console.log(err);
            })
        }
    }
}
</script>
