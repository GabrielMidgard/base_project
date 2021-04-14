<template>
    <iq-card>
        <template v-slot:headerAction class="mt-2">
            <b-button variant="primary" :to="{ name: UrlElement }"><i class="fas fa-plus"></i> Nuevo</b-button>
            <b-button variant="outline-danger" class="ml-3" v-on:click="onRemoveSelected()"><i class="fa fa-trash"></i>Borrar</b-button>
        </template>

        <template v-slot:body>

            <b-form-group
                class="row"
                label-cols-sm="2"
                :label="lblFilter"
                label-for="quickFilter">
                <b-form-input id="quickFilter"
                type="text" placeholder="Buscar..."
                v-on:input="onQuickFilterChanged()"></b-form-input>
            </b-form-group>

            <ag-grid-vue
                id="ag-grid"
                class="ag-theme-material border height-500"  
                :gridOptions="gridOptions"
                :rowData="rowData"
                :modules="modules"
                rowSelection="multiple"
                :pagination="true"
                :paginationPageSize="paginationPageSize"
                :paginationNumberFormatter="paginationNumberFormatter"
                :localeText="localeText"  
                :frameworkComponents="frameworkComponents"
                @grid-ready="onGridReady"
                @row-clicked="onRowClicked"><!--:floatingFilter="true"-->
            </ag-grid-vue>
        </template>
    </iq-card>
