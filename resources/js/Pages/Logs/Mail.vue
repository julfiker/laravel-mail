<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Logs - mail
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                     <div class="p-5 grid grid-flow-col grid-rows-1 grid-cols-3 gap-4">
                         <div>
                             <label>Search</label>
                               <t-input v-model="filter.subject" @keyup="getEmailLogs"   />
                         </div>
                         <div>
                             <label>Status</label>
                             <t-select v-model="filter.status" @change="getEmailLogs" class="block w-full pl-3 pr-10 py-2 text-black placeholder-gray-400 transition duration-100 ease-in-out bg-white border border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed
"
                                 placeholder="Select an option"
                                 :options="status"
                             ></t-select>
                         </div>
                     </div>
                    <t-table
                        :headers="headers"
                        :data="items"
                    >
                        <template slot="row" slot-scope="props">
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-gray-100' : '']">
                                <td :class="props.tdClass">
                                    {{ props.row.mail_to }}
                                </td>
                                <td :class="props.tdClass">
                                  {{ props.row.mail_from }}
                                </td>
                                <td :class="props.tdClass">
                                  {{ props.row.mail_subject }}
                                </td>
                                <td :class="props.tdClass">
                                  {{ props.row.created_at }}
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.updated_at }}
                                </td>
                                <td :class="props.tdClass">
                                   <span :class="{'text-green-500': props.row.status == 'Sent', 'text-red-500': props.row.status == 'Failed', 'text-orange-500': props.row.status == 'Posted'}">
                                      {{ props.row.status }}
                                   </span>
                                </td>
                                <td :class="props.tdClass">
                                    <t-button variant="secondary" class="btn btn-sm btn-secondary">Retry</t-button>
                                </td>
                            </tr>
                        </template>
                        <template slot="tfoot" slot-scope="{ tfootClass, trClass, tdClass, renderResponsive }">
                            <tfoot :class="tfootClass">
                            <tr :class="trClass">
                                <td
                                    :class="tdClass"
                                    :colspan="renderResponsive ? 2 : 7"
                                >
                                    <t-pagination v-model="currentPage" @change="getEmailLogs"
                                        :hide-prev-next-controls="renderResponsive"
                                        :total-items="totalRows"
                                        :limit="10"
                                        :per-page=15
                                        :class="{'ml-auto': !renderResponsive, 'mx-auto': renderResponsive}"
                                    />
                                </td>
                            </tr>
                            </tfoot>
                        </template>
                    </t-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import {TTable,TButton,TPagination, TSelect, TInput} from 'vue-tailwind/dist/components'
    import repo from '../../AxiosRepository';

    export default {
        components: {
            AppLayout,
            Welcome,
            TTable,
            TButton,
            TPagination,
            TSelect,
            TInput
        },
        data() {
            return {
                headers: ['Sender', 'Recipient', 'Subject', 'Posted At', 'Sent at','Status', 'Action'],
                status: ['Posted', 'Sent', "Failed"],
                items: [],
                filter:{},
                totalRows:0,
                perPage:15,
                limit:5,
                disabled:false,
                currentPage:1,
            }
        },
        mounted() {
           this.getEmailLogs();
        },
        methods : {
            async getEmailLogs() {
                const queryString = Object.keys(this.filter).map(key => key + '=' + this.filter[key]).join('&');
                repo.callApi(repo.GET_COMMAND, '/mail/logs?page='+this.currentPage+"&"+queryString).then(res => {
                    this.items = res.data.data;
                    this.currentPage = res.data.current_page;
                    this.perPage = res.data.per_page;
                    this.totalRows = res.data.total;
                });
            },

        }
    }
</script>
