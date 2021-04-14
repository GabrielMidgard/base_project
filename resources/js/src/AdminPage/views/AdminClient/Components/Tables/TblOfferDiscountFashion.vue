<template>
    <div> 
        <b-form-group
            class="row"
            label-cols-sm="2"
            label="Buscar Oferta:"
            label-for="quickFilterTblOffers">
            <b-form-input id="quickFilterTblOffers"
            type="text"   placeholder="Buscar..."
            v-on:input="onQuickFilterChangedTblOffers()"></b-form-input>
        </b-form-group>
            <!--ag-theme-material || ag-theme-alpine -->
        
        <ag-grid-vue
            id="ag-grid-Offers"
            style="width: 100%; height: 100%;"
            class="border ag-theme-material height-500" 

            :gridOptions="gridTblOffersOptions"
            :rowData="rowDataTblOffers"
            :modules="modules"
            rowSelection="multiple"
            :pagination="true"
            :paginationPageSize="paginationPageSizeTblOffers"
            :paginationNumberFormatter="paginationNumberFormatterTblOffers"
            :localeText="localeText" 
            :frameworkComponents="frameworkComponentsTblOffers"
            @grid-ready="onGridReadyTblOffers"
            @row-clicked="onRowTblOffersClicked"
            :overlayLoadingTemplate="overlayLoadingTemplate"
            :overlayNoRowsTemplate="overlayNoRowsTemplate"> <!--:floatingFilter="true"--> 
        </ag-grid-vue>
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
    import ViewImageRenderer from "../ViewImageRenderer";
  
    export default {
    
        props: { 
            validStep: {
                type: Number,
                required: true,
                default: 0
            },
            clientSelected:null,
            api:{
                type: String,
                required: true,
                default: ''
            },
            modalImageProductShow:{
                type: Boolean,
                required: true,
                default: false
            },
        },

        data() {
            return {
                
                modules: AllCommunityModules,
                gridTblOffersOptions: null,
                gridApiTblOffers: null,
                columnApiTblOffers:null,
                columnDefsTblOffers: null,
                paginationPageSizeTblOffers: null,
                paginationNumberFormatterTblOffers: null,
                frameworkComponentsTblOffers: null,
                overlayLoadingTemplate: null,
                overlayNoRowsTemplate: null,
                rowDataTblOffers: [],
                imageProductView: '',
            }
        },
        components: {
            AgGridVue, ActionUser
        },
        watch: {
            
        },
        methods: {
            getListDataOffers:function(){
                var paramsData = {
                elementData:this.clientSelected.groupPrice,
                api:this.api+'getFashionWithStock'
            }
        
                crud.getElementData(paramsData)
                .then(response => {
                if (response.status == 200) {
                    var data = response.data;
                    this.rowDataTblOffers = data;
                }else{
                    if (response.data.errors.length > 0){
                        this.$refs.form.setErrors(response.data.errors);
                    }
                    this.gridApiTblOffers.showNoRowsOverlay();
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
            },

            onGridReadyTblOffers(params) {
                this.gridApiTblOffers = params.api;
                this.columnApiTblOffers = params.columnApi;
                const httpRequest = new XMLHttpRequest();
                const updateData = (data) => {
                this.rowDataTblOffers = data;
                };
            },

            onPageSizeChanged(newPageSize) {
                var value = document.getElementById('page-size').value;
                this.gridApiTblOffers.paginationSetPageSize(Number(value));
            },
            
            onQuickFilterChangedTblOffers() {
                this.gridApiTblOffers.setQuickFilter(document.getElementById('quickFilterTblOffers').value);
            },
            
            viewImageModal: function(name, color, thumbnail_url){
                this.$parent.$parent.productSelected.name = name+' - '+color;
                this.$parent.$parent.productSelected.imageView = thumbnail_url;
                this.$parent.$parent.modalImageProductShow = !this.modalImageProductShow;
            },

            onRowTblOffersClicked(event) {
                //this.clientSelected.segment = event.node.data.SEGMENTID;
                //this.clientSelected.segment = this.clientSelected.segment.toLowerCase();// minusculas
                //this.clientSelected.creditMax = this.financial(event.node.data.CREDITMAX); //limitar a .00
                //console.log('onRowTblClientsClicked: ' + event.node.data.name);
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
      
            this.columnDefsTblOffers = [
                { 
                field: '', 
                //cellRenderer: productImgCellRenderer, 
                checkboxSelection: checkboxSelection,
                headerCheckboxSelection: headerCheckboxSelection,
                
                maxWidth: 50,
                width: 50,
                suppressMenu: true,
                sortable: false,
                },
                
                {
                headerName: "Codigo",
                field: "itemID",
                sortable: true,
                //filter: "agTextColumnFilter"
                flex: 1,
                filter: true
                },
                {
                headerName: "Nombre",
                field: "name",
                sortable: true,
                //
                sortable: true, flex: 1, filter: "agTextColumnFilter",
                colSpan: colSpan,
                flex: 2,
                filter: true
                /*checkboxSelection: checkboxSelection,
                headerCheckboxSelection: headerCheckboxSelection*/
                },
                {
                headerName: "Color ID",
                field: "colorId",
                sortable: true,
                flex: 1,
                filter: true
                },
                { headerName: "Color", field: "color", sortable: true, flex: 1, filter: true },   
                { headerName: "Precio", field: "price", sortable: true, flex: 1, filter: 'agNumberColumnFilter' }, //filter: true },
                { 
                headerName: "", 
                cellRendererFramework: ViewImageRenderer, 
                cellRendererParams: {
                    
                },
                minWidth: 60,
                maxWidth: 70,
                suppressMenu: true,
                sortable: false,
                }
                /*
                { headerName: "For", field: "for", sortable: true, flex: 1, filter: 'agNumberColumnFilter' }, //filter: true },
                { headerName: "Dis", field: "dis", sortable: true, flex: 1, filter: 'agNumberColumnFilter' }, //filter: true },
                { headerName: "Inf", field: "inf", sortable: true, flex: 1, filter: 'agNumberColumnFilter',  }, //},
                */
                //{ headerName: "Unidad", field: "unidad", sortable: true, flex: 1}, //filter: true },
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
            this.frameworkComponentsTblOffers = { agColumnHeader: CustomHeader, };
      
            this.gridTblOffersOptions = {
                context: {
                componentParent: me
                },
                defaultColDef: {
                resizable: true,
                headerComponentParams: { menuIcon: 'fa-search' },
                sortable: true, 
                filter: true,
                }, 
                
                columnDefs: me.columnDefsTblOffers,
                getRowStyle: me.getRowStyleScheduled,
                onColumnResized: function (params) {
                console.log(params);
                },
            };

            this.rowModelType = 'serverSide';
            this.cacheBlockSize = 100;
            this.maxBlocksInCache = 10;

            this.paginationPageSizeTblOffers = 10;
            this.paginationNumberFormatterTblOffers = (params) => {
                return '[' + params.value.toLocaleString() + ']';
            };
            
            this.overlayNoRowsTemplate ='<span style="padding: 10px; border: 2px solid #444; background: lightgoldenrodyellow;">Espere un momento, mientras de carga la información</span>';
            this.overlayLoadingTemplate ='<span class="ag-overlay-loading-center">Espere un momento, mientras de carga la información</span>';
        },
        
        mounted() {
            this.getListDataOffers();
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