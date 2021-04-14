<template>
  <div>
    <Loader />
    <section class="sign-in-page login">
      <b-container class="bg-white p-0">
        <div class="row no-gutters">
          
          <div class="col-sm-12 text-center">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
              <a href="#" class="-intro-x flex items-center pt-5">
                <img class="logo" :alt="companyName" :src="logo"> 
              </a>
              
            </div>
            
          </div>

          <div class="col-sm-12 align-self-center">
            <div class="col-sm-6 offset-3  sign-in-from">
              <router-view></router-view>
            </div>
          </div>

        </div>
      </b-container>
    </section>
  </div>
</template>
<script>
import Loader from '../../components/core/loader/Loader'
import logo from '../../assets/images/logos/logoazul@3x.png'
import { core } from '../../config/pluginInit'
import bgImage from '../../assets/images/login/login-2.jpg'
import Swiper from '../../components/core/slider/Swiper'
import SwiperSlide from '../../components/core/slider/SwiperSlide'
export default {
  name: 'AuthLayout',
  companyName:'Logotipo SparkUp Academy',
  components: {
    Loader,
    Swiper,
    SwiperSlide
  },
  mounted () {
    core.index()
  },
  data () {
    return {
      options: {
        slidesPerView: 1,
        loop: true
      },
      logo: logo,
      bgImageURL: bgImage,
      companyName:'Logotipo Garantia',
    }
  }
}
</script>
<style>
  @import url("../../assets/css/custom.css");
    
  .login {
    position: relative;
    --bg-opacity: 1;
    background-color: #fff;
    background-color: rgba(255, 255, 255, var(--bg-opacity));
  }

  @media (max-width: 1279px) {
    .login {
      background: linear-gradient(to bottom, #1C3FAA, #2B51B4);
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  }

  .login:before {
    content: "";
    margin-left: -78%;
    background-image: url('../../assets/images/login/bg-login-simplistic.svg'); 
    background-repeat: no-repeat;
    background-size: auto 130%;
    background-position: right;
    width: 130%;
    height: 104%;
    position: absolute;
    top: 0;
    left: 0;
  }

  @media (max-width: 1279px) {
    .login:before {
      display: none;
    }
  }

  .login .logo{
    width: 40%;
    margin-top: 20px;
    margin-bottom: 20px;
  }

</style>
