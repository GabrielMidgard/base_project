<template>        
  <!-- Info Cliente -->
  <iq-card v-if="clientSelected.id!=0">
    <template v-slot:body id="clientForOrder">
      <b-row>
        <div class="d-flex align-items-center">
          <img
            class="rounded-circle img-fluid avatar-50"
            src="../../../../assets/images/user/userprofile_lua-02.jpg"
            alt="profile" />
          
          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Nombre</p>
            <h6 class="mb-0">{{clientSelected.alias}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Cliente</p>
            <h6 class="mb-0">{{clientSelected.accountNum}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Precios</p>
            <div class="mb-0 badge badge-pill badge-cobalt-blue">{{clientSelected.groupPrice}}</div>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Segmento</p>
            <div class="text-center">
              <div class="mb-0 badge badge-pill badge-cobalt-blue">{{clientSelected.segment}}</div>
            </div>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Agente</p>
            <h6 class="mb-0">{{clientSelected.salesAgent}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Piso</p>
            <h6 class="mb-0">{{clientSelected.salePiso}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Email</p>
            <h6 class="mb-0">{{clientSelected.email}}</h6>
          </div>
                  
          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Tel.</p>
            <h6 class="mb-0">{{clientSelected.phone}}</h6>
          </div>
          
        </div>
      </b-row>

      <b-row class="mt-4">
        <div class="d-flex align-items-center">
         <img
           class="rounded-circle img-fluid avatar-50"
           src="../../../../assets/images/banks/citibanamex2.png" 
           alt="citibanamex"/>
                  
          <div class="text-left ml-3 mr-3">
            <p class="mb-0"># Referencia bancaria</p>
            <h6>{{clientSelected.iztReferenceBanamex}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Saldo a favor</p>
            <h6>$ 0.00</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Saldo vencido</p>
            <h6>$ 29,545.66</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Limite de credito</p>
            <h6>$ {{clientSelected.creditMax}}</h6>
          </div>

          <div class="text-left ml-3 mr-3">
            <p class="mb-0">Plazo</p>
            <h6>{{clientSelected.paymentDay}}</h6>
          </div>
        </div>
                
      </b-row>
              
    </template>
  </iq-card>
</template>


<script>
  export default {
    props: {
      clientSelected:{
        id:0,
        accountNum:'',
        name:'',
        alias:'',
        email:'n/a',
        phone:'n/a',
        groupPrice:'n/a',
        segment:'',
        salesAgent:'n/a',
        salePiso: 'n/a', 
        bankAccount:'',
        paymentDay:'',
        paymTermId : '',
        vatNum: '',
        bloked:0,
        payMode:'',
        iztInvoice:1, 
        creditMax:0.0,
        dlvMode:'LOCAL',
        salesPoolId:'B',
        
        iztReferenceBanamex:'',
        luaReferenceBancomer:'',

        currency:'',
        languageId:'',
        RFC_mx:'',
        salesDistricId:'',
        satPayMethodted_mx:'',
        partition:'',
        party:'',
        partyCountry:'',
        partyNumber:''
     },
            
    },
    
    data() {
      return {
      }
    },
    
    watch: {
    },
    
    methods: {
    },
    
    mounted() {
    }
  }
</script>