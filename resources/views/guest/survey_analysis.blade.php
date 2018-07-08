@extends('layouts.survey')
@section('externals')
<meta name="session-type" content="dev">
<title>Knocks Survey</title>
<style>
	.el-step__title.is-process{
		color :#91124f !important;
	}
	.el-loading-mask{
		border-radius: 10px !important;
	}
</style>
@endsection
@section('content')
<div class = "knocks_fair_bounds knocks_standard_border_radius"
	style="margin-top: 70px !important;
	border : 1px solid #e3f2fd;
	background-color: rgb(251, 251, 251)">
	<br/>
	<div class = "row">
		@if(auth()->check())
		<h3 class = "knocks_text_dark_active animated bounceInDown"   style = "word-wrap: break-word;">
		@if(auth()->user()->nickname != null)
		<span >Hello,</span><span >Welcome back,</span> {{ucfirst(auth()->user()->nickname)}}
		@endif
		@if(auth()->user()->nickname == null)
		<span >Hello,</span><span  >Welcome back,</span> {{ucfirst(auth()->user()->first_name)}}
		@endif!
		<br/><small class = "knocks_text_dark_active animated bounceInUp">According to <strong>Knocks</strong> Survey, Here's what do people think about
		Social Networking.</small>
		<hr class="uk-divider-icon">
		@endif
		@if(!auth()->check())
		<h3 class = "knocks_text_dark_active animated bounceInDown"   style = "word-wrap: break-word;">
		Hello There!
		<br/><small class = "knocks_text_dark_active animated bounceInUp">According to <strong>Knocks</strong> Survey, Here's what do people think about
		Social Networking, if you want to Take the survey please <a href="{{asset('user/login')}}">Login</a> if you have an account,	 or <a href="{{asset('user/register')}}">Register</a> then <a href="{{asset('faq/survey')}}">Take The Survey</a>.</small>
		<hr class="uk-divider-icon">
		@endif
	</div>
	<div class = "row" >
		<div class = "col l6 s12">
			<p class = "knocks_text_ms knocks_text_dark">People who have Social Networking accounts.</p>
			<center><el-progress class = "knocks_standard_border_radius" type="circle" :percentage="98"></el-progress></center>
			<hr class="uk-divider-icon">
		</div>
		<div class = "col l6 s12" >
			<p class = "knocks_text_ms knocks_text_dark">People who were victims of online bullying.</p>
			<center><el-progress  type="circle" :percentage="54"></el-progress></center>
			<hr class="uk-divider-icon">
		</div>
		<div class = "col l6 s12" >
			<p class = "knocks_text_ms knocks_text_dark">People who think that Social Networks is not safe for kids.</p>
			<center><el-progress  type="circle" :percentage="70"></el-progress></center>
			<hr class="uk-divider-icon">
		</div>
		<div class = "col l6 s12" >
			<p class = "knocks_text_ms knocks_text_dark">People who were disabled to share their content because of other people.</p>
			<center><el-progress   type="circle" :percentage="70"></el-progress></center>
			<hr class="uk-divider-icon">
		</div>
	</div>
	<!--Q3-->
	<div class = "row">
		<div class = "col s12" >
			<p class = "knocks_text_ms knocks_text_dark">Importance level of social networking among people.</p>
			<div class = "row knocks_house_keeper">
				<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
				<div class = "col s12 l8">
					<el-progress  :percentage="36"></el-progress>
				</div>
			</div>
			<div class = "row knocks_house_keeper">
				<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
				<div class = "col s12 l8">
					<el-progress  :percentage="52"></el-progress>
				</div>
			</div>
			<div class = "row knocks_house_keeper">
				<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
				<div class = "col s12 l8">
					<el-progress  :percentage="3"></el-progress>
				</div>
			</div>
			<div class = "row knocks_house_keeper">
				<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
				<div class = "col s12 l8">
					<el-progress  :percentage="7"></el-progress>
				</div>
			</div>
			<div class = "row knocks_house_keeper">
				<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
				<div class = "col s12 l8">
					<el-progress  :percentage="0"></el-progress>
				</div>
			</div>
			<hr class="uk-divider-icon">
		</div>
		<!--Q5-->
		<div class = "row">
			<div class = "col s12">
				<p class = "knocks_text_ms knocks_text_dark">Users Activity level on Social Networks.</p>
				<div class = "row knocks_house_keeper">
					<div class = "col s12 l4"><p class = "knocks_text_dark_active">Very active</p></div>
					<div class = "col s12 l8">
						<el-progress  :percentage="25"></el-progress>
					</div>
				</div>
				<div class = "row knocks_house_keeper">
					<div class = "col s12 l4"><p class = "knocks_text_dark_active">Active</p></div>
					<div class = "col s12 l8">
						<el-progress  :percentage="56"></el-progress>
					</div>
				</div>
				<div class = "row knocks_house_keeper">
					<div class = "col s12 l4"><p class = "knocks_text_dark_active">Not active</p></div>
					<div class = "col s12 l8">
						<el-progress  :percentage="16"></el-progress>
					</div>
				</div>
				<div class = "row knocks_house_keeper">
					<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Not active at all</p></div>
					<div class = "col s12 l8">
						<el-progress  :percentage="1"></el-progress>
					</div>
				</div>
				<hr class="uk-divider-icon">
			</div>
			<!--Q6-->
			<div class = "row">
				<div class = "col s12" >
					<p class = "knocks_text_ms knocks_text_dark">Social Networks that people joined </p>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-brand71"></span>  Facebook</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="85"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-brand268"></span>  Twitter</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="45"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-brand297"></span>  YouTube</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="67"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-brand115"></span>  Instagram</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="80"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"> <span class = "knocks-brand284"></span>  WhatsApp</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="85"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-brand227 " style="border-radius: 3px; background-color: rgba(0,0,0,0.3)"></span>  Snapchat</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="47"></el-progress>
						</div>
					</div>
					<div class = "row knocks_house_keeper">
						<div class = "col s12 l4"><p class = "knocks_text_dark_active"> <span class = "knocks-brand130"></span>  Kik</p></div>
						<div class = "col s12 l8">
							<el-progress  :percentage="10"></el-progress>
						</div>
					</div>
					<hr class="uk-divider-icon">
				</div>
				<!--Q9-->
				<div class = "row">
					<div class = "col s12" >
						<p class = "knocks_text_ms knocks_text_dark">Devices used to access social networks.</p>
						<div class = "row knocks_house_keeper">
							<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-monitor3"></span>  Desktop/PC</p></div>
							<div class = "col s12 l8">
								<el-progress  :percentage="21"></el-progress>
							</div>
						</div>
						<div class = "row knocks_house_keeper">
							<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-laptop2"></span>  Laptop</p></div>
							<div class = "col s12 l8">
								<el-progress  :percentage="61"></el-progress>
							</div>
						</div>
						<div class = "row knocks_house_keeper">
							<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-tablet6"></span>  Tablet</p></div>
							<div class = "col s12 l8">
								<el-progress  :percentage="18"></el-progress>
							</div>
						</div>
						<div class = "row knocks_house_keeper">
							<div class = "col s12 l4"><p class = "knocks_text_dark_active"><span class = "knocks-phone9"></span>  Smartphone</p></div>
							<div class = "col s12 l8">
								<el-progress  :percentage="87"></el-progress>
							</div>
						</div>
						<hr class="uk-divider-icon">
					</div>
					<!--Q11-->
					<div class = "row">
						<div class = "col s12" >
							<p class = "knocks_text_ms knocks_text_dark">People's opinion about whether online bullying for kids can affect his/her personality negatively</p>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="36"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="52"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="3"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="7"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="0"></el-progress>
								</div>
							</div>
							<hr class="uk-divider-icon">
						</div>
					</div>
					<!--Q12-->
					<div class = "row">
						<div class = "col s12" >
							<p class = "knocks_text_ms knocks_text_dark">People's opinion about whether having a kid of 12 years old or younger with his parental monitored social network account will ensure the kid wellbeing.</p>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="20"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="47"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="23"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="9"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="0"></el-progress>
								</div>
							</div>
							<hr class="uk-divider-icon">
						</div>
					</div>
					<!--Q13-->
					<div class = "row">
						<div class = "col s12" >
							<p class = "knocks_text_ms knocks_text_dark">Privacy policies are effective in Social Networking sites?</p>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="16"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="54"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="16"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="12"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="0"></el-progress>
								</div>
							</div>
							<hr class="uk-divider-icon">
						</div>
					</div>
					<!--Q16-->
					<div class = "row">
						<div class = "col s12">
							<p class = "knocks_text_ms knocks_text_dark">Would it be better to expand the options of interactivity?	<br/><small class = "knocks_text_pink">
								*Posting can be with a text,poet and articles templates, media and also a voice note*
							</small></p>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="16"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="70"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="10"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="1"></el-progress>								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="0"></el-progress>
								</div>
							</div>
							<hr class="uk-divider-icon">
						</div>
					</div>
					<!--Q17-->
					<div class = "row">
						<div class = "col s12">
							<p class = "knocks_text_ms knocks_text_dark">Are you usually able to interact in your social media account
								<br/><small class = "knocks_text_pink">
								*for example: while driving*
							</small></p>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="12"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Agree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="52"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Fair</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="16"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active"> Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="14"></el-progress>
								</div>
							</div>
							<div class = "row knocks_house_keeper">
								<div class = "col s12 l4"><p class = "knocks_text_dark_active">Strongly Disgree</p></div>
								<div class = "col s12 l8">
									<el-progress  :percentage="1"></el-progress>
								</div>
							</div>
							<hr class="uk-divider-icon">
						</div>
					</div>
				</div>
			</div>
			@endsection