</template>
<script>
    import "ag-grid-community/dist/styles/ag-grid.min.css";
    import "ag-grid-community/dist/styles/ag-theme-material.css";

    import { AllCommunityModules } from "@ag-grid-enterprise/all-modules";
    import {ModuleRegistry} from '@ag-grid-community/core';     // @ag-grid-community/core will always be implicitly available
    import {ClientSideRowModelModule} from "@ag-grid-community/client-side-row-model";
    import {CsvExportModule} from "@ag-grid-community/csv-export";
    import {ExcelExportModule} from "@ag-grid-enterprise/excel-export";
    import {MasterDetailModule} from "@ag-grid-enterprise/master-detail";

    ModuleRegistry.registerModules([
        ClientSideRowModelModule,
        CsvExportModule,
        ExcelExportModule,
        MasterDetailModule
    ]);

    import { AgGridVue } from "ag-grid-vue";
    
    import CrudRenderer from "../CrudRenderer"; 
    import crud from "../../../services/crud";
    import ActiveRenderer from '../ActiveRenderer';
    import languageData from "../Language/sp";
    import CustomHeader from './customHeaderVue.js';
    
    export default {
    
        props: {
            api: {
                type: String,
                required: true,
                default: ''
            }, 
            UrlList: {
                type: String,
                required: true,
                default: ''
            }, 
            UrlElement: {
                type: String,
                required: true,
                default: ''
            }, 
        },
        data() {
            return {   
                lblFilter:'Buscar usuario:',
                gridOptions: null,
                columnDefs: null,
                gridOptions: null,
                rowData: [],
                modules: [AllCommunityModules],//ClientSideRowModelModule, RowGroupingModule
                paginationPageSize: null,
                paginationNumberFormatter: null,
                localeText: null,
                frameworkComponents: null

            }
        },
        components: {
            AgGridVue, CrudRenderer
        },
        watch: {
            
        },
          
        beforeMount() {
            var me = this;
            var colSpan =  function (params) {
                return params.data === 2 ? 3 : 1;
            };

            this.columnDefs = [ {
                headerName: "Nombre",
                field: "nombre",
                sortable: true,
                filter: "agTextColumnFilter", 
                colSpan: colSpan,
                flex: 3,
                checkboxSelection: checkboxSelection,
                headerCheckboxSelection: headerCheckboxSelection,
            },
            {    headerName: "Email",
                field: "correo",
                sortable: true,
                filter: "agTextColumnFilter", 
                colSpan: colSpan,
                flex: 3 ,
            },
            {    
                headerName: "Telefono",
                field: "telefono",
                sortable: true,
                filter: "agTextColumnFilter", 
                colSpan: colSpan,
                flex: 3 ,
            },
            {
                headerName: "Activo", field: "estatus", 
                //pinned: true,
                flex: 2,
                sortable: true,
                filter: true,  
                minWidth: 170,
                maxWidth: 170, 
                
                headerComponentParams : {readonly: true},
                cellRenderer: "activeRenderer",
                cellRendererParams: {
                    api:this.api,
                    list:this.UrlList, 
                    element:this.UrlElement,
                    
                    clicked: function(id, status) {
                        //this.activeData(id, status);
                    }
                },
                colId: 'params',
                editable: false,
            },
            { 
                headerName: "", 
                cellRendererFramework: CrudRenderer, 
                cellRendererParams: {
                    api:this.api,
                    list:this.UrlList, 
                    element:this.UrlElement,
                },
                flex: 1,
                minWidth: 130,
                maxWidth: 130,
            },
           
            
            ];
            //var ejemplo = RefData.COUNTRY_CODES;
            this.localeText = languageData.AG_GRID_LOCALE_SP;

            this.gridOptions = {
                context: {
                    componentParent: me
                },
                defaultColDef: {
                    resizable: true,
                },
                columnDefs: me.columnDefs,
                getRowStyle: me.getRowStyleScheduled,
                onColumnResized: function (params) {
                    console.log(params);
                },
                onGridReady: (params) => {
                    this.gridApi = this.gridOptions.api;
                    //document.addEventListener('keydown', keyDownListener);
                }
            };
    
            this.frameworkComponents = {
                activeRenderer:ActiveRenderer,
            };
            this.paginationPageSize = 30;
            this.paginationNumberFormatter = (params) => {
                return '[' + params.value.toLocaleString() + ']';
            }; 
        },

        methods: {
            keyDownListener:function (e) {
                // delete the rows 
                // keyCode 8 is Backspace
                // keyCode 46 is Delete
                if(e.keyCode === 8 || e.keyCode === 46) {
                    const sel = gridOptions.api.getSelectedRows();
                    gridOptions.api.applyTransaction({remove: sel});
                }
            },
            getListData:function() {
                //this.loading = true;
                var paramsData = {
                    elementData:null,
                    api:this.api
                }

                crud.getList(paramsData)
                    .then(response => {
                    if (response.status == 200) {
                        var data = response.data;
                        this.rowData = data;
                    }else{
                        if (response.data.errors.length > 0){
                            this.$refs.form.setErrors(response.data.errors);
                        }
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
                    this.loading = false;
                });
                /*this.rowData = this.createRowData();*/
            },
            createRowData:function() {
                var data = [];
                for (var i = 0; i < 20; i++) {
                    data.push({
                    height: Math.floor(Math.random() * 100),
                    width: Math.floor(Math.random() * 100),
                    depth: Math.floor(Math.random() * 100),
                    });
                }
                return data;
            },
            getSelectedRows() {
                const selectedNodes = this.gridApi.getSelectedNodes();
                const selectedData = selectedNodes.map( node => node.data );
                const selectedDataStringPresentation = selectedData.map( node => node.make + ' ' + node.model).join(', ');
                alert(`Selected nodes: ${selectedDataStringPresentation}`);
            },
            onRowClicked(event) {
                /*
                this.elementData.id = event.node.data.id;
                this.elementData.name = event.node.data.name;
                this.elementData.active = event.node.data.active;
                //console.log('onRowClicked: ' + event.node.data.name);
                var selectedRowData = this.gridApi.getSelectedRows();
                if(selectedRowData.length >0){
                    this.lbldeleteElement=' '+selectedRowData.length+' elementos';
                }else{
                    this.lbldeleteElement='';
                }*/
            },
            onGridReady(params) {
                this.getListData();
            },
            onPageSizeChanged(newPageSize) {
                var value = document.getElementById('page-size').value;
                this.gridApi.paginationSetPageSize(Number(value));
            },
            onQuickFilterChanged() {
                this.gridApi.setQuickFilter(document.getElementById('quickFilter').value);
            },
            onRemoveSelected() {
                var me = this;
                this.$swal.fire({
                    title: '¿Seguro que deseas borrar este elemento?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, adelante'
                }).then((result) => {
                    if (result.isConfirmed) {
                    var selectedRowData = me.gridApi.getSelectedRows();

                    var ids = [];
                    for (var i = 0; i < selectedRowData.length; i++) {
                        var row = selectedRowData[i];
                        ids.push(row.id);
                    }

                    me.elementData=ids;

                    var paramsData = {
                        elementData:me.elementData,
                        api:me.api+'/multiDelete'
                    }
                
                    crud.multiDeleteElement(paramsData).then(response => {
                        if (response.status == 200) {
                        var selectedRowData = me.gridApi.getSelectedRows();
                        var msn = "";
                        if(selectedRowData.length > 0){
                            msn = "El elemento ha sido eliminado";
                        }else{
                            msn = "Los elementos ha sido eliminados";
                        }
                        me.notice('success', msn);
                        me.gridApi.applyTransaction({ remove: selectedRowData });

                        }else{
                        if (response.data.errors.length > 0){
                            me.$refs.form.setErrors(response.data.errors);
                        }
                        //PENDIENTE: Validar que nos regrese el error
                        //PENDIENTE: Traduccir errores en diferentes idiomas
                        me.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal!',
                            footer: 'No se puedo iniciar sesion revice sus datos'
                        })
                        }
                    })
                    .finally(() => {
                        me.loading = false;
                    });
                    }
                })
            },

            notice (type, message) { 
                var title = '';
                if(type == 'success'){
                    title = "Noticia"
                }
                else if(type == 'warning'){
                    title = "Noticia de advertencia"
                }
                this.$notice[type]({
                    title: title,
                    description: message
                })
            },

        },
        
        mounted() {
            this.gridApi = this.gridOptions.api;
            this.gridColumnApi = this.gridOptions.columnApi;
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
            if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) { return 0; }
            if (cellDate < filterLocalDateAtMidnight) { return -1; }
            if (cellDate > filterLocalDateAtMidnight) { return 1; }
        },
        browserDatePicker: true,
    };
    
</script>