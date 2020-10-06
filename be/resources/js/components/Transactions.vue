<template>
    <data-table
        :data="data"
        :columns="columns"
        @onTablePropsChanged="reloadTable">
    </data-table>
</template>

<script>

import {mapGetters} from 'vuex'
import DeleteButton from "./DeleteButton";

export default {
    name: "Transactions",
    data() {
        return {
            data: {},
            selectOptions: [],
            tableProps: {
                search: '',
                length: 10,
                column: 'id',
                dir: 'asc'
            },
            columns: [
                {
                    label: '#',
                    name: 'id',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'User(Balance)',
                    name: 'user_balance',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'Type',
                    name: 'type',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'Amount',
                    name: 'amount',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'DELETE',
                    name: ' ',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-primary': true,
                        'btn-sm': true,
                    },
                    event: "click",
                    handler: this.deleteTransaction,
                    component: DeleteButton,
                    searchable: false
                },
            ]
        }
    },
    created() {
        this.getData();
    },
    methods: {
        getData(options = this.tableProps){
            console.log(this.tableProps);
            axios.get('/api/transactions', {
                    params: options
                })
                .then(res => {
                    this.data = res.data;
                }).catch(err => {
                console.log(err);
            })
        },
        deleteTransaction(transaction) {
            axios.delete(`/api/transactions/${transaction.id}`)
                .then(res => {
                    if (res.data === 'ok')
                        this.reloadTable();
                        console.log('deleted')
                        //reload table
                }).catch(err => {
                console.log(err);
            })
        },
        reloadTable(tableProps) {
            console.log(tableProps);
            this.getData(tableProps);
        }
    },
    computed: {
        ...mapGetters([
            'transactions'
        ]),
    }
}
</script>

<style scoped>

</style>
