let actions = {
    createTransaction({commit}, transaction) {
        axios.post('/api/transactions', transaction)
            .then(res => {
                commit('CREATE_TRANSACTION', res.data)
            }).catch(err => {
            console.log(err)
        })

    },
    fetchTransaction({commit}) {
        axios.get('/api/transactions')
            .then(res => {
                commit('FETCH_TRANSACTION', res.data)
                console.log(res.data);
                console.log(res.data.data);
            }).catch(err => {
            console.log(err)
        })
    },
    deleteTransaction({commit}, transaction) {
        axios.delete(`/api/transactions/${transaction.id}`)
            .then(res => {
                if (res.data === 'ok')
                    commit('DELETE_TRANSACTION', transaction)
            }).catch(err => {
            console.log(err)
        })
    }
}

export default actions
