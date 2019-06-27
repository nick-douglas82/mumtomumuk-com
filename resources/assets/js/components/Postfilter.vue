<template>
    <div class="cell filters">
        <div class="posts__filter" v-bind:class="{ isactive: isActive }" @click="filterToggle()">
            <span v-text="filterText"></span>
            <i class="icon icon--filter-down"></i>
        </div>
        <div class="posts__filters" v-show="isActive">
            <ul class="filters__list">
                <li class="filters__item" @click="changeFilter('All', 0)">All</li>
                <li class="filters__item" v-for="filter in filters" :key="filter.id" @click="changeFilter(filter.name, filter.id)">
                    {{ filter.name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: [ 'filters' ],

        data() {
            return {
                isActive: false,
                filterText: "Filter Posts",
            }
        },

        methods: {
            filterToggle() {
                this.isActive = this.isActive == false ? true : false;
            },

            changeFilter(name, id) {
                this.$emit('filterChanged', id);
                this.isActive   = false;
                this.filterText = name;
            }
        }
    }
</script>
