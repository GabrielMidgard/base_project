<template>
    <div> 
        
        <b-form-group
            class="row"
            label-cols-sm="2"
            label="Buscar Cliente:"
            label-for="quickFilterTblClients">

            <b-form-input id="quickFilterTblClients"
                type="text"   placeholder="Buscar..."
                v-on:input="onQuickFilterChangedTblClients()">
            </b-form-input>
        </b-form-group>

        <ag-grid-vue
            id="ag-grid"
            class="ag-theme-material border height-500"  
            :gridOptions="gridTblClientsOptions"
            :rowData="rowDataTblClients"
            :modules="modules"
            :rowSelection="rowClientSelection"
            :pagination="true"
            :paginationPageSize="paginationPageSizeTblClients"
            :paginationNumberFormatter="paginationNumberFormatterTblClients"
            :localeText="localeText" 
            :frameworkComponents="frameworkComponentsTblClients"
            @grid-ready="onGridReadyTblClients"
            @row-clicked="onRowTblClientsClicked"
            :overlayLoadingTemplate="overlayLoadingTemplate"
            :overlayNoRowsTemplate="overlayNoRowsTemplate"> 
        </ag-grid-vue><!--:floatingFilter="true"--> 
    </div>
</template>
<script>
    import "ag-grid-community/dist/styles/ag-grid.min.css";
    import "ag-grid-community/dist/styles/ag-theme-material.css";

    import { AllCommunityModules } from "@ag-grid-enterprise/all-modules";
    import { AgGridVue } from "ag-grid-vue";
    import {ModuleRegistry} from '@ag-grid-community/core';     // @ag-grid-community/core will always be implicitly available
    import {ClientSideRowModelModule} from "@ag-grid-community/client-side-row-model";
    import {CsvExportModule} from "@ag-grid-community/csv-export";
    import {ExcelExportModule} from "@ag-grid-enterprise/excel-export";
    import {MasterDetailModule} from "@ag-grid-enterprise/master-detail";
    
    import ActionUser from "../../../User/Components/ActionUser"; 
    import crud from "../../../../services/crud";
    import languageData from "../Language/sp";
    import CustomHeader from './customHeaderVue.js';
    
    export default {
    
        props: { 
            validStep: {
                type: Number,
                required: true,
                default: 0
            },
            clientSelected:null,
        },
        data() {
            return {    
                gridApiTblClients: null,
                paginationPageSizeTblClients: null,
                paginationNumberFormatterTblClients: null,

                overlayLoadingTemplate: null,
                overlayNoRowsTemplate: null,

                frameworkComponentsTblClients: null,
                gridTblClientsOptions: null,
                modules: AllCommunityModules,
                columnApiTblClients:null,                
                columnDefsTblClients: null,
                rowClientSelection:null,
                rowDataTblClients: [],
            }
        },
        components: {
            AgGridVue, ActionUser
        },
        watch: {
            
        },
        methods: {
            getListData:function() {
                this.gridApiTblClients.showLoadingOverlay();
                var paramsData = {
                    elementData:null,
                    api:'api/clients/'
                }
        
                crud.getList(paramsData)
                .then(response => {
                    this.gridApiTblClients.hideOverlay();
                    if (response.status == 200) {
                        var data = response.data;
                        this.rowDataTblClients = data;
                    }else{
                        if (response.data.errors.length > 0){
                            this.$refs.form.setErrors(response.data.errors);
                        }
                        this.gridApiTblClients.showNoRowsOverlay();
                        //PENDIENTE: Validar que nos regrese el error
                        //PENDIENTE: Traduccir errores en diferentes idiomas
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            footer: 'No se puedo iniciar sesion revice sus datos'
                        })
                    }
                })
                .finally(() => {
                    //this.isLoading.show = false;
                });
            },

            onQuickFilterChangedTblClients() {
                this.gridApiTblClients.setQuickFilter(document.getElementById('quickFilterTblClients').value);
            },

            onGridReadyTblClients(params) {
                this.gridApiTblClients = params.api;
                this.columnApiTblClients = params.columnApi;
                const httpRequest = new XMLHttpRequest();
                const updateData = (data) => {
                    this.rowDataTblClients = data;
                };
                this.getListData();
            },

            onPageSizeChanged(newPageSize) {
                var value = document.getElementById('page-size').value;
                this.gridApiTblClients.paginationSetPageSize(Number(value));
            },

            onRowTblClientsClicked(event) {

                this.clientSelected.id = event.node.data.RECID;
                this.clientSelected.accountNum = event.node.data.ACCOUNTNUM;
                this.clientSelected.name = event.node.data.NAME;
                this.clientSelected.alias = event.node.data.NAMEALIAS;
                switch(event.node.data.PRICEGROUP){
                case 'inf':
                case 'INF':
                    this.clientSelected.groupPrice = 'Informal';
                break;

                case 'for':
                case 'FOR':
                    this.clientSelected.groupPrice = 'Formal';
                break;

                case 'dis':
                case 'DIS':
                    this.clientSelected.groupPrice = 'Distribuidor';
                break;
                }
                this.clientSelected.segment = event.node.data.SEGMENTID;
                this.clientSelected.segment = this.clientSelected.segment.toLowerCase();// minusculas
                this.clientSelected.salesAgent = event.node.data.SALESGROUP;

                if(event.node.data.SALESGROUPPISO != ""){ this.clientSelected.salePiso = event.node.data.SALESGROUPPISO; }
                
                this.clientSelected.bankAccount = event.node.data.BANKACCOUNT;

                this.clientSelected.paymTermId = event.node.data.PAYMTERMID;
                this.clientSelected.vatNum = event.node.data.VATNUM;
                this.clientSelected.bloked = event.node.data.BLOCKED;
                this.clientSelected.payMode = event.node.data.PAYMMODE;  
                this.clientSelected.iztInvoice = event.node.data.IZT_INVOICE; 
                this.clientSelected.creditMax = this.financial(event.node.data.CREDITMAX); //limitar a .00
                
                this.clientSelected.dlvMode = event.node.data.DLVMODE;
                this.clientSelected.salesPoolId = event.node.data.SALESPOOLID;

                this.clientSelected.iztReferenceBanamex = event.node.data.IZT_REFERENCEBANAMEX;
                this.clientSelected.luaReferenceBancomer = event.node.data.LUA_ReferenceBancomer;

                this.clientSelected.currency = event.node.data.CURRENCY;
                this.clientSelected.languageId = event.node.data.LANGUAGEID;
                this.clientSelected.RFC_mx = event.node.data.RFC_MX;
                this.clientSelected.salesDistricId = event.node.data.SALESDISTRICTID;
                this.clientSelected.satPayMethodted_mx = event.node.data.SATPAYMMETHOD_MX;
                this.clientSelected.partition = event.node.data.PARTITION;
                this.clientSelected.party = event.node.data.PARTY;
                this.clientSelected.partyCountry = event.node.data.PARTYCOUNTRY;
                this.clientSelected.partyNumber = event.node.data.PARTYNUMBER;

                this.$parent.$parent.getInfoContact();

                if(this.validStep == 1){
                    this.$parent.$parent.validStep =  2;
                } 
            },

            financial(x) {
                return Number.parseFloat(x).toFixed(2);
            },

        },
         
        beforeMount() {
            var me = this;
            this.rowClientSelection = "single"; 
            var colSpan = function (params) {
                return params.data === 2 ? 3 : 1;
            };
      
            this.columnDefsTblClients = [
                {
                headerName: "Nombre",
                field: "NAME",
                sortable: true,
                //filter: "agTextColumnFilter"
                colSpan: colSpan,
                flex: 3,
                
                },
                { headerName: "Alias", field: "NAMEALIAS", sortable: true, flex: 2 }, //filter: true },
                { headerName: "# Cliente", field: "ACCOUNTNUM", sortable: true, flex: 1}, //filter: true },
            ];
      
            // console.log()
            this.localeText = languageData.AG_GRID_LOCALE_SP;

            this.frameworkComponentsTblClients = { agColumnHeader: CustomHeader };
            this.gridTblClientsOptions = {
                context: {
                componentParent: me
                },
                defaultColDef: {
                resizable: true,
                minWidth: 150,
                flex: 1,
                headerComponentParams: { menuIcon: 'fa-search' },
                    filter: true,
                },
                columnDefs: me.columnDefsTblClients,
                getRowStyle: me.getRowStyleScheduled,
                onColumnResized: function (params) {
                console.log(params);
                },
            };
      
            this.rowModelType = 'serverSide';
            this.cacheBlockSize = 100;
            this.maxBlocksInCache = 10;

            this.paginationPageSizeTblClients = 10;
            this.paginationNumberFormatterTblClients = (params) => {
                return '[' + params.value.toLocaleString() + ']';
            }; 
            this.overlayNoRowsTemplate ='<span style="padding: 10px; border: 2px solid #444; background: lightgoldenrodyellow;">Espere un momento, mientras de carga la información</span>';
            this.overlayLoadingTemplate ='<span class="ag-overlay-loading-center">Espere un momento, mientras de carga la información</span>';
            
        },
        
        mounted() {
            //this.getListData();
        }
    }

    var checkboxSelection = function (params) {
        return params.columnApi.getRowGroupColumns().length === 0;
    };

    var headerCheckboxSelection = function (params) {
        return params.columnApi.getRowGroupColumns().length === 0;
    };

    var filterParams = {
        comparator: function (filterLocalDateAtMidnight, cellValue) {
        var dateAsString = cellValue;
        if (dateAsString == null) return -1;
        var dateParts = dateAsString.split('/');
        var cellDate = new Date(
            Number(dateParts[2]),
            Number(dateParts[1]) - 1,
            Number(dateParts[0])
        );
        if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
            return 0;
        }
        if (cellDate < filterLocalDateAtMidnight) {
            return -1;
        }
        if (cellDate > filterLocalDateAtMidnight) {
            return 1;
        }
        },
        browserDatePicker: true,
    };
    
</script>