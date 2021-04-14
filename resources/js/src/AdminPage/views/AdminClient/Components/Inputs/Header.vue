<template>
	
	<div class="row">
	
		<!-- Profile Info and Notifications -->
		<div class="col-md-6 col-sm-8 clearfix">
	
			<ul class="user-info pull-left pull-none-xsm">
	
				<!-- Profile Info -->
				<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
	
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img :src="profile()" alt="" class="img-circle" width="44" />
						{{this.$parent.user.name}}
					</a>
	
					<ul class="dropdown-menu">
	
						<!-- Reverse Caret -->
						<li class="caret"></li>
	
						<!-- Profile sub-links -->
						<li>
							<router-link to="/profile/"><i class="fa fa-edit"></i> Editar perfil</router-link>
							
						</li>

					</ul>
				</li>
	
			</ul>
			
			<ul class="user-info pull-left pull-right-xs pull-none-xsm">
	
				<!-- Raw Notifications -->
				<li class="notifications dropdown">
	
					<a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" @click="readAll">
						<i class="fa fa-bell"></i>
						<span class="badge badge-info" v-if="unreaded!=0">{{unreaded}}</span>
					</a>
	
					<ul class="dropdown-menu">
						<li class="top">
							<p class="small">								
								Notificaciones:
							</p>
						</li>
						
						<li>
							<ul class="dropdown-menu-list scroller">
								<li v-for="notification in notifications" :class="'notification-'+notification.type">
									<router-link v-if="notification.url!=null" :to="notification.url">
										<i :class="notification.icon+' pull-right'"></i>
										
										<span class="line">
											<strong>{{notification.text}}</strong>
										</span>
										
										<span class="line small">
											{{notification.created_at}}
										</span>
									</router-link>
									<router-link to="/home" v-else>
										<i :class="notification.icon+' pull-right'"></i>
										
										<span class="line">
											<strong>{{notification.text}}</strong>
										</span>
										
										<span class="line small">
											{{notification.created_at}}
										</span>
									</router-link>
								</li>
								
							</ul>
						</li>
						
						<li class="external">
							<router-link to="/home" >Ver mas</router-link>
						</li>
					</ul>
	
				</li>		
			</ul>
	
		</div>
	
	
		<!-- Raw Links -->
		<div class="col-md-6 col-sm-4 clearfix hidden-xs">
	
			<ul class="list-inline links-list pull-right">	
				<li>
					<a @click="logout">
						Cerrar session <i class="entypo-logout right"></i>
					</a>
				</li>
			</ul>
	
		</div>
	
	</div>
	
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				notifications:{},
			}
		},
		computed:{
			unreaded:function(){
				let unread=jQuery.map(this.notification,(row)=>{
					if(row.unread==0)
						return row;
				});

				return unread.length;
			},
		},
		methods:{
			profile(){
				return window.tools.url('/img/'+this.$parent.user.img.key);
			},
			logout(){
				axios.post(tools.url("/api/logout")).then((response)=>{
			    	this.$parent.user={};
			    	this.$parent.token="";
			    	localStorage.removeItem('token');
			    	this.$parent.logged=false;
			    	this.$router.push('/');
			        this.inPetition=false;
			        
			    }).catch((error)=>{
			        this.error=error.response.data.error;			        
			        this.inPetition=false;
			    });
			},
			getNotifications:function(){
				// this.$parent.inPetition=true;
				axios.get(tools.url('/api/notifications/'+this.$parent.user.id+'/resume'))
				.then((response)=>{
					this.notifications=response.data;
					// this.$parent.inPetition=false;
				})
				.catch(()=>{
					// this.$parent.inPetition=false;
				});
			},
			readAll:function(){
				axios.post(tools.url('/api/notifications/'+this.$parent.user.id+'/read_all'))
				.then((response)=>{
					this.getNotifications();
					// this.$parent.inPetition=false;
				})
				.catch(()=>{
					// this.$parent.inPetition=false;
				});
			}			
		},
        mounted() {
            this.getNotifications();
        }
    }
</script>