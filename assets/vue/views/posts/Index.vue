<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
            </div>
        </div>
        <h2>Section title</h2>
        <div class="table-responsive">
            <!-- User Interface controls -->
            <b-row>
                <b-col md="6" class="my-1">
                    <b-form-group label-cols-sm="3" label="Filter" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Type to Search" />
                        <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                    </b-form-group>
                </b-col>

                <b-col md="6" class="my-1">
                    <b-form-group label-cols-sm="3" label="Sort" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortBy" :options="sortOptions">
                        <option slot="first" :value="null">-- none --</option>
                        </b-form-select>
                        <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                        <option :value="false">Asc</option> <option :value="true">Desc</option>
                        </b-form-select>
                    </b-input-group>
                    </b-form-group>
                </b-col>

                <b-col md="6" class="my-1">
                    <b-form-group label-cols-sm="3" label="Sort direction" class="mb-0">
                    <b-input-group>
                        <b-form-select v-model="sortDirection" slot="append">
                        <option value="asc">Asc</option> <option value="desc">Desc</option>
                        <option value="last">Last</option>
                        </b-form-select>
                    </b-input-group>
                    </b-form-group>
                </b-col>

                <b-col md="6" class="my-1">
                    <b-form-group label-cols-sm="3" label="Per page" class="mb-0">
                    <b-form-select :options="pageOptions" v-model="perPage" />
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Main table element -->
            <b-table
            show-empty
            stacked="md"
            :items="posts"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection"
            ></b-table>

            <b-row>
                <b-col md="6" class="my-1">
                    <b-pagination
                    :total-rows="posts.length"
                    :per-page="perPage"
                    v-model="currentPage"
                    class="my-0"
                    />
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
export default {
    name: 'indexposts',
    data () {
        return {
            fields: [
                {key: 'id', label: "ID"},
                {key: 'title', label: "Title", sortable: true, sortDirection: 'desc'},
                {key: 'message', label: "Message", sortable: true, sortDirection: 'desc'},
                {key: 'created', label: "Created", sortable: true, sortDirection: 'desc'},
                {key: 'updated', label: "Updated", sortable: true, sortDirection: 'desc'},
            ],
            currentPage: 1,
            perPage: 10,
            totalRows: null,
            pageOptions: [10, 20, 30],
            sortBy: null,
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            modalInfo: { title: '', content: '' }
        }
    },
    created () {
        this.$store.dispatch('fetchPosts');
    },
    computed: {
        isLoading () {
            return this.$store.getters['isLoading'];
        },
        hasError () {
            return this.$store.getters['hasError'];
        },
        error () {
            return this.$store.getters['error'];
        },
        hasPosts () {
            return this.$store.getters['hasPosts'];
        },
        posts () {
            return this.$store.getters['posts'];
        },
        sortOptions() {
            // Create an options list from our fields
            return this.fields
            .filter(f => f.sortable)
            .map(f => {
                return { text: f.label, value: f.key }
            })
        }
    },
}
</script>
