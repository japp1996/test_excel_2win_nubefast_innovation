<template id="template-users">
    <section class="col m12">
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Creado (DD-MM-AAAA h:m:s)</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="(user, i) in setTable.data" :key="i">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.created_at}}</td>
                <td>
                    <div class="switch">
                        <label>
                        Desactivado
                        <input type="checkbox" :checked="user.status == '1' ? true : false" v-on:click="_switch(user.id)">
                        <span class="lever"></span>
                        Activado
                        </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <ul class="pagination">
            <li v-on:click="_first()" v-show="setTable.current_page > 1">
                <a href="#!"><i class="material-icons"><<</i></a>
            </li>
            <li v-on:click="_prev()" v-show="setTable.current_page > 1">
                <a href="#!"><i class="material-icons"><</i></a>
            </li>
            <li v-for="(i) in totalPages()" :class="setTable.current_page == i ? 'active' : ''" v-on:click="_load(i)" :key="i" v-show="i <= showMaxPagination() && i >= showMinPagination()" >
                <a href="#!">{{i}}</a>
            </li>
            <li class="waves-effect" v-on:click="_next()">
                <a href="#!"><i class="material-icons">></i></a>
            </li>
            <li v-on:click="_last()">
                <a href="#!"><i class="material-icons">>></i></a>
            </li>
        </ul>
    </section>
</template>
<script>
export default {
    template: "#template-users",
    data() {
        return {
            setTable: {
                data:[],
                total: 0,
                per_page:0,
                current_page: 1
            }
        }
    },
    methods: {
        _load(page=1) {
            axios.post('users?page='+page, {})
            .then(response => {
                this.setTable = response.data
            }).catch(error => {
                let message  = "Disculpe, ha ocurrido un error";
                if (error.response.status == 422) {
                    message = error.response.data.error;
                }
                swal("", message, "error");
            })
        },
        
        _switch(id) {
            let index = this.setTable.data.findIndex(e => {
                return e.id == id
            })

            axios.put('users/update', {id:id})
            .then(response => {
                this.setTable[index].data.status = response.data.status
            })
            .catch(error => {
                let message  = "Disculpe, ha ocurrido un error";
                if (error.response.status == 422) {
                    message = error.response.data.error;
                }
                swal("", message, "error");
            })
        },
        totalPages() {
            let totalPage = parseInt(this.setTable.total/this.setTable.per_page)
            return isNaN(totalPage) ? 0 : totalPage
        },
        showMaxPagination() {
            let max = this.setTable.current_page + 19
            return max
        },
        showMinPagination() {
            let current = this.setTable.current_page
            let min = current > 1 ? current -1 : current
            return min
        },
        _first() {
            this._load(1)
        },
        _last() {
            this._load(this.setTable.last_page)
        },
        _next() {
            if (this.setTable.current_page != this.setTable.last_page) {
                this._load(this.setTable.current_page + 1)
            }
        },
        _prev() {
            if (this.setTable.current_page > 1) {
                this._load(this.setTable.current_page - 1)
            }
        }
    },
    mounted() {
        this._load()
    }
}
</script>