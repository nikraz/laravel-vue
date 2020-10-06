let mutations = {
    CREATE_TRANSACTION(state, transaction) {
        state.transactions.unshift(transaction)
    },
    FETCH_TRANSACTION(state, transaction) {
        return state.transactions = transaction
    },
    DELETE_TRANSACTION(state, transaction) {
        let index = state.transactions.findIndex(item => item.id === transaction.id)
        state.transactions.splice(index, 1)
    }

}
export default mutations